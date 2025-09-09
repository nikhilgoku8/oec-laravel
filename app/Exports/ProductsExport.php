<?php

namespace App\Exports;

use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\FilterType;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $q;
    protected $category_id;
    protected $sub_category_id;

    public function __construct($request)
    {
        $this->q = $request->q;
        $this->category_id = $request->category_id;
        $this->sub_category_id = $request->sub_category_id;
    }

    public function collection()
    {
        $subCategoryIds = [];

        if(!empty($this->category_id)){
            $category = Category::find($this->category_id);
            if ($category) {
                $subCategoryIds = $category->subcategories->pluck('id')->toArray();
            }
        }

        if(!empty($this->sub_category_id)){
            $subCategoryIds = [$this->sub_category_id];
        }

        // Get products with relationships
        $products = Product::with([
                'subCategory',
                'subCategory.category',
                'productImages',
                'filterValues',
                'filterValues.filterType',
                'productTabContents',
                'productTabContents.productTabLabel'
            ])
            ->when($this->q, fn($query) => $query->where('title', 'LIKE', '%' . $this->q . '%'))
            ->when(!empty($subCategoryIds), fn($query) => $query->whereIn('sub_category_id', $subCategoryIds))
            ->get();

        // Set max filter types
        $maxFilterIndex = FilterType::count();

        // Define static headings
        $headings = [
            'Name', 'Description', 'Categories', 'Sub-Categories', 'Features', 'Images (Comma separated Values)', 'General Specification', 'Product Specification', 'Certifications and Compliance', 'Dimensions', 'Temperature Rating', 'Conductor Related', 'Electrical Ratings', 'Sales Drawing', 'Catalog'
        ];

        // Add dynamic product columns
        for ($i = 1; $i <= $maxFilterIndex; $i++) {
            $headings[] = "Attribute $i name";
            $headings[] = "Attribute $i value";
        }

        // Create the dataset with products
        $data = collect([$headings]); // First row as headings

        $products->each(function ($product) use ($maxFilterIndex, &$data) {

            if(!empty($product->productImages) && count($product->productImages) > 0){
                $productImages = [];
                foreach ($product->productImages as $productImage) {
                    $productImages[] = $productImage->image_file;
                }
                $productImages = implode(',', $productImages);
            }

            $row = [
                $product->title,
                $product->description,
                $product->subCategory->category->title,
                $product->subCategory->title,
                $product->features,
                $productImages ?? null,
                $product->billing_company,
                $product->billing_address,
                $product->billing_city,
                $product->billing_state,
                $product->billing_country,
                $product->billing_postcode,
                $product->enquiry_notes,
                $product->admin_remark,
                $product->created_by,
                $product->updated_by,
                $product->created_at,
                $product->updated_at,
            ];

            $filters = collect();

            $quantities = [];

            foreach ($product->productProducts as $p) {
                $filters[$p->product_id] = $p->product; // Store the Product model
                $quantities[$p->product_id] = $p->quantity; // Store purchase quantity
            }

            // Fill in product details dynamically
            $productIds = $filters->keys(); // Get unique product IDs
            for ($i = 0; $i < $maxProducts; $i++) {
                $row[] = $filters[$productIds[$i] ?? null]?->title ?? ''; // Product Name
                $row[] = $quantities[$productIds[$i] ?? null] ?? ''; // Purchase Qty
            }

            $data->push($row);
        });

        return $data;
    }
}
