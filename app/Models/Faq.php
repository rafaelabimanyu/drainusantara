<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'category',
        'order',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Common categories dictionary.
     */
    public static function categories(): array
    {
        return [
            'teknis' => 'Metode & Teknis Pipa',
            'durasi' => 'Estimasi Waktu & Durasi',
            'biaya' => 'Biaya & Tarif Transparan',
            'garansi' => 'Garansi & Jaminan',
            'wilayah' => 'Jangkauan Wilayah & Dispatch',
            'layanan' => 'Layanan Komersial & B2B',
            'peralatan' => 'Peralatan & Mesin',
            'darurat' => 'Keadaan Darurat & Luapan',
            'administrasi' => 'Legalitas & Faktur Pajak',
            'umum' => 'Pertanyaan Umum',
        ];
    }

    /**
     * Get label for the current category.
     */
    public function getCategoryLabelAttribute(): string
    {
        return self::categories()[$this->category] ?? ucfirst($this->category);
    }

    /**
     * Scope for active FAQs.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured FAQs on homepage.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for filtering by category.
     */
    public function scopeCategory(Builder $query, ?string $category): Builder
    {
        if ($category && $category !== 'all') {
            return $query->where('category', $category);
        }

        return $query;
    }

    /**
     * Scope for default ordering.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Get next available order number.
     */
    public static function getNextAvailableOrder(): int
    {
        return ((int) self::max('order')) + 1;
    }
}

