<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        \Illuminate\Support\Facades\View::composer('layouts.app', function ($view) {
            try {
                $navServices = \App\Models\Service::where('is_active', true)->orderBy('order')->get();
                $view->with('navServices', $navServices);
            } catch (\Throwable $e) {
                $view->with('navServices', collect());
            }
        });
    }
}
