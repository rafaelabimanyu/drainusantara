<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleSubcategory;
use App\Models\CoverageArea;
use App\Models\Equipment;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class GscSeoAuditRemediationTest extends TestCase
{
    use RefreshDatabase;

    private function resetSeoFacades(): void
    {
        foreach (['seotools.json-ld-multi', 'seotools.metatags', 'seotools.opengraph', 'seotools.twitter'] as $service) {
            app()->forgetInstance($service);
            Facade::clearResolvedInstance($service);
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function extractJsonLdSchemas(string $html): array
    {
        preg_match_all('~<script type="application/ld\\+json"[^>]*>(.*?)</script>~s', $html, $scripts);
        $schemas = [];

        foreach ($scripts[1] as $raw) {
            $decoded = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
            if (isset($decoded['@graph']) && is_array($decoded['@graph'])) {
                foreach ($decoded['@graph'] as $node) {
                    $schemas[] = $node;
                }
            } elseif (array_is_list($decoded)) {
                foreach ($decoded as $node) {
                    $schemas[] = $node;
                }
            } else {
                $schemas[] = $decoded;
            }
        }

        return $schemas;
    }

    public function test_legacy_equipment_slugs_301_redirect_to_active_canonical_equipments(): void
    {
        $targets = [
            'mesin-drain-cleaner-spiral-rotary',
            'kamera-inspeksi-saluran-pipa',
            'mesin-hydro-jetting-tekanan-tinggi',
            'kabel-spiral-baja-drain-cleaner',
            'mesin-drain-cleaner-heavy-duty-roda',
            'set-mata-bor-pisau-spiral-drain-cleaner',
        ];

        foreach ($targets as $idx => $slug) {
            Equipment::create([
                'name' => 'Alat ' . $slug,
                'slug' => $slug,
                'order' => $idx + 1,
                'is_active' => true,
            ]);
        }

        $legacyMap = [
            'kamera-cctv-endoskopi-pipa-ip68-30-meter' => 'kamera-inspeksi-saluran-pipa',
            'mesin-drain-rooter-spiral-baja-rotary-ridgid-k-50-k-60' => 'mesin-drain-cleaner-spiral-rotary',
            'set-4-jenis-mata-pemotong-spiral-baja-modular' => 'set-mata-bor-pisau-spiral-drain-cleaner',
            'unit-pembersih-saluran-high-pressure-hydro-jetting' => 'mesin-hydro-jetting-tekanan-tinggi',
            'mesin-rooter-ridgid-k-50-cable-spiral' => 'mesin-drain-cleaner-spiral-rotary',
            'inspeksi-kamera-cctv-pipa-saluran' => 'kamera-inspeksi-saluran-pipa',
            'high-pressure-hydro-jetting-unit' => 'mesin-hydro-jetting-tekanan-tinggi',
        ];

        foreach ($legacyMap as $legacy => $canonical) {
            $res = $this->get('/tentang-kami/peralatan/' . $legacy);
            $res->assertStatus(301);
            $res->assertRedirect(route('equipment.show', ['slug' => $canonical]));
        }
    }

    public function test_legacy_article_slugs_301_redirect_to_canonical_replacement_articles(): void
    {
        $targets = [
            'standar-perawatan-grease-trap-restoran-kafe-cegah-lemak-membatu-di-pipa-utama',
            'kenapa-air-wastafel-sering-melambat-kenali-5-penyebab-utama-cara-mencegahnya',
            'pelacakan-presisi-tanpa-bongkar-standar-inspeksi-kamera-drainusantara',
            'solusi-tuntas-pipa-mampet-dapur-komersial-mengapa-mesin-spiral-baja-lebih-aman-dari-bahan-kimia',
            'mengenal-mesin-ridgid-fungsi-teknologi-dan-kegunaannya-untuk-mengatasi-saluran-pipa-mampet',
        ];

        foreach ($targets as $slug) {
            Article::create([
                'title' => 'Artikel ' . $slug,
                'slug' => $slug,
                'content' => 'Konten edukasi sanitasi pipa.',
                'is_published' => true,
                'published_at' => now(),
            ]);
        }

        $legacyMap = [
            'panduan-perawatan-grease-trap-dapur-restoran' => 'standar-perawatan-grease-trap-restoran-kafe-cegah-lemak-membatu-di-pipa-utama',
            '5-kebiasaan-penyebab-bak-cuci-piring-tersumbat' => 'kenapa-air-wastafel-sering-melambat-kenali-5-penyebab-utama-cara-mencegahnya',
            'kapan-saluran-pipa-butuh-inspeksi-kamera-cctv' => 'pelacakan-presisi-tanpa-bongkar-standar-inspeksi-kamera-drainusantara',
            'bahaya-menggunakan-soda-api-saluran-mampet' => 'solusi-tuntas-pipa-mampet-dapur-komersial-mengapa-mesin-spiral-baja-lebih-aman-dari-bahan-kimia',
            'bahaya-kawat-manual-saluran-pipa-mampet' => 'mengenal-mesin-ridgid-fungsi-teknologi-dan-kegunaannya-untuk-mengatasi-saluran-pipa-mampet',
        ];

        foreach ($legacyMap as $legacy => $target) {
            $res = $this->get('/artikel/' . $legacy);
            $res->assertStatus(301);
            $res->assertRedirect(route('articles.show', ['slug' => $target]));

            $siloRes = $this->get('/edukasi/edukasi/tips/' . $legacy);
            $siloRes->assertStatus(301);
            $siloRes->assertRedirect(route('articles.show', ['slug' => $target]));
        }
    }

    public function test_legacy_gallery_demo_case_study_slugs_301_redirect_to_matching_canonical_services(): void
    {
        $legacyCaseStudies = [
            'pelancaran-floor-drain-kamar-mandi-utama' => 'jasa-kamar-mandi-dan-floor-drain-mampet',
            'ekstraksi-benda-asing-dari-kloset-duduk-hunian' => 'jasa-wc-dan-kloset-mampet',
            'inspeksi-kamera-cctv-pipa-bawah-tanah-ruko-kantor' => 'jasa-inspeksi-kamera-cctv-pipa',
            'kuras-grease-trap-dan-sedot-lemak-kafe-komersial' => 'jasa-hydro-jetting-dan-rooter-pipa',
            'pelancaran-pipa-wastafel-dapur-restoran' => 'jasa-wastafel-dan-cucian-piring-mampet',
            'pelancaran-pipa-talang-air-hujan-rooftop-hunian' => 'jasa-talang-air-dan-saluran-utama-mampet',
        ];

        foreach ($legacyCaseStudies as $legacySlug => $targetServiceSlug) {
            $res = $this->get('/studi-kasus/' . $legacySlug);
            $res->assertStatus(301);
            $res->assertRedirect(route('services.show', ['slug' => $targetServiceSlug]));
        }
    }

    public function test_depok_salin_judul_article_redirects_one_hop_to_depok_cinere_and_excluded_from_sitemap(): void
    {
        $depokArticle = Article::create([
            'title' => 'Jasa Saluran Pipa Mampet Depok (Salin Judul)',
            'slug' => 'jasa-saluran-pipa-mampet-depok-perbaikan-pelancaran-saluran-air-profesional-salin-judul',
            'content' => 'Konten duplikat Depok.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->get('/artikel/' . $depokArticle->slug)
            ->assertStatus(301)
            ->assertRedirect(route('area.city', ['city' => 'depok-cinere']));

        $this->get('/edukasi/edukasi/umum/' . $depokArticle->slug)
            ->assertStatus(301)
            ->assertRedirect(route('area.city', ['city' => 'depok-cinere']));

        Cache::forget('sitemap.xml');
        Cache::forget('sitemap_xml');
        $sitemap = $this->get('/sitemap.xml')->assertOk()->getContent();
        $this->assertStringNotContainsString($depokArticle->slug, $sitemap);
    }

    public function test_article_slug_sanitizer_strips_salin_judul_suffix_on_admin_store(): void
    {
        $this->assertSame('panduan-pipa-depok', Article::sanitizeSlug('panduan-pipa-depok-salin-judul'));

        $admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.local',
            'password' => Hash::make('secret123'),
        ]);

        $this->actingAs($admin)->post(route('admin.articles.store'), [
            'title' => 'Panduan Pipa Depok Salin Judul',
            'slug' => 'panduan-pipa-depok-salin-judul',
            'content' => 'Konten panduan teknis saluran pipa.',
            'is_published' => '1',
        ])->assertRedirect();

        $this->assertDatabaseHas('articles', ['slug' => 'panduan-pipa-depok']);
        $this->assertDatabaseMissing('articles', ['slug' => 'panduan-pipa-depok-salin-judul']);
    }

    public function test_semarang_article_renders_200_with_contextual_semarang_area_hub_link(): void
    {
        $cat = ArticleCategory::create(['name' => 'Edukasi', 'slug' => 'edukasi']);
        $sub = ArticleSubcategory::create(['category_id' => $cat->id, 'name' => 'Layanan Lokal', 'slug' => 'layanan-lokal']);

        $article = Article::create([
            'title' => 'Jasa Saluran Pipa Mampet Semarang Perbaikan Cepat Tanpa Bongkar Keramik',
            'slug' => 'jasa-saluran-pipa-mampet-semarang-perbaikan-cepat-tanpa-bongkar-keramik',
            'category_id' => $cat->id,
            'subcategory_id' => $sub->id,
            'category' => 'Edukasi',
            'sub_category' => 'Layanan Lokal',
            'content' => 'Panduan penanganan saluran mampet untuk rumah dan ruko di Semarang.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $res = $this->get('/artikel/' . $article->slug)->assertOk();
        $html = $res->getContent();

        $this->assertStringContainsString(route('area.city', ['city' => 'semarang']), $html);
        // Breadcrumbs must link directly to /pengetahuan?category=..., never 301 /edukasi/...
        $this->assertStringNotContainsString('href="' . url('/edukasi/' . $cat->slug) . '"', $html);
        $this->assertStringContainsString(route('articles.index', ['category' => $cat->slug]), $html);
    }

    public function test_sitemap_excludes_edukasi_categories_privacy_policy_and_duplicate_districts(): void
    {
        ArticleCategory::create(['name' => 'Edukasi', 'slug' => 'edukasi']);
        ArticleCategory::create(['name' => 'Tips', 'slug' => 'tips']);

        Cache::forget('sitemap.xml');
        Cache::forget('sitemap_xml');
        $xml = $this->get('/sitemap.xml')->assertOk()->getContent();

        $this->assertStringNotContainsString('/edukasi/', $xml);
        $this->assertStringNotContainsString('/kebijakan-privasi</loc>', $xml);
        $this->assertStringContainsString('/syarat-dan-ketentuan</loc>', $xml);

        foreach ([
            '/area/demak/demak</loc>',
            '/area/bogor/kota-bogor</loc>',
            '/area/kabupaten-gianyar/gianyar</loc>',
            '/area/kabupaten-tabanan/tabanan</loc>',
            '/area/kabupaten-buleleng/buleleng</loc>',
            '/area/kabupaten-bangli/bangli</loc>',
            '/area/kabupaten-karangasem/karangasem</loc>',
        ] as $dupLoc) {
            $this->assertStringNotContainsString($dupLoc, $xml, "Duplicate district leaked into sitemap: {$dupLoc}");
        }

        // Non-duplicate districts stay active in sitemap by default (Opsi 2)
        $this->assertStringContainsString('/area/kabupaten-klungkung/klungkung</loc>', $xml);
        $this->assertStringContainsString('/area/jakarta-selatan/tebet</loc>', $xml);
    }

    public function test_noindex_follow_applied_to_sitemap_privacy_and_paginated_or_search_pengetahuan(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            Article::create([
                'title' => "Panduan Saluran {$i}",
                'slug' => "panduan-saluran-{$i}",
                'content' => 'Konten perawatan pipa.',
                'is_published' => true,
                'published_at' => now()->subDays($i),
            ]);
        }

        foreach (['/sitemap', '/kebijakan-privasi', '/pengetahuan?page=2', '/pengetahuan?q=wastafel'] as $path) {
            $this->resetSeoFacades();
            $html = $this->get($path)->assertOk()->getContent();
            $this->assertStringContainsString('<meta name="robots" content="noindex, follow">', $html, "Missing noindex, follow on {$path}");
        }

        // /syarat-dan-ketentuan and /pengetahuan (page 1) must remain indexable
        foreach (['/syarat-dan-ketentuan', '/pengetahuan'] as $path) {
            $this->resetSeoFacades();
            $html = $this->get($path)->assertOk()->getContent();
            $this->assertStringNotContainsString('noindex', $html, "Unexpected noindex on {$path}");
        }
    }

    public function test_json_ld_schemas_have_no_instock_no_duplicate_beranda_and_no_product_on_equipment(): void
    {
        $equipment = Equipment::create([
            'name' => 'Mesin Drain Cleaner Spiral Rotary',
            'slug' => 'mesin-drain-cleaner-spiral-rotary',
            'category' => 'Mesin Utama',
            'short_description' => 'Mesin spiral baja untuk pelancaran saluran mampet.',
            'is_active' => true,
        ]);

        // 1. Equipment detail: Plumber + Service, no Product/AggregateOffer/InStock
        $this->resetSeoFacades();
        $equipHtml = $this->get(route('equipment.show', $equipment->slug))->assertOk()->getContent();
        $equipSchemas = $this->extractJsonLdSchemas($equipHtml);
        $equipTypes = array_column($equipSchemas, '@type');
        $this->assertContains('Plumber', $equipTypes);
        $this->assertContains('Service', $equipTypes);
        $this->assertNotContains('Product', $equipTypes);
        $this->assertStringNotContainsString('https://schema.org/InStock', $equipHtml);
        $this->assertStringContainsString('property="og:type" content="website"', $equipHtml);

        // 2. Contact page: single Beranda in BreadcrumbList
        $this->resetSeoFacades();
        $contactHtml = $this->get(route('contact'))->assertOk()->getContent();
        $contactSchemas = $this->extractJsonLdSchemas($contactHtml);
        $breadcrumbs = array_values(array_filter($contactSchemas, static fn (array $s): bool => ($s['@type'] ?? null) === 'BreadcrumbList'));
        $this->assertCount(1, $breadcrumbs);
        $names = array_column($breadcrumbs[0]['itemListElement'], 'name');
        $this->assertSame(['Beranda', 'Kontak & Pemesanan'], $names);

        // 3. Home, Service, Area pages: zero InStock
        foreach (['/', '/layanan/jasa-wc-dan-kloset-mampet', '/area/jakarta-selatan', '/area/jakarta-selatan/tebet'] as $path) {
            $this->resetSeoFacades();
            $html = $this->get($path)->assertOk()->getContent();
            $this->assertStringNotContainsString('https://schema.org/InStock', $html, "Unexpected InStock on {$path}");
        }

        // 4. Service detail page has full Plumber + Service with areaServed
        $this->resetSeoFacades();
        $svcHtml = $this->get('/layanan/jasa-wc-dan-kloset-mampet')->assertOk()->getContent();
        $svcSchemas = $this->extractJsonLdSchemas($svcHtml);
        $svcTypes = array_column($svcSchemas, '@type');
        $this->assertContains('Plumber', $svcTypes);
        $this->assertContains('Service', $svcTypes);
        $serviceNode = collect($svcSchemas)->firstWhere('@type', 'Service');
        $this->assertNotEmpty($serviceNode['areaServed'] ?? null);
    }

    public function test_case_study_title_is_under_58_chars_with_single_brand_and_links_to_city_and_service(): void
    {
        $service = Service::create([
            'name' => 'Wastafel Cuci Piring Mampet',
            'slug' => 'wastafel-cuci-piring-mampet',
            'is_active' => true,
        ]);

        $study = Gallery::create([
            'title' => 'Pelancaran Pipa Wastafel Mampet di BSD Tangerang oleh Drainusantara',
            'slug' => 'pelancaran-pipa-wastafel-mampet-di-bsd-tangerang',
            'category' => 'rumahan',
            'service_id' => $service->id,
            'location' => 'BSD, Tangerang',
            'drain_type' => 'Wastafel Dapur',
            'method' => 'Spiral Rotary Ridgid K-50',
            'is_active' => true,
        ]);

        $res = $this->get(route('case-study.show', $study->slug))->assertOk();
        $html = $res->getContent();

        $dom = new \DOMDocument;
        @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
        $title = trim((new \DOMXPath($dom))->evaluate('string(//title)'));

        $this->assertLessThanOrEqual(58, mb_strlen($title), "Case study title too long ({$title})");
        $this->assertStringEndsWith('oleh Drainusantara', $title);
        $this->assertSame(1, substr_count($title, 'Drainusantara'));
        $this->assertStringNotContainsString('| Studi Kasus |', $title);

        // Internal linking to City Hub & canonical Service detail
        $this->assertStringContainsString(route('area.city', ['city' => 'tangerang-selatan']), $html);
        $this->assertStringContainsString(route('services.show', ['slug' => 'jasa-wastafel-dan-cucian-piring-mampet']), $html);
        $this->assertStringNotContainsString('/#layanan', $html);
    }

    public function test_seven_duplicate_city_district_slugs_301_to_city_hub_and_cms_is_priority_toggle_works(): void
    {
        $duplicates = [
            '/area/demak/demak' => '/area/demak',
            '/area/bogor/kota-bogor' => '/area/bogor',
            '/area/kabupaten-gianyar/gianyar' => '/area/kabupaten-gianyar',
            '/area/kabupaten-tabanan/tabanan' => '/area/kabupaten-tabanan',
            '/area/kabupaten-buleleng/buleleng' => '/area/kabupaten-buleleng',
            '/area/kabupaten-bangli/bangli' => '/area/kabupaten-bangli',
            '/area/kabupaten-karangasem/karangasem' => '/area/kabupaten-karangasem',
        ];

        foreach ($duplicates as $from => $to) {
            $this->get($from)
                ->assertStatus(301)
                ->assertRedirect(url($to));
        }

        // Klungkung stays 200 OK
        $this->get('/area/kabupaten-klungkung/klungkung')->assertOk();

        // CMS is_priority = false redirects district 301 to city hub & removes it from sitemap
        $tebet = CoverageArea::create([
            'type' => 'district',
            'city' => 'Jakarta Selatan',
            'district' => 'Tebet',
            'slug' => 'tebet',
            'is_active' => true,
            'is_priority' => false,
        ]);

        $this->get('/area/jakarta-selatan/tebet')
            ->assertStatus(301)
            ->assertRedirect(route('area.city', ['city' => 'jakarta-selatan']));

        Cache::forget('sitemap.xml');
        Cache::forget('sitemap_xml');
        $sitemap = $this->get('/sitemap.xml')->assertOk()->getContent();
        $this->assertStringNotContainsString('/area/jakarta-selatan/tebet</loc>', $sitemap);

        // Inactive area still returns 404 (not 301)
        $tebet->update(['is_active' => false]);
        $this->get('/area/jakarta-selatan/tebet')->assertNotFound();

        // Admin CMS listing & edit views render district status badges and is_priority checkbox cleanly
        $admin = User::create([
            'name' => 'Admin Area Test',
            'email' => 'admin-area@test.local',
            'password' => Hash::make('secret123'),
        ]);
        $tebet->update(['is_active' => true, 'is_priority' => false]);
        $this->actingAs($admin)
            ->get('/admin/coverage-areas?type=district')
            ->assertOk()
            ->assertSee('Konsolidasi 301', false)
            ->assertSee('Prioritas GSC', false);

        $this->actingAs($admin)
            ->get(route('admin.coverage-areas.edit', $tebet))
            ->assertOk()
            ->assertSee('name="is_priority"', false);
    }

    public function test_desktop_rendering_fixes_navbar_canonical_links_and_bali_cluster_visibility(): void
    {
        $homeHtml = $this->get('/')->assertOk()->getContent();

        // 1. Navbar links Layanan directly to /layanan, includes demak & kabupaten-semarang (no broken kabupaten-demak)
        $this->assertStringContainsString('href="' . route('services.index') . '"', $homeHtml);
        $this->assertStringContainsString(route('area.city', ['city' => 'demak']), $homeHtml);
        $this->assertStringContainsString(route('area.city', ['city' => 'kabupaten-semarang']), $homeHtml);
        $this->assertStringNotContainsString('kabupaten-demak', $homeHtml);

        // 2. Homepage has Bali coverage card, default GTM container, & no content-auto on main sections
        $this->assertStringContainsString(route('area.province', ['province' => 'bali']), $homeHtml);
        $this->assertStringContainsString(route('area.city', ['city' => 'kota-denpasar']), $homeHtml);
        $this->assertStringContainsString("})(window,document,'script','dataLayer','GTM-5C655FNM');", $homeHtml);
        $this->assertStringContainsString('https://www.googletagmanager.com/ns.html?id=GTM-5C655FNM', $homeHtml);
        $this->assertStringNotContainsString('content-auto', $homeHtml);

        // 3. City hero H1 has no reveal-soft & uses 22ch max-width
        $cityHtml = $this->get('/area/semarang')->assertOk()->getContent();
        $this->assertStringContainsString('.area-city-page .area-hero h1 { max-width: 22ch;', $cityHtml);
        $this->assertDoesNotMatchRegularExpression('/<h1[^>]*reveal-soft/', $cityHtml);
        $this->assertStringContainsString('Bali &amp; Sekitarnya', $cityHtml);
    }
}
