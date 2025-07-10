<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsSuperAdmin;

use App\Http\Controllers\Front\HomeController;

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\FilterTypeController;
use App\Http\Controllers\Admin\FilterValueController;
use App\Http\Controllers\Admin\ProductTabLabelController;
use App\Http\Controllers\Admin\UploadDataController;

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('electrical', function(){
//     print_r('Hello');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('overview', [HomeController::class, 'overview'])->name('overview');
Route::get('careers', [HomeController::class, 'careers'])->name('careers');
Route::get('sustainability', [HomeController::class, 'sustainability'])->name('sustainability');
Route::get('markets', [HomeController::class, 'markets'])->name('markets');
Route::get('reach-us', [HomeController::class, 'reach_us'])->name('reach-us');
Route::get('electricals', [HomeController::class, 'electricals'])->name('electricals');
Route::get('automotive', [HomeController::class, 'automotive'])->name('automotive');
Route::get('login', [HomeController::class, 'login'])->name('login');
Route::get('register', [HomeController::class, 'register'])->name('register');

Route::get('electrical', [HomeController::class, 'electrical'])->name('electrical');
Route::get('electrical/commercial-and-industrial', [HomeController::class, 'commercial_and_industrial'])->name('commercial-and-industrial');
Route::get('electrical/landscape-irrigation-solutions', [HomeController::class, 'landscape_irrigation_solutions'])->name('landscape-irrigation-solutions');
Route::get('electrical/energy-systems-renewables', [HomeController::class, 'energy_systems_renewables'])->name('energy-systems-renewables');
Route::get('electrical/operation-manual', [HomeController::class, 'operation_manual'])->name('operation-manual');
Route::get('electrical/safety-standards', [HomeController::class, 'safety_standards'])->name('safety-standards');
Route::get('electrical/nabl-testing-lab', [HomeController::class, 'nabl_testing_lab'])->name('nabl-testing-lab');
Route::get('electrical/brochure', [HomeController::class, 'brochure'])->name('brochure');
Route::get('electrical/cross-reference', [HomeController::class, 'cross_reference'])->name('cross-reference');
Route::get('electrical/my-account/dashboard', [HomeController::class, 'my_account'])->name('my-account.dashboard');
Route::get('electrical/my-account/orders', [HomeController::class, 'orders'])->name('my-account.orders');
Route::get('electrical/my-account/view-order/{order_no}', [HomeController::class, 'view_order'])->name('my-account.view-order');
Route::get('electrical/my-account/addresses', [HomeController::class, 'addresses'])->name('my-account.addresses');
Route::get('electrical/my-account/edit-address/{id}', [HomeController::class, 'edit_address'])->name('my-account.edit-address');
Route::get('electrical/my-account/account-details', [HomeController::class, 'account_details'])->name('my-account.account-details');
Route::get('electrical/my-account/logout', [HomeController::class, 'logout'])->name('my-account.logout');

Route::get('electrical/{category}/{subCategory}', [HomeController::class, 'products'])->name('products');

Route::prefix('owm')->group(function () {

    Route::get('/register', [LoginController::class, 'register']);
    Route::get('/login', [LoginController::class, 'login']);
    Route::post('/authenticate', [LoginController::class, 'authenticate'] );
    Route::get('/logout', [LoginController::class, 'logout'] );

    Route::middleware([IsAdmin::class])->group( function (){

        Route::get('/import-data', [UploadDataController::class, 'import_data'])->name('import_data.edit');
        Route::post('/importData', [UploadDataController::class, 'importData'])->name('import_data.store');

        Route::resource('categories', CategoryController::class);
        Route::post('categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');

        Route::resource('sub-categories', SubCategoryController::class);
        Route::post('sub-categories/bulk-delete', [SubCategoryController::class, 'bulkDelete'])->name('sub-categories.bulk-delete');
        Route::post('get_sub_categories_by_category/{id}', [SubCategoryController::class, 'get_sub_categories_by_category'])->name('get_sub_categories_by_category');

        Route::get('products/search', [ProductController::class, 'search'])->name('products.search');
        Route::get('products/search_new', [ProductController::class, 'search_new'])->name('products.search_new');
        Route::resource('products', ProductController::class);
        Route::post('products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulk-delete');


        Route::resource('filter-types', FilterTypeController::class);
        Route::post('filter-types/bulk-delete', [FilterTypeController::class, 'bulkDelete'])->name('filter-types.bulk-delete');
        
        Route::post('get_filter_values_by_type/{id}', [FilterValueController::class, 'get_filter_values_by_type'])->name('get_filter_values_by_type');

        Route::resource('product-tab-labels', ProductTabLabelController::class);
        Route::post('product-tab-labels/bulk-delete', [ProductTabLabelController::class, 'bulkDelete'])->name('product-tab-labels.bulk-delete');

        Route::middleware([IsSuperAdmin::class])->group( function (){
            Route::get('dashboard', [AdminController::class, 'dashboard'] )->name('dashboard');

            Route::get('/admins', [AdminController::class, 'index'] );
            Route::get('/admins/create', [AdminController::class, 'create'] );
            Route::get('/admins/edit/{id}', [AdminController::class, 'edit'] );
            Route::post('/admins/store', [AdminController::class, 'store'] );
            Route::post('/admins/delete', [AdminController::class, 'delete'] );
            Route::get('/admins/usertype/{id}', [AdminController::class, 'usertype'] );
            // Route::get('/admins/edit/{id}/google2fa_setup', [AdminController::class, 'show2FASetup'] );
            // Route::post('/admins/confirm2FA', [AdminController::class, 'confirm2FA'] );
        });

    });

});