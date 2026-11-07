# Catatan Arsitektur Codebase Drainusantara

Hasil pembacaan dan pembaruan arsitektur kode (branch `ilham-dev`, update per November 2026). Dipakai sebagai peta kerja, standar teknis, dan panduan audit sebelum improvement.

---

## 1. Identitas Produk

Bukan sekadar company profile biasa: mesin akuisisi lead lewat SEO lokal terstruktur + integrasi WhatsApp dinamis + Form Permohonan Kunjungan, dengan CMS buatan sendiri sebagai backend konten.

- **Audiens:** Rumah tangga (darurat kloset, wastafel, pipa talang mampet) dan B2B (restoran, ruko, hotel, sentra kuliner, grease trap, butuh legalitas resmi & faktur pajak PT Jawa Jaya Rooter).
- **Positioning:** Non-destructive engineering (tanpa bongkar keramik lantai), tanpa zat kimia/soda api korosif, mesin spiral rotary Ridgid baja lentur, inspeksi visual kamera endoskopi CCTV IP68 30 meter, garansi tertulis 30 hari kalender, no cure no pay.
- **Konteks produk lengkap:** `PRODUCT.md`; sistem visual & standard UI: `DESIGN.md`; aturan anti-slop: `AGENTS.md`.

---

## 2. Peta Teknis & Struktur Controller

**Stack:** Laravel 13 (`laravel/framework: ^13.17`), Blade, Tailwind CSS 4, Alpine.js 3, Vite bundler lokal (`@vite(['resources/css/app.css', 'resources/js/app.js'])`), SQLite in-memory untuk dev/test suite, MySQL produksi.

Controller publik telah dipecah modular ke dalam namespace `App\Http\Controllers\Pages\*` (menggantikan monolitik `PageController` lama):
- `HomeController`: Landing page beranda (`/`).
- `AreaController`: Direktori hierarki wilayah (`/area`, `/area/provinsi/{province}`, `/area/{city}`, `/area/{city}/{district}`).
- `AboutController`: Sub-page perusahaan (`/tentang-kami/*`: profil, holding PT Jawa Jaya Rooter, SOP K3, peralatan, garansi, FAQ).
- `ShowcaseController`: Dokumentasi hasil pengerjaan, studi kasus lapangan, dan kemitraan (`/galeri`, `/studi-kasus/{slug}`, `/kemitraan/{slug}`).
- `ArticleController`: Pusat pengetahuan & edukasi pipa sanitasi (`/pengetahuan`, `/artikel/{slug}`).
- `ContactController`: Halaman kontak resmi & submit form reservasi teknisi (`/kontak`).
- `SitemapController`: Human HTML sitemap (`/sitemap`), dynamic XML sitemap (`/sitemap.xml`), robots.txt dinamis (`/robots.txt`), dan AI crawler discovery (`/llms.txt`).
- `AiCatalogController`: Agentic Resource Discovery (ARD v1.0) AI Catalog (`/.well-known/ai-catalog.json`).

Controller admin berada di namespace `App\Http\Controllers\*` untuk CRUD 10 resource CMS: `ServiceController`, `CoverageAreaController`, `GalleryController`, `PortfolioController`, `StaffController`, `EquipmentController`, `ArticleController`, `ReviewController`, `FaqController`, `ContactMessageController`, dan `CompanyPageController`.

---

## 3. Alur Request Halaman Publik

`Route` -> `Pages\Controller@action` -> set metadata SEO via `PageMetadata` + `SEOMeta` + `OpenGraph` + `TwitterCard` + `SafeJsonLdMulti`
-> ambil data via `Cache::remember` (TTL 86400) -> view extends `layouts.app`
-> `{!! SEO::generate() !!}` di `<head>` -> render komponen Blade berstandar Core Web Vitals tinggi.

`layouts/app.blade.php` adalah shell utama:
- Preload font lokal (`Plus Jakarta Sans` woff2) & preload WebP hero image untuk optimalisasi LCP.
- Tag bahasa dan target regional kanonikal: `<link rel="alternate" hreflang="id" ...>` & `hreflang="x-default"`.
- Geotargeting terstruktur: `@hasSection('custom_geo') @yield('custom_geo') @else ... @endif` mencegah duplikasi tag koordinat pada halaman wilayah.
- Injeksi global state: `window.__DRAINUSANTARA_WA__`, `window.__DRAINUSANTARA_DYNAMIC_WA_URL__`, `window.__DRAINUSANTARA_CONTEXTUAL_WA_MSG__`.
- Komponen layout: Navbar (popover grid 5 kolom mencakup Bandung & hub `/area`), Mobile Drawer, Search Modal, Footer 4 kolom ber-anchor link posko kota, Mobile Bottom Bar, dan Floating WhatsApp CTA.

---

## 4. Mesin Wilayah & GEO SEO

Sumber data master: `App\Services\RegionService` mencakup **6 provinsi, 19 kota/kabupaten, dan 114+ kecamatan**:
1. **DKI Jakarta (`ID-JK`):** Jakarta Timur, Jakarta Selatan, Jakarta Barat, Jakarta Utara, Jakarta Pusat.
2. **Jawa Barat (`ID-JB`):** Bogor, Depok & Cinere, Bekasi & Cikarang, Kota Bandung, Kabupaten Bandung, Kota Cimahi.
3. **Banten (`ID-BT`):** Tangerang Kota, Tangerang Selatan.
4. **Jawa Tengah (`ID-JT`):** Kota Semarang, Kabupaten Semarang, Kabupaten Demak.
5. **Lampung (`ID-LA`):** Bandar Lampung.
6. **Bali (`ID-BA`):** Kota Denpasar, Kabupaten Badung, Kabupaten Gianyar, Kabupaten Tabanan, Kabupaten Buleleng, Kabupaten Bangli, Kabupaten Klungkung, Kabupaten Karangasem, Kabupaten Jembrana.

### Mekanisme Geotargeting:
- **Centroid Presisi 100%:** `RegionService::centroid($citySlug, $districtName)` memetakan koordinat latitude/longitude GPS riil untuk seluruh kota dan kecamatan (termasuk Bali dan Bandung Raya).
- **ISO 3166-2 Sub-division:** `RegionService::isoRegion()` menghasilkan kode wilayah standar internasional (`ID-JK`, `ID-JB`, `ID-BT`, `ID-JT`, `ID-LA`, `ID-BA`).
- **Pencegahan Konflik Head:** Halaman wilayah menginjeksi `@section('custom_geo')` berisi `geo.region`, `geo.placename`, `geo.position`, `ICBM`, serta tag OpenGraph location (`og:latitude`, `og:longitude`, `og:locality`, `og:region`), menggantikan tag default Jakarta.
- **Silo Internal Link Antar-Kota:** Halaman kota (`city.blade.php`) menyertakan blok navigasi horizontal *"Posko Kota Terkait di Provinsi Ini"* untuk memperkuat transfer *link equity*.
- **Alias Redirect 301:** Menangani variasi singkatan lokal (jaksel, jaktim, jakbar, jakut, jakpus, tangsel, tangerang, depok, bekasi, cikarang, semarang, bandung, lampung).

---

## 5. Mesin Indexing & Structured Data (SEO)

### A. Protokol Indexing & Sitemap
- **IndexNow Instant Push:** File otentikasi `public/drainusantara-indexnow-key.txt` disiapkan untuk validasi mesin pencari. `SearchEnginePingService` otomatis mengirim batch URL saat CMS diperbarui.
- **Hierarchical Priority XML Sitemap (`/sitemap.xml`):**
  - Beranda (`/`): `1.0`
  - Hub Kota, Direktori Wilayah & Kontak (`/area`, `/area/{city}`, `/kontak`): `0.9`
  - Halaman Kecamatan & Profil Perusahaan (`/area/{city}/{district}`, `/tentang-kami/*`): `0.8`
  - Halaman Legalitas (`/kebijakan-privasi`, `/syarat-dan-ketentuan`): `0.5`
- **Timestamp `<lastmod>` Autentik:** Mengambil waktu riil `updated_at` dari model database (`CoverageArea`, `CompanyPage`, `Article`, `Gallery`, `Portfolio`, `Equipment`) dan menghilangkan synthetic date palsu agar mematuhi aturan Google Webmaster.
- **Full HTML Sitemap (`/sitemap`):** Mengekspos direktori pohon lengkap dari 6 provinsi, 19 kota, hingga seluruh 114+ kecamatan agar Googlebot dapat merayapi seluruh hierarki wilayah dari 1 halaman HTML.

### B. Schema.org Rich Results
- **Schema `Plumber` (LocalBusiness):**
  - Memuat `name`, `url` kanonikal, `image` teknisi profesional, `telephone` E.164 (`+6285609009009`), `priceRange`, `openingHours` 24/7, `address` (`PostalAddress`), `geo` (`GeoCoordinates`), dan `parentOrganization` (PT JAWA JAYA ROOTER).
  - Dilengkapi **`aggregateRating`** (rating 4.9 dari ulasan riil) untuk memicu Google Rich Snippets (bintang emas ⭐⭐⭐⭐⭐ di SERP).
  - Dilengkapi `hasOfferCatalog` yang memetakan katalog spesialis pipa mampet.
- **Schema Tambahan:** `BreadcrumbList` terstruktur di setiap halaman via `HasPageSeo::addBreadcrumb`, `Article` pada halaman edukasi sanitasi, `FAQPage` pada accordion tanya jawab, dan `WebSite` pada beranda.

---

## 6. Mesin Konversi (WhatsApp & Reservasi)

- **WhatsApp URL Builder Dinamis:** `WhatsAppService::buildUrl()` membuat tautan `https://wa.me/{nomor}?text={encoded_msg}` dengan parameter spesifik masalah (kloset, wastafel, floor drain, talang air, grease trap, posko kecamatan).
- **Form Reservasi Layanan (`/kontak`):** Disediakan form kontak alternatif dengan proteksi rate limiting `throttle:10,1`, tersimpan ke database `contact_messages` untuk ditindaklanjuti admin.
- **Browser Agent Discovery (WebMCP):** `resources/js/webmcp.js` mendaftarkan context tool ke `navigator.modelContext` agar asisten AI browser dapat memahami katalog diagnostik dan membangun kontak dispatch.

---

## 7. Alur Konten CMS, Media & Cache Invalidation

1. Admin melakukan CRUD melalui antarmuka admin yang dilindungi middleware `auth` dan throttling login.
2. File gambar divalidasi ketat oleh `App\Rules\OptimizedImage` dan diproses oleh `App\Support\ImageOptimizer` (konversi WebP otomatis, max 20 MB, batas resolusi 20 MP, pembacaan EXIF orientation APP1).
3. Transaksi DB menggunakan `MediaLifecycle` untuk menjamin file lama hanya dihapus setelah database commit sukses.
4. Model-model utama (`Service`, `Review`, `Gallery`, `Article`, `Portfolio`, `CoverageArea`, `Staff`, `Equipment`, `CompanyPage`, `Faq`) dipantau oleh `ContentCacheObserver`.
5. Saat terjadi create/update/delete, `CacheService::clearPublicCache()` secara otomatis menginvalidasi cache publik (layanan, wilayah, galeri, FAQ, sitemap, llms.txt) agar data selalu mutakhir.

---

## 8. Status Tes & Jaminan Kualitas (Test Suite Baseline)

Seluruh perubahan kode wajib mematuhi standar test-driven verification tanpa regresi:

```bash
php artisan test
```

- **Status Baseline (Per November 2026):** **464 tests passed**, **4,702 assertions**, **100% PASS**.
- **Cakupan Pengujian Kunci:**
  - `GeoSeoTest`: Memastikan akurasi geotags ISO 3166-2 (DKI Jakarta, Jabar, Banten, Jateng, Lampung, Bali), koordinat GPS Denpasar/Sanur/Bandung, `aggregateRating` pada Schema Plumber, ketiadaan duplikasi meta geo tags, dan tag `hreflang`.
  - `SitemapTest`: Memverifikasi struktur XML sitemap, tiered priorities (1.0, 0.9, 0.8, 0.5), keberadaan file kunci IndexNow, dan keterjangkauan seluruh kecamatan di HTML sitemap.
  - `SeoContentRegressionTest`: Memastikan keaslian tanggal `<lastmod>` dari database dan ketiadaan synthetic date pada rute statis.
  - `AreaPageTest`, `CoverageAreaLandingEnhancedTest`, `AreaMobileGapRegressionTest`: Menjaga hierarki routing provinsi, kota, dan kecamatan.
  - `ImageUploadRulesTest`: Menjaga aturan format WebP/JPEG/PNG dan penolakan SVG/GIF/eksesif memori.
  - `PublicAccessibilityTest` & `ResponsiveNavbarTest`: Menjaga kontras WCAG AA, navigasi keyboard, dan kepatuhan UI anti-slop.
