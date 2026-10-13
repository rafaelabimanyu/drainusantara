<?php

declare(strict_types=1);

namespace App\Observers;

use App\Services\CacheService;

class ContentCacheObserver
{
    /**
     * Handle the model "saved" event (after create or update).
     */
    public function saved(): void
    {
        CacheService::clearPublicCache();
    }

    /**
     * Handle the model "deleted" event.
     */
    public function deleted(): void
    {
        CacheService::clearPublicCache();
    }
}
