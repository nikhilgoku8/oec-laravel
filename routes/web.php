<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsSuperAdmin;

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\FilterTypeController;
use App\Http\Controllers\Admin\ProductTabLabelController;
use App\Http\Controllers\Admin\UploadDataController;

Route::get('/', function () {
    return view('welcome');
});

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
        Route::resource('products', ProductController::class);
        Route::post('products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulk-delete');


        Route::resource('filter-types', FilterTypeController::class);
        Route::post('filter-types/bulk-delete', [FilterTypeController::class, 'bulkDelete'])->name('filter-types.bulk-delete');

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