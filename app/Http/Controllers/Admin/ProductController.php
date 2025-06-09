<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Admin\SubCategory;
use App\Models\Admin\Product;
use App\Models\Admin\ProductTabLabel;
use App\Models\Admin\FilterType;

class ProductController extends Controller
{
    public function index()
    {
        $result = Product::with('subCategory','subCategory.category')->paginate(100);
        return view('admin.products.index', compact('result'));
    }

    public function create()
    {
        $categories = Category::all();
        $productTabLabels = ProductTabLabel::all();
        $filterTypes = FilterType::all();
        return view('admin.products.create', compact('categories','productTabLabels','filterTypes'));
    }

    public function show(Product $product)
    {
        $result = $product;
        $categories = Category::all();
        $productTabLabels = ProductTabLabel::all();
        $subCategories = SubCategory::all();
        $filterTypes = FilterType::all();
        return view('admin.products.show', compact('result','categories','subCategories','productTabLabels','filterTypes'));
    }

    public function edit(Product $product)
    {
        $result = $product;
        $categories = Category::all();
        $productTabLabels = ProductTabLabel::all();
        $subCategories = SubCategory::all();
        $filterTypes = FilterType::all();
        return view('admin.products.edit', compact('result','categories','subCategories','productTabLabels','filterTypes'));
    }

    public function store(Request $request)
    {
        return $this->handleProductRequest($request, new Product(), true);
    }

    public function update(Request $request, Product $product)
    {
        return $this->handleProductRequest($request, $product, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handleProductRequest(Request $request, Product $product, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'sub_category_id' => 'required|exists:sub_categories,id',
                'title' => 'required|string|max:255|unique:products,title,'.$dataID,
                'description' => 'required',
                'features' => 'required',
                'tabs' => 'required|array|min:1', // Ensure at least one tab is added
                'tabs.*.id' => 'required|exists:product_tab_labels,id', // Each tabs must exist
                'tabs.*.content' => 'required',
                'filters' => 'required|array|min:1', // Ensure at least one filter is added
                'filters.*.id' => 'required|exists:filter_types,id', // Each filter_types must exist
                'filters.*.value' => 'required',
            ];

            $messages = [];

            $attributes = [];

            $validator = Validator::make($request->all(), $rules , $messages, $attributes);

            // **Custom validation for duplicate tabs IDs**
            $validator->after(function ($validator) use ($request) {
                if (!empty($request->tabs)) {
                    $tabIds = array_column($request->tabs, 'id');
                    
                    if (count($tabIds) !== count(array_unique($tabIds))) {
                        $validator->errors()->add('tabs', 'Duplicate Tabs are not allowed.');
                    }
                }
            });

            // **Custom validation for duplicate tabs IDs**
            $validator->after(function ($validator) use ($request) {
                if (!empty($request->filters)) {
                    $filterIds = array_column($request->filters, 'id');
                    
                    if (count($filterIds) !== count(array_unique($filterIds))) {
                        $validator->errors()->add('filters', 'Duplicate Filters are not allowed.');
                    }
                }
            });

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            $validated['slug'] = $this->string_filter($validated['title']);

            if ($isNew) {
                $validated['created_by'] = session('username');
            }
            $validated['updated_by'] = session('username');

            // Directly handle the save/update logic here
            if ($isNew) {
                $product = Product::create($validated);
            } else {
                $product->update($validated);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'Product created successfully!' : 'Product updated successfully!',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'error_type' => 'form',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'status' => 'error',
                'error_type' => 'server',
                'message' => 'Something went wrong. Please try again later.',
                'console_message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted!');
    }

    public function bulkDelete(Request $request)
    {
        $dataIDs = $request->input('dataID');

        foreach ($dataIDs as $id) {
            $product = Product::find($id);
            if ($product) {
                $product->delete(); // Triggers model events and cascades
            }
        }

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }
}
