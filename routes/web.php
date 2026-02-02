<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:admin', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Admin root -> Dashboard
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        // Roles & Users
        Route::resource('roles', App\Http\Controllers\Admin\RoleController::class);
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);

        // Company Services (company info managed from frontend)
        Route::resource('services', App\Http\Controllers\Admin\ServiceController::class);

        // Product Categories
        Route::resource('product-categories', App\Http\Controllers\Admin\ProductCategoryController::class);
        Route::get('sub-categories', [App\Http\Controllers\Admin\ProductCategoryController::class, 'subIndex'])
            ->name('product-categories.sub-index');
        Route::get('get-subcategories/{id}', [App\Http\Controllers\Admin\ProductCategoryController::class, 'getSubcategories'])
            ->name('get-subcategories');

        Route::post('product-categories/ajax-store', [App\Http\Controllers\Admin\ProductCategoryController::class, 'ajaxStore'])
            ->name('product-categories.ajax-store');
        Route::put('product-categories/ajax-update/{id}', [App\Http\Controllers\Admin\ProductCategoryController::class, 'ajaxUpdate'])
            ->name('product-categories.ajax-update');
        Route::delete('product-categories/ajax-destroy/{id}', [App\Http\Controllers\Admin\ProductCategoryController::class, 'ajaxDestroy'])
            ->name('product-categories.ajax-destroy');

        // Products
        Route::delete('products/gallery/{id}', [App\Http\Controllers\Admin\ProductController::class, 'deleteGalleryImage'])
            ->name('products.delete-gallery-image');
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class);

        // Blogs
        Route::resource('blogs', App\Http\Controllers\Admin\BlogController::class);

        // Contact Messages
        Route::resource('contact-messages', App\Http\Controllers\Admin\ContactMessageController::class);
        Route::post('contact-messages/{id}/send-reply', [App\Http\Controllers\Admin\ContactMessageController::class, 'sendReply'])
            ->name('contact-messages.send-reply');

        // Sliders
        Route::resource('sliders', App\Http\Controllers\Admin\SliderController::class);

        // Fabrics
        Route::resource('fabric-categories', App\Http\Controllers\Admin\FabricCategoryController::class);
        Route::post('fabric-categories/ajax-store', [App\Http\Controllers\Admin\FabricCategoryController::class, 'ajaxStore'])
            ->name('fabric-categories.ajax-store');

        Route::resource('fabrics', App\Http\Controllers\Admin\FabricController::class);
        Route::get('get-fabrics/{categoryId}', [App\Http\Controllers\Admin\FabricController::class, 'getFabricsByCategory'])
            ->name('get-fabrics');

        // Pages
        Route::get('pages/about', [App\Http\Controllers\Admin\AboutPageController::class, 'index'])
            ->name('pages.about');
        Route::put('pages/about', [App\Http\Controllers\Admin\AboutPageController::class, 'update'])
            ->name('pages.about.update');

        // Logs
        Route::get('activity-logs', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])
            ->name('activity-logs.index');
        Route::get('error-logs', [App\Http\Controllers\Admin\ErrorLogController::class, 'index'])
            ->name('error-logs.index');
        Route::get('visitors', [App\Http\Controllers\Admin\VisitorController::class, 'index'])
            ->name('visitors.index');
        
        // Profile
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Orders
        Route::get('orders/summary-page', [App\Http\Controllers\Admin\OrderController::class, 'summaryPage'])
            ->name('orders.summary-page');
        Route::get('orders/summary', [App\Http\Controllers\Admin\OrderController::class, 'getOrderSummary'])
            ->name('orders.summary');
        Route::patch('orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])
            ->name('orders.update-status');
        Route::resource('orders', App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'destroy']);

        // Return Management
        Route::get('returns', [App\Http\Controllers\Admin\ReturnManagementController::class, 'index'])
            ->name('returns.index');
        Route::get('returns/{id}', [App\Http\Controllers\Admin\ReturnManagementController::class, 'show'])
            ->name('returns.show');
        Route::patch('returns/{id}/status', [App\Http\Controllers\Admin\ReturnManagementController::class, 'updateStatus'])
            ->name('returns.update-status');
    });

/*
|--------------------------------------------------------------------------
| User Profile Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze / Jetstream)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    require __DIR__ . '/auth.php';
});

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/frontend.php';
