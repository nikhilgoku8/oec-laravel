<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Admin\SubCategory;
use App\Models\Admin\Product;
use App\Models\Admin\ProductTabLabel;
use App\Models\Admin\FilterType;
use App\Models\Admin\FilterValue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Laravel\Scout\Builder;

class ProductController extends Controller
{
    // public function index(Request $request)
    // {
    //     $query = $request->input('q');
    //     $filterParams = $request->input('filters', []);

    //     // Get all filter types with their values
    //     $filterTypes = FilterType::with('filterValues')->get();

    //     // Start Meilisearch query
    //     $builder = Product::search($query);

    //     // Build filter string for Meilisearch
    //     $filterStrings = [];
    //     foreach ($filterParams as $typeId => $valueIds) {
    //         foreach ($valueIds as $id) {
    //             $filterStrings[] = 'filter_value_ids = ' . $id;
    //         }
    //     }

    //     if (!empty($filterStrings)) {
    //         $builder->where(implode(' AND ', $filterStrings));
    //     }

    //     // Paginate the search result
    //     $products = $builder->paginate(12);

    //     return view('admin.products.index', compact('products', 'filterTypes'));
    // }
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
                // 'filters.*.value' => 'required|exists:filter_values,id',
                'filters.*.value' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (is_numeric($value)) {
                            // Must exist in filter_values table
                            if (!\DB::table('filter_values')->where('id', $value)->exists()) {
                                $fail("The selected filter value ID ($value) is invalid.");
                            }
                        } elseif (!preg_match('/^@.+$/', $value)) {
                            // Must start with @ and have at least one more character
                            $fail("Custom filter values must start with '@'.");
                        }
                    }
                ],
            ];

            $messages = [];

            $attributes = [];

            $validator = Validator::make($request->all(), $rules , $messages, $attributes);

            $validator->after(function ($validator) use ($request) {
                // **Custom validation for duplicate tabs IDs**
                if (!empty($request->tabs)) {
                    $tabIds = array_column($request->tabs, 'id');
                    
                    if (count($tabIds) !== count(array_unique($tabIds))) {
                        $validator->errors()->add('tabs', 'Duplicate Tabs are not allowed.');
                    }
                }
                
                // **Custom validation for duplicate filter_types IDs**
                if (!empty($request->filters)) {
                    $filterIds = array_column($request->filters, 'id');
                    
                    if (count($filterIds) !== count(array_unique($filterIds))) {
                        $validator->errors()->add('filters', 'Duplicate Filters are not allowed.');
                    }
                }
            });

            // ==================================================================
            // Check Duplicate Custom Filter Values
            if(!empty($request->filters)){
                $i = 0;
                foreach ($request->filters as $filter) {
                    if (preg_match('/^@.+$/', $filter['value'])){
                        $filterValue = preg_replace('/^@/', '', $filter['value']);
                        $valueExists = FilterValue::where('filter_type_id',$filter['id'])->where('value',$filterValue)->exists();
                        if($valueExists){
                            $errorKey = 'filters-'.$i.'-value';
                            $validator->errors()->add($errorKey, 'Value Already Exists.');
                        }
                    }
                    $i++;
                }
            }
            // ==================================================================

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

            // ==================================================================
            // Create Custom Filter Values and Sync 
            $filterIds = [];
            if(!empty($request->filters)){
                foreach ($request->filters as $filter) {
                    if (preg_match('/^@.+$/', $filter['value'])){
                        $filterValue = preg_replace('/^@/', '', $filter['value']);
                        
                        $newFilterValue = FilterValue::create([
                            'filter_type_id' => $filter['id'],
                            'value' => $filterValue
                        ]);
                        $filterIds[] = $newFilterValue->id;
                    }else{
                        $filterIds[] = $filter['value'];
                    }
                }

                $product->filterValues()->sync($filterIds);
            }
            // ==================================================================

            // ==================================================================
            // Create or update Tabs

            // Get current tab label IDs in DB
            $existingIds = $product->productTabContents()->pluck('product_tab_label_id')->toArray();

            // Get incoming tab label IDs from request
            $incoming = collect($request->tabs);
            $incomingIds = $incoming->pluck('id')->toArray();

            // 1. Delete removed tab labels
            $idsToDelete = array_diff($existingIds, $incomingIds);
            $product->productTabContents()->whereIn('product_tab_label_id', $idsToDelete)->delete();

            // 2. Update or create each incoming tab content
            foreach ($incoming as $tab) {
                $tabData = [
                    'content'     => $tab['content'],
                    'updated_by'  => session('username'),
                ];

                if (!$dataID) {
                    $tabData['created_by'] = session('username');
                }
                $product->productTabContents()->updateOrCreate(
                    ['product_tab_label_id' => $tab['id']],
                    $tabData
                );
            }
            // ==================================================================

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

    public function search(Request $request)
    {
        $query = $request->input('q');

        // $products = Product::search($query)->orderBy('title')->take(100)->get();
        $products = Product::search($query)->take(100)->get();

        return view('admin.products.search', compact('products', 'query'));
    }
}
