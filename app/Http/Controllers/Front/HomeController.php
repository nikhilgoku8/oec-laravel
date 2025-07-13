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
    
    public function login()
    {
        return view('front.login');
    }
    
    public function register()
    {
        return view('front.register');
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
    
    public function my_account()
    {
        $this->data['dashboard'] = 'active';
        return view('electrical.my-account.dashboard', $this->data);
    }
    
    public function orders()
    {
        $this->data['orders'] = 'active';
        return view('electrical.my-account.orders', $this->data);
    }
    
    public function view_order($order_no)
    {
        $this->data['orders'] = 'active';
        return view('electrical.my-account.view-order', $this->data);
    }
    
    public function addresses()
    {
        $this->data['addresses'] = 'active';
        return view('electrical.my-account.addresses', $this->data);
    }
    
    public function edit_address($id)
    {
        $this->data['addresses'] = 'active';
        return view('electrical.my-account.edit-address', $this->data);
    }
    
    public function account_details()
    {
        $this->data['accountDetails'] = 'active';
        return view('electrical.my-account.account-details', $this->data);
    }
    
    public function logout()
    {
        $this->data['logout'] = 'active';
        return view('electrical.my-account.logout', $this->data);
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
        $this->data['category'] = $category;
        $this->data['subCategory'] = $subCategory;
        return view('electrical.products.detail', $this->data);
    }
}
