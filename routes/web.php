<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminCouponController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TrustController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteSettingsController;
use Illuminate\Support\Facades\Route;



// Route for Login
Route::controller(AdminAuthController::class)->group(function () {
    Route::get('admin/login', 'index')->name('admin.login');
    Route::post('admin/login-process', 'LoginProcess')->name('adminuser.login-process');
});


// Admin Section
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {

    // Route for admin homepage / Dashboard
    Route::controller(AdminAuthController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/logout', 'logout')->name('logout');
        Route::get('/change-password', 'changePassword')->name('change-password');
        Route::post('/password-update/{id}', 'updatePassword')->name('password-update');
    });

    // Admin crud
    Route::get('/admin', [AdminController::class, 'Admin'])->name('admin');
    Route::get('/admin_data', [AdminController::class, 'AdminData'])->name('admin.data');
    Route::get('/admin_edit_data', [AdminController::class, 'AdminEditData'])->name('admin.edit');
    Route::post('/admin_insert', [AdminController::class, 'AdminInsert'])->name('admin.insert');


    // Admin Routes
    Route::get('admins', [AdminRoleController::class, 'index'])->name('admins.index');
    Route::get('admins/create', [AdminRoleController::class, 'create'])->name('admins.create');
    Route::post('admins', [AdminRoleController::class, 'store'])->name('admins.store');
    Route::get('admins/{admin}/edit', [AdminRoleController::class, 'edit'])->name('admins.edit');
    Route::put('admins/{admin}', [AdminRoleController::class, 'update'])->name('admins.update');
    Route::delete('admins/{admin}', [AdminRoleController::class, 'destroy'])->name('admins.destroy');

    // Permission Routes
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');


    // Role Routes
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('roles/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');


    // customer list
    Route::get('/customer', [UserController::class, 'Customer'])->name('customer');
    Route::get('/customer_data', [UserController::class, 'CustomerData'])->name('customer.data');


    //  Website Settings
    Route::get('website_settings', [WebsiteSettingsController::class, 'WebsiteSettingsEditData'])->name('website_settings');
    Route::post('website_settings_update', [WebsiteSettingsController::class, 'WebsiteSettingsUpdate'])->name('website_settings.update');

    // slider crud
    Route::get('slider', [SliderController::class, 'Slider'])->name('slider');
    Route::get('slider_data', [SliderController::class, 'SliderData'])->name('slider.data');
    Route::get('slider_edit_data', [SliderController::class, 'SliderEditData'])->name('slider.edit');
    Route::post('slider_insert', [SliderController::class, 'SliderInsert'])->name('slider.insert');

    // banner crud
    Route::get('banner', [BannerController::class, 'Banner'])->name('banner');
    Route::get('banner_data', [BannerController::class, 'BannerData'])->name('banner.data');
    Route::get('banner_edit_data', [BannerController::class, 'BannerEditData'])->name('banner.edit');
    Route::post('banner_insert', [BannerController::class, 'BannerInsert'])->name('banner.insert');

    // feature crud
    Route::get('feature', [FeatureController::class, 'Feature'])->name('feature');
    Route::get('feature_data', [FeatureController::class, 'FeatureData'])->name('feature.data');
    Route::get('feature_edit_data', [FeatureController::class, 'FeatureEditData'])->name('feature.edit');
    Route::post('feature_insert', [FeatureController::class, 'FeatureInsert'])->name('feature.insert');

    // trust crud
    Route::get('trust', [TrustController::class, 'Trust'])->name('trust');
    Route::get('trust_data', [TrustController::class, 'TrustData'])->name('trust.data');
    Route::get('trust_edit_data', [TrustController::class, 'TrustEditData'])->name('trust.edit');
    Route::post('trust_insert', [TrustController::class, 'TrustInsert'])->name('trust.insert');

    // Page  crud
    Route::get('page', [PageController::class, 'Page'])->name('page');
    Route::get('page_data', [PageController::class, 'PageData'])->name('page.data');
    Route::get('page_edit_data', [PageController::class, 'PageEditData'])->name('page.edit');
    Route::post('page_insert', [PageController::class, 'PageInsert'])->name('page.insert');

    // Link  crud
    Route::get('link', [LinkController::class, 'Link'])->name('link');
    Route::get('link_data', [LinkController::class, 'LinkData'])->name('link.data');
    Route::get('link_edit_data', [LinkController::class, 'LinkEditData'])->name('link.edit');
    Route::post('link_insert', [LinkController::class, 'LinkInsert'])->name('link.insert');

    // City crud
    Route::get('city', [CityController::class, 'City'])->name('city');
    Route::get('city_data', [CityController::class, 'CityData'])->name('city.data');
    Route::get('city_edit_data', [CityController::class, 'CityEditData'])->name('city.edit');
    Route::post('city_insert', [CityController::class, 'CityInsert'])->name('city.insert');

    // Category crud
    Route::get('category', [CategoryController::class, 'Category'])->name('category');
    Route::get('category_data', [CategoryController::class, 'CategoryData'])->name('category.data');
    Route::get('category_edit_data', [CategoryController::class, 'CategoryEditData'])->name('category.edit');
    Route::post('category_insert', [CategoryController::class, 'CategoryInsert'])->name('category.insert');

    // Unit crud
    Route::get('unit', [UnitController::class, 'Unit'])->name('unit');
    Route::get('unit_data', [UnitController::class, 'UnitData'])->name('unit.data');
    Route::get('unit_edit_data', [UnitController::class, 'UnitEditData'])->name('unit.edit');
    Route::post('unit_insert', [UnitController::class, 'UnitInsert'])->name('unit.insert');

    // Product crud
    Route::get('product', [ProductController::class, 'Product'])->name('product');
    Route::get('product_data', [ProductController::class, 'ProductData'])->name('product.data');
    Route::get('product_edit_data', [ProductController::class, 'ProductEditData'])->name('product.edit');
    Route::post('product_insert', [ProductController::class, 'ProductInsert'])->name('product.insert');
    Route::get('product-gallery/{productId}', [ProductController::class, 'getProductGallery']);
    Route::delete('product-gallery/{imageId}', [ProductController::class, 'deleteProductGalleryImage']);


    // order management
    Route::get('/processing/orders', [AdminOrderController::class, 'processingOrderindex'])->name('processing.orders.index');
    Route::get('/processing/orders/orders_data', [AdminOrderController::class, 'processingOrderData'])->name('processing.orders.data');
    Route::get('/approved/orders', [AdminOrderController::class, 'approvedOrderIndex'])->name('approved.orders.index');
    Route::get('approved/orders/orders_data', [AdminOrderController::class, 'approvedOrderData'])->name('approved.orders.data');
    Route::get('/delivered/orders', [AdminOrderController::class, 'deliveredOrderIndex'])->name('delivered.orders.index');
    Route::get('delivered/orders/orders_data', [AdminOrderController::class, 'deliveredOrderData'])->name('delivered.orders.data');
    Route::get('/cancelled/orders', [AdminOrderController::class, 'cancelledOrderIndex'])->name('cancelled.orders.index');
    Route::get('cancelled/orders/orders_data', [AdminOrderController::class, 'cancelledOrderData'])->name('cancelled.orders.data');

    Route::get('/orders/details', [AdminOrderController::class, 'OrderDetails'])->name('orders.details');
    Route::post('/orders/approved', [AdminOrderController::class, 'OrderApproved'])->name('orders.approved');
    Route::post('/orders/delivered', [AdminOrderController::class, 'OrderDelivered'])->name('orders.delivered');
    Route::post('/orders/cancelled', [AdminOrderController::class, 'OrderCancelled'])->name('orders.cancelled');
    Route::post('/orders/delete', [AdminOrderController::class, 'OrderDelete'])->name('orders.delete');
    Route::post('/orders/discount', [AdminOrderController::class, 'applyDiscount'])->name('orders.discount');

    // user Invoice
    Route::get('/invoice/{id}', [InvoiceController::class, 'generateInvoice']);
    // delivery man invoice
    Route::get('/delivery-man/invoice/{id}', [InvoiceController::class, 'generateInvoiceForDeliveryMan']);


    // contact
    Route::get('contact', [ContactController::class, 'Contact'])->name('contact');
    Route::get('contact_data', [ContactController::class, 'ContactData'])->name('contact.data');
    Route::get('contact_details', [ContactController::class, 'ContactDetails'])->name('contact.details');
    Route::post('contact_delete', [ContactController::class, 'ContactDelete'])->name('contact.delete');


    // coupon management
    Route::get('coupon', [AdminCouponController::class, 'Coupon'])->name('coupon');
    Route::get('coupon_data', [AdminCouponController::class, 'CouponData'])->name('coupon.data');
    Route::get('coupon_edit_data', [AdminCouponController::class, 'CouponEditData'])->name('coupon.edit');
    Route::post('coupon_insert', [AdminCouponController::class, 'CouponInsert'])->name('coupon.insert');
    Route::post('coupon/toggle-status', [AdminCouponController::class, 'CouponToggleStatus'])->name('coupon.toggle-status');

    // End
});

// Route for applying coupon
Route::post('/apply-coupon', [CouponController::class, 'apply'])->name('coupon.apply');
Route::post('/remove-coupon', [CouponController::class, 'removeCoupon'])->name('coupon.remove');

// front-End Section


Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('/featured-products', [HomepageController::class, 'featuredProducts'])->name('featured.products');
Route::get('/upcoming-products', [HomepageController::class, 'upcomingProducts'])->name('upcoming.products');
Route::get('product/{category}/{name}/{id}', [HomepageController::class, 'ProductDetails'])->name('product-details');
Route::get('category/{name}/{id}', [HomepageController::class, 'CategoryWiseProduct'])->name('categorywise-product');

// page route
Route::get('/page/{slug}/{id}', [PageController::class, 'PageDetails'])->name('page.details');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact_process', [ContactController::class, 'store'])->name('contact.process');


// cart
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/delete', [CartController::class, 'deleteCart'])->name('cart.delete');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::get('user/checkout', [CartController::class, 'Checkout'])->name('user.checkout');
Route::get('/order-confirm', [OrderController::class, 'index'])->name('order-confirm');



// User Section
Route::prefix('user')->name('user.')->middleware('guest')->group(function () {
    Route::get('register', [UserController::class, 'create'])->name('register');
    Route::post('register_process', [UserController::class, 'store'])->name('register_process');
    Route::get('login', [UserController::class, 'index'])->name('login');
    Route::post('login_process', [UserController::class, 'LoginProcess'])->name('login_process');

    // password reset routes
    Route::get('forgot-password', [UserController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [UserController::class, 'sendResetLink'])->name('password.email');
    Route::get('reset-password/{token}', [UserController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [UserController::class, 'resetPassword'])->name('password.update');

    // End
});

// Route for user Dashboard
Route::prefix('user')->name('user.')->middleware('auth.user')->group(function () {
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('logout', [UserController::class, 'logout'])->name('logout');
    Route::get('change-password', [UserController::class, 'changePassword'])->name('change-password');
    Route::post('update-profile/{id}', [UserController::class, 'updateprofile'])->name('update-profile');
    Route::post('password-update/{id}', [UserController::class, 'updatePassword'])->name('password-update');
    Route::post('order', [OrderController::class, 'createOrder'])->name('order');
    Route::get('order-list', [OrderController::class, 'OrderList'])->name('order-list');
    Route::get('order-details/{order}', [OrderController::class, 'OrderDetails'])->name('order-details');
    Route::post('order-cancel/{order}', [OrderController::class, 'OrderCancel'])->name('order-cancel');
});

// Route for user Dashboard
Route::prefix('user')->name('user.')->group(function () {
    Route::post('order', [OrderController::class, 'createOrder'])->name('order');
});