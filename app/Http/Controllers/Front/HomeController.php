<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
