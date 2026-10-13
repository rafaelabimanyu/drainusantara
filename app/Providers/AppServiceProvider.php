<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Article;
use App\Models\CoverageArea;
use App\Models\Equipment;
use App\Models\Gallery;
use App\Models\Portfolio;
use App\Models\Review;
use App\Models\Service;
use App\Models\Staff;
use App\Observers\ContentCacheObserver;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->extend('seotools.json-ld-multi', fn ($service, $app) => new \App\Support\SafeJsonLdMulti(
            $app['config']->get('seotools.json-ld.defaults', []),
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (str_starts_with((string) config('app.url'), 'https://') || app()->isProduction()) {
            URL::forceScheme('https');
        }

        // 1. Invalidate frontend cache automatically when content changes in CMS
        $cacheObserver = ContentCacheObserver::class;
        Service::observe($cacheObserver);
        Review::observe($cacheObserver);
        Gallery::observe($cacheObserver);
        Article::observe($cacheObserver);
        Portfolio::observe($cacheObserver);
        CoverageArea::observe($cacheObserver);
        Staff::observe($cacheObserver);
        Equipment::observe($cacheObserver);

        // 2. Cache global layout navigation services for fast rendering
        View::composer('layouts.app', function ($view) {
            try {
                $navServices = Cache::remember('nav.services', 86400, function () {
                    return Service::where('is_active', true)->orderBy('order')->get();
                });
                $view->with('navServices', $navServices);
            } catch (\Throwable $e) {
                $view->with('navServices', collect());
            }
        });
    }
}
