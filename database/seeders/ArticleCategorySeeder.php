<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleSubcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Edukasi',
                'slug' => 'edukasi',
                'description' => 'Panduan, tips pemeliharaan pipa, bahaya kimia, dan edukasi seputar sistem saluran air plumbing.',
                'sort_order' => 1,
                'subcategories' => [
                    ['name' => 'Tips Wastafel & Kloset', 'slug' => 'tips-wastafel-kloset', 'sort_order' => 1],
                    ['name' => 'Penyebab & Bahaya Kimia', 'slug' => 'penyebab-bahaya-kimia', 'sort_order' => 2],
                    ['name' => 'Mesin & Teknologi Rooter', 'slug' => 'mesin-teknologi-rooter', 'sort_order' => 3],
                ],
            ],
            [
                'name' => 'Penguatan Brand',
                'slug' => 'penguatan-brand',
                'description' => 'Informasi profil layanan Drainusantara, SOP pengerjaan K3, garansi resmi, dan armada teknisi siaga.',
                'sort_order' => 2,
                'subcategories' => [
                    ['name' => 'Profil & Keunggulan Layanan', 'slug' => 'profil-keunggulan-layanan', 'sort_order' => 1],
                    ['name' => 'Garansi & Standar SOP K3', 'slug' => 'garansi-standar-sop-k3', 'sort_order' => 2],
                    ['name' => 'Armada Siaga Lapangan', 'slug' => 'armada-siaga-lapangan', 'sort_order' => 3],
                ],
            ],
            [
                'name' => 'Promo Penawaran',
                'slug' => 'promo-penawaran',
                'description' => 'Paket penawaran khusus residensial, kemitraan komersial restoran B2B, dan layanan darurat 24 jam.',
                'sort_order' => 3,
                'subcategories' => [
                    ['name' => 'Paket Residensial', 'slug' => 'paket-residensial', 'sort_order' => 1],
                    ['name' => 'Komersial & B2B Resto', 'slug' => 'komersial-b2b-resto', 'sort_order' => 2],
                    ['name' => 'Penanganan Darurat 24 Jam', 'slug' => 'penanganan-darurat-24-jam', 'sort_order' => 3],
                ],
            ],
        ];

        foreach ($categories as $catData) {
            $subs = $catData['subcategories'];
            unset($catData['subcategories']);

            $category = ArticleCategory::firstOrCreate(
                ['slug' => $catData['slug']],
                $catData
            );

            foreach ($subs as $subData) {
                ArticleSubcategory::firstOrCreate(
                    [
                        'category_id' => $category->id,
                        'slug' => $subData['slug'],
                    ],
                    $subData
                );
            }
        }

        // Relate existing articles
        foreach (Article::all() as $article) {
            $catSlug = $article->category_slug;
            $category = ArticleCategory::where('slug', $catSlug)->first();
            if ($category) {
                $article->category_id = $category->id;
                if (!empty($article->sub_category)) {
                    $subSlug = Str::slug($article->sub_category);
                    $subcategory = ArticleSubcategory::where('category_id', $category->id)
                        ->where(function ($q) use ($subSlug, $article): void {
                            $q->where('slug', $subSlug)->orWhere('name', $article->sub_category);
                        })->first();
                    if ($subcategory) {
                        $article->subcategory_id = $subcategory->id;
                    }
                }
                $article->saveQuietly();
            }
        }
    }
}
