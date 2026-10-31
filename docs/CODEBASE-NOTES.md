# Catatan Arsitektur Codebase Drainusantara

Hasil pembacaan kode (branch `ilham-dev`). Dipakai sebagai peta kerja sebelum improvement.

## 1. Identitas produk

Bukan company profile biasa: mesin akuisisi lead lewat SEO lokal + WhatsApp, dengan CMS buatan sendiri sebagai backend konten.

- Audiens: rumah tangga (darurat kloset/wastafel mampet) dan B2B (resto/hotel/grease trap, butuh faktur pajak).
- Positioning: tanpa bongkar keramik, tanpa soda api, garansi 30 hari, no cure no pay.
- Konteks produk lengkap: `PRODUCT.md`; sistem visual: `DESIGN.md`.

## 2. Peta teknis

Stack: Laravel 13, Blade, Tailwind CSS 4, Alpine.js 3, Vite, SQLite dev / MySQL produksi.

`routes/web.php` membagi 4 blok:

- Publik: `/`, `/area` (+provinsi/kota/kecamatan), `/galeri`, `/pengetahuan`, `/artikel/{slug}`
- SEO mesin: `/sitemap.xml`, `/robots.txt`, `/llms.txt`
- Tentang kami: 8 sub-halaman di `/tentang-kami/*`
- CMS: `/login` (throttle 5/menit) + `/admin/*` 8 resource (services, coverage-areas, galleries, portfolios, staff, equipments, articles, reviews)

Hampir semua halaman publik ditangani `App\Http\Controllers\PageController` (~1013 baris). Controller lain murni CRUD admin. Tidak ada endpoint API/JSON; data untuk JS ditanam sebagai `<script type="application/json">`.

## 3. Alur request halaman publik

route -> PageController@action -> set SEO (SEOMeta + OpenGraph + TwitterCard + JsonLdMulti)
-> ambil data via `Cache::remember` (TTL 86400) -> view extends `layouts.app`
-> `{!! SEO::generate() !!}` di head -> komponen Blade.

`layouts/app.blade.php` satu-satunya shell: preload font + preload hero image (khusus homepage, untuk LCP), inject `window.__DRAINUSANTARA_WA__`, JSON webmcp, Vite assets, skip-link, navbar + search modal + drawer + footer + mobile dock, dan satu IntersectionObserver global untuk animasi reveal.

## 4. Mesin wilayah (inti SEO)

Sumber data `App\Services\RegionService`: array PHP hardcoded 5 provinsi, 13 kota, 114 kecamatan = 132 URL area, semuanya masuk sitemap.

Alur:
- `/area` -> daftar provinsi
- `/area/provinsi/{province}` -> daftar kota
- `/area/{city}` -> halaman kota
- `/area/{city}/{district}` -> halaman kecamatan

Halaman kecamatan menggabungkan dua sumber: RegionService (validasi slug; tidak ada di array = 404) + model `CoverageArea` (konten CMS: meta_title, meta_description, content, is_active). Kecamatan yang ada di array tapi belum ada di DB dibuatkan instance CoverageArea in-memory dengan meta otomatis, jadi URL tetap hidup tanpa seed. Ada tabel alias redirect (jaksel, tangsel, depok, cikarang, dll) dengan 301.

## 5. Alur konten CMS -> cache -> invalidasi

Admin CRUD (validasi field inline; file gambar lewat rule `App\Rules\OptimizedImage`; hanya Article/Gallery/Review punya FormRequest)
-> `MediaLifecycle` (transaksi DB + upload WebP + hapus file lama setelah commit)
-> observer `ContentCacheObserver` pada 8 model
-> `CacheService::clearPublicCache()` menghapus 15 key manual.

TTL: 24 jam normal, sitemap 1 jam, llms.txt 10 menit. Setiap simpan admin membuang seluruh cache publik, rebuild on-demand.

## 6. Mesin SEO

- JSON-LD via Artesaos\SEOTools, dibungkus `SafeJsonLdMulti` (override `generate()` agar JSON_HEX_TAG aman).
- Tipe schema: `Plumber` (LocalBusiness) untuk landing/area/galeri, `Article` untuk artikel, `BreadcrumbList` konsisten lewat helper `addBreadcrumb`.
- Sitemap runtime + cache 1 jam; slug area via `Str::slug`, `lastmod` artikel dari `updated_at`.
- robots.txt dinamis (disallow `/admin/`, `/login`), llms.txt untuk AI crawler (llmstxt.org).
- `PageMetadata::cleanTitle()` mencegah suffix brand ganda di meta title.

## 7. Mesin konversi WhatsApp

Tidak ada form kontak/booking. Semua konversi = link `wa.me/{nomor}?text=...` dengan teks terisi sesuai konteks (kecamatan, layanan, artikel, portofolio, kasus darurat). Nomor dari `config('app.whatsapp_number')` dengan fallback `6285609009009` yang diulang di banyak view.

Tambahan: `resources/js/webmcp.js` mendaftarkan tool read-only ke `navigator.modelContext` (WebMCP) agar agen AI browser bisa mencari layanan dan membangun link WA.

## 8. Frontend

- Landing = 12 komponen di `resources/views/components/landing-page/`.
- Alpine: satu store `layoutData` (menu, drawer, search dialog dengan focus trap manual, katalog diagnostik 6 masalah).
- Carousel custom (`resources/js/carousel.js`, 212 baris) dengan tes aksesibilitas node.
- Desain system di `DESIGN.md` ditegakkan lewat tes (`CarouselStyleTest`, `PublicAccessibilityTest`, `WhatsAppConfigTest`).

## 9. Status tes (diukur, bukan asumsi)

`php artisan test` -> 321 tes, 3097 assertion, semuanya lulus (baseline hijau per perbaikan 2026-10-28).

Dua penyebab 14 kegagalan sebelumnya, keduanya di `app/Support/ImageOptimizer.php`:

- EXIF orientation tidak pernah diterapkan karena build PHP lokal tidak memuat `ext-exif`, padahal kode hanya memutar gambar kalau `function_exists('exif_read_data')`. Sekarang orientasi dibaca langsung dari segmen APP1 JPEG oleh parser internal (`jpegOrientation()` + `tiffOrientation()`), jadi perilaku tidak lagi bergantung pada ekstensi.
- Estimasi memori (`$width * $height * 16 + 32 MB`) terlalu konservatif dan menolak foto 2400x1200 di CLI dengan `memory_limit=128M`. Sekarang dihitung dari buffer GD nyata: 4 byte/piksel untuk sumber + 4 byte/piksel untuk hasil resize + ukuran file + 8 MB overhead.

Guard tetap berfungsi: tes `test_memory_budget_is_checked_before_decode` (budget 16 MB) masih ditolak, dan PNG 6000x4000 tetap ditolak oleh batas 20 megapiksel.


## 10. Temuan untuk improvement

Prioritas 1 (risiko data/SEO):

- Harga "Rp 400.000" dan katalog 6 masalah diduplikasi di `welcome.blade.php` ($problemCatalogs), `resources/js/app.js` (diagnostics), `resources/js/webmcp.js` (DIAGNOSTIC_MESSAGES), padahal DB `Service` sudah punya `price_starting_from`.
- Search modal menyuntik JSON 132 area (~30 KB) ke setiap halaman karena berada di layout.
- Dua sumber kebenaran wilayah (RegionService array vs tabel coverage_areas) + 14 alias redirect hardcoded di controller.
- `CacheService` memakai daftar key manual; key baru yang tidak didaftarkan = data basi sampai TTL habis.

Prioritas 2 (struktur kode):

- `PageController` 1013 baris dengan boilerplate SEO berulang per action -> ekstrak PageMeta/SeoBuilder.
- Halaman provinsi/kota/kecamatan tidak di-cache (query CoverageArea tiap request), padahal landing di-cache.
- Validasi admin tidak konsisten: Service/Equipment/Staff inline, Article/Gallery/Review pakai FormRequest.

Prioritas 3 (CWV/visual):

- Hanya 3 file punya `srcset`; gambar dokumentasi/portofolio belum responsif.
- Copy halaman provinsi (663 baris) dan kecamatan (517 baris) padat hardcoded; area kerja utama untuk peningkatan visual/konversi.

## 11. Validasi upload media (disatukan)

Sebelumnya setiap controller punya rantai `image|mimes|max` sendiri: Equipment/Portfolio/Gallery menerima SVG dan GIF, Service/Staff/Article menerima SVG, dengan batas 5 MB sampai 20 MB. Optimizer hanya bisa JPEG/PNG/WebP, jadi SVG dan GIF lolos validasi lalu ditolak di belakang.

Sekarang satu sumber:

- `App\Support\ImageOptimizer::rejectionReason()` mengembalikan pesan penolakan atau `null`, dan dipakai oleh `webp()` maupun rule.
- `App\Rules\OptimizedImage` membungkus `rejectionReason()` untuk semua field media (Service, Equipment, Portfolio, Staff, Article thumbnail, Gallery before/after/image, Review avatar).
- Batas resmi ada sebagai konstanta: `MAX_BYTES` 20 MB, `MAX_SIDE` 12000 px, `MAX_PIXELS` 20 MP, `MAX_TARGET_SIDE` 1920 px.
- Atribut `accept` pada semua input file CMS diseragamkan ke `image/jpeg,image/png,image/webp`.
- Regresi dijaga `tests/Feature/ImageUploadRulesTest.php` (SVG ditolak, GIF ditolak, >20 MB ditolak, JPEG valid tetap tersimpan sebagai WebP).
