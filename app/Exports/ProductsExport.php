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

        // Define static headings
        $headings = [
            'Name', 'Description', 'Categories', 'Sub-Categories', 'Features', 'Images (Comma separated Values)', 'General Specification', 'Product Specification', 'Certifications and Compliance', 'Dimensions', 'Temperature Rating', 'Conductor Related', 'Electrical Rating', 'Sales Drawing', 'Catalog'
        ];

        // Set max filter types
        $maxFilterIndex = 8;

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
            ];

            $tabSortOrder = [
                'General Specification',
                'Product Specification',
                'Certifications And Compliance',
                'Dimensions',
                'Temperature Rating',
                'Conductor Related',
                'Electrical Rating'
            ];

            $sortedTabs = $product->productTabContents->sortBy(function($tabContent) use ($tabSortOrder) {
                return array_search($tabContent->productTabLabel->title, $tabSortOrder);
            })
            ->unique(fn($tabContent) => $tabContent->product_tab_label_id);

            // foreach ($sortedTabs as $tabContent) {
            //     $row[] = $tabContent->content ?? null;
            // }

            foreach ($tabSortOrder as $label) {
                $tab = $sortedTabs->firstWhere('productTabLabel.title', $label);
                $row[] = $tab->content ?? null;
            }

            // foreach ($sortedTabs as $tabContent) {
            //     if($tabContent->productTabLabel->title == 'General Specification'){
            //         $row[] = $tabContent->content ?? null;
            //     }
            // }

            $row[] = $product->sales_drawing ?? null;
            $row[] = $product->catalogue ?? null;

            foreach ($product->filterValues as $filterValue) {
                $row[] =  $filterValue->filterType->title;
                $row[] =  $filterValue->value;
            }

            $data->push($row);
        });

        return $data;
    }
}
