<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsUser;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsSuperAdmin;

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\CartController;

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\FilterTypeController;
use App\Http\Controllers\Admin\FilterValueController;
use App\Http\Controllers\Admin\ProductTabLabelController;
use App\Http\Controllers\Admin\UploadDataController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\ReachUsController;
use App\Http\Controllers\Admin\CompetitorController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\UsStateController;
use App\Http\Controllers\Admin\SalesRepresentativeController;

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('electrical', function(){
//     print_r('Hello');
// });

Route::get('migrateDbData', [UploadDataController::class, 'migrateDbData']);
Route::get('test-otp-mail', [UserController::class, 'testOtpMail']);
Route::post('sendOtpViaEmail', [UserController::class, 'sendOtpViaEmail'])->name('sendOtpViaEmail');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('overview', [HomeController::class, 'overview'])->name('overview');
Route::get('careers', [HomeController::class, 'careers'])->name('careers');
Route::get('sustainability', [HomeController::class, 'sustainability'])->name('sustainability');
Route::get('markets', [HomeController::class, 'markets'])->name('markets');
Route::get('reach-us', [HomeController::class, 'reach_us'])->name('reach-us');
Route::get('electricals', [HomeController::class, 'electricals'])->name('electricals');
Route::get('automotive', [HomeController::class, 'automotive'])->name('automotive');

Route::get('login', [HomeController::class, 'login'])->name('login');
Route::get('register', [HomeController::class, 'showRegisterForm'])->name('register');
Route::post('register', [UserController::class, 'register'])->name('register.post');
Route::post('authenticateUser', [UserController::class, 'authenticateUser'])->name('authenticateUser');

Route::get('/reset-password', [HomeController::class, 'showResetPasswordForm'])->name('reset-password');
Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('reset-password.post');
Route::post('subscribeNewsletter', [HomeController::class, 'subscribeNewsletter'])->name('subscribeNewsletter');

Route::post('careerEnquiry', [HomeController::class, 'careerEnquiry'])->name('careerEnquiry');
Route::get('career-thank-you', [HomeController::class, 'career_thank_you'])->name('career.thankyou');
Route::post('reachUsEnquiry', [HomeController::class, 'reachUsEnquiry'])->name('reach-us.post');
Route::get('reach-us-thank-you', [HomeController::class, 'reach_us_thank_you'])->name('reach-us.thankyou');

Route::middleware([IsUser::class])->group(function(){
    
    Route::prefix('electrical')->group(function(){

        Route::get('/', [HomeController::class, 'electrical'])->name('electrical');
        Route::get('/commercial-and-industrial', [HomeController::class, 'commercial_and_industrial'])->name('commercial-and-industrial');
        Route::get('/landscape-irrigation-solutions', [HomeController::class, 'landscape_irrigation_solutions'])->name('landscape-irrigation-solutions');
        Route::get('/energy-systems-renewables', [HomeController::class, 'energy_systems_renewables'])->name('energy-systems-renewables');
        Route::get('/operation-manual', [HomeController::class, 'operation_manual'])->name('operation-manual');
        Route::get('/safety-standards', [HomeController::class, 'safety_standards'])->name('safety-standards');
        Route::get('/nabl-testing-lab', [HomeController::class, 'nabl_testing_lab'])->name('nabl-testing-lab');
        Route::get('/brochure', [HomeController::class, 'brochure'])->name('brochure');
		Route::get('/catalog', [HomeController::class, 'catalog'])->name('catalog');
        Route::get('/cross-reference', [HomeController::class, 'competitors'])->name('cross-reference');
        Route::get('/competitors-search', [HomeController::class, 'competitors_search'])->name('competitors.search');

        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
        Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

        Route::get('/checkout', [UserController::class, 'checkout'])->name('checkout');
        Route::post('/checkout', [UserController::class, 'place_order'])->name('checkout.post');

        Route::get('/categories', [HomeController::class, 'categories'])->name('categories');
        Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
        Route::get('/privacy-policy', [HomeController::class, 'privacy_policy'])->name('privacy-policy');
        // Route::match(['get', 'post'], '/shop', [HomeController::class, 'shop'])->name('shop');

        Route::get('/thank-you', [HomeController::class, 'shop_thank_you'])->name('shop.thank-you');
        Route::get('/z_map', [HomeController::class, 'z_map'])->name('z_map');

        Route::post('/quick-view-product/{id}', [HomeController::class, 'quick_view_product'])->name('quick-view-product');

        Route::get('/download-product-pdf/{id}', [HomeController::class, 'downloadPdf'])->name('download-pdf');

        Route::get('/{category}', [HomeController::class, 'category_products'])->name('category.products');
        Route::get('/{category}/{subCategory}', [HomeController::class, 'products'])->name('products');
        Route::get('/{category}/{subCategory}/{product}', [HomeController::class, 'product_detail'])->name('product');
    });

    Route::prefix('my-account')->group(function(){
        Route::get('/dashboard', [UserController::class, 'my_account'])->name('my-account.dashboard');
        Route::get('/orders', [UserController::class, 'orders'])->name('my-account.orders');
        Route::get('/view-order/{order_no}', [UserController::class, 'view_order'])->name('my-account.view-order');
        Route::get('/addresses', [UserController::class, 'addresses'])->name('my-account.addresses');
        Route::post('/addresses', [UserController::class, 'address_update'])->name('my-account.addresses.post');
        Route::get('/edit-address/{id}', [UserController::class, 'edit_address'])->name('my-account.edit-address');
        Route::get('/account-details', [UserController::class, 'account_details'])->name('my-account.account-details');
        Route::post('/account-details', [UserController::class, 'update_account_details'])->name('account-details.post');
        Route::get('/logout', [UserController::class, 'logout'])->name('my-account.logout');
    });

});

Route::prefix('owm')->group(function () {

    Route::get('/register', [LoginController::class, 'register']);
    Route::get('/login', [LoginController::class, 'login']);
    Route::post('/authenticate', [LoginController::class, 'authenticate'] );
    Route::get('/logout', [LoginController::class, 'logout'] );

    Route::middleware([IsAdmin::class])->group( function (){

        Route::get('/import-data', [UploadDataController::class, 'import_data'])->name('import_data.edit');
        Route::post('/importData', [UploadDataController::class, 'importData'])->name('import_data.store');
        Route::get('/representatives-states-import-data', [UploadDataController::class, 'representatives_states_data'])->name('representatives_states_data.edit');
        Route::post('/representativesStatesImportData', [UploadDataController::class, 'importSalesRepresentativeData'])->name('representatives_states_data.store');

        Route::post('categories/sortSubCategories', [CategoryController::class, 'sortSubCategories'])->name('categories.sortSubCategories');
        Route::post('categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');
        Route::resource('categories', CategoryController::class);

        Route::resource('sub-categories', SubCategoryController::class);
        Route::post('sub-categories/bulk-delete', [SubCategoryController::class, 'bulkDelete'])->name('sub-categories.bulk-delete');
        Route::post('get_sub_categories_by_category/{id}', [SubCategoryController::class, 'get_sub_categories_by_category'])->name('get_sub_categories_by_category');

        Route::get('products/search', [ProductController::class, 'search'])->name('products.search');
        Route::get('products/search_new', [ProductController::class, 'search_new'])->name('products.search_new');
        Route::post('products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulk-delete');
        Route::post('products/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
        Route::get('products/export', [ProductController::class, 'export'])->name('products.export');
        Route::resource('products', ProductController::class);


        Route::resource('filter-types', FilterTypeController::class);
        Route::post('filter-types/bulk-delete', [FilterTypeController::class, 'bulkDelete'])->name('filter-types.bulk-delete');

        Route::resource('filter-values', FilterValueController::class);
        Route::post('filter-values/bulk-delete', [FilterValueController::class, 'bulkDelete'])->name('filter-values.bulk-delete');
        
        Route::post('get_filter_values_by_type/{id}', [FilterValueController::class, 'get_filter_values_by_type'])->name('get_filter_values_by_type');

        Route::resource('product-tab-labels', ProductTabLabelController::class);
        Route::post('product-tab-labels/bulk-delete', [ProductTabLabelController::class, 'bulkDelete'])->name('product-tab-labels.bulk-delete');

        Route::get('orders/pending', [OrderController::class, 'pending'])->name('orders.pending');
        Route::get('orders/completed', [OrderController::class, 'completed'])->name('orders.completed');
        Route::get('orders/denied', [OrderController::class, 'denied'])->name('orders.denied');
        Route::get('orders/export', [OrderController::class, 'export'])->name('orders.export');
        Route::post('orders/bulk-delete', [OrderController::class, 'bulkDelete'])->name('orders.bulk-delete');
        Route::resource('orders', OrderController::class);

        Route::get('users/pending', [AdminUserController::class, 'pending'])->name('users.pending');
        Route::get('users/approved', [AdminUserController::class, 'approved'])->name('users.approved');
        Route::get('users/denied', [AdminUserController::class, 'denied'])->name('users.denied');
        Route::get('users/export', [AdminUserController::class, 'export'])->name('users.export');
        Route::post('users/address_update', [AdminUserController::class, 'address_update'])->name('users.address_update');
        Route::post('users/bulk-delete', [AdminUserController::class, 'bulkDelete'])->name('users.bulk-delete');
        Route::resource('users', AdminUserController::class);

        Route::resource('careers', CareerController::class);
        Route::post('careers/bulk-delete', [CareerController::class, 'bulkDelete'])->name('careers.bulk-delete');

        Route::resource('newsletters', NewsletterController::class);
        Route::post('newsletters/bulk-delete', [NewsletterController::class, 'bulkDelete'])->name('newsletters.bulk-delete');

        Route::resource('reach-us', ReachUsController::class)->parameters(['reach-us' => 'reachUs']);
        Route::post('reach-us/bulk-delete', [ReachUsController::class, 'bulkDelete'])->name('reach-us.bulk-delete');

        Route::resource('banners', BannerController::class);
        Route::post('banners/bulk-delete', [BannerController::class, 'bulkDelete'])->name('banners.bulk-delete');

        Route::resource('competitors', CompetitorController::class);
        Route::post('competitors/bulk-delete', [CompetitorController::class, 'bulkDelete'])->name('competitors.bulk-delete');

        Route::resource('us-states', UsStateController::class);
        Route::post('us-states/bulk-delete', [UsStateController::class, 'bulkDelete'])->name('us-states.bulk-delete');

        Route::resource('sales-representatives', SalesRepresentativeController::class);
        Route::post('sales-representatives/bulk-delete', [SalesRepresentativeController::class, 'bulkDelete'])->name('sales-representatives.bulk-delete');

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