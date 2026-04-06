<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\OrderController;

// ----------------------
// Home & Contact
// ----------------------
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::view('/contact', 'contact')->name('contact');

// Shop Routes (Public)
Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/product/{id}', [App\Http\Controllers\ShopController::class, 'show'])->name('shop.product');

// ----------------------
// Authentication
// ----------------------
// Show login form
Route::get('/login', [UserController::class, 'loginForm'])->name('login');
// Process login
Route::post('/login', [UserController::class, 'login'])->name('login.post');

// Show signup form
Route::get('/signup', [UserController::class, 'signupForm'])->name('signup');
// Process signup
Route::post('/signup', [UserController::class, 'register'])->name('signup.post');

// ----------------------
// Protected routes (require login)
// ----------------------
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    // Profile (accessible by all authenticated users)
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');

    // Admin Dashboard
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');

        Route::get('/admin/vendors', [App\Http\Controllers\AdminController::class, 'vendors'])->name('admin.vendors');
        Route::post('/admin/vendor/store', [App\Http\Controllers\AdminController::class, 'storeVendor'])->name('admin.vendor.store');
        Route::put('/admin/vendor/update/{id}', [App\Http\Controllers\AdminController::class, 'updateVendor'])->name('admin.vendor.update');
        Route::delete('/admin/vendor/delete/{id}', [App\Http\Controllers\AdminController::class, 'deleteVendor'])->name('admin.vendor.delete');

        Route::get('/admin/customers', [App\Http\Controllers\AdminController::class, 'customers'])->name('admin.customers');
        Route::post('/admin/customer/store', [App\Http\Controllers\AdminController::class, 'storeCustomer'])->name('admin.customer.store');
        Route::put('/admin/customer/update/{id}', [App\Http\Controllers\AdminController::class, 'updateCustomer'])->name('admin.customer.update');
        Route::delete('/admin/customer/delete/{id}', [App\Http\Controllers\AdminController::class, 'deleteCustomer'])->name('admin.customer.delete');

        Route::get('/admin/categories', [CategoryController::class, 'adminIndex'])->name('admin.categories');

        Route::get('/admin/products', function () {
            return view('admin.products');
        })->name('admin.products');

        Route::get('/admin/vendor', [App\Http\Controllers\VendorController::class, 'adminVendor'])->name('admin.vendor');

    });

    // Vendor Dashboard
    Route::middleware('role:vendor')->group(function () {
        Route::get('/vendor/dashboard', [App\Http\Controllers\VendorController::class, 'dashboard'])->name('vendor.dashboard');
        Route::get('/vendor/products', [App\Http\Controllers\VendorController::class, 'products'])->name('vendor.products');
        Route::get('/vendor/orders', [App\Http\Controllers\VendorController::class, 'orders'])->name('vendor.orders');
        Route::get('/vendor/sales', [App\Http\Controllers\VendorController::class, 'sales'])->name('vendor.sales');
        Route::get('/vendor/reviews', [App\Http\Controllers\VendorController::class, 'reviews'])->name('vendor.reviews');
        Route::get('/vendor/settings', [App\Http\Controllers\VendorController::class, 'settings'])->name('vendor.settings');
        Route::put('/vendor/settings/profile', [App\Http\Controllers\VendorController::class, 'updateProfile'])->name('vendor.settings.profile');
        Route::put('/vendor/settings/shop', [App\Http\Controllers\VendorController::class, 'updateShop'])->name('vendor.settings.shop');
        Route::put('/vendor/settings/address', [App\Http\Controllers\VendorController::class, 'updateAddress'])->name('vendor.settings.address');
        Route::put('/vendor/settings/password', [App\Http\Controllers\VendorController::class, 'updatePassword'])->name('vendor.settings.password');
        Route::post('/vendor/product/store', [App\Http\Controllers\VendorController::class, 'storeProduct'])->name('vendor.product.store');
        Route::put('/vendor/product/{id}/update', [App\Http\Controllers\VendorController::class, 'updateProduct'])->name('vendor.product.update');
        Route::delete('/vendor/product/{id}/delete', [App\Http\Controllers\VendorController::class, 'deleteProduct'])->name('vendor.product.delete');
        Route::put('/vendor/order/{id}/update', [App\Http\Controllers\VendorController::class, 'updateOrderStatus'])->name('vendor.order.update');
    });

    // Customer Dashboard
    Route::middleware('role:customer')->group(function () {
        Route::get('/customer/dashboard', [App\Http\Controllers\CustomerController::class, 'dashboard'])->name('customer.dashboard');
        Route::get('/customer/orders', [App\Http\Controllers\CustomerController::class, 'orders'])->name('customer.orders');
        Route::get('/customer/profile', [App\Http\Controllers\CustomerController::class, 'profile'])->name('customer.profile');
        Route::get('/customer/reviews', [App\Http\Controllers\CustomerController::class, 'reviews'])->name('customer.reviews');
        Route::get('/customer/wishlist', [App\Http\Controllers\CustomerController::class, 'wishlist'])->name('customer.wishlist');
        Route::get('/customer/wishlist/count', [App\Http\Controllers\CustomerController::class, 'wishlistCount'])->name('customer.wishlist.count');
        Route::post('/customer/profile/update', [App\Http\Controllers\CustomerController::class, 'updateProfile'])->name('customer.profile.update');
        Route::post('/customer/address/update', [App\Http\Controllers\CustomerController::class, 'updateAddress'])->name('customer.address.update');
        Route::post('/customer/password/update', [App\Http\Controllers\CustomerController::class, 'updatePassword'])->name('customer.password.update');
        Route::put('/customer/preferences/update', [App\Http\Controllers\CustomerController::class, 'updatePreferences'])->name('customer.preferences.update');
        Route::get('/customer/wishlist/remove/{id}', [App\Http\Controllers\CustomerController::class, 'removeFromWishlist'])->name('customer.wishlist.remove');
        Route::post('/customer/review/store', [App\Http\Controllers\CustomerController::class, 'storeReview'])->name('customer.review.store');
        Route::post('/customer/order/{id}/cancel', [App\Http\Controllers\CustomerController::class, 'cancelOrder'])->name('customer.order.cancel');
        Route::get('/customer/order/{id}/view', [App\Http\Controllers\CustomerController::class, 'viewOrder'])->name('customer.order.view');
    });

    // Cart (accessible by all users, authentication handled in controller)
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update-quantity/{id}', [CartController::class, 'updateQuantity'])->name('cart.update.quantity');
    Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

    // Orders (accessible by customers and vendors)
    Route::middleware('auth')->group(function () {
        Route::get('/checkout', [OrderController::class, 'showCheckout'])->name('checkout');
        Route::post('/buy-now', [OrderController::class, 'buyNow'])->name('buy.now');
        Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');
        Route::get('/order/success', [OrderController::class, 'orderSuccess'])->name('order.success');
    });

    // Order Management (admin and vendor)
    Route::middleware(['auth', 'role:admin,vendor'])->group(function () {
        Route::get('/order/management', [OrderController::class, 'orderManagement'])->name('order.management');
        Route::put('/order/update-status/{id}', [OrderController::class, 'updateOrderStatus'])->name('order.update.status');
    });

    // Likes (accessible by all authenticated users)
    Route::post('/product/{id}/like', [LikeController::class, 'toggle'])->name('product.like');

    // Categories (admin only)
    Route::middleware('role:admin')->group(function () {
        Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
    });

    // Products (admin and vendor)
    Route::middleware('role:admin,vendor')->group(function () {
        Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
    });
});
