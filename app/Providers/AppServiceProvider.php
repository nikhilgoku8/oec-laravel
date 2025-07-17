<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Admin\Category;
use App\Models\Admin\User;

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

            $user = null;
            if (session('isUser') === 'yes' && session()->has('userId')) {
                $user = User::find(session('userId'));
            }

            $view->with([
                'categories' => $categories,
                'user' => $user,
            ]);
        });
    }
}
