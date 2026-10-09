<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * List of all public cache keys used in the application.
     */
    public const PUBLIC_KEYS = [
        'nav.services',
        'landing.services',
        'landing.reviews',
        'landing.galleries',
        'landing.articles',
        'landing.portfolios',
        'services.all_active',
        'reviews.top3',
        'reviews.top4',
        'galleries.top3',
        'galleries.all_active',
        'staff.all_active',
        'equipments.all_active',
        'sitemap.xml',
        'llms.txt',
    ];

    /**
     * Flush all public frontend caches.
     */
    public static function clearPublicCache(): void
    {
        foreach (self::PUBLIC_KEYS as $key) {
            Cache::forget($key);
        }
    }
}
