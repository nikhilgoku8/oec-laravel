<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\SubCategory;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\FilterType;
use App\Models\Admin\NewsletterSubscription;
use App\Models\Admin\Career;
use App\Models\Admin\ReachUs;
use App\Models\Admin\Competitor;
use Illuminate\Support\Facades\Validator;

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
        $this->data['featuredProducts'] = Product::where('featured', 1)->limit(10)->get();
        return view('electrical.home', $this->data);
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
        foreach ($filterParams as $typeId => $valueId) {
            $filterStrings[] = "filter_value_ids = $valueId";
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
        $products = Product::with('subCategory')
            ->whereIn('id', $hitIds)
            ->whereIn('sub_category_id', $subCategoryIds)
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
        return view('electrical.products.list-by-category', [
            'products'       => $paginator,
            'category'       => $category,
            'filterTypes'    => $filterTypes,
            'currentQ'       => $query,
            'currentFilters' => $filterParams,
            'filterCounts' => $filterCounts,
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

        if (!empty($hitIds)) {
            $products = Product::whereIn('id', $hitIds)
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

    public function competitors(Request $request)
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

            return view('electrical.competitors', [
                'products' => $emptyPaginator,
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
        $hitIds = collect($hits)->pluck('product_id')->all();

        // 3) Total matching documents
        // Depending on your Meili client version, this might be getEstimatedTotalHits() or getNbHits()
        $totalHits = method_exists($raw, 'getEstimatedTotalHits')
            ? $raw->getEstimatedTotalHits()
            : $raw->getNbHits();

        // 4) Fetch Eloquent models in the Meili order
        if (!empty($hitIds)) {
            $products = Product::whereIn('id', $hitIds)
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

        // return view('admin.products.search_new', [
        return view('electrical.competitors', [
            'products'       => $paginator,
        ]);
    }
    
    public function product_detail($category, $subCategory, $product)
    {
        // $this->data['logout'] = 'active';
        // dd($category);
        $category = Category::where('slug',$category)->first();
        $subCategory = SubCategory::where('slug',$subCategory)->first();
        $this->data['product'] = Product::with('productImages','productTabContents')->where('slug', $product)->first();
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
                $destination = public_path('uploads/resumes');

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
        return view('front.thank-you-career');
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
                $destination = public_path('uploads/reach-us-documents');

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
        return view('front.thank-you-reach-us');
    }
}
