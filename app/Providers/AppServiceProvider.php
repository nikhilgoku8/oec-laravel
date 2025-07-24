<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\Admin\User;
use App\Models\Admin\CartItem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('electrical.*', function ($view) {
            $categories = Category::with('subCategories')->get();
            $productsMayLike = Product::inRandomOrder()->limit(5)->get();

            $user = null;
            $cartProducts = null;
            if (session('isUser') === 'yes' && session()->has('userId')) {
                $user = User::find(session('userId'));
                $cartProducts = CartItem::with('product')->where('user_id',session('userId'))->get();
            }

            $view->with([
                'categories' => $categories,
                'user' => $user,
                'cartProducts' => $cartProducts,
                'productsMayLike' => $productsMayLike,
            ]);
        });
    }
}
