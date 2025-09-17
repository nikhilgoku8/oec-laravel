<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\SubCategory;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\FilterType;
use App\Models\Admin\FilterValue;
use App\Models\Admin\NewsletterSubscription;
use App\Models\Admin\Career;
use App\Models\Admin\ReachUs;
use App\Models\Admin\Competitor;
use App\Models\Admin\Banner;
use App\Models\Admin\SalesRepresentative;
use App\Models\Admin\UsState;
use Illuminate\Support\Facades\Validator;

use Illuminate\Pagination\LengthAwarePaginator;
use Meilisearch\Client;
use Barryvdh\DomPDF\Facade\Pdf;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'meta_title' => 'OEC',
            'meta_description' => 'OEC',
        ];
        return view('front.home', $data);
    }
    
    public function overview()
    {
        $data = [
            'meta_title' => 'Overview - OEC',
            'meta_description' => 'Overview - OEC',
        ];
        return view('front.overview', $data);
    }
    
    public function careers()
    {
        $data = [
            'meta_title' => 'Careers - OEC',
            'meta_description' => 'Careers - OEC',
        ];
        return view('front.careers', $data);
    }
    
    public function sustainability()
    {
        $data = [
            'meta_title' => 'Sustainability - OEC',
            'meta_description' => 'Sustainability - OEC',
        ];
        return view('front.sustainability', $data);
    }
    
    public function markets()
    {
        $data = [
            'meta_title' => 'Market - OEC',
            'meta_description' => 'Market - OEC',
        ];
        return view('front.markets', $data);
    }
    
    public function reach_us()
    {
        $data = [
            'meta_title' => 'Reach Us - OEC',
            'meta_description' => 'Reach Us - OEC',
        ];
        return view('front.reach-us', $data);
    }
    
    public function electricals()
    {
        $data = [
            'meta_title' => 'Electricals - OEC',
            'meta_description' => 'Electricals - OEC',
        ];
        return view('front.electricals', $data);
    }
    
    public function automotive()
    {
        $data = [
            'meta_title' => 'Automotive - OEC',
            'meta_description' => 'Automotive - OEC',
        ];
        return view('front.automotive', $data);
    }
    
    public function showRegisterForm()
    {
        if (session('isUser') == 'yes') {
            return redirect()->route('electrical');
        }

        $data = [
            'meta_title' => 'Register - OEC',
            'meta_description' => 'Register - OEC',
        ];

        return view('front.register', $data);
    }
    
    public function login()
    {
        if (session('isUser') == 'yes') {
            return redirect()->route('electrical');
        }

        $data = [
            'meta_title' => 'Login - OEC',
            'meta_description' => 'Login - OEC',
        ];

        return view('front.login', $data);
    }
    
    public function showResetPasswordForm()
    {
        if (session('isUser') == 'yes') {
            return redirect()->route('electrical');
        }

        $data = [
            'meta_title' => 'Reset Password - OEC',
            'meta_description' => 'Reset Password - OEC',
        ];

        return view('front.reset-password', $data);
    }
    
    public function electrical()
    {
        $this->data['featuredProducts'] = Product::where('featured', 1)->limit(10)->get();
        $this->data['banners'] = Banner::orderBy('sort_order')->get();
        return view('electrical.home', $this->data);
    }
    
    public function commercial_and_industrial()
    {
        $data = [
            'meta_title' => 'Commercial and Industrial - OEC',
            'meta_description' => 'Commercial and Industrial - OEC',
        ];
        return view('electrical.commercial-and-industrial', $data);
    }
    
    public function landscape_irrigation_solutions()
    {
        $data = [
            'meta_title' => 'Landscape & Irrigation Solutions - OEC',
            'meta_description' => 'Landscape & Irrigation Solutions - OEC',
        ];
        return view('electrical.landscape-irrigation-solutions', $data);
    }
    
    public function energy_systems_renewables()
    {
        $data = [
            'meta_title' => 'Energy Systems & Renewables - OEC',
            'meta_description' => 'Energy Systems & Renewables - OEC',
        ];
        return view('electrical.energy-systems-renewables', $data);
    }
    
    public function operation_manual()
    {
        $data = [
            'meta_title' => 'Crimping Chart - OEC',
            'meta_description' => 'Crimping Chart - OEC',
        ];
        return view('electrical.operation-manual', $data);
    }
    
    public function safety_standards()
    {
        $data = [
            'meta_title' => 'Safety Standards - OEC',
            'meta_description' => 'Safety Standards - OEC',
        ];
        return view('electrical.safety-standards', $data);
    }
    
    public function nabl_testing_lab()
    {
        $data = [
            'meta_title' => 'NABL Testing Lab - OEC',
            'meta_description' => 'NABL Testing Lab - OEC',
        ];
        return view('electrical.nabl-testing-lab', $data);
    }
    
    public function brochure()
    {
        $data = [
            'meta_title' => 'Brochure - OEC',
            'meta_description' => 'Brochure - OEC',
        ];
        return view('electrical.brochure', $data);
    }
    
    public function cross_reference()
    {
        $data = [
            'meta_title' => 'Cross Reference - OEC',
            'meta_description' => 'Cross Reference - OEC',
        ];
        return view('electrical.cross-reference', $data);
    }
    
    public function privacy_policy()
    {
        $data = [
            'meta_title' => 'Privacy Policy - OEC',
            'meta_description' => 'Privacy Policy - OEC',
        ];
        return view('electrical.privacy-policy', $data);
    }

    public function addRecentSearch(string $query, int $limit = 5)
    {
        // Get current searches
        $searches = session('recent_searches', []);

        // Remove the same query if it already exists
        $searches = array_filter($searches, fn($item) => $item !== $query);

        // Add new query at the beginning
        array_unshift($searches, $query);

        // Limit the array length
        $searches = array_slice($searches, 0, $limit);

        // Save back to session
        session(['recent_searches' => $searches]);
    }

    public function addRecentlyViewed(int $productId, int $limit = 5)
    {
        $products = session('recently_viewed', []);

        // Remove if already exists
        $products = array_filter($products, fn($id) => $id !== $productId);

        // Add at the top
        array_unshift($products, $productId);

        // Limit the list
        $products = array_slice($products, 0, $limit);

        session(['recently_viewed' => $products]);
    }
    
    public function categories()
    {
        $data = [
            'meta_title' => 'Product Categories - OEC',
            'meta_description' => 'Product Categories - OEC',
        ];
        return view('electrical.products.categories', $data);
    }
    
    public function category_products(Request $request)
    {

        $category = Category::where('slug',$request->category)->first();
        $this->data['category'] = $category;
        $subCategoryIds = $category->subcategories->pluck('id')->toArray();

        $query        = $request->input('q', '');
        $filterParams = $request->input('filters', []);
        $page         = $request->input('page', 1);
        $perPage      = 12;

        // Build the Meili filter clause
        $filterStrings = [];

        // foreach ($filterParams as $typeId => $valueId) {
        //     $filterStrings[] = "filter_value_ids = $valueId";
        // }

        // Build OR part for filters as we need multiple filters        
        foreach ($filterParams as $group => $values) {
            // OR within the same group
            $orFilters = [];
            foreach ($values as $valueId) {
                $orFilters[] = "filter_value_ids = $valueId";
            }
            $filterStrings[] = '(' . implode(' OR ', $orFilters) . ')';
        }

        // if ($subCategory && $subCategory->id) {
        //     $filterStrings[] = "sub_category_id = {$subCategory->id}";
        // }
        if (!empty($subCategoryIds)) {
            $ids = implode(' OR ', array_map(fn($id) => "sub_category_id = $id", $subCategoryIds));
            $filterStrings[] = "($ids)";
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
                    'facets' => ['filter_value_ids'],  // ← ask for counts
                ]
            );

        $facetedResult = $client
            ->index($indexId)
            ->search($query, [
                'filter' => $filterClause,
                'facets' => ['filter_value_ids'],
                'limit' => 0, // ← no hits, only facets & totalHits
            ]);

        // 2) Extract hits array from the SearchResult object
        $hits = $raw->getHits();              // array of associative arrays
        $hitIds = collect($hits)->pluck('id')->all();

        $filterCounts = $facetedResult->getFacetDistribution()['filter_value_ids'] ?? [];
        // $filterCounts is now an array like: [ '577' => 5, '578' => 12, ... ]

        // Just get the IDs (the keys)
        $filterValueIds = array_keys($filterCounts);

        // 3) Total matching documents
        // Depending on your Meili client version, this might be getEstimatedTotalHits() or getNbHits()
        $totalHits = method_exists($raw, 'getEstimatedTotalHits')
            ? $raw->getEstimatedTotalHits()
            : $raw->getNbHits();

        // 4) Fetch Eloquent models in the Meili order
        // $products = Product::with('subCategory')
        //     ->whereIn('id', $hitIds)
        //     ->whereIn('sub_category_id', $subCategoryIds)
        //     ->orderByRaw("FIELD(id, " . implode(',', $hitIds) . ")")
        //     ->get();

        if (!empty($hitIds)) {
            $products = Product::with('subCategory')
            ->whereIn('id', $hitIds)
            ->whereIn('sub_category_id', $subCategoryIds)
            ->orderByRaw("FIELD(id, " . implode(',', $hitIds) . ")")
            ->get();
        } else {
            // Just return empty collection to keep paginator happy
            $products = collect();
        }

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
        // $relevantFilterValueIds = DB::table('filter_value_product')
        //     ->whereIn('product_id', $hitIds) // We are using $hitIds cause we need to get all products not just the current page
        //     ->pluck('filter_value_id');

        // $filterTypes = FilterType::with(['filterValues' => function ($q) use ($relevantFilterValueIds) {
        //         $q->whereIn('id', $relevantFilterValueIds);
        //     }])->get();

        $filterTypes = FilterType::with(['filterValues' => function ($q) use ($filterValueIds) {
                $q->whereIn('id', $filterValueIds);
            }])->orderBy('sort_order')->get();

        // $filterCounts = DB::table('filter_value_product')
        //     ->select('filter_value_id', DB::raw('count(*) as count'))
        //     ->whereIn('product_id', $hitIds) // We are using $hitIds cause we need to get all products not just the current page
        //     ->groupBy('filter_value_id')
        //     ->pluck('count', 'filter_value_id');

        // ****************************************************
        // Custom $filterCounts & $filterTypes including all the products by subCategory

        $subCategoryProducts = Product::whereIn('sub_category_id', $subCategoryIds)->get();
        
        $subCategoryProductIds = $subCategoryProducts->pluck('id')->toArray();

        $filterValueIds = FilterValue::whereHas('products', function ($query) use ($subCategoryIds) {
            $query->whereIn('sub_category_id', $subCategoryIds);
        })->pluck('id');

        $filterTypes = FilterType::with(['filterValues' => function ($q) use ($filterValueIds) {
                $q->whereIn('id', $filterValueIds);
            }])->orderBy('sort_order')->get();

        // Get global filter counts for all matching products
        $filterCounts = DB::table('filter_value_product')
            ->select('filter_value_id', DB::raw('count(*) as count'))
            ->whereIn('product_id', $subCategoryProductIds)
            ->groupBy('filter_value_id')
            ->pluck('count', 'filter_value_id');
        // ****************************************************

        // return view('admin.products.search_new', [
        return view('electrical.products.list-by-category', [
            'products'       => $paginator,
            'category'       => $category,
            'filterTypes'    => $filterTypes,
            'currentQ'       => $query,
            'currentFilters' => $filterParams,
            'filterCounts' => $filterCounts,
            'meta_title' => $category->title . ' - OEC',
            'meta_description' => $category->title . ' - OEC',
        ]);
        // return view('electrical.products.list-by-category', $this->data);
    }
    
    // public function products($category, $subCategory)
    // public function products(Request $request)
    // {
    //     $category = $request->category;
    //     $subCategory = $request->subCategory;
    //     // $this->data['logout'] = 'active';
    //     $category = Category::where('slug',$category)->first();
    //     $subCategory = SubCategory::where('slug',$subCategory)->first();
    //     $this->data['products'] = Product::where('sub_category_id', $subCategory->id)->paginate(12);
    //     $this->data['category'] = $category;
    //     $this->data['subCategory'] = $subCategory;
    //     return view('electrical.products.list', $this->data);
    // }
    public function products(Request $request)
    {

        $category = $request->category;
        $subCategory = $request->subCategory;
        $category = Category::where('slug',$category)->first();
        $subCategory = SubCategory::where('slug',$subCategory)->first();
        $this->data['category'] = $category;
        $this->data['subCategory'] = $subCategory;

        $query        = $request->input('q', '');
        $filterParams = $request->input('filters', []);
        $page         = $request->input('page', 1);
        $perPage      = 12;

        // Build the Meili filter clause
        $filterStrings = [];
        // foreach ($filterParams as $typeId => $valueId) {
        //     $filterStrings[] = "filter_value_ids = $valueId";
        // }

        // if ($subCategory && $subCategory->id) {
        //     $filterStrings[] = "sub_category_id = {$subCategory->id}";
        // }

        // $filterClause = implode(' AND ', $filterStrings) ?: null;

        // Build OR part for filters as we need multiple filters
        foreach ($filterParams as $group => $values) {
            // OR within the same group
            $orFilters = [];
            foreach ($values as $valueId) {
                $orFilters[] = "filter_value_ids = $valueId";
            }
            $filterStrings[] = '(' . implode(' OR ', $orFilters) . ')';
        }

        // Subcategory condition (required) as we need results for specific sub-category
        if ($subCategory && $subCategory->id) {
            $filterStrings[] = "sub_category_id = {$subCategory->id}";
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
                    'facets' => ['filter_value_ids'],  // ← ask for counts
                ]
            );

        $facetedResult = $client
            ->index($indexId)
            ->search($query, [
                'filter' => $filterClause,
                'facets' => ['filter_value_ids'],
                'limit' => 0, // ← no hits, only facets & totalHits
            ]);

        // 2) Extract hits array from the SearchResult object
        $hits = $raw->getHits();              // array of associative arrays
        $hitIds = collect($hits)->pluck('id')->all();

        $filterCounts = $facetedResult->getFacetDistribution()['filter_value_ids'] ?? [];
        // $filterCounts is now an array like: [ '577' => 5, '578' => 12, ... ]

        // Just get the IDs (the keys)
        $filterValueIds = array_keys($filterCounts);

        // 3) Total matching documents
        // Depending on your Meili client version, this might be getEstimatedTotalHits() or getNbHits()
        $totalHits = method_exists($raw, 'getEstimatedTotalHits')
            ? $raw->getEstimatedTotalHits()
            : $raw->getNbHits();

        // 4) Fetch Eloquent models in the Meili order
        // $products = Product::whereIn('id', $hitIds)
        //     ->where('sub_category_id', $subCategory->id)
        //     ->orderByRaw("FIELD(id, " . implode(',', $hitIds) . ")")
        //     ->get();

        if (!empty($hitIds)) {
            $products = Product::whereIn('id', $hitIds)
                ->where('sub_category_id', $subCategory->id)
                ->orderByRaw("FIELD(id, " . implode(',', $hitIds) . ")")
                ->get();
        } else {
            // Just return empty collection to keep paginator happy
            $products = collect();
        }

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
        // $relevantFilterValueIds = DB::table('filter_value_product')
        //     ->whereIn('product_id', $hitIds) // We are using $hitIds cause we need to get all products not just the current page
        //     ->pluck('filter_value_id');

        // $filterTypes = FilterType::with(['filterValues' => function ($q) use ($relevantFilterValueIds) {
        //         $q->whereIn('id', $relevantFilterValueIds);
        //     }])->get();

        $filterTypes = FilterType::with(['filterValues' => function ($q) use ($filterValueIds) {
                $q->whereIn('id', $filterValueIds);
            }])->orderBy('sort_order')->get();

        // $filterCounts = DB::table('filter_value_product')
        //     ->select('filter_value_id', DB::raw('count(*) as count'))
        //     ->whereIn('product_id', $hitIds) // We are using $hitIds cause we need to get all products not just the current page
        //     ->groupBy('filter_value_id')
        //     ->pluck('count', 'filter_value_id');

        // ****************************************************
        // Custom $filterCounts & $filterTypes including all the products by subCategory

        $subCategoryProducts = Product::where('sub_category_id', $subCategory->id)->get();
        
        $subCategoryProductIds = $subCategoryProducts->pluck('id')->toArray();

        $filterValueIds = FilterValue::whereHas('products', function ($query) use ($subCategory) {
            $query->where('sub_category_id', $subCategory->id);
        })->pluck('id');

        $filterTypes = FilterType::with(['filterValues' => function ($q) use ($filterValueIds) {
                $q->whereIn('id', $filterValueIds);
            }])->orderBy('sort_order')->get();

        // Get global filter counts for all matching products
        $filterCounts = DB::table('filter_value_product')
            ->select('filter_value_id', DB::raw('count(*) as count'))
            ->whereIn('product_id', $subCategoryProductIds)
            ->groupBy('filter_value_id')
            ->pluck('count', 'filter_value_id');
        // ****************************************************

        // return view('admin.products.search_new', [
        return view('electrical.products.list', [
            'products'       => $paginator,
            'category'       => $category,
            'subCategory'    => $subCategory,
            'filterTypes'    => $filterTypes,
            'currentQ'       => $query,
            'currentFilters' => $filterParams,
            'filterCounts' => $filterCounts,
            'meta_title' => $subCategory->title . ' - OEC',
            'meta_description' => $subCategory->title . ' - OEC',
        ]);

        // return view('electrical.products.list', $this->data);
    }

    public function shop(Request $request)
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
                    'facets' => ['filter_value_ids'],  // ← ask for counts
                ]
            );

        $facetedResult = $client
            ->index($indexId)
            ->search($query, [
                'filter' => $filterClause,
                'facets' => ['filter_value_ids'],
                'limit' => 0, // ← no hits, only facets & totalHits
            ]);

        // 2) Extract hits array from the SearchResult object
        $hits = $raw->getHits();              // array of associative arrays
        $hitIds = collect($hits)->pluck('id')->all();

        $filterCounts = $facetedResult->getFacetDistribution()['filter_value_ids'] ?? [];
        // $filterCounts is now an array like: [ '577' => 5, '578' => 12, ... ]

        // Just get the IDs (the keys)
        $filterValueIds = array_keys($filterCounts);

        // 3) Total matching documents
        // Depending on your Meili client version, this might be getEstimatedTotalHits() or getNbHits()
        $totalHits = method_exists($raw, 'getEstimatedTotalHits')
            ? $raw->getEstimatedTotalHits()
            : $raw->getNbHits();

        // 4) Fetch Eloquent models in the Meili order
        // $products = Product::whereIn('id', $hitIds)
        //     ->orderByRaw("FIELD(id, " . implode(',', $hitIds) . ")")
        //     ->get();

        // Just return empty collection to keep paginator happy
        $products = collect();

        if (!empty($hitIds)) {
            // $products = Product::whereIn('id', $hitIds)
            //     ->orderByRaw("FIELD(id, " . implode(',', $hitIds) . ")")
            //     ->get();
            $query = Product::whereIn('id', $hitIds)
                ->orderByRaw("FIELD(id, " . implode(',', $hitIds) . ")");

            // Decide based on request type
            if ($request->ajax()) {

                $products = $query->take(10)->get(); // fewer results

            } else {
                $products = $query->get(); // all results
            }

        }

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
        // $relevantFilterValueIds = DB::table('filter_value_product')
        //     ->whereIn('product_id', $hitIds) // We are using $hitIds cause we need to get all products not just the current page
        //     ->pluck('filter_value_id');

        // $filterTypes = FilterType::with(['filterValues' => function ($q) use ($relevantFilterValueIds) {
        //         $q->whereIn('id', $relevantFilterValueIds);
        //     }])->get();

        $filterTypes = FilterType::with(['filterValues' => function ($q) use ($filterValueIds) {
                $q->whereIn('id', $filterValueIds);
            }])->orderBy('sort_order')->get();

        // We return for AJAX Request
        if($request->ajax()){            
            return response()->json([
                'html' => view('electrical.partials.ajax-search-products', compact('products'))->render()
            ]);
        }

        // Add search q to recent searches
        if($request->input('q') != ''){
            $this->addRecentSearch($request->input('q'));
        }

        return view('electrical.products.shop', [
            'products'       => $paginator,
            'filterTypes'    => $filterTypes,
            'currentQ'       => $query,
            'currentFilters' => $filterParams,
            'filterCounts' => $filterCounts,
            'meta_title' => 'Shop - OEC',
            'meta_description' => 'Shop - OEC',
        ]);
    }

    public function competitors(Request $request)
    {
        return view('electrical.competitors.page');
    }

    public function competitors_search(Request $request)
    {
        $query        = $request->input('q', '');
        $page         = $request->input('page', 1);
        $perPage      = 12;

        // Return empty paginator if no query
        if (trim($query) === '') {
            $emptyPaginator = new LengthAwarePaginator(
                collect(), // empty collection
                0,         // total
                $perPage,
                $page,
                [
                    'path'  => url()->current(),
                    'query' => $request->query(),
                ]
            );

            return view('electrical.competitors.page', [
                'competitors' => $emptyPaginator,
            ]);
        }

        // Instantiate Meili client & index name
        $model   = new Competitor;
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
        if (!empty($hitIds)) {
            $competitors = Competitor::with('product')->whereIn('id', $hitIds)
                ->orderByRaw("FIELD(id, " . implode(',', $hitIds) . ")")
                ->get();
        } else {
            // Just return empty collection to keep paginator happy
            $competitors = collect();
        }

        // 5) Make a LengthAwarePaginator for Blade
        $paginator = new LengthAwarePaginator(
            $competitors,
            $totalHits,
            $perPage,
            $page,
            [
                'path'  => url()->current(),
                'query' => $request->query(),
            ]
        );

        // return view('admin.products.search_new', [
        return view('electrical.competitors.partials', [
            'competitors' => $paginator,
            'meta_title' => 'Competitors - OEC',
            'meta_description' => 'Competitors - OEC',
        ]);
    }
    
    public function product_detail($category, $subCategory, $product)
    {
        // $this->data['logout'] = 'active';
        // dd($category);
        $category = Category::where('slug',$category)->first();
        $subCategory = SubCategory::where('slug',$subCategory)->first();
        $this->data['product'] = Product::with('productImages','productTabContents')->where('slug', $product)->first();
        $this->data['product']->productTabContents = $this->data['product']->productTabContents
            ->sortBy(fn($item) => $item->productTabLabel->sort_order)
            ->values();
        // $this->data['product'] = Product::with([
        //         'productImages',
        //         'productTabContents' => function ($query) {
        //             $query->with('productTabLabel')
        //                   ->join('product_tab_labels', 'product_tab_labels.id', '=', 'product_tab_contents.product_tab_label_id')
        //                   ->orderBy('product_tab_labels.sort_order');
        //         }
        //     ])->where('slug', $product)->first();
        $this->data['relatedProducts'] = Product::with('productImages','subCategory','subCategory.category')
            ->where('id', '!=', $this->data['product']->id)
            ->where('sub_category_id', $subCategory->id)
            ->inRandomOrder()
            ->limit(10)
            ->get();
        $this->data['category'] = $category;
        $this->data['subCategory'] = $subCategory;

        // Step 1
        // Get all product IDs in same subcategory
        $productIds = Product::where('sub_category_id', $this->data['product']->sub_category_id)
            ->orderBy('id')
            ->pluck('id')
            ->toArray();

        // Step 2
        $currentIndex = array_search($this->data['product']->id, $productIds);

        // Step 3
        $total = count($productIds);
        $prevIndex = ($currentIndex - 1 + $total) % $total;
        $nextIndex = ($currentIndex + 1) % $total;

        // Step 4
        $prevProductId = $productIds[$prevIndex];
        $nextProductId = $productIds[$nextIndex];

        // Step 5
        $this->data['prevProduct'] = Product::with('productImages')->find($prevProductId);
        $this->data['nextProduct'] = Product::with('productImages')->find($nextProductId);

        $this->data['meta_title'] = $this->data['product']->title . ' - OEC';
        $this->data['meta_description'] = $this->data['product']->description . ' - OEC';

        $this->addRecentlyViewed($this->data['product']->id);

        // return view('pdf.product-specification', $this->data);
        return view('electrical.products.detail', $this->data);
    }
    
    public function quick_view_product($id)
    {
        $product = Product::with('productImages','productTabContents')->find($id);
        return response()->json([
            'success' => true,
            'id' => $product->id,
            'product_slug' => $product->slug,
            'title' => $product->title,
            'description' => $product->description,
            'category' => $product->subCategory->category->slug,
            'subCategory' => $product->subCategory->slug,
            'images' => $product->productImages->pluck('image_file') // or getFullUrlAttribute
        ]);
    }
    
    public function subscribeNewsletter(Request $request)
    {

        try {

            $rules = [
                'email'=>'required|email|unique:newsletter_subscriptions,email'
            ];

            $messages = [
                'unique' => 'Email Already Registered'
            ];

            $attributes = [
                'email'=>'Email'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            NewsletterSubscription::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Newsletter Subscribed Successfully'
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

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }
    
    public function careerEnquiry(Request $request)
    {

        try {

            $rules = [
                'name'=>'required|string|max:100',
                'email'=>'required|email|unique:careers,email',
                'position'=>'required|string|max:100',
                'message'=>'required|string|max:255',
                'resume'=>'required|file|mimes:doc,docx,pdf|max:2048'
            ];

            $messages = [
                'email.unique' => 'Existing application on provided email',
                'resume.max' => 'The resume field must not be greater than 2MB.'
            ];

            $attributes = [];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            $fileName = null;
            if($request->hasFile('resume')){
                // $destination = public_path('uploads/resumes');
                $uploadRoot = base_path(env('UPLOAD_ROOT'));
                $destination = $uploadRoot . '/resumes';

                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true); // recursive = true to create nested folders
                }

                $fileName = $this->string_filter($validated['name']) .'_'.time().'.'.$request->file('resume')->getClientOriginalExtension();
                $request->file('resume')->move($destination, $fileName);
            }

            // $request->file('resume')
            $validated['resume'] = $fileName;
            $validated['created_by'] = $validated['name'];
            $validated['updated_by'] = $validated['name'];

            Career::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully'
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
    
    public function career_thank_you()
    {
        $data = [
            'meta_title' => 'Thank You - OEC',
            'meta_description' => 'Thank You - OEC',
        ];
        return view('front.thank-you-career', $data);
    }
    
    public function reachUsEnquiry(Request $request)
    {

        try {

            $rules = [
                'name'=>'required|string|max:100',
                'email'=>'required|email',
                'phone'=>'required|string|max:20',
                'company_name'=>'required|string|max:100',
                'company_website'=>['nullable', 'regex:/^(https?:\/\/)?([\da-z\.-]+\.[a-z\.]{2,6})([\/\w\.-]*)*\/?$/'],
                'street_address'=>'nullable|string|max:100',
                'city'=>'nullable|string|max:100',
                'state'=>'required|string|max:50',
                'country'=>'required|string|max:60',
                'postcode'=>'nullable|string|max:20',
                'contact_reason'=>'required|string|max:100',
                'message'=>'nullable|string|max:255',
                'document'=>'nullable|file|mimes:doc,docx,pdf,jpg,jpeg,png,webp|max:5120'
            ];

            $messages = [
                'document.max' => 'The resume field must not be greater than 5MB.'
            ];

            $attributes = [];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            $fileName = null;
            if($request->hasFile('document')){
                // $destination = public_path('uploads/reach-us-documents');
                $uploadRoot = base_path(env('UPLOAD_ROOT'));
                $destination = $uploadRoot . '/reach-us-documents';

                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true); // recursive = true to create nested folders
                }

                $fileName = $this->string_filter($validated['name']) .'_'.time().'.'.$request->file('document')->getClientOriginalExtension();
                $request->file('document')->move($destination, $fileName);
            }

            // $request->file('resume')
            $validated['document'] = $fileName;
            $validated['created_by'] = $validated['name'];
            $validated['updated_by'] = $validated['name'];

            ReachUs::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully'
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
    
    public function reach_us_thank_you()
    {
        $data = [
            'meta_title' => 'Thank You - OEC',
            'meta_description' => 'Thank You - OEC',
        ];
        return view('front.thank-you-reach-us', $data);
    }
    
    public function shop_thank_you()
    {
        $data = [
            'meta_title' => 'Thank You - OEC',
            'meta_description' => 'Thank You - OEC',
        ];
        return view('electrical.thank-you', $data);
    }
    
    public function downloadPdf($id)
    {
        $product = Product::with('productTabContents','productTabContents.productTabLabel')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.product-specification', compact('product'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isRemoteEnabled' => true,   // allow external images
                'isHtml5ParserEnabled' => true,
            ]);

        // return view('pdf.product-specification', compact('product'));
        return $pdf->download('product-'.$product->slug.'.pdf');
    }
    
    public function z_map()
    {
        $data = [
            'meta_title' => 'Sales Representatives Territories - OEC',
            'meta_description' => 'Sales Representatives Territories - OEC',
        ];
        $data['usStates'] = UsState::with('salesRepresentatives','salesRepresentatives.usStates')->get();
        return view('electrical.z_map', $data);
    }
}
