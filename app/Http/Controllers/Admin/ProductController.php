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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Laravel\Scout\Builder;

use Illuminate\Pagination\LengthAwarePaginator;
use Meilisearch\Client;

class ProductController extends Controller
{

    public function index()
    {
        $result = Product::with('subCategory','subCategory.category')->orderByDesc('created_at')->paginate(100);
        return view('admin.products.index', compact('result'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        // $products = Product::search($query)->orderBy('title')->take(100)->get();
        $products = Product::search($query)->take(100)->get();

        return view('admin.products.search', compact('products', 'query'));
    }

    // public function search_new(Request $request)
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

    //     return view('admin.products.search_new', compact('products', 'filterTypes'));
    // }

    // public function search_new(Request $request)
    // {

    //     // $products = Product::search('')
    //     //         ->query('*', function ($meilisearch, $query, $options) {
    //     //             $options['filter'] = 'filter_value_ids = 577'; // use a real filter_value_id from DB
    //     //             return [$query, $options];
    //     //         })
    //     //         ->get();

    //     //     dd($products);

    //     $keyword = $request->input('q');
    //     $selectedFilters = $request->get('filters', []); // array of filter_value_ids

    //     $search = Product::search($keyword);

    //     // if (!empty($selectedFilters)) {
    //     //     // // Meilisearch syntax: `filter_value_ids = 3 AND filter_value_ids = 7`
    //     //     // $filterString = implode(' AND ', array_map(fn($id) => "filter_value_ids = $id", $selectedFilters));
            
    //     //     // $search->query('', function ($meilisearch, $query, $options) use ($filterString) {
    //     //     //     $options['filter'] = $filterString;
    //     //     //     return [$query, $options];
    //     //     // });

    //     //     // Format for Meilisearch: filter_value_ids = 577 OR filter_value_ids = 578
    //     //     $filterString = collect($selectedFilters)
    //     //         ->map(fn($id) => "filter_value_ids = {$id}")
    //     //         ->implode(' OR ');

    //     //     $search = $search->query('', function ($meili, $queryString, $options) use ($filterString) {
    //     //         $options['filter'] = $filterString;
    //     //         return [$queryString, $options];
    //     //     });
    //     // }

    //     if (!empty($selectedFilters)) {
    //         // Meilisearch syntax for multiple values for the same attribute:
    //         // filter_value_ids IN [577, 578]
    //         $filterString = 'filter_value_ids IN [' . implode(', ', $selectedFilters) . ']';

    //         $search->query('', function ($meili, $queryString, $options) use ($filterString) {
    //             $options['filter'] = $filterString;
    //             return [$queryString, $options];
    //         });
    //     }

    //     $products = $search->get();
    //     $productIds = $products->pluck('id')->toArray();
    //     // -------------------
    //     $relevantFilterValueIds = DB::table('filter_value_product')
    //         ->whereIn('product_id', $productIds)
    //         ->pluck('filter_value_id');

    //     $filterTypes = FilterType::with(['filterValues' => function ($q) use ($relevantFilterValueIds) {
    //             $q->whereIn('id', $relevantFilterValueIds);
    //         }])->get();

    //     $filterCounts = DB::table('filter_value_product')
    //         ->select('filter_value_id', DB::raw('count(*) as count'))
    //         ->whereIn('product_id', $productIds)
    //         ->groupBy('filter_value_id')
    //         ->pluck('count', 'filter_value_id');

    //     // Paginate the search result
    //     $products = $search->paginate(12);

    //     return view('admin.products.search_new', compact('products', 'filterTypes', 'filterCounts'));
    // }

    public function search_new(Request $request)
    {
        $query        = $request->input('q', '');
        $filterParams = $request->input('filters', []);
        $page         = $request->input('page', 1);
        $perPage      = 12;

        // Build the Meili filter clause
        $filterStrings = [];
        foreach ($filterParams as $typeId => $valueId) {
            $filterStrings[] = "filter_value_ids = $valueId";
        }
        $filterClause = implode(' AND ', $filterStrings) ?: null;

        // Instantiate Meili client & index name
        $model   = new Product;
        $indexId = $model->searchableAs();
        $client  = new Client(
            config('scout.meilisearch.host'),
            config('scout.meilisearch.key')
        );

        // 1) Do the Meili search
        /** @var \Meilisearch\Search\SearchResult $raw */
        $raw = $client
            ->index($indexId)
            ->search(
                $query === '' ? '*' : $query,
                [
                    'filter' => $filterClause,
                    'limit'  => $perPage,
                    'offset' => ($page - 1) * $perPage,
                ]
            );

        // 2) Extract hits array from the SearchResult object
        $hits = $raw->getHits();              // array of associative arrays
        $hitIds = collect($hits)->pluck('id')->all();

        // 3) Total matching documents
        // Depending on your Meili client version, this might be getEstimatedTotalHits() or getNbHits()
        $totalHits = method_exists($raw, 'getEstimatedTotalHits')
            ? $raw->getEstimatedTotalHits()
            : $raw->getNbHits();

        // 4) Fetch Eloquent models in the Meili order
        $products = Product::whereIn('id', $hitIds)
            ->orderByRaw("FIELD(id, " . implode(',', $hitIds) . ")")
            ->get();

        // 5) Make a LengthAwarePaginator for Blade
        $paginator = new LengthAwarePaginator(
            $products,
            $totalHits,
            $perPage,
            $page,
            [
                'path'  => url()->current(),
                'query' => $request->query(),
            ]
        );

        // 6) Also load filter types/values for the UI

        $productIds = $products->pluck('id')->toArray();
        // -------------------
        $relevantFilterValueIds = DB::table('filter_value_product')
            ->whereIn('product_id', $productIds)
            ->pluck('filter_value_id');

        $filterTypes = FilterType::with(['filterValues' => function ($q) use ($relevantFilterValueIds) {
                $q->whereIn('id', $relevantFilterValueIds);
            }])->get();

        $filterCounts = DB::table('filter_value_product')
            ->select('filter_value_id', DB::raw('count(*) as count'))
            ->whereIn('product_id', $productIds)
            ->groupBy('filter_value_id')
            ->pluck('count', 'filter_value_id');

        return view('admin.products.search_new', [
            'products'       => $paginator,
            'filterTypes'    => $filterTypes,
            'currentQ'       => $query,
            'currentFilters' => $filterParams,
            'filterCounts' => $filterCounts,
        ]);
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
        $filterTypes = FilterType::with('filterValues')->get();
        return view('admin.products.show', compact('result','categories','subCategories','productTabLabels','filterTypes'));
    }

    public function edit(Product $product)
    {
        $result = $product;
        $categories = Category::all();
        $productTabLabels = ProductTabLabel::all();
        $subCategories = SubCategory::all();
        $filterTypes = FilterType::with('filterValues')->get();
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
                'featured' => 'required',
                'images' => 'required|array|min:1',
                'images.*.link' => 'required',
                'images.*.sort_order' => [
                        'required',
                        'numeric',
                        'min:1',
                        function ($attribute, $value, $fail) use ($request) {
                            $sortOrders = array_column($request->images, 'sort_order');
                            if (count($sortOrders) !== count(array_unique($sortOrders))) {
                                $fail('Sort order must be unique.');
                            }
                        }
                    ],
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
            // Create or update Images

            // Get current Image IDs in DB
            $existingImageIds = $product->productImages()->pluck('id')->toArray();

            // Get incoming Image IDs from request
            $incomingImages = collect($request->images);
            $incomingImagesIds = $incomingImages->pluck('id')->toArray();

            // 1. Delete removed images
            $imageIdsToDelete = array_diff($existingImageIds, $incomingImagesIds);
            $product->productImages()->whereIn('id', $imageIdsToDelete)->delete();

            // 2. Update or create each incoming image
            foreach ($incomingImages as $image) {
                $tabData = [
                    'image_file' => $image['link'],
                    'sort_order' => $image['sort_order'],
                    'updated_by' => session('username'),
                ];

                if (!$dataID) {
                    $tabData['created_by'] = session('username');
                }

                if (!empty($image['id'])) {
                    // Update existing
                    $product->productImages()->where('id', $image['id'])->update($tabData);
                } else {
                    // Create new
                    $product->productImages()->create($tabData);
                }
            }
            // ==================================================================

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
}
