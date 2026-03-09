<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\ProductCategory;


use Illuminate\Support\Str;

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
        View::composer('frontend.*', function ($view) {
            $view->with('mainCategories', ProductCategory::whereNull('parent_id')->with('children.children')->orderBy('sequence')->get());

            // Categories that have products on sale
            $saleCategories = ProductCategory::whereHas('products', function ($query) {
                $query->where('is_sale', 1)->where('status', 1);
            })->orderBy('category_name')->get();

            $view->with('saleCategories', $saleCategories);
            $view->with('services', \App\Models\Service::orderBy('service_name')->get());
            $view->with('company', \App\Models\CompanyInfo::first() ?? new \App\Models\CompanyInfo());
        });

        View::composer('admin.layouts.partials.navbar', function ($view) {
            $unreadMessages = \App\Models\ContactMessage::where('is_read', false)->latest()->take(5)->get();
            $pendingOrders = \App\Models\Order::where('status', 'pending')->latest()->take(5)->get();
            $pendingReturns = \App\Models\ReturnRequest::where('status', 'pending')->latest()->take(5)->get();

            $totalUnread = $unreadMessages->count() + $pendingOrders->count() + $pendingReturns->count();

            $view->with([
                'unreadMessages' => $unreadMessages,
                'pendingOrders' => $pendingOrders,
                'pendingReturns' => $pendingReturns,
                'totalUnreadCount' => $totalUnread
            ]);
        });
    }
}
