<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasAutoOrder
{
    /**
     * Boot trait untuk auto-assign order jika belum terisi saat pembuatan model.
     */
    protected static function bootHasAutoOrder(): void
    {
        static::creating(function (Model $model): void {
            if (!isset($model->order) || (int) $model->order <= 0) {
                $model->order = static::getNextAvailableOrder();
            }
        });
    }

    /**
     * Dapatkan nomor urutan positif terkecil yang belum digunakan (gap-filling atau urutan berikutnya).
     */
    public static function getNextAvailableOrder(): int
    {
        $existingOrders = static::whereNotNull('order')
            ->where('order', '>', 0)
            ->pluck('order')
            ->map(fn($val) => (int) $val)
            ->all();

        if (empty($existingOrders)) {
            return 1;
        }

        $lookup = array_flip($existingOrders);
        $order = 1;
        while (isset($lookup[$order])) {
            $order++;
        }

        return $order;
    }
}
