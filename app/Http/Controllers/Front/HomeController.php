<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\SubCategory;

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
    
    public function products($category, $subCategory)
    {
        // $this->data['logout'] = 'active';
        $category = Category::where('slug',$category)->first();
        $subCategory = SubCategory::where('slug',$subCategory)->first();
        $this->data['products'] = Product::where('sub_category_id', $subCategory->id)->paginate(12);
        $this->data['category'] = $category;
        $this->data['subCategory'] = $subCategory;
        return view('electrical.products.list', $this->data);
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
}
