<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\SubCategory;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\FilterType;

use Illuminate\Pagination\LengthAwarePaginator;
use Meilisearch\Client;

class HomeController extends Controller
{
    public function index()
    {
        return view('front.home');
    }
    
    public function overview()
    {
        return view('front.overview');
    }
    
    public function careers()
    {
        return view('front.careers');
    }
    
    public function sustainability()
    {
        return view('front.sustainability');
    }
    
    public function markets()
    {
        return view('front.markets');
    }
    
    public function reach_us()
    {
        return view('front.reach-us');
    }
    
    public function electricals()
    {
        return view('front.electricals');
    }
    
    public function automotive()
    {
        return view('front.automotive');
    }
    
    public function showRegisterForm()
    {
        if (session('isUser') == 'yes') {
            return redirect()->route('electrical');
        }

        return view('front.register');
    }
    
    public function login()
    {
        if (session('isUser') == 'yes') {
            return redirect()->route('electrical');
        }

        return view('front.login');
    }
    
    public function showResetPasswordForm()
    {
        if (session('isUser') == 'yes') {
            return redirect()->route('electrical');
        }

        return view('front.reset-password');
    }
    
    public function electrical()
    {
        return view('electrical.home');
    }
    
    public function commercial_and_industrial()
    {
        return view('electrical.commercial-and-industrial');
    }
    
    public function landscape_irrigation_solutions()
    {
        return view('electrical.landscape-irrigation-solutions');
    }
    
    public function energy_systems_renewables()
    {
        return view('electrical.energy-systems-renewables');
    }
    
    public function operation_manual()
    {
        return view('electrical.operation-manual');
    }
    
    public function safety_standards()
    {
        return view('electrical.safety-standards');
    }
    
    public function nabl_testing_lab()
    {
        return view('electrical.nabl-testing-lab');
    }
    
    public function brochure()
    {
        return view('electrical.brochure');
    }
    
    public function cross_reference()
    {
        return view('electrical.cross-reference');
    }
    
    public function categories()
    {
        return view('electrical.products.categories');
    }
    
    public function sub_categories($category)
    {
        $categoryId = Category::where('slug',$category)->value('id');
        $this->data['subCategories'] = SubCategory::where('category_id', $categoryId)->paginate(12);
        return view('electrical.products.categories', $this->data);
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
        foreach ($filterParams as $typeId => $valueId) {
            $filterStrings[] = "filter_value_ids = $valueId";
        }

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
        $products = Product::whereIn('id', $hitIds)
            ->where('sub_category_id', $subCategory->id)
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
        // $relevantFilterValueIds = DB::table('filter_value_product')
        //     ->whereIn('product_id', $hitIds) // We are using $hitIds cause we need to get all products not just the current page
        //     ->pluck('filter_value_id');

        // $filterTypes = FilterType::with(['filterValues' => function ($q) use ($relevantFilterValueIds) {
        //         $q->whereIn('id', $relevantFilterValueIds);
        //     }])->get();

        $filterTypes = FilterType::with(['filterValues' => function ($q) use ($filterValueIds) {
                $q->whereIn('id', $filterValueIds);
            }])->get();

        // $filterCounts = DB::table('filter_value_product')
        //     ->select('filter_value_id', DB::raw('count(*) as count'))
        //     ->whereIn('product_id', $hitIds) // We are using $hitIds cause we need to get all products not just the current page
        //     ->groupBy('filter_value_id')
        //     ->pluck('count', 'filter_value_id');

        // return view('admin.products.search_new', [
        return view('electrical.products.list', [
            'products'       => $paginator,
            'category'       => $category,
            'subCategory'    => $subCategory,
            'filterTypes'    => $filterTypes,
            'currentQ'       => $query,
            'currentFilters' => $filterParams,
            'filterCounts' => $filterCounts,
        ]);

        return view('electrical.products.list', $this->data);
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
        // $relevantFilterValueIds = DB::table('filter_value_product')
        //     ->whereIn('product_id', $hitIds) // We are using $hitIds cause we need to get all products not just the current page
        //     ->pluck('filter_value_id');

        // $filterTypes = FilterType::with(['filterValues' => function ($q) use ($relevantFilterValueIds) {
        //         $q->whereIn('id', $relevantFilterValueIds);
        //     }])->get();

        $filterTypes = FilterType::with(['filterValues' => function ($q) use ($filterValueIds) {
                $q->whereIn('id', $filterValueIds);
            }])->get();

        // $filterCounts = DB::table('filter_value_product')
        //     ->select('filter_value_id', DB::raw('count(*) as count'))
        //     ->whereIn('product_id', $hitIds) // We are using $hitIds cause we need to get all products not just the current page
        //     ->groupBy('filter_value_id')
        //     ->pluck('count', 'filter_value_id');

        // return view('admin.products.search_new', [
        return view('electrical.products.shop', [
            'products'       => $paginator,
            'filterTypes'    => $filterTypes,
            'currentQ'       => $query,
            'currentFilters' => $filterParams,
            'filterCounts' => $filterCounts,
        ]);
    }
    
    public function product_detail($category, $subCategory, $product)
    {
        // $this->data['logout'] = 'active';
        // dd($category);
        $category = Category::where('slug',$category)->first();
        $subCategory = SubCategory::where('slug',$subCategory)->first();
        $this->data['product'] = Product::with('productImages','productTabContents')->find($product);
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

        return view('electrical.products.detail', $this->data);
    }
    
    public function quick_view_product($id)
    {
        $product = Product::with('productImages','productTabContents')->find($id);
        return response()->json([
            'success' => true,
            'id' => $product->id,
            'title' => $product->title,
            'description' => $product->description,
            'category' => $product->subCategory->category->slug,
            'subCategory' => $product->subCategory->slug,
            'images' => $product->productImages->pluck('image_file') // or getFullUrlAttribute
        ]);
    }
}
