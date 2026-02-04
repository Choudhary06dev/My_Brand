<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categories', [HomeController::class, 'categories'])->name('frontend.categories');
Route::get('/products', [HomeController::class, 'products'])->name('frontend.products');
Route::get('/sale/{slug?}', [HomeController::class, 'saleProducts'])->name('frontend.sale');


// Frontend Authentication Routes
Route::name('frontend.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('register', [RegisteredUserController::class, 'create'])
            ->name('register');

        Route::post('register', [RegisteredUserController::class, 'store'])
            ->name('register.store');

        Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('login');

        Route::post('login', [AuthenticatedSessionController::class, 'store'])
            ->name('login.store');

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
            ->name('password.request');

        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
            ->name('password.email');

        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
            ->name('password.reset');

        Route::post('reset-password', [NewPasswordController::class, 'store'])
            ->name('password.store');
    });

    Route::middleware('auth')->group(function () {
        Route::get('verify-email', EmailVerificationPromptController::class)
            ->name('verification.notice');

        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');

        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('verification.send');

        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->name('password.confirm');

        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store'])
            ->name('password.confirm.store');

        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
        Route::get('logout', [AuthenticatedSessionController::class, 'destroy']);

        // Profile & Orders
        Route::get('profile/orders', [App\Http\Controllers\Frontend\ProfileController::class, 'orders'])
            ->name('profile.orders');
        Route::get('profile/orders/{order_number}', [App\Http\Controllers\Frontend\ProfileController::class, 'orderDetail'])
            ->name('profile.order-detail');
        Route::post('profile/orders/{order_number}/cancel', [App\Http\Controllers\Frontend\ProfileController::class, 'cancelOrder'])
            ->name('profile.order-cancel');
        
        Route::get('profile/wallet', [App\Http\Controllers\Frontend\ProfileController::class, 'wallet'])
            ->name('profile.wallet');
            
        // Return Requests
        Route::get('profile/orders/{order_number}/return', [App\Http\Controllers\User\ReturnRequestController::class, 'showRequestForm'])
            ->name('profile.order-return');
        Route::post('profile/orders/{order_number}/return', [App\Http\Controllers\User\ReturnRequestController::class, 'storeRequest'])
            ->name('profile.order-return.store');
    });
});

// Dynamic Pages Routes
Route::get('/about', [HomeController::class, 'about'])->name('frontend.about');

Route::get('/companies/{id?}', [HomeController::class, 'companyShow'])->name('frontend.company.show');
Route::get('/category/{slug}', [HomeController::class, 'categoryDetail'])->name('frontend.category.detail');
Route::get('/services', [HomeController::class, 'services'])->name('frontend.services');
Route::get('/services/{slug}', [HomeController::class, 'serviceDetail'])->name('frontend.services.detail');
Route::get('/news', [HomeController::class, 'news'])->name('frontend.news');
Route::get('/news/{id}', [HomeController::class, 'newsDetail'])->name('frontend.news.detail');
Route::get('/products/{slug}', [HomeController::class, 'productDetail'])->name('frontend.products.detail');
Route::get('/contact', [HomeController::class, 'contact'])->name('frontend.contact');
Route::post('/contact', [HomeController::class, 'storeContact'])->name('frontend.contact.store');

Route::get('/cart', [App\Http\Controllers\Frontend\CartController::class, 'index'])->name('frontend.cart');
Route::post('/cart/add', [App\Http\Controllers\Frontend\CartController::class, 'addToCart'])->name('frontend.cart.add');
Route::post('/cart/update', [App\Http\Controllers\Frontend\CartController::class, 'updateCart'])->name('frontend.cart.update');
Route::post('/cart/remove', [App\Http\Controllers\Frontend\CartController::class, 'removeFromCart'])->name('frontend.cart.remove');
Route::get('/cart/count', [App\Http\Controllers\Frontend\CartController::class, 'cartCount'])->name('frontend.cart.count');
Route::get('/checkout', [App\Http\Controllers\Frontend\CheckoutController::class, 'index'])->name('frontend.checkout');
Route::post('/checkout/place-order', [App\Http\Controllers\Frontend\CheckoutController::class, 'placeOrder'])->name('frontend.checkout.place');
Route::get('/order/success/{order_number}', [App\Http\Controllers\Frontend\CheckoutController::class, 'success'])->name('frontend.order.success');
