# Audit Pengindeksan Google Search Console & Rencana Perbaikan (`drainusantara.id`)

- **Tanggal Audit:** 27 November 2026
- **Properti GSC:** `https://drainusantara.id/` (URL-prefix, akses `siteRestrictedUser`)
- **Sumber Data:** Live Google Search Console API (`list_sites`, `list_sitemaps`, `diagnose_site`, `search_analytics` 480 hari, dan `batch_url_inspect` pada 405 URL) + verifikasi status HTTP live + inspeksi codebase Laravel di repo ini.
- **Status Codebase:** **Selesai diimplementasikan & terverifikasi lokal (Opsi A penuh + 301 studi kasus demo lama ke `/layanan/{slug}` + sinkronisasi [plan.md](../plan.md)). Siap deploy ke production.**

---

## 1. Ringkasan Eksekutif

Dari total **405 URL** yang diperiksa satu per satu melalui URL Inspection API (`0` error/kuota aman):

| Kelompok URL | Diperiksa | Terindeks (`PASS`) | Tidak Terindeks (`NEUTRAL`) | Catatan Penting |
| :--- | :---: | :---: | :---: | :--- |
| **`sitemap.xml` aktif** | 371 | **318 (85,7%)** | **53 (14,3%)** | 4 di antaranya adalah URL 301 redirect (`/edukasi/{category}`) |
| **Historis Search Analytics (di luar sitemap)** | 34 | 29 | **5** | 13 dari 34 URL ini mengembalikan **HTTP 404** di production (2 sudah terdeteksi 404 di GSC, 11 lainnya masih terindeks lama dan akan segera menjadi 404 di GSC) |
| **Total** | **405** | **347** | **58** | — |

### Ringkasan Sitemap & Performa GSC
- **Sitemap:** `https://drainusantara.id/sitemap.xml` — terakhir dikirim `2026-11-25`, terakhir diunduh Google `2026-11-27`, `0` error, `0` warning, `371` URL submitted. *(Angka `indexed: 0` di endpoint `list_sitemaps` hanyalah lag pelaporan metrik sitemap; faktanya **318 URL sudah `Submitted and indexed`**.)*
- **Performa 28 hari terakhir (`2026-10-29` s.d. `2026-11-25`):** `445` klik (`+5462,5%`), `2.039` tayangan, CTR `21,82%`, posisi rata-rata `14,6`.

> [!NOTE]
> **Batasan GSC API:** Google Search Console API tidak menyediakan endpoint langsung untuk tabel laporan *Pengindeksan → Halaman* di UI web GSC. Hasil di dokumen ini mencakup **100% URL `sitemap.xml` (371 URL)** ditambah **100% URL yang pernah mendapat tayangan di Search Analytics 480 hari terakhir (34 URL di luar sitemap)**. Jika ada URL lain yang belum pernah masuk sitemap maupun Search Analytics (mis. URL berparameter query acak), URL tersebut hanya terlihat di dashboard web GSC.

---

## 2. Daftar Lengkap 53 URL `sitemap.xml` yang Tidak Terindeks

### 2.1 `Crawled - currently not indexed` (35 URL)
Seluruh URL di bawah mengembalikan **HTTP `200 OK`**, `robots.txt: ALLOWED`, `meta robots: index, follow`, dan mayoritas baru di-crawl Google pada **25 November 2026** (kecuali `area/depok-cinere/sawangan` pada 3 November 2026).

#### Layanan (2 URL)
| URL | Crawl Terakhir | HTTP Live | Dugaan Penyebab |
| :--- | :---: | :---: | :--- |
| `https://drainusantara.id/layanan/jasa-hydro-jetting-dan-rooter-pipa` | 2026-11-25 | 200 | Slug lama `/layanan/kuras-grease-trap-lemak` masih berstatus terindeks (crawl 2026-11-14) & masih ditautkan internal link |
| `https://drainusantara.id/layanan/jasa-inspeksi-kamera-cctv-pipa` | 2026-11-25 | 200 | Slug lama `/layanan/inspeksi-kamera-cctv-pipa` masih berstatus terindeks (crawl 2026-11-14) & masih ditautkan internal link |

#### Customer Service (4 URL)
| URL | Crawl Terakhir | HTTP Live |
| :--- | :---: | :---: |
| `https://drainusantara.id/customer-service` | 2026-11-25 | 200 |
| `https://drainusantara.id/customer-service/tiktok` | 2026-11-25 | 200 |
| `https://drainusantara.id/customer-service/youtube` | 2026-11-25 | 200 |
| `https://drainusantara.id/customer-service/linkedin` | 2026-11-25 | 200 |

#### Area Layanan (29 URL)
| Wilayah | URL | Crawl Terakhir |
| :--- | :--- | :---: |
| **DKI Jakarta (10)** | `https://drainusantara.id/area/jakarta-timur/rawamangun` | 2026-11-25 |
| | `https://drainusantara.id/area/jakarta-selatan/cilandak` | 2026-11-25 |
| | `https://drainusantara.id/area/jakarta-selatan/pancoran` | 2026-11-25 |
| | `https://drainusantara.id/area/jakarta-selatan/pesanggrahan` | 2026-11-25 |
| | `https://drainusantara.id/area/jakarta-selatan/jagakarsa` | 2026-11-25 |
| | `https://drainusantara.id/area/jakarta-barat/kebon-jeruk` | 2026-11-25 |
| | `https://drainusantara.id/area/jakarta-barat/grogol-petamburan` | 2026-11-25 |
| | `https://drainusantara.id/area/jakarta-barat/kalideres` | 2026-11-25 |
| | `https://drainusantara.id/area/jakarta-utara/pantai-indah-kapuk` | 2026-11-25 |
| | `https://drainusantara.id/area/jakarta-pusat/gambir` | 2026-11-25 |
| **Depok & Bekasi (4)** | `https://drainusantara.id/area/depok-cinere/sawangan` | 2026-11-03 |
| | `https://drainusantara.id/area/bekasi-cikarang/cikarang-utara` | 2026-11-25 |
| | `https://drainusantara.id/area/bekasi-cikarang/harapan-indah` | 2026-11-25 |
| | `https://drainusantara.id/area/bekasi-cikarang/cibitung` | 2026-11-25 |
| **Bandung (6)** | `https://drainusantara.id/area/bandung/arcamanik` | 2026-11-25 |
| | `https://drainusantara.id/area/bandung/babakan-ciparay` | 2026-11-25 |
| | `https://drainusantara.id/area/bandung/batununggal` | 2026-11-25 |
| | `https://drainusantara.id/area/bandung/dago` | 2026-11-25 |
| | `https://drainusantara.id/area/bandung/lengkong` | 2026-11-25 |
| | `https://drainusantara.id/area/bandung/sukajadi` | 2026-11-25 |
| **Tangerang (3)** | `https://drainusantara.id/area/tangerang-kota` | 2026-11-25 |
| | `https://drainusantara.id/area/tangerang-kota/ciledug` | 2026-11-25 |
| | `https://drainusantara.id/area/tangerang-kota/tangerang` | 2026-11-25 |
| **Semarang (2)** | `https://drainusantara.id/area/semarang/candisari` | 2026-11-25 |
| | `https://drainusantara.id/area/semarang/semarang-tengah` | 2026-11-25 |
| **Lampung (1)** | `https://drainusantara.id/area/bandar-lampung/sukarame` | 2026-11-25 |
| **Bali (3)** | `https://drainusantara.id/area/kabupaten-gianyar/tegallalang` | 2026-11-25 |
| | `https://drainusantara.id/area/kabupaten-karangasem/karangasem` *(slug kembar — dicakup `plan.md`)* | 2026-11-25 |
| | `https://drainusantara.id/area/kabupaten-karangasem/padangbai` | 2026-11-25 |

---

### 2.2 `Discovered - currently not indexed` (13 URL)
Sudah diketahui Google (dari sitemap/link) namun belum di-crawl:

| Bagian | URL | HTTP Live | Catatan |
| :--- | :--- | :---: | :--- |
| **Tentang Kami** | `https://drainusantara.id/tentang-kami/portofolio` | 200 | Belum di-crawl |
| **Peralatan (4/6)** | `https://drainusantara.id/tentang-kami/peralatan/kabel-spiral-baja-drain-cleaner` | 200 | Slug peralatan baru |
| | `https://drainusantara.id/tentang-kami/peralatan/kamera-inspeksi-saluran-pipa` | 200 | Pengganti slug lama yang kini 404 |
| | `https://drainusantara.id/tentang-kami/peralatan/mesin-drain-cleaner-heavy-duty-roda` | 200 | Slug peralatan baru |
| | `https://drainusantara.id/tentang-kami/peralatan/set-mata-bor-pisau-spiral-drain-cleaner` | 200 | Pengganti slug lama yang kini 404 |
| **Customer Service** | `https://drainusantara.id/customer-service/instagram` | 200 | Belum di-crawl |
| **Edukasi (Artikel)** | `https://drainusantara.id/edukasi/edukasi/panduan/mengapa-saluran-pembuangan-dapur-restoran-lebih-cepat-mampet` | 200 | Versi `/artikel/...` masih terindeks |
| | `https://drainusantara.id/edukasi/penguatan-brand/panduan/drainusantara-kini-hadir-di-bali-solusi-jasa-saluran-pipa-mampet-profesional` | 200 | Artikel baru |
| | `https://drainusantara.id/edukasi/edukasi/panduan/mengenal-mesin-ridgid-fungsi-teknologi-dan-kegunaannya-untuk-mengatasi-saluran-pipa-mampet` | 200 | Versi `/artikel/...` masih terindeks |
| | `https://drainusantara.id/edukasi/penguatan-brand/panduan/mengenal-lebih-dekat-tim-profesional-di-balik-layanan-drainusantara` | 200 | Versi `/artikel/...` masih terindeks |
| | `https://drainusantara.id/edukasi/penguatan-brand/panduan/bukan-sekadar-kerja-etos-profesionalisme-di-balik-layanan-drainusantara` | 200 | Versi `/artikel/...` masih terindeks |
| **Edukasi (Kategori)** | `https://drainusantara.id/edukasi/edukasi` | **301** | ⚠️ Redirect ke `/pengetahuan?category=edukasi` |
| | `https://drainusantara.id/edukasi/area-layanan` | **301** | ⚠️ Redirect ke `/pengetahuan?category=area-layanan` |

---

### 2.3 `URL is unknown to Google` (4 URL)
| Bagian | URL | HTTP Live | Catatan |
| :--- | :--- | :---: | :--- |
| **Edukasi (Artikel)** | `https://drainusantara.id/edukasi/penguatan-brand/panduan/pelacakan-presisi-tanpa-bongkar-standar-inspeksi-kamera-drainusantara` | 200 | Versi `/artikel/...` masih terindeks |
| **Edukasi (Kategori)** | `https://drainusantara.id/edukasi/promo-penawaran` | **301** | ⚠️ Redirect ke `/pengetahuan?category=promo-penawaran` |
| **Peralatan (2/6)** | `https://drainusantara.id/tentang-kami/peralatan/mesin-drain-cleaner-spiral-rotary` | 200 | Pengganti slug lama yang kini 404 |
| | `https://drainusantara.id/tentang-kami/peralatan/mesin-hydro-jetting-tekanan-tinggi` | 200 | Pengganti slug lama (`EquipmentSeeder`) |

---

### 2.4 `Page with redirect` (1 URL)
| URL | Crawl Terakhir | HTTP Live | Target Redirect & Canonical |
| :--- | :---: | :---: | :--- |
| `https://drainusantara.id/edukasi/penguatan-brand` | 2026-11-19 | **301** | ⚠️ Redirect ke `/pengetahuan?category=penguatan-brand` (canonical: `/pengetahuan`) |

---

## 3. Audit 34 URL Historis Search Analytics (di Luar `sitemap.xml`)

### 3.1 Sudah Berstatus Tidak Terindeks di GSC (5 URL)
| Status GSC | URL | HTTP Live | Keterangan |
| :--- | :--- | :---: | :--- |
| `Not found (404)` | `https://drainusantara.id/artikel/5-kebiasaan-penyebab-bak-cuci-piring-tersumbat` | **404** | Demo `ArticleSeeder` terhapus |
| `Not found (404)` | `https://drainusantara.id/artikel/bahaya-menggunakan-soda-api-saluran-mampet` | **404** | Demo `ArticleSeeder` terhapus |
| `Page with redirect` | `https://drainusantara.id/artikel/jasa-saluran-pipa-mampet-depok-perbaikan-pelancaran-saluran-air-profesional-salin-judul` | 301 | Redirect ke `/edukasi/area-layanan/depok/...` (di `plan.md` akan di-301 ke `/area/depok-cinere`) |
| `Page with redirect` | `https://drainusantara.id/layanan/floor-drain-kamar-mandi` | 301 | Redirect ke `/layanan/jasa-kamar-mandi-dan-floor-drain-mampet` |
| `Alternate page with proper canonical tag` | `https://drainusantara.id/tentang-kami` | 301 | Canonical ke `/tentang-kami/profil` |

### 3.2 Bom Waktu: 11 URL Masih Terindeks Lama di GSC, Tetapi Sudah Live **HTTP 404** di Production
URL berikut terakhir di-crawl Oktober–awal November 2026 sehingga masih tampil `Submitted and indexed` di GSC, padahal saat ini sudah mengembalikan **404** dan akan segera masuk laporan error *Not found (404)* saat Google melakukan recrawl:

#### A. Peralatan Lama (3 URL — berasal dari `EquipmentSeeder`)
| URL Lama (Live 404) | Terakhir Crawl | Slug Peralatan Baru Aktif di Production (`200 OK`) |
| :--- | :---: | :--- |
| `/tentang-kami/peralatan/kamera-cctv-endoskopi-pipa-ip68-30-meter` | 2026-11-03 | `/tentang-kami/peralatan/kamera-inspeksi-saluran-pipa` |
| `/tentang-kami/peralatan/mesin-drain-rooter-spiral-baja-rotary-ridgid-k-50-k-60` | 2026-11-03 | `/tentang-kami/peralatan/mesin-drain-cleaner-spiral-rotary` |
| `/tentang-kami/peralatan/set-4-jenis-mata-pemotong-spiral-baja-modular` | 2026-11-03 | `/tentang-kami/peralatan/set-mata-bor-pisau-spiral-drain-cleaner` |

*(Catatan: `EquipmentSeeder` juga punya 1 slug lama lain `unit-pembersih-saluran-high-pressure-hydro-jetting`, dan template fallback [equipment.blade.php](../resources/views/about/equipment.blade.php#L153-L315) memakai 3 slug hardcoded `mesin-rooter-ridgid-k-50-cable-spiral`, `inspeksi-kamera-cctv-pipa-saluran`, `high-pressure-hydro-jetting-unit`.)*

#### B. Artikel Lama Terhapus (3 URL — berasal dari `ArticleSeeder`)
| URL Lama (Live 404) | Terakhir Crawl | Kandidat Pengganti Topik Langsung di Production |
| :--- | :---: | :--- |
| `/artikel/panduan-perawatan-grease-trap-dapur-restoran` | 2026-10-13 | `standar-perawatan-grease-trap-restoran-kafe-cegah-lemak-membatu-di-pipa-utama` |
| `/artikel/kapan-saluran-pipa-butuh-inspeksi-kamera-cctv` | 2026-10-12 | `pelacakan-presisi-tanpa-bongkar-standar-inspeksi-kamera-drainusantara` |
| `/artikel/bahaya-kawat-manual-saluran-pipa-mampet` | 2026-10-12 | `mengenal-mesin-ridgid-fungsi-teknologi-dan-kegunaannya-untuk-mengatasi-saluran-pipa-mampet` |

*(Ditambah 2 artikel yang sudah terdeteksi `Not found (404)` di Bagian 3.1: `5-kebiasaan-penyebab-bak-cuci-piring-tersumbat` → `kenapa-air-wastafel-sering-melambat-kenali-5-penyebab-utama-cara-mencegahnya`, dan `bahaya-menggunakan-soda-api-saluran-mampet` → `solusi-tuntas-pipa-mampet-dapur-komersial-mengapa-mesin-spiral-baja-lebih-aman-dari-bahan-kimia`.)*

#### C. Studi Kasus Demo Lama (5 URL — berasal dari `GallerySeeder`)
| URL Lama (Live 404) | Terakhir Crawl | Rekomendasi |
| :--- | :---: | :--- |
| `/studi-kasus/ekstraksi-benda-asing-dari-kloset-duduk-hunian` | 2026-11-03 | Biarkan 404 (tidak ada pengganti 1-to-1) atau 301 ke `/layanan/jasa-wc-dan-kloset-mampet` |
| `/studi-kasus/inspeksi-kamera-cctv-pipa-bawah-tanah-ruko-kantor` | 2026-11-03 | Biarkan 404 atau 301 ke `/layanan/jasa-inspeksi-kamera-cctv-pipa` |
| `/studi-kasus/kuras-grease-trap-dan-sedot-lemak-kafe-komersial` | 2026-11-03 | Biarkan 404 atau 301 ke `/layanan/jasa-hydro-jetting-dan-rooter-pipa` |
| `/studi-kasus/pelancaran-floor-drain-kamar-mandi-utama` | 2026-11-03 | Biarkan 404 atau 301 ke `/layanan/jasa-kamar-mandi-dan-floor-drain-mampet` |
| `/studi-kasus/pelancaran-pipa-wastafel-dapur-restoran` | 2026-11-03 | Biarkan 404 atau 301 ke `/layanan/jasa-wastafel-dan-cucian-piring-mampet` |

---

## 4. Akar Masalah di Codebase & Sinkronisasi dengan `plan.md`

| # | Temuan Audit Live GSC (27 Nov 2026) | Lokasi di Codebase | Status terhadap [plan.md](../plan.md) |
| :-: | :--- | :--- | :--- |
| **1** | **4 URL kategori `/edukasi/{cat}` di `sitemap.xml` adalah 301 redirect** | [SitemapController.php](../app/Http/Controllers/Pages/SitemapController.php#L294-L307) & [web.php](../routes/web.php#L71-L73) | **Sudah tercakup** di `plan.md` Poin 2. |
| **2** | **Breadcrumb artikel (HTML & JSON-LD) masih menautkan ke URL 301 `/edukasi/{cat}` & `/edukasi/{cat}/{sub}`** | [ArticleController.php](../app/Http/Controllers/Pages/ArticleController.php#L217-L225) & [show.blade.php](../resources/views/articles/show.blade.php#L45-L48) | **Tambahan baru** — perlu diarahkan langsung ke `route('articles.index', ...)` agar nol internal link menuju 301. |
| **3** | **6/6 halaman peralatan baru belum terindeks; 3 slug peralatan lama live 404** | [AboutController.php](../app/Http/Controllers/Pages/AboutController.php#L150-L159) (`equipmentDetail()`) | **Tambahan baru** — `plan.md` Poin 3 baru mengubah schema `Product` → `Plumber/Service`, belum menyertakan 301 map slug peralatan lama → baru. |
| **4** | **5 slug artikel lama (`ArticleSeeder`) live 404** | [ArticleController.php](../app/Http/Controllers/Pages/ArticleController.php#L146-L154) (`articleDetail()`) | **Tambahan baru** — target 301 perlu **mengikuti keputusan `plan.md` Poin 1** (langsung ke kanonik `/artikel/{slug-pengganti}`, bukan `/edukasi/...`, bila `plan.md` dieksekusi). |
| **5** | **16+ artikel `/artikel/*` masih terindeks, sementara versi `/edukasi/*` macet di *Discovered/Unknown*** | [Article.php](../app/Models/Article.php#L521-L524) & [web.php](../routes/web.php#L77-L78) | **Memvalidasi `plan.md` Poin 1** (mengembalikan kanonik artikel ke `/artikel/{slug}`). |
| **6** | **2 layanan kanonik (`jasa-hydro-jetting-...`, `jasa-inspeksi-kamera-...`) masih `Crawled - not indexed`** | Slug lama masih terindeks & ditautkan di 4 view Blade | **Sudah tercakup** di `plan.md` Poin 1 (`Service::getCanonicalSlugAttribute()`). |
| **7** | **29 halaman `/area/*` + 5 `/customer-service/*` + `/tentang-kami/portofolio` belum terindeks** | Mayoritas baru di-crawl 25 Nov 2026; `kabupaten-karangasem/karangasem` termasuk 7 slug kembar | Sebagian besar masih dalam masa evaluasi crawl baru (2 hari); 7 slug kembar & pruning kecamatan tipis sudah dicakup `plan.md` Poin 5. |

---

## 5. Rencana Perbaikan Teknis yang Diusulkan (Menunggu Konfirmasi)

### Opsi A — Gabungkan Temuan Baru Ini ke Eksekusi [plan.md](../plan.md) *(Direkomendasikan)*
Agar tidak terjadi konflik arah kanonik artikel (`/edukasi/...` vs `/artikel/...`), perbaikan terbaik adalah menambahkan 3 item baru hasil audit ini ke paket implementasi `plan.md`:

1. **Hapus `/edukasi/{cat->slug}` dari `sitemap.xml`** ([SitemapController.php](../app/Http/Controllers/Pages/SitemapController.php#L294-L307)) + perbarui link breadcrumb kategori/subkategori di [ArticleController.php](../app/Http/Controllers/Pages/ArticleController.php#L217-L225) & [show.blade.php](../resources/views/articles/show.blade.php#L45-L48) agar langsung menuju `route('articles.index', ...)`.
2. **Tambahkan 301 Redirect Map untuk Slug Peralatan Lama** di [AboutController.php](../app/Http/Controllers/Pages/AboutController.php#L150-L159):
   - Cek dulu slug aktif di DB (agar tidak memecah test/DB yang masih memakai slug lama).
   - Jika tidak ada di DB dan termasuk daftar `LEGACY_EQUIPMENT_SLUG_MAP` serta slug target aktif di DB → `301` ke `route('equipment.show', ['slug' => $canonicalSlug])`:
     - `kamera-cctv-endoskopi-pipa-ip68-30-meter` → `kamera-inspeksi-saluran-pipa`
     - `mesin-drain-rooter-spiral-baja-rotary-ridgid-k-50-k-60` → `mesin-drain-cleaner-spiral-rotary`
     - `set-4-jenis-mata-pemotong-spiral-baja-modular` → `set-mata-bor-pisau-spiral-drain-cleaner`
     - `unit-pembersih-saluran-high-pressure-hydro-jetting` → `mesin-hydro-jetting-tekanan-tinggi`
     - `mesin-rooter-ridgid-k-50-cable-spiral` → `mesin-drain-cleaner-spiral-rotary`
     - `inspeksi-kamera-cctv-pipa-saluran` → `kamera-inspeksi-saluran-pipa`
     - `high-pressure-hydro-jetting-unit` → `mesin-hydro-jetting-tekanan-tinggi`
   - Selain itu tetap `404`.
3. **Tambahkan 301 Redirect Map untuk 5 Slug Artikel Lama (`ArticleSeeder`)** di [ArticleController.php](../app/Http/Controllers/Pages/ArticleController.php#L146-L154):
   - Jika slug artikel tidak ditemukan di DB dan artikel pengganti topiknya berstatus `is_published = true`, arahkan `301` langsung ke URL kanonik artikel pengganti (mengikuti URL kanonik final di `plan.md`: `/artikel/{slug-pengganti}`).
4. **Keputusan yang Perlu Dikonfirmasi untuk 5 Studi Kasus Demo Lama (Live 404):**
   - **Pilihan 1 (Disarankan SEO):** Biarkan tetap `404` agar Google membersihkan URL demo lama secara alami karena tidak ada studi kasus pengganti 1-to-1.
   - **Pilihan 2:** Tambahkan 301 ke halaman `/layanan/{slug}` yang sesuai topiknya.
5. **Tindak Lanjut di Google Search Console setelah Deploy:**
   - Jalankan `php artisan sitemap:generate --ping` di server production untuk membersihkan cache `sitemap_xml` dan mengirim ping.
   - Ajukan *Request Indexing* manual di UI GSC untuk halaman prioritas tinggi yang baru di-crawl/belum terindeks: 2 halaman `/layanan/*`, 6 halaman `/tentang-kami/peralatan/*`, `/tentang-kami/portofolio`, dan `/area/tangerang-kota`.
   - Pantau 29 halaman `/area/*` dan 5 `/customer-service/*` selama 7–14 hari (karena mayoritas baru di-crawl 25 Nov 2026) sebelum memutuskan apakah perlu pengayaan konten lokal atau *noindex/pruning*.

### Opsi B — Terapkan Quick-Fix Indexing Saja Terlebih Dahulu (Tanpa Mengubah Struktur `/edukasi/` vs `/artikel/` di `plan.md`)
Hanya mengerjakan poin 1, 2, dan 3 di atas (hapus `/edukasi/{cat}` dari sitemap + perbaiki breadcrumb redirect + tambah 301 peralatan lama & 5 artikel lama + test regresi) sebelum mengeksekusi sisa `plan.md`.

---

## 6. Rencana Verifikasi Setelah Eksekusi
- `php artisan test --filter="SitemapTest|EquipmentDetailAndCmsTest|SeoSiloAndSchemaIntegrityTest|AboutPageTest"`
- Pastikan `/sitemap.xml` tidak lagi memuat `/edukasi/{category}`.
- Pastikan seluruh slug peralatan lama & 5 artikel lama mengembalikan `301` 1-hop ke target kanonik aktif (dan slug acak/nonaktif tetap `404`).
