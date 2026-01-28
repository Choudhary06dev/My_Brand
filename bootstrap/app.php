<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\TrackVisitors::class,
        ]);

        $middleware->redirectTo(
            guests: function ($request) {
                if ($request->is('admin') || $request->is('admin/*')) {
                    return \Illuminate\Support\Facades\Route::has('admin.login') 
                        ? route('admin.login') 
                        : url('/admin/login');
                }
                return \Illuminate\Support\Facades\Route::has('frontend.login') 
                    ? route('frontend.login') 
                    : url('/login');
            },
            users: function ($request) {
                if ($request->is('admin') || $request->is('admin/*')) {
                    if (\Illuminate\Support\Facades\Auth::guard('admin')->check()) {
                        return route('admin.dashboard');
                    }
                } else {
                    if (\Illuminate\Support\Facades\Auth::guard('web')->check()) {
                        return route('home');
                    }
                }
                // If not authenticated in the specific guard, don't redirect (let them see the guest page)
                return null; 
            }
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
