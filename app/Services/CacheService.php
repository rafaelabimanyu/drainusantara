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
        'sitemap.html_data',
        'llms.txt',
        'ai-catalog.json',
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

    /**
     * Invalidate specific case study cache by slug.
     */
    public static function forgetCaseStudy(?string $slug): void
    {
        if ($slug) {
            Cache::forget('case_study_' . $slug);
        }
    }

    /**
     * Invalidate specific partnership cache by slug.
     */
    public static function forgetPartnership(?string $slug): void
    {
        if ($slug) {
            Cache::forget('partnership_' . $slug);
        }
    }

    /**
     * Invalidate specific equipment cache by slug.
     */
    public static function forgetEquipment(?string $slug): void
    {
        if ($slug) {
            Cache::forget('equipment_' . $slug);
        }
    }
}
