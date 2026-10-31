<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Equipment;
use App\Models\Gallery;
use App\Models\Portfolio;
use App\Services\CacheService;
use Illuminate\Database\Eloquent\Model;

class ContentCacheObserver
{
    /**
     * Handle the model "saved" event (after create or update).
     */
    public function saved(Model $model): void
    {
        CacheService::clearPublicCache();
        $this->purgeDynamicEntityCache($model);
    }

    /**
     * Handle the model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        CacheService::clearPublicCache();
        $this->purgeDynamicEntityCache($model);
    }

    /**
     * Purge dynamic slug-based entity caches.
     */
    private function purgeDynamicEntityCache(Model $model): void
    {
        if ($model instanceof Gallery) {
            CacheService::forgetCaseStudy($model->slug);
            if ($model->isDirty('slug') || $model->wasChanged('slug')) {
                CacheService::forgetCaseStudy((string) $model->getOriginal('slug'));
            }
        } elseif ($model instanceof Portfolio) {
            CacheService::forgetPartnership($model->slug);
            if ($model->isDirty('slug') || $model->wasChanged('slug')) {
                CacheService::forgetPartnership((string) $model->getOriginal('slug'));
            }
        } elseif ($model instanceof Equipment) {
            CacheService::forgetEquipment($model->slug);
            if ($model->isDirty('slug') || $model->wasChanged('slug')) {
                CacheService::forgetEquipment((string) $model->getOriginal('slug'));
            }
        }
    }
}
