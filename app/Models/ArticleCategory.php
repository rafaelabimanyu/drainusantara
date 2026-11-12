<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ArticleCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $category): void {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            } else {
                $category->slug = Str::slug($category->slug);
            }
        });
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(ArticleSubcategory::class, 'category_id')->orderBy('sort_order')->orderBy('name');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'category_id');
    }

    /**
     * Ensure default categories and subcategories exist, returning full collection.
     */
    public static function ensureDefaults(): \Illuminate\Database\Eloquent\Collection
    {
        if (static::query()->count() === 0) {
            $defaults = [
                ['name' => 'Edukasi', 'slug' => 'edukasi', 'sort_order' => 1, 'subs' => ['Tips Wastafel & Kloset', 'Penyebab & Bahaya Kimia', 'Mesin & Teknologi Rooter']],
                ['name' => 'Penguatan Brand', 'slug' => 'penguatan-brand', 'sort_order' => 2, 'subs' => ['Profil & Keunggulan Layanan', 'Garansi & Standar SOP K3', 'Armada Siaga Lapangan']],
                ['name' => 'Promo Penawaran', 'slug' => 'promo-penawaran', 'sort_order' => 3, 'subs' => ['Paket Residensial', 'Komersial & B2B Resto', 'Penanganan Darurat 24 Jam']],
            ];
            foreach ($defaults as $item) {
                $cat = static::create([
                    'name' => $item['name'],
                    'slug' => $item['slug'],
                    'sort_order' => $item['sort_order'],
                ]);
                foreach ($item['subs'] as $idx => $sub) {
                    ArticleSubcategory::create([
                        'category_id' => $cat->id,
                        'name' => $sub,
                        'slug' => Str::slug($sub),
                        'sort_order' => $idx + 1,
                    ]);
                }
            }
        }

        return static::with('subcategories')->orderBy('sort_order')->orderBy('name')->get();
    }
}
