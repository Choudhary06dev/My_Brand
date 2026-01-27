<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\ProductCategory;


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
        // Strict Session Isolation for Admin
        if (request()->is('admin') || request()->is('admin/*')) {
            config(['session.cookie' => 'aoht_admin_session']);
        } else {
            config(['session.cookie' => 'aoht_session']);
        }

        View::composer('frontend.*', function ($view) {
            $view->with('mainCategories', ProductCategory::whereNull('parent_id')->with('children.children')->orderBy('sequence')->get());
            $view->with('services', \App\Models\Service::orderBy('service_name')->get());
            $view->with('company', \App\Models\CompanyInfo::first());
        });
    }
}

