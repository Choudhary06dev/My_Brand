<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $banners = \App\Models\Banner::where('is_active', true)->orderBy('order')->get();
    return view('welcome', compact('banners'));
});

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('categories', CategoryController::class)->names('admin.categories');
    Route::resource('products', ProductController::class)->names('admin.products');

    Route::get('/customers', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('admin.customers.index');
    Route::get('/customers/{user}', [App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('admin.customers.show');
    
    Route::resource('orders', App\Http\Controllers\Admin\OrderController::class)->names('admin.orders')->only(['index', 'show', 'update', 'destroy']);
    Route::resource('banners', App\Http\Controllers\Admin\BannerController::class)->names('admin.banners');
    Route::resource('coupons', App\Http\Controllers\Admin\CouponController::class)->names('admin.coupons');
    Route::resource('pages', App\Http\Controllers\Admin\PageController::class)->names('admin.pages');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
