# Rencana Perbaikan Teknis SEO & Arsitektur `drainusantara.id`

Dokumen ini merangkum hasil audit data ekspor Google Search Console (`14 Nov 2026 - 20 Nov 2026` vs `7 Nov 2026 - 13 Nov 2026`), inspeksi langsung codebase Laravel 13, **serta validasi terhadap dump database production `drainusantara_selected.sql`** (`17 artikel`, `30 studi kasus`, `8 layanan`, `6 peralatan`, `278 area cakupan`). **Belum ada file codebase yang diubah.**

> [!NOTE]
> **Temuan Validasi Database Production (`drainusantara_selected.sql`):**
> - **`articles` (17 baris)**: Artikel ID 12 (`...-salin-judul`) berstatus `is_published = 1` -> selain 301 redirect ke `/area/depok-cinere`, slug ini akan **dikecualikan otomatis** dari `sitemap.xml`, `/pengetahuan`, homepage, dan widget artikel terkait lewat scope `Article::scopeIndexable()` agar nol internal link mengarah ke URL 301. Artikel ID 13 (`jasa-saluran-pipa-mampet-semarang-...`) **tetap aktif `200 OK`** dengan penguatan internal link kontekstual ke `/area/semarang`.
> - **`services` (8 baris)**: Seluruh 7 layanan aktif di production DB masih menyimpan slug alias lama (termasuk ID 7 `pelancaran-bak-kontrol-mampet`). Penggunaan `Service::getCanonicalSlugAttribute()` pada 4 view akan menghapus 100% internal link 301 layanan.
> - **`galleries` (30 baris)**: Dry-run 30/30 studi kasus riil production menghasilkan **0 judul > 58 karakter** (43-58 kar, semua berakhir `oleh Drainusantara`), **0 gagal match `/area/{kota}`**, dan **0 gagal match `/layanan/{slug}`**, termasuk edge-case: ID 24 (`location = NULL`, fallback baca `title`), ID 35 (`location = "La Trobe Coffee & Brunch"`, fallback baca `slug` `cilandak-barat`), ID 7 (`"BSD, Tangerang"` -> `tangerang-selatan`, bukan `tangerang-kota`), dan ID 31 (`service_id = NULL`, fallback ke `jasa-talang-air-dan-saluran-utama-mampet`).
> - **`coverage_areas` (278 baris: 6 provinsi, 26 kota, 246 kecamatan)**: Semua 239 kecamatan non-kembar tetap aktif `200 OK` dan masuk `sitemap.xml` sesuai Opsi 2 (hanya 7 slug kembar seperti `demak/demak` yang di-`301` ke hub kotanya). Daftar referensi **53 kecamatan prioritas** terverifikasi 100% slug eksaknya terhadap `RegionService::all()` disiapkan di `config/area_priority.php` sebagai badge rekomendasi di CMS Admin & preset jika suatu saat mode pruning global diaktifkan.

> [!IMPORTANT]
> **Keputusan Final yang Sudah Dikonfirmasi & Diperbarui dengan Live Audit GSC 27 Nov 2026 ([docs/gsc-indexing-audit-2026-11-27.md](./docs/gsc-indexing-audit-2026-11-27.md)):**
> 1. **Kanonik Artikel (`/artikel/{slug}`) & Slug Kembar**: Seluruh artikel menggunakan `/artikel/{slug}` sebagai kanonik tunggal; seluruh `/edukasi/{category}/{subcategory}/{slug}` di-`301` ke `/artikel/{slug}` (Depok `-salin-judul` langsung 1-hop `301` ke `/area/depok-cinere`; artikel ID 13 Semarang tetap aktif dengan internal link kuat ke `/area/semarang`). 7 slug kembar (`demak/demak`, `bogor/kota-bogor`, `kabupaten-gianyar/gianyar`, `kabupaten-tabanan/tabanan`, `kabupaten-buleleng/buleleng`, `kabupaten-bangli/bangli`, `kabupaten-karangasem/karangasem`) di-`301` ke hub kotanya; `kabupaten-klungkung/klungkung` tetap aktif (1 klik di GSC).
> 2. **Tambahan Live Audit GSC URL Inspection (405 URL, 27 Nov 2026) — Redirect 301 1-Hop URL Legacy 404 & Nol Breadcrumb 301**:
>    - **7 slug peralatan lama** (termasuk 3 URL live `404` di GSC: `kamera-cctv-endoskopi-pipa-ip68-30-meter`, `mesin-drain-rooter-spiral-baja-rotary-ridgid-k-50-k-60`, `set-4-jenis-mata-pemotong-spiral-baja-modular`) → `301` ke slug peralatan baru aktif di `AboutController::equipmentDetail()` (hanya jika slug lama tidak ada di DB aktif & target aktif).
>    - **5 slug artikel lama (`ArticleSeeder`)** yang live `404` (`panduan-perawatan-grease-trap-dapur-restoran`, `5-kebiasaan-penyebab-bak-cuci-piring-tersumbat`, `kapan-saluran-pipa-butuh-inspeksi-kamera-cctv`, `bahaya-menggunakan-soda-api-saluran-mampet`, `bahaya-kawat-manual-saluran-pipa-mampet`) → `301` 1-hop ke `/artikel/{replacement-slug}` di `Pages\ArticleController::articleDetail()`.
>    - **6 slug studi kasus demo lama (`GallerySeeder`)** (5 di antaranya live `404` di GSC & sempat mencapai posisi 2.6 dan 6.9) → `301` 1-hop ke halaman `/layanan/{slug}` kanonik terkait di `ShowcaseController::showCaseStudy()` (hanya jika slug tidak ada di DB aktif).
>    - **Breadcrumb artikel HTML & JSON-LD** (`Pages\ArticleController::renderArticleView()` & `resources/views/articles/show.blade.php`) diarahkan langsung ke `route('articles.index', ...)` agar nol internal link mengarah ke URL 301 `/edukasi/{cat}`.
>    - **Status Bali di Desktop Navbar**: Kolom Bali di `navbar.blade.php` sudah tersedia; fokus perbaikan `navbar.blade.php` pada menu `Layanan` (`/#layanan` → `/layanan`), bug `kabupaten-demak` → `demak`, dan penambahan `kabupaten-semarang`, sementara klaster Bali ditambahkan di `coverage-areas.blade.php` & `regional-coverage.blade.php`.
> 3. **Halaman Kecamatan & `sitemap.xml` (Opsi 2)**: Seluruh **239 kecamatan non-kembar + 26 kota + 6 provinsi** tetap aktif `200 OK` dan **masuk semua ke `sitemap.xml`** (yang dibuang hanya `/admin`, utilitas `noindex` seperti `/sitemap`, `/kebijakan-privasi`, `?page >= 2`, URL duplikat `/edukasi/...` & Depok `-salin-judul`, serta 7 slug kembar). Mekanisme pruning `301` (`is_priority` di DB + CMS toggle + switch config `AREA_PRUNE_THIN_DISTRICTS`) tetap dibangun lengkap dengan default aktif (`true`) sehingga kecamatan tipis mana pun bisa di-`301` ke `/area/{kota}` kapan saja dari CMS Admin.
> 4. **Format `<title>` Studi Kasus (Opsi A)**: Tetap menggunakan akhiran **`oleh Drainusantara`** dengan format ringkas `{Solusi/Masalah} {Lokasi} oleh Drainusantara` (**maks 58 karakter**, tanpa append `| Studi Kasus | Drainusantara`), sementara hook CTR (`Tanpa bongkar keramik, garansi 30 hari, no cure no pay`) diletakkan di awal Meta Description. URL slug eksisting tetap utuh.
> 5. **Status `/syarat-dan-ketentuan`**: Tetap terindeks & tetap ada di `sitemap.xml` (`noindex, follow` hanya pada `/sitemap`, `/kebijakan-privasi`, paginasi `?page >= 2`, dan pencarian `?q=...`).
> 6. **Mode Antislop**: Diterapkan **selama pengerjaan (Mode 1)** untuk perubahan UI/copy/layout pada Poin 4 dan Poin 6.

---

## Ringkasan Audit Data GSC vs Akar Masalah Codebase

| # | Masalah Utama (Data GSC) | Akar Masalah di Codebase | Solusi Teknis Utama |
|---|---|---|---|
| **1** | 5 URL `/edukasi/edukasi/panduan/*` & `/edukasi/area-layanan/depok/*-salin-judul` terindeks ganda; `/area/depok-cinere` anjlok `11 -> 1` klik; `/area/demak/demak` bentrok `/area/demak`; `/layanan/floor-drain-kamar-mandi` terindeks | `Article::getSiloUrlAttribute()` mem-prefix `/edukasi/` pada kategori `edukasi` + sub `panduan`; `ArticleController::store()` tidak menyaring `-salin-judul`; `RegionService` mendaftarkan kecamatan `Demak` di dalam kota `demak`; tabel `services` & 4 view masih menautkan slug layanan lama | Jadikan `/artikel/{slug}` kanonik; 301 semua `/edukasi/...` -> `/artikel/{slug}`; 301 1-hop Depok `-salin-judul` -> `/area/depok-cinere`; 301 `/area/demak/demak` -> `/area/demak`; paksa link internal layanan memakai slug kanonik; tambah slug sanitizer anti `-salin-judul` |
| **2** | `/sitemap` (28 impr, 1 klik), `/kebijakan-privasi` (8 impr), dan `/pengetahuan?page=2` (3 impr) ikut terindeks; `sitemap.xml` berisi URL redirect & utilitas | Tidak ada `SEOMeta::setRobots('noindex, follow')` di `htmlSitemap()`, `privacy()`, dan paginasi `page >= 2`; `SitemapController` meng-emit `/kebijakan-privasi`, `/edukasi/{cat}` (yang 301!), `$article->silo_url`, dan semua 246 kecamatan | Standarisasi canonical absolut self-referencing; tambah `noindex, follow` pada `/sitemap`, `/kebijakan-privasi`, dan `?page>=2`; bersihkan `SitemapController::generateSitemapXml()` & `generateFallbackSitemapXml()` |
| **3** | Rich result `Cuplikan produk` kolaps: pos `12.79` (CTR `29.41%`, 10 klik) -> pos `45.00` (CTR `0%`, 0 klik) | `AboutController::equipmentDetail()` menyematkan `og:type=product` + JSON-LD `Product` & `AggregateOffer` (`InStock`, `400000`) pada halaman peralatan jasa tanpa data e-commerce; `ServicePageController::show()` membocorkan blok `Plumber` kosong di index 0; `Service.offers` memakai `InStock` fisik; `ContactController` double `Beranda` breadcrumb | Hapus schema `Product` & `og:type=product` di `equipmentDetail()`; ganti ke `Plumber` + `Service` + `AreaServed` + `BreadcrumbList`; perbaiki index 0 `Plumber` di `ServicePageController`; hapus `InStock` fisik dari `Service.offers`; perbaiki double breadcrumb di `ContactController` |
| **4** | 31 URL `/studi-kasus/*` dapat 283 tayangan tapi CTR hanya `2.83%` (8 klik); contoh Pademangan: 90 impr di pos 6.66, 0 klik | `<title>` menyertakan kata filler panjang + `Oleh Drainusantara` + `| Studi Kasus | Drainusantara` (114 char, nama brand ganda & terpotong di SERP); `studi-kasus/show.blade.php` menautkan layanan ke `/#layanan` dan tidak punya link ke `/area/{kota}`; query galeri di `AreaController::city()` gagal mencocokkan nama kota majemuk/alias | Builder `<title>` <= 58 karakter (Opsi A: tetap akhiran `oleh Drainusantara`, buang `| Studi Kasus | Drainusantara` & filler -> `{Solusi/Masalah} {Lokasi} oleh Drainusantara`) + hook CTR di awal Meta Description; komponen internal link otomatis ke `/area/{kota}` & `/layanan/{slug}`; perbaikan matching studi kasus di `/area/{kota}` |
| **5** | Dari 107 URL `/area/{kota}/{kecamatan}` di GSC, 97 URL mencatat `0 klik` (total sistem meng-generate 246 kecamatan) | Semua 246 kecamatan di `RegionService` selalu render `200 OK`, masuk `sitemap.xml`, dan status nonaktif (`is_active=false`) mengembalikan `404` bukan `301` | **Opsi 2**: Pertahankan 239 kecamatan non-kembar tetap `200 OK` & masuk `sitemap.xml` (konsolidasi 7 slug kembar via `301` ke hub kota), sekaligus bangun mekanisme penuh `is_priority` (default `true`) di DB + CMS toggle + switch `AREA_PRUNE_THIN_DISTRICTS` sehingga kecamatan mana pun yang dimatikan langsung `301` ke `/area/{kota}` & keluar dari `sitemap.xml` |
| **6** | Klik Desktop turun `50%` (`38 -> 19`, pos `16.77`, CTR `14.39%`) sedangkan Mobile naik `+44.4%` (`72 -> 104`, pos `12.72`, CTR `24.3%`) | Tidak ada `H1` ber-`lg:hidden`, **tetapi** `H1` & hero area memakai `.reveal-soft` (`opacity: 0` saat initial paint); section homepage menggabungkan `content-auto` (`content-visibility: auto`) dengan `.reveal-soft` (`opacity: 0`); `.area-hero h1 { max-width: 15ch }` merusak fold desktop; Desktop navbar menautkan Layanan ke `/#layanan` (bukan `/layanan`) dan bug key `'kabupaten-demak'` menghilangkan link Demak + tidak ada Bali | Hapus `.reveal-soft`/`.reveal-fade` dari semua elemen *above-the-fold* & pisahkan dari `content-auto`; ubah `.area-hero h1` ke lebar proporsional desktop; samakan Desktop navbar (`Layanan` -> `/layanan`, fix `demak`, tambah `kabupaten-semarang` & Bali); lengkapi klaster Bali di `coverage-areas` & `regional-coverage` |

---

## Daftar File Terdampak

### File Baru (`[NEW]`)
- `config/area_priority.php` — Konfigurasi daftar kecamatan prioritas (berbasis data GSC + studi kasus) & daftar slug kembar yang selalu dikonsolidasikan.
- `database/migrations/2026_11_23_000001_add_is_priority_to_coverage_areas_table.php` — Menambah kolom boolean `is_priority` (indexed) ke tabel `coverage_areas`.
- `app/Support/CaseStudyLinking.php` (atau service khusus) — Resolver otomatis judul SEO <= 58 karakter, meta description CTR, hub `/area/{kota}`, dan layanan `/layanan/{slug}` untuk `Gallery` (Studi Kasus).
- `resources/views/components/case-study/related-hubs.blade.php` — Komponen Blade internal linking otomatis di halaman detail studi kasus menuju `/area/{kota}` dan `/layanan/{slug}`.
- `tests/Feature/GscSeoAuditRemediationTest.php` — Test suite regresi lengkap untuk 6 perbaikan audit GSC.

### File Dimodifikasi (`[MODIFY]`)
- **Routing & Konfigurasi**:
  - [web.php](./routes/web.php)
  - [seotools.php](./config/seotools.php) *(cek bila perlu)*
- **Models & Services & Support**:
  - [Article.php](./app/Models/Article.php)
  - [Service.php](./app/Models/Service.php)
  - [CoverageArea.php](./app/Models/CoverageArea.php)
  - [RegionService.php](./app/Services/RegionService.php)
  - [ServiceCatalogRegistry.php](./app/Services/ServiceCatalogRegistry.php)
  - [PageMetadata.php](./app/Support/PageMetadata.php)
- **Controllers & Requests**:
  - [ArticleController.php (Public)](./app/Http/Controllers/Pages/ArticleController.php)
  - [ArticleController.php (Admin)](./app/Http/Controllers/ArticleController.php)
  - [StoreArticleRequest.php](./app/Http/Requests/Admin/StoreArticleRequest.php) & [UpdateArticleRequest.php](./app/Http/Requests/Admin/UpdateArticleRequest.php)
  - [SitemapController.php](./app/Http/Controllers/Pages/SitemapController.php)
  - [LegalController.php](./app/Http/Controllers/Pages/LegalController.php)
  - [AboutController.php](./app/Http/Controllers/Pages/AboutController.php)
  - [ServicePageController.php](./app/Http/Controllers/Pages/ServicePageController.php)
  - [HomeController.php](./app/Http/Controllers/Pages/HomeController.php)
  - [AreaController.php](./app/Http/Controllers/Pages/AreaController.php)
  - [ShowcaseController.php](./app/Http/Controllers/Pages/ShowcaseController.php)
  - [ContactController.php](./app/Http/Controllers/Pages/ContactController.php)
  - [CoverageAreaController.php (Admin)](./app/Http/Controllers/CoverageAreaController.php)
  - [Plumber.php](./app/View/Components/Schema/Plumber.php)
- **Views & CSS**:
  - [app.css](./resources/css/app.css) & [app.blade.php](./resources/views/layouts/app.blade.php)
  - [navbar.blade.php](./resources/views/components/layout/navbar.blade.php)
  - [studi-kasus/show.blade.php](./resources/views/studi-kasus/show.blade.php)
  - [areas/city.blade.php](./resources/views/areas/city.blade.php), [areas/province.blade.php](./resources/views/areas/province.blade.php), [areas/district.blade.php](./resources/views/areas/district.blade.php), [areas/index.blade.php](./resources/views/areas/index.blade.php)
  - [articles/index.blade.php](./resources/views/articles/index.blade.php), [gallery.blade.php](./resources/views/gallery.blade.php), [sitemap.blade.php](./resources/views/sitemap.blade.php)
  - [services.blade.php](./resources/views/components/landing-page/services.blade.php), [advantages.blade.php](./resources/views/components/landing-page/advantages.blade.php), [documentation.blade.php](./resources/views/components/landing-page/documentation.blade.php), [portfolio-b2b.blade.php](./resources/views/components/landing-page/portfolio-b2b.blade.php), [articles.blade.php](./resources/views/components/landing-page/articles.blade.php), [coverage-areas.blade.php](./resources/views/components/landing-page/coverage-areas.blade.php)
  - [service-card.blade.php](./resources/views/components/area/service-card.blade.php), [regional-coverage.blade.php](./resources/views/components/area/regional-coverage.blade.php)
  - [admin/coverage-areas/index.blade.php](./resources/views/admin/coverage-areas/index.blade.php), [admin/coverage-areas/edit.blade.php](./resources/views/admin/coverage-areas/edit.blade.php)
- **Existing Feature Tests yang Perlu Diselaraskan**:
  - [SeoSiloAndSchemaIntegrityTest.php](./tests/Feature/SeoSiloAndSchemaIntegrityTest.php)
  - [SeoContentRegressionTest.php](./tests/Feature/SeoContentRegressionTest.php)
  - [SitemapTest.php](./tests/Feature/SitemapTest.php)
  - [ArticleStudioAndTaxonomyTest.php](./tests/Feature/ArticleStudioAndTaxonomyTest.php), [ArticleStudioAndRendererTest.php](./tests/Feature/ArticleStudioAndRendererTest.php), [ArticleOutputSafetyTest.php](./tests/Feature/ArticleOutputSafetyTest.php), [BlogEnhancementsTest.php](./tests/Feature/BlogEnhancementsTest.php), [ComprehensiveEnhancementsV5Test.php](./tests/Feature/ComprehensiveEnhancementsV5Test.php), [FrontendContentTest.php](./tests/Feature/FrontendContentTest.php)
  - [GeoSeoTest.php](./tests/Feature/GeoSeoTest.php), [NewRegionsExpansionTest.php](./tests/Feature/NewRegionsExpansionTest.php), [RegionContentRegressionTest.php](./tests/Feature/RegionContentRegressionTest.php)

---

## Rencana Perubahan Teknis Per Poin

### 1. Bug Route Ganda & Kanibalisasi URL (`/edukasi/` vs `/artikel/` & `/area/`)

#### Akar Masalah di Kode Saat Ini
1. **Prefix Ganda `/edukasi/edukasi/panduan/{slug}`**:
   - Di [web.php](./routes/web.php#L77-L78), rute `/edukasi/{category}/{subcategory}/{slug}` menjadi halaman detail utama, sedangkan `/artikel/{slug}` di-301 redirect ke `$article->silo_url` ([Pages/ArticleController.php](./app/Http/Controllers/Pages/ArticleController.php#L146-L154)).
   - Di [Article.php](./app/Models/Article.php#L453-L524), kategori default `Edukasi` memiliki slug `edukasi` dan subkategori fallback `panduan`, sehingga `getSiloUrlAttribute()` membentuk `/edukasi/edukasi/panduan/{slug}` (dan `/edukasi/edukasi/floor-drain/{slug}`).
   - Di [SitemapController.php](./app/Http/Controllers/Pages/SitemapController.php#L295-L307), `/edukasi/{cat->slug}` dimasukkan ke `sitemap.xml` padahal [web.php](./routes/web.php#L71-L73) me-301 redirect URL tersebut ke `/pengetahuan?category={category}`.
2. **Kanibalisasi Depok `-salin-judul` & Bug Slug Generator**:
   - GSC menunjukkan kedua varian slug `jasa-saluran-pipa-mampet-depok-perbaikan-pelancaran-saluran-air-profesional-salin-judul` (di `/artikel/` dan `/edukasi/area-layanan/depok/`) aktif bersaing dengan `/area/depok-cinere`.
   - Di [ArticleController.php](./app/Http/Controllers/ArticleController.php#L57-L63), pembuatan slug hanya memanggil `Str::slug($validated['title'])` tanpa membuang akhiran duplikasi seperti `-salin-judul`, `-salin`, atau `-copy`.
3. **Slug Kembar `/area/demak/demak`**:
   - Di [RegionService.php](./app/Services/RegionService.php#L415-L440), kota `demak` memiliki entri kecamatan `'Demak'`, menghasilkan `/area/demak/demak` di samping `/area/demak`.
4. **Layanan Legacy `/layanan/floor-drain-kamar-mandi`**:
   - Meskipun [ServicePageController.php](./app/Http/Controllers/Pages/ServicePageController.php#L108-L112) sudah punya 301 redirect via `ServiceCatalogRegistry::SLUG_ALIASES`, database `services` masih menyimpan slug lama (`floor-drain-kamar-mandi`, `kuras-grease-trap-lemak`, `wastafel-cuci-piring-mampet`, `kloset-wc-mampet`, `inspeksi-kamera-cctv-pipa`) dan 4 template Blade ([services.blade.php](./resources/views/components/landing-page/services.blade.php#L94), [service-card.blade.php](./resources/views/components/area/service-card.blade.php#L52), [sitemap.blade.php](./resources/views/sitemap.blade.php#L58), [areas/district.blade.php](./resources/views/areas/district.blade.php#L334-L358)) masih menautkan ke slug lama tersebut.

#### Rencana Diff Perubahan

```diff
--- a/routes/web.php
+++ b/routes/web.php
@@ -35,6 +35,9 @@ Route::get('/area', [Pages\AreaController::class, 'index'])->name('area.index');
 Route::get('/area/provinsi/{province}', [Pages\AreaController::class, 'province'])->name('area.province');
 Route::get('/area/{city}', [Pages\AreaController::class, 'city'])->name('area.city');
+// Konsolidasi slug kembar Demak -> hub Kabupaten Demak (1 hop, 301 permanen)
+Route::permanentRedirect('/area/demak/demak', '/area/demak');
 Route::get('/area/{city}/{district}', [Pages\AreaController::class, 'area'])->name('area.detail');

@@ -66,14 +69,24 @@ Route::get('/pengetahuan', [Pages\ArticleController::class, 'articles'])->name('
 Route::get('/blog', fn () => redirect()->route('articles.index', [], 301));
 Route::get('/pengetahuan/{slug}', fn (string $slug) => redirect()->route('articles.show', ['slug' => $slug], 301));
 Route::get('/blog/{slug}', fn (string $slug) => redirect()->route('articles.show', ['slug' => $slug], 301));
+// Redirect 1-hop URL kanibalisasi Depok -salin-judul -> /area/depok-cinere
+Route::permanentRedirect(
+    '/artikel/jasa-saluran-pipa-mampet-depok-perbaikan-pelancaran-saluran-air-profesional-salin-judul',
+    '/area/depok-cinere'
+);
+Route::permanentRedirect(
+    '/edukasi/area-layanan/depok/jasa-saluran-pipa-mampet-depok-perbaikan-pelancaran-saluran-air-profesional-salin-judul',
+    '/area/depok-cinere'
+);
 Route::get('/edukasi', fn () => redirect()->route('articles.index', [], 301))->name('articles.silo.index');
 Route::get('/edukasi/{category}', function (string $category) {
     return redirect()->route('articles.index', ['category' => $category], 301);
 })->name('articles.silo.category');
 Route::get('/edukasi/{category}/{subcategory}', function (string $category, string $subcategory) {
     return redirect()->route('articles.index', ['category' => $category, 'sub' => $subcategory], 301);
 })->name('articles.silo.subcategory');
-Route::get('/edukasi/{category}/{subcategory}/{slug}', [Pages\ArticleController::class, 'articleSiloDetail'])->name('articles.silo');
-Route::get('/artikel/{slug}', [Pages\ArticleController::class, 'articleDetail'])->name('articles.show');
+// Semua varian /edukasi/{category}/{subcategory}/{slug} (termasuk /edukasi/edukasi/panduan/*) -> 301 ke /artikel/{slug}
+Route::get('/edukasi/{category}/{subcategory}/{slug}', [Pages\ArticleController::class, 'redirectSiloToCanonical'])->name('articles.silo');
+Route::get('/artikel/{slug}', [Pages\ArticleController::class, 'articleDetail'])->name('articles.show');

@@ -130,6 +143,10 @@ Route::get('/kemitraan/{slug}', [Pages\ShowcaseController::class, 'showPartnersh
 // Halaman Layanan Dedicated (Silo Layanan)
 Route::get('/layanan', [Pages\ServicePageController::class, 'index'])->name('services.index');
+Route::permanentRedirect(
+    '/layanan/floor-drain-kamar-mandi',
+    '/layanan/jasa-kamar-mandi-dan-floor-drain-mampet'
+);
 Route::get('/layanan/{slug}', [Pages\ServicePageController::class, 'show'])->name('services.show');
```

```diff
--- a/app/Models/Article.php
+++ b/app/Models/Article.php
@@ -518,7 +518,33 @@ class Article extends Model
+    /**
+     * Bersihkan slug dari akhiran duplikasi CMS (-salin-judul, -salin, -copy, -duplikat).
+     */
+    public static function sanitizeSlug(string $value): string
+    {
+        $slug = Str::slug($value);
+        $cleaned = preg_replace('/(?:-(?:salin-judul|salin|copy|duplikat)(?:-\d+)?)+$/i', '', $slug) ?? $slug;
+        $cleaned = trim($cleaned, '-');
+
+        return $cleaned !== '' ? $cleaned : $slug;
+    }
+
+    public function getCanonicalUrlAttribute(): string
+    {
+        return route('articles.show', ['slug' => $this->slug]);
+    }
+
     public function getSiloUrlAttribute(): string
     {
-        return url("/edukasi/{$this->category_slug}/{$this->subcategory_slug}/{$this->slug}");
+        // Backward-compatible alias: semua view & link internal kini mengarah ke URL kanonik /artikel/{slug}
+        return $this->canonical_url;
     }
```

- Di [ArticleController.php (Admin)](./app/Http/Controllers/ArticleController.php#L57-L63): pakai `Article::sanitizeSlug($validated['title'])` saat `store()`, dan tambahkan `saving` guard di model `Article` (plus aturan validasi di `StoreArticleRequest`/`UpdateArticleRequest` untuk menolak/membersihkan akhiran `-salin-judul`).
- Di [Article.php](./app/Models/Article.php): tambahkan konstanta `REDIRECTED_SLUGS` (berisi slug Depok `-salin-judul` dari artikel ID 12 production) dan scope `scopeIndexable($query)` (`is_published = true` & `whereNotIn('slug', self::REDIRECTED_SLUGS)`), lalu gunakan di `/pengetahuan`, `sitemap.xml`, homepage, halaman area, halaman layanan, dan artikel terkait agar nol link internal mengarah ke URL 301.
- Di [Pages/ArticleController.php](./app/Http/Controllers/Pages/ArticleController.php#L127-L180):
  - `redirectSiloToCanonical(string $category, string $subcategory, string $slug)` mengecek peta redirect khusus terlebih dahulu (jika slug Depok `-salin-judul` -> `301` ke `/area/depok-cinere`), jika tidak -> `301` langsung ke `route('articles.show', ['slug' => $slug])`.
  - `articleDetail(string $slug)` langsung merender halaman artikel dengan canonical `route('articles.show', ['slug' => $article->slug])`.
- Di [Service.php](./app/Models/Service.php): tambahkan accessor `getCanonicalSlugAttribute()` yang memanggil `ServiceCatalogRegistry::canonicalSlug($this->slug)`, lalu perbarui 4 view (`services.blade.php`, `service-card.blade.php`, `sitemap.blade.php`, `areas/district.blade.php`) agar selalu menautkan ke `$service->canonical_slug`.

---

### 2. Canonical Tag, Noindex Utilitas & Pembersihan Sitemap

#### Akar Masalah di Kode Saat Ini
1. `SitemapController::htmlSitemap()` (`/sitemap`), `LegalController::privacy()` (`/kebijakan-privasi`), dan `Pages\ArticleController::articles()` saat `?page >= 2` tidak memasang `<meta name="robots" content="noindex, follow">`.
2. Beberapa controller memakai `url()->current()` alih-alih `route(...)` absolut berbasis `APP_URL`, sehingga berisiko inkonsistensi host/trailing slash.
3. `SitemapController::generateSitemapXml()` masih memasukkan:
   - `route('legal.privacy')` (baris 209 & 386),
   - `/edukasi/{cat->slug}` yang 301 redirect (baris 295-307),
   - `$article->silo_url` ber-prefix ganda + slug yang sudah di-redirect,
   - seluruh 246 kecamatan termasuk `/area/demak/demak` dan kecamatan tipis yang akan di-301 redirect.

#### Rencana Diff Perubahan

```diff
--- a/app/Http/Controllers/Pages/SitemapController.php
+++ b/app/Http/Controllers/Pages/SitemapController.php
@@ -34,6 +34,7 @@ class SitemapController extends Controller
         PageMetadata::title('Peta Situs Resmi | Navigasi Lengkap Drainusantara');
         SEOMeta::setDescription('...');
         SEOMeta::setCanonical(url('/sitemap'));
+        SEOMeta::setRobots('noindex, follow');
```

```diff
--- a/app/Http/Controllers/Pages/LegalController.php
+++ b/app/Http/Controllers/Pages/LegalController.php
@@ -21,7 +21,8 @@ class LegalController extends Controller
         PageMetadata::title('Kebijakan Privasi');
         SEOMeta::setDescription('...');
-        SEOMeta::setCanonical(url()->current());
+        SEOMeta::setCanonical(route('legal.privacy'));
+        SEOMeta::setRobots('noindex, follow');
```

```diff
--- a/app/Http/Controllers/Pages/ArticleController.php
+++ b/app/Http/Controllers/Pages/ArticleController.php
@@ -31,15 +31,19 @@ class ArticleController extends Controller
         $page = max(1, (int) $request->query('page', 1));
 
-        if ($searchTerm !== '') {
+        if ($searchTerm !== '' || $page >= 2) {
             SEOMeta::setRobots('noindex, follow');
         }
```

- **Canonical Absolut Self-Referencing**: Audit & ganti `SEOMeta::setCanonical(url()->current())` menjadi named route absolut (`route('home')`, `route('area.index')`, `route('area.province', ...)`, `route('area.city', ...)`, `route('area.detail', ...)`, `route('gallery')`, `route('legal.terms')`, dll.) di seluruh controller publik agar `APP_URL` HTTPS selalu menjadi sumber tunggal.
- **Pembersihan `SitemapController::generateSitemapXml()` & `generateFallbackSitemapXml()`**:
  - Hapus `route('legal.privacy')` dari array `$staticPages` (baik normal maupun fallback).
  - Hapus loop `ArticleCategory` yang meng-emit `url("/edukasi/{$cat->slug}")`.
  - Gunakan `route('articles.show', ['slug' => $article->slug])` dan filter keluar slug yang termasuk daftar redirect (mis. Depok `-salin-judul`).
  - Pada loop kecamatan, kecualikan 7 slug kembar (`demak/demak`, `bogor/kota-bogor`, `kabupaten-gianyar/gianyar`, `kabupaten-tabanan/tabanan`, `kabupaten-buleleng/buleleng`, `kabupaten-bangli/bangli`, `kabupaten-karangasem/karangasem`) dan hanya masukkan kecamatan yang memenuhi `RegionService::isIndexableDistrict($citySlug, $districtSlug, $dbArea)` dan `is_active === true` (di Opsi 2 default: **seluruh 239 kecamatan non-kembar masuk `sitemap.xml`**, dan otomatis keluar jika admin mematikan `is_priority = false`).
  - Sinkronkan `generateFallbackSitemapXml()` agar juga menyertakan `/layanan` + layanan kanonik dan seluruh kecamatan indexable (tanpa 7 slug kembar).

---

### 3. Perbaikan JSON-LD Schema (`Cuplikan produk` Kolaps)

#### Akar Masalah di Kode Saat Ini
1. **Penyebab Utama Kolaps `Cuplikan produk`**: [AboutController.php](./app/Http/Controllers/Pages/AboutController.php#L181-L207) (`equipmentDetail()`) memasang `OpenGraph::addProperty('type', 'product')` dan `JsonLdMulti::setType('Product')` lengkap dengan `AggregateOffer` (`lowPrice: 400000`, `availability: InStock`) pada halaman informasi peralatan jasa Ridgid/CCTV (bukan halaman jual-beli produk fisik).
2. **Kebocoran Blok `Plumber` Kosong di Halaman Layanan**: [ServicePageController.php](./app/Http/Controllers/Pages/ServicePageController.php#L182) memanggil `JsonLdMulti::newJsonLd()` tanpa mengisi blok index 0 terlebih dahulu, sehingga blok default `Plumber` tanpa `address`, `telephone`, `url`, dan `areaServed` ikut ter-render; sekaligus blok `Service` tidak menyertakan `areaServed`.
3. **Enum Fisik `InStock` pada `Service.offers`**: Ditemukan di `HomeController` (baris 128), `AreaController` (baris 264, 479, 739), dan `ServicePageController` (baris 202).
4. **Bug Bonus Ditemukan**:
   - [ContactController.php](./app/Http/Controllers/Pages/ContactController.php#L47-L50) menyisipkan `['Beranda', route('home')]` secara manual padahal `HasPageSeo::addBreadcrumb()` sudah otomatis menambahkannya -> menghasilkan 2 item `Beranda` di `BreadcrumbList`.
   - [app/View/Components/Schema/Plumber.php](./app/View/Components/Schema/Plumber.php#L164-L170) menyertakan `aggregateRating` hardcoded (`4.9`, `48` ulasan) yang rentan penalti kebijakan *self-serving reviews*.

#### Rencana Diff Perubahan

```diff
--- a/app/Http/Controllers/Pages/AboutController.php
+++ b/app/Http/Controllers/Pages/AboutController.php
@@ -178,34 +178,51 @@ class AboutController extends Controller
         OpenGraph::setTitle($pageTitle.' Drainusantara');
         OpenGraph::setDescription($metaDescription);
         OpenGraph::setUrl(route('equipment.show', $slug));
-        OpenGraph::addProperty('type', 'product');
+        OpenGraph::addProperty('type', 'website');
         OpenGraph::addImage($imageUrl);
@@ -188,20 +188,37 @@ class AboutController extends Controller
-        JsonLdMulti::setTitle($equipment->name);
-        JsonLdMulti::setDescription($metaDescription);
-        JsonLdMulti::setType('Product');
-        JsonLdMulti::addValues([
-            'name' => $equipment->name,
-            'description' => $metaDescription,
-            'image' => $imageUrl,
-            'category' => $equipment->category ?? 'Drain Cleaning Equipment',
-            'brand' => [
-                '@type' => 'Brand',
-                'name' => 'Drainusantara',
-            ],
-            'offers' => [
-                '@type' => 'AggregateOffer',
-                'priceCurrency' => 'IDR',
-                'lowPrice' => '400000',
-                'price' => '400000',
-                'availability' => 'https://schema.org/InStock',
-            ],
-        ]);
+        $canonicalUrl = route('equipment.show', $slug);
+
+        JsonLdMulti::setType('Plumber');
+        JsonLdMulti::setTitle('Drainusantara - ' . $equipment->name);
+        JsonLdMulti::setDescription($metaDescription);
+        JsonLdMulti::addValues([
+            '@id' => url('/#organization'),
+            'name' => 'Drainusantara',
+            'legalName' => 'PT Jawa Jaya Rooter',
+            'url' => url('/'),
+            'image' => $imageUrl,
+            'telephone' => $this->formatInternationalPhone(),
+            'address' => $this->getHeadquartersAddress(),
+            'areaServed' => ['DKI Jakarta', 'Jawa Barat', 'Banten', 'Jawa Tengah', 'Lampung', 'Bali'],
+        ]);
+
+        $serviceJsonLd = JsonLdMulti::newJsonLd();
+        $serviceJsonLd->setType('Service');
+        $serviceJsonLd->addValues([
+            '@id' => $canonicalUrl . '#service',
+            'name' => "Layanan Pelancaran Pipa dengan {$equipment->name}",
+            'serviceType' => 'Plumbing Service',
+            'description' => $metaDescription,
+            'url' => $canonicalUrl,
+            'image' => $imageUrl,
+            'provider' => ['@id' => url('/#organization')],
+            'areaServed' => ['DKI Jakarta', 'Jawa Barat', 'Banten', 'Jawa Tengah', 'Lampung', 'Bali'],
+        ]);
```

- **Standarisasi `ServicePageController::show()`**: Konfigurasi index 0 sebagai `Plumber` lengkap (`@id`, `name`, `legalName`, `url`, `telephone`, `email`, `address`, `areaServed`), lalu `newJsonLd()` untuk `Service` (dengan `provider.@id`, `areaServed`, `offers` tanpa `InStock`), `FAQPage`, dan `BreadcrumbList`.
- **Bersihkan `Service.offers`**: Hapus `'availability' => 'https://schema.org/InStock'` di `HomeController`, `AreaController` (`province`, `city`, `area`), dan `ServicePageController` agar Google tidak salah mengklasifikasikan halaman jasa sebagai `Product`.
- **Perbaiki `ContactController::index()`**: Hapus `['Beranda', route('home')]` dari `$this->addBreadcrumb(...)`.
- **Perbaiki `Schema\Plumber` Component**: Jadikan `aggregateRating` opsional (tidak di-hardcode) atau hanya muncul jika ada ulasan terverifikasi yang dipass sebagai prop (dengan pembaruan test di `GeoSeoTest.php`).

---

### 4. Optimasi CTR & Internal Linking `Studi Kasus` dan Hub `Area Kota`

#### Akar Masalah di Kode Saat Ini
1. **Judul SERP Terpotong & Nama Brand Ganda**:
   - Di [ShowcaseController.php](./app/Http/Controllers/Pages/ShowcaseController.php#L87), `PageMetadata::title($caseStudy->title.' | Studi Kasus')` menghasilkan `<title>` seperti:
     `Pelancaran Pipa Wastafel Dapur Mampet di Pademangan Jakarta Utara Oleh Drainusantara | Studi Kasus | Drainusantara` (**114 karakter!**).
   - [PageMetadata.php](./app/Support/PageMetadata.php#L15-L21) belum membersihkan akhiran `Oleh Drainusantara` / `oleh-drainusantara`.
2. **Internal Link Terputus**:
   - Di [studi-kasus/show.blade.php](./resources/views/studi-kasus/show.blade.php#L240), tautan `Layanan yang Dipilih` masih mengarah ke `url('/#layanan')` alih-alih `/layanan/{slug}`, dan tidak ada tautan ke hub `/area/{kota}`.
   - Di [AreaController.php](./app/Http/Controllers/Pages/AreaController.php#L525-L546), query galeri untuk `/area/{kota}` hanya memakai `location LIKE "%{$cityData['name']}%"` yang gagal mencocokkan nama kota gabungan (`Depok & Cinere`, `Bekasi & Cikarang`, `Kota Semarang`) atau nama kecamatan/kawasan (`Tangsel`, `PIK`, `SCBD`, `Blok M`, `Sentul`, `Cibubur`).

#### Rencana Desain & Diff Perubahan

1. **Generator `<title>` <= 58 Karakter dengan Akhiran `oleh Drainusantara` (Opsi A) & Meta Description CTR (`app/Support/CaseStudyLinking.php`)**:
   - Normalisasi judul mentah: bersihkan duplikasi brand di awal/akhir (`oleh drainusantara`, `oleh-drainusantara`, `| studi kasus`, `- drainusantara`, `| drainusantara`) terlebih dahulu agar tidak pernah muncul ganda, lalu pasang akhiran tunggal **`oleh Drainusantara`** secara terkontrol.
   - Ekstrak komponen **Solusi/Masalah ringkas** (mis. `Solusi Wastafel Mampet`, `Solusi Bak Kontrol Mampet`, `Atasi Kloset Mampet`, `Inspeksi CCTV Floor Drain`, `Kuras Grease Trap`) + **Lokasi spesifik** (ambil kecamatan/kawasan paling spesifik dari `location` atau judul, tanpa embel-embel kota/provinsi panjang jika melebihi budget karakter) + akhiran **`oleh Drainusantara`** (18 karakter).
   - Panggil `SEOMeta::setTitle($seoTitle, false)` (matikan suffix otomatis `| Drainusantara`) dengan budget ketat **<= 58 karakter** (fallback otomatis memangkas kata pembuka atau nama kota bila masih > 58 karakter, sehingga akhiran `oleh Drainusantara` tidak pernah terpotong di SERP Desktop & Mobile):
     - Contoh 1 (Pademangan): `"Solusi Wastafel Mampet Pademangan oleh Drainusantara"` (**52 karakter**)
     - Contoh 2 (Pasar Minggu): `"Solusi Bak Kontrol Mampet Pasar Minggu oleh Drainusantara"` (**57 karakter**)
     - Contoh 3 (Pejaten): `"Inspeksi CCTV Floor Drain Pejaten oleh Drainusantara"` (**52 karakter**)
     - Contoh 4 (Kelapa Gading): `"Atasi Kloset Mampet Kelapa Gading oleh Drainusantara"` (**52 karakter**)
   - **Meta Description CTR (140-155 karakter)** dengan hook nilai jual langsung di kalimat pertama: `"Lancar tanpa bongkar keramik! Penanganan nyata {masalah} di {lokasi} memakai {metode}. Garansi resmi 30 hari & No Cure No Pay."`
   - *URL slug eksisting di database tidak diubah* agar tidak memutus indeks & sinyal historis.

2. **Komponen Internal Link Otomatis (`studi-kasus/show.blade.php` & `components/case-study/related-hubs.blade.php`)**:
   - Resolver `resolveCityHub(Gallery $caseStudy)` mencocokkan `location`, `title`, dan `slug` ke daftar kota, alias kota (`tangsel` -> `tangerang-selatan`, `depok` -> `depok-cinere`, `bekasi` -> `bekasi-cikarang`, `pik`/`kapuk` -> `jakarta-utara`, `scbd`/`blok m`/`senopati` -> `jakarta-selatan`), dan nama kecamatan di `RegionService`.
   - Resolver `resolveService(Gallery $caseStudy)` mengambil dari `$caseStudy->service->canonical_slug`, atau fallback pencocokan kata kunci `drain_type`/`title` ke 6 slug kanonik di `ServiceCatalogRegistry`.
   - Pada `studi-kasus/show.blade.php`:
     - Ubah link `Layanan yang Dipilih` di Technical Data Sheet dari `url('/#layanan')` menjadi `route('services.show', ['slug' => $relatedService['slug']])`.
     - Jadikan `Lokasi Pengerjaan` di Technical Data Sheet dapat diklik menuju `route('area.city', ['city' => $relatedCityHub['slug']])`.
     - Tambahkan section `<x-case-study.related-hubs>` sebelum "Studi Kasus Terkait Lainnya" yang menautkan secara eksplisit ke halaman hub `/area/{kota}` (beserta kecamatan prioritas bila cocok) dan halaman `/layanan/{slug}` yang relevan, mengikuti standar visual `AGENTS.md` (`rounded-lg`, `border border-slate-200`, tanpa `shadow-2xl`, kontras WCAG AA).

3. **Daftar Studi Kasus Terkait di `/area/{kota}` (`AreaController::city()` & `areas/city.blade.php`)**:
   - Bangun token pencarian kota di `AreaController::city()`: nama kota tanpa prefiks `Kota`/`Kabupaten`, pecahan `&` (`Depok`, `Cinere`, `Bekasi`, `Cikarang`), alias umum (`Tangsel`, `Jaksel`, `Jaktim`, `Jakut`, `Jakbar`, `Jakpus`), plus daftar kecamatan milik kota tersebut.
   - Cocokkan pada `location`, `title`, dan `slug` galeri aktif yang memiliki `slug`.
   - Jangan menimpa judul studi kasus asli yang benar-benar cocok dengan kota tersebut, dan pastikan setiap kartu di [areas/city.blade.php](./resources/views/areas/city.blade.php#L725-L803) menampilkan tautan jelas ke `route('case-study.show', $gallery->slug)` serta tautan ke `/galeri`.

---

### 5. Konsolidasi Halaman Kecamatan Tipis (Thin Content Pruning)

#### Akar Masalah di Kode Saat Ini
- Sistem menghasilkan **246 halaman kecamatan** dari [RegionService.php](./app/Services/RegionService.php) (tersimpan di `coverage_areas` sebanyak 248 baris `district`, seluruhnya aktif).
- Data GSC `Halaman.csv` menunjukkan **97 dari 107 URL `/area/{kota}/{kecamatan}` mencatat 0 klik** di periode berjalan (hanya 10 URL yang mendapat klik pada 14-20 Nov, dan 23 URL termasuk `demak/demak` bila digabung dua periode).
- Menonaktifkan kecamatan melalui `is_active = false` saat ini memicu `abort(404)` di [AreaController.php](./app/Http/Controllers/Pages/AreaController.php#L585), bukan `301` redirect ke hub kota `/area/{kota}`.

#### Rencana Arsitektur Pruning (Opsi 2: Semua 239 Kecamatan Aktif & Masuk Sitemap + Kontrol CMS 301 Siap Pakai)

1. **Migration & Config**:
   - Tambah kolom `$table->boolean('is_priority')->default(true)->index();` di `coverage_areas` (**default `true`** sesuai Opsi 2, sehingga seluruh 239 kecamatan non-kembar tetap berdiri sebagai halaman mandiri `200 OK` dan masuk `sitemap.xml`, sementara admin bisa mengubah ke `false` kapan saja untuk mengonsolidasikan kecamatan tertentu via `301` ke `/area/{kota}`).
   - Buat `config/area_priority.php` berisi:
     - `prune_non_priority`: `env('AREA_PRUNE_THIN_DISTRICTS', false)` (default `false` sesuai Opsi 2; bila suatu saat diset `true`, hanya daftar `recommended_priority_districts` + kecamatan yang `is_priority = true` / punya studi kasus yang aktif, sisanya otomatis `301`).
     - `forced_city_redirects`: 7 slug kembar yang **selalu** di-`301` ke hub kotanya masing-masing & dikecualikan dari `sitemap.xml` (`demak/demak` -> `demak`, `bogor/kota-bogor` -> `bogor`, `kabupaten-gianyar/gianyar` -> `kabupaten-gianyar`, `kabupaten-tabanan/tabanan` -> `kabupaten-tabanan`, `kabupaten-buleleng/buleleng` -> `kabupaten-buleleng`, `kabupaten-bangli/bangli` -> `kabupaten-bangli`, `kabupaten-karangasem/karangasem` -> `kabupaten-karangasem`).
     - `recommended_priority_districts`: daftar referensi **53 kecamatan ber-bukti GSC/studi kasus** terverifikasi 100% slug eksaknya terhadap `RegionService::all()` (ditampilkan sebagai label **"Prioritas GSC/Studi Kasus"** di CMS Admin dan menjadi preset otomatis jika `AREA_PRUNE_THIN_DISTRICTS=true`):
       - **DKI Jakarta**: `jakarta-timur` (`pulo-gadung`, `ciracas`, `cipayung`, `makasar`, `cakung`, `pasar-rebo`, `kramat-jati`, `jatinegara`, `duren-sawit`), `jakarta-selatan` (`kebayoran-baru`, `tebet`, `pasar-minggu`, `cilandak`, `mampang-prapatan`), `jakarta-utara` (`penjaringan`, `kelapa-gading`, `pantai-indah-kapuk`, `pademangan`, `sunter`), `jakarta-pusat` (`gambir`, `senen`, `menteng`, `kemayoran`), `jakarta-barat` (`puri-kembangan`, `kebon-jeruk`, `grogol-petamburan`)
       - **Bodetabek**: `tangerang-selatan` (`bintaro`, `bsd-city`, `serpong`), `depok-cinere` (`cinere`, `sukmajaya`, `cimanggis`), `bekasi-cikarang` (`bekasi-selatan`, `cikarang-selatan`, `cikarang-utara`), `bogor` (`cibinong`, `sentul-city`), `tangerang-kota` (`cipondoh`, `pinang`)
       - **Jawa Barat**: `bandung` (`dago`, `buahbatu`), `kabupaten-bandung` (`rancaekek`), `kota-cimahi` (`cimahi-tengah`)
       - **Jawa Tengah**: `semarang` (`semarang-selatan`, `banyumanik`, `gayamsari`, `tembalang`, `tugu`, `candisari`), `kabupaten-semarang` (`ungaran-barat`), `demak` (`sayung`, `bonang`, `mranggen`, `dempet`, `mijen`)
       - **Lampung**: `bandar-lampung` (`sukarame`, `kedaton`, `tanjung-karang-pusat`)
       - **Bali**: `kota-denpasar` (`denpasar-selatan`), `kabupaten-badung` (`kuta-selatan`, `canggu`, `kuta`, `seminyak`), `kabupaten-gianyar` (`ubud`), `kabupaten-jembrana` (`gilimanuk`), `kabupaten-klungkung` (`klungkung` - dipertahankan aktif karena memiliki 1 klik di GSC)
   - Helper `RegionService::isIndexableDistrict(string $citySlug, string $districtSlug, ?CoverageArea $record = null): bool`:
     1. Jika masuk `forced_city_redirects` (7 slug kembar) -> **`false`** (selalu `301` ke hub kota & keluar dari sitemap).
     2. Jika `$record` ada di DB dan `$record->is_priority === false` -> **`false`** (admin menandai kecamatan ini untuk dikonsolidasikan via `301` ke hub kota).
     3. Jika `config('area_priority.prune_non_priority') === true`: kembalikan `true` hanya bila masuk `recommended_priority_districts` (atau punya studi kasus aktif).
     4. Default Opsi 2 (`prune_non_priority === false` & `is_priority === true`): kembalikan **`true`** -> semua 239 kecamatan non-kembar aktif `200 OK` dan masuk `sitemap.xml`!

2. **Perilaku HTTP di `AreaController::area()`**:
```diff
--- a/app/Http/Controllers/Pages/AreaController.php
+++ b/app/Http/Controllers/Pages/AreaController.php
@@ -571,6 +571,12 @@ class AreaController extends Controller
         $districtFormatted = collect($cityData['districts'])
             ->first(fn (string $name) => Str::slug($name) === $district);
         abort_unless($districtFormatted, 404);
 
+        // Konsolidasi 7 slug kembar & kecamatan yang dinon-prioritaskan (is_priority=false) -> 301 ke hub /area/{kota}
+        if (! RegionService::isIndexableDistrict($cityData['slug'], $district, $area)) {
+            return redirect()->route('area.city', ['city' => $cityData['slug']], 301);
+        }
```
*(Catatan: pengecekan `$area` DB dipindah ke atas pengecekan prioritas; jika `$area && ! $area->is_active`, tetap mengembalikan 404 seperti kontrak test eksisting, sedangkan `$area->is_priority = false` atau 7 slug kembar mengembalikan `301` ke `/area/{kota}`.)*

3. **Sinkronisasi Internal Link, Sitemap & CMS Toggle**:
   - `SitemapController`: emit seluruh kecamatan yang `isIndexableDistrict(...) === true` dan `is_active === true` (**239 kecamatan non-kembar masuk semua ke `sitemap.xml`**; 7 slug kembar & kecamatan yang diset `is_priority = false` otomatis keluar dari sitemap).
   - `areas/city.blade.php`, `areas/province.blade.php`, `areas/district.blade.php`, `areas/index.blade.php`, `sitemap.blade.php`:
     - Kecamatan indexable (`isIndexableDistrict === true`) dirender sebagai `<a href="{{ route('area.detail', ...) }}">`.
     - 7 slug kembar & kecamatan yang dimatikan admin (`is_priority = false`) dirender sebagai *badge/chip teks cakupan* (`<span>`, bukan link ke 301) sehingga keyword wilayah tetap terbaca di `/area/{kota}` tanpa menciptakan link 301.
   - `RegionService::getSearchableItems()`: untuk kecamatan yang di-301 (7 slug kembar / `is_priority = false`), arahkan `url` pencarian langsung ke `route('area.city', ['city' => $citySlug])`.
   - `CoverageAreaController` & view CMS (`admin/coverage-areas/index.blade.php`, `edit.blade.php`): tambah checkbox **"Tampilkan Halaman Kecamatan Mandiri (Jika dimatikan: 301 ke Halaman Kota)"** + badge status `Aktif (200 OK)` vs `Konsolidasi 301 -> Kota` + indikator `Prioritas GSC` pada 53 kecamatan referensi.
   - **Bonus Penguatan Artikel ID 13 (Semarang)**: Tambahkan blok tautan kontekstual otomatis di `articles/show.blade.php` yang menautkan artikel ber-kota (mis. Semarang -> `/area/semarang`, Bali -> `/area/provinsi/bali`, Jakarta Timur -> `/area/jakarta-timur`) ke hub area resminya agar sinyal relevansi mengalir ke halaman kota.

---

### 6. Audit Perbedaan Rendering Desktop vs Mobile

#### Hasil Audit Blade, Tailwind, dan CSS
1. **Pengecekan `hidden` / `md:hidden` / `lg:hidden`**:
   - Tidak ada `<h1>`, paragraf konten SEO utama, atau daftar cakupan area yang disembunyikan dengan kelas `md:hidden`/`lg:hidden` pada desktop.
2. **4 Akar Masalah Rendering & Crawlability Desktop yang Ditemukan**:
   - **A. Elemen Above-the-Fold (`<h1>`, Breadcrumb, Deskripsi, CTA) Tertahan `opacity: 0` oleh `.reveal-soft` / `.reveal-fade`**:
     - Di [app.css](./resources/css/app.css#L116-L145), `.reveal-soft` dan `.reveal-fade` men-set `opacity: 0` sebelum JS `IntersectionObserver` di [app.blade.php](./resources/views/layouts/app.blade.php#L168-L195) berjalan.
     - Elemen `<h1>` pada [areas/city.blade.php](./resources/views/areas/city.blade.php#L197), [areas/province.blade.php](./resources/views/areas/province.blade.php#L183), [areas/index.blade.php](./resources/views/areas/index.blade.php#L43), [articles/index.blade.php](./resources/views/articles/index.blade.php#L37), dan [gallery.blade.php](./resources/views/gallery.blade.php#L38) semuanya memakai `.reveal-soft`! Ini memperlambat Desktop LCP/FCP dan berisiko ter-render transparan saat timeout/WRS snapshot.
   - **B. Jebakan `content-auto` (`content-visibility: auto`) + `.reveal-soft` (`opacity: 0`) di Homepage**:
     - Lima section utama Homepage ([services.blade.php](./resources/views/components/landing-page/services.blade.php#L4), [advantages.blade.php](./resources/views/components/landing-page/advantages.blade.php#L1), [documentation.blade.php](./resources/views/components/landing-page/documentation.blade.php#L4), [portfolio-b2b.blade.php](./resources/views/components/landing-page/portfolio-b2b.blade.php#L4), [articles.blade.php](./resources/views/components/landing-page/articles.blade.php#L4)) memakai kelas `.content-auto` (`content-visibility: auto`) sekaligus `.reveal-soft` (`opacity: 0`) pada konten di dalamnya. Pada viewport desktop lebar / headless renderer, penundaan layout `content-visibility: auto` dapat menghambat `IntersectionObserver` memicu `.is-visible`.
   - **C. Disparitas Internal Link pada Desktop Navbar vs Mobile Drawer ([navbar.blade.php](./resources/views/components/layout/navbar.blade.php))**:
     - Baris 126: Menu `Layanan` desktop hanya menautkan ke `url('/#layanan')` (anchor), sedangkan Mobile Drawer ([mobile-drawer.blade.php](./resources/views/components/layout/mobile-drawer.blade.php#L124)) menautkan ke `route('services.index')` (`/layanan`).
     - Baris 246: Bug key array `'kabupaten-demak' => 'jawa-tengah'` (seharusnya `'demak'`) membuat **link `/area/demak` hilang total dari Desktop Navbar**! `kabupaten-semarang` dan klaster **Bali** juga absen dari Desktop Navbar, serta `coverage-areas.blade.php` & `regional-coverage.blade.php` tidak mencantumkan klaster Bali.
   - **D. Distorsi `max-width: 15ch` pada `H1` Desktop di Halaman Area**:
     - Di [areas/city.blade.php](./resources/views/areas/city.blade.php#L141), [areas/district.blade.php](./resources/views/areas/district.blade.php#L53), dan [areas/province.blade.php](./resources/views/areas/province.blade.php#L131), `.area-hero h1 { max-width: 15ch; }` memaksa heading `lg:text-5xl` pecah jadi 6-7 baris vertikal sempit di layar desktop dan mendorong CTA ke bawah fold.

#### Rencana Diff Perubahan

```diff
--- a/resources/css/app.css
+++ b/resources/css/app.css
@@ -115,9 +115,12 @@
 /* Soft Scroll-Reveal System (No Heavy Bounce) */
-.reveal-soft {
+/* Progressive enhancement: hanya sembunyikan elemen below-the-fold saat JS aktif */
+.js-reveal-ready .reveal-soft:not(.is-visible) {
     opacity: 0;
     transform: translateY(14px);
     transition: opacity 0.65s cubic-bezier(0.22, 1, 0.36, 1), transform 0.65s cubic-bezier(0.22, 1, 0.36, 1);
 }
```
- Hapus kelas `.reveal-soft` / `.reveal-fade` dari semua elemen *above-the-fold* (breadcrumb, eyebrow, `<h1>`, deskripsi hero, CTA utama, gambar hero) di `areas/city.blade.php`, `areas/province.blade.php`, `areas/index.blade.php`, `articles/index.blade.php`, dan `gallery.blade.php`.
- Hapus `.content-auto` dari section Homepage yang memiliki elemen `.reveal-soft` (atau ubah reveal agar hanya diterapkan dengan kelas `js-reveal-ready` + fallback auto-reveal cepat sehingga tidak pernah tertahan `opacity: 0` di Googlebot Desktop).
- Ubah `.area-hero h1 { max-width: 15ch; }` menjadi `max-width: 22ch;` (atau `max-w-2xl` pada desktop) di `areas/city.blade.php`, `areas/district.blade.php`, dan `areas/province.blade.php`.
- Di [navbar.blade.php](./resources/views/components/layout/navbar.blade.php):
  ```diff
  - <a href="{{ url('/#layanan') }}"
  + <a href="{{ route('services.index') }}"
  ...
  - @foreach (['semarang' => 'jawa-tengah', 'kabupaten-demak' => 'jawa-tengah', 'bandar-lampung' => 'lampung'] as $slug => $province)
  + @foreach (['semarang' => 'jawa-tengah', 'kabupaten-semarang' => 'jawa-tengah', 'demak' => 'jawa-tengah', 'bandar-lampung' => 'lampung', 'kota-denpasar' => 'bali', 'kabupaten-badung' => 'bali'] as $slug => $province)
  ```
- Tambahkan kartu/klaster **Bali** (`Denpasar`, `Badung`, `Gianyar`, dkk.) di [coverage-areas.blade.php](./resources/views/components/landing-page/coverage-areas.blade.php) dan [regional-coverage.blade.php](./resources/views/components/area/regional-coverage.blade.php) agar cakupan nasional di Homepage & halaman Area sinkron 100% antara Desktop dan Mobile.

---

## Rencana Verifikasi & Pengujian

Setelah Anda menyetujui rencana ini dan seluruh perubahan diterapkan, verifikasi akan dijalankan secara menyeluruh:

1. **Automated Test Suite (`php artisan test`)**:
   - Menulis test baru `tests/Feature/GscSeoAuditRemediationTest.php` yang memverifikasi:
     - 301 redirect `/edukasi/edukasi/panduan/{slug}` -> `/artikel/{slug}` (status `301`, target tepat), dan `/artikel/{slug}` merender `200 OK` dengan `<link rel="canonical">` absolut ke `/artikel/{slug}`.
     - 301 1-hop untuk kedua varian Depok `-salin-judul` -> `/area/depok-cinere`.
     - 301 `/area/demak/demak` -> `/area/demak` dan `/layanan/floor-drain-kamar-mandi` -> `/layanan/jasa-kamar-mandi-dan-floor-drain-mampet`.
     - Pembuatan artikel baru lewat CMS dengan judul berakhiran `salin judul` menghasilkan slug bersih tanpa `-salin-judul`.
     - `<meta name="robots" content="noindex, follow">` hadir di `/sitemap`, `/kebijakan-privasi`, `/pengetahuan?page=2`, dan TIDAK hadir di `/`, `/pengetahuan`, `/area/jakarta-timur`.
     - `sitemap.xml` tidak mengandung `/kebijakan-privasi`, `/edukasi/`, Depok `-salin-judul`, 7 slug kembar (termasuk `/area/demak/demak`), atau kecamatan yang diset `is_priority = false`; namun mengandung `/artikel/{slug}` dan seluruh 239 kecamatan non-kembar aktif (Opsi 2).
     - JSON-LD di `/tentang-kami/peralatan/{slug}` tidak mengandung `"@type":"Product"` atau `og:type="product"`, melainkan `Plumber` + `Service` + `AreaServed` + `BreadcrumbList`; `/layanan/{slug}` tidak membocorkan `Plumber` kosong; `/kontak` tidak memiliki `Beranda` ganda pada `BreadcrumbList`; tidak ada `https://schema.org/InStock` pada `Service`.
     - `<title>` pada `/studi-kasus/{slug}` berakhir `oleh Drainusantara` (tanpa duplikasi `| Studi Kasus | Drainusantara`), panjang <= 58 karakter, meta description memuat hook CTR, serta halaman merender link internal ke `/area/{kota}` dan `/layanan/{slug}` (bukan `/#layanan`).
     - 7 slug kembar & kecamatan yang diset `is_priority = false` (atau saat `AREA_PRUNE_THIN_DISTRICTS=true`) mengembalikan `301` ke `/area/{kota}`, sedangkan seluruh 239 kecamatan non-kembar (default `is_priority = true`) mengembalikan `200 OK`.
     - Homepage & `/area/jakarta-timur` merender `<h1>` tanpa `opacity: 0` / `.reveal-soft`, dan Desktop navbar memuat `/layanan` serta `/area/demak`.
   - Menyelaraskan test lama yang terdampak perubahan arah kanonik `/artikel/{slug}` & schema `equipment.show`, lalu menjalankan `php artisan test` hingga seluruh test hijau.
2. **Frontend Build & Cache Check**:
   - Menjalankan `npm run build` untuk memverifikasi bundling Vite (`resources/css/app.css`, `resources/js/app.js`) bebas error.
   - Menjalankan `php artisan migrate --pretend` (dan `php artisan migrate` pada DB lokal) + `php artisan sitemap:warm` untuk memverifikasi migrasi & output XML aktual.
