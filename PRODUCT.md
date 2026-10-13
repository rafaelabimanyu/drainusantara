# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

1. **Pemilik Properti Residensial:**
   - Ibu rumah tangga, keluarga muda, bapak-bapak, hingga lansia yang mengalami situasi darurat saluran pembuangan mampet (wastafel dapur, floor drain kamar mandi, kloset toilet, atau talang air hujan).
   - Membutuhkan penanganan cepat, transparan tanpa biaya siluman, dan tidak ingin lantai keramik/marmer rumah mereka dibongkar atau dirusak.

2. **Pengelola Properti Komersial & Bisnis B2B:**
   - Manajer restoran/kafe F&B, pengelola ruko, hotel berbintang, manajemen gedung perkantoran, dan pengelola kawasan industri.
   - Membutuhkan penanganan sumbatan lemak (grease trap) berskala besar, pembersihan terjadwal di luar jam operasional (after-hours), serta kelengkapan administrasi pengadaan korporat resmi (SPK, BAPP, NPWP/SPPKP, dan e-Faktur Pajak PPN 11%).

## Product Purpose

Drainusantara adalah platform dan penyedia jasa spesialis pelancaran saluran pipa pembuangan tersumbat serta inspeksi perpipaan modern tanpa bongkar (non-destruktif). Kami mengubah pengalaman menghadapi pipa mampet yang kotor, membingungkan, dan memicu stres menjadi proses perbaikan yang bersih, tenang, akuntabel, dan bergaransi nyata.

## Positioning

Berbeda dari tukang ledeng konvensional yang mengandalkan pembongkaran lantai keramik berbiaya mahal atau penggunaan bahan kimia korosif (soda api/NaOH) yang melunakkan dan merusak pipa PVC, Drainusantara beroperasi dengan metode 100% mekanis presisi:
- Mesin spiral rotary heavy-duty (Ridgid USA) dengan kabel baja fleksibel berkecepatan 400 RPM.
- Unit semprotan air tekanan tinggi (High Pressure Hydro-Jetting) 100-200 bar untuk mengikis kerak minyak dan lemak beku.
- Kamera endoskopi inspeksi CCTV pipa tahan air IP68 jangkauan hingga 30 meter dengan dokumentasi video real-time.
- Didukung legalitas terverifikasi di bawah naungan ekosistem J&J Group, teknisi berstandar K3 & higienis (seragam rapi, sarung tangan, cover sepatu).

## Operating Context

- **Alur Pemesanan:** Panggilan darurat dan konsultasi langsung melalui integrasi URL dinamis WhatsApp 24 jam dengan teks otomatis berdasarkan jenis masalah dan lokasi.
- **Prinsip Pembayaran:** *No Cure No Pay* (saluran tuntas lancar plong, baru bayar).
- **Cakupan Wilayah Operasional:** Posko armada teknisi siaga di seluruh Jabodetabek (DKI Jakarta, Bogor, Depok, Tangerang, Tangerang Selatan, Bekasi), Kota Semarang, dan Kota Bandar Lampung.

## Capabilities and Constraints

- **Teknologi & Framework:** Laravel 13 (`laravel/framework: ^13.17`; versi terpasang mengikuti `composer.lock`), Blade Templates, Tailwind CSS, Alpine.js, SQLite/MySQL.
- **Frontend Assets:** Bundling lokal via Vite (`@vite(['resources/css/app.css', 'resources/js/app.js'])`), dilarang menggunakan CDN eksternal di production view.
- **Performance & SEO:** Memenuhi skor tinggi Core Web Vitals, dynamic JSON-LD Schema `LocalBusiness` & `PlumbingService`, `{!! SEO::generate() !!}` di `<head>`.
- **Integrasi WhatsApp:** Parameter generator dinamis `https://wa.me/{nomor}?text={encoded_text}` pada setiap CTA.
- **Istilah Teknis Perpipaan Indonesia:** Menggunakan terminologi plumbing presisi (Spiral Baja Rotary, Rooter, Hydro-Jetting, Grease Trap, Leher Angsa, Bak Kontrol, Kamera CCTV IP68).

## Brand Commitments

- **Identitas Visual:** Modern, bersih, higienis, dan ramah segala usia (*All-Ages Approachable*).
- **Palet Warna Utama:** `sky-700` (identitas kebersihan air & kepercayaan), `emerald-600` (CTA WhatsApp konversi tinggi), `amber-500` (bintang ulasan Google Maps 5.0 & badge garansi), kanvas `bg-slate-50` / `bg-white`, serta `bg-slate-900` untuk kontras teknis.
- **Tipografi:** `Plus Jakarta Sans`, kontras rasio WCAG AA minimal 4.5:1, target sentuh minimum 44px–48px untuk kemudahan navigasi lansia dan pengguna ponsel.
- **Anti-Slop Standard:** Dilarang menggunakan bayangan buram tebal (`shadow-2xl`), dilarang sudut melengkung ekstrem (`rounded-3xl` berlebihan), gunakan garis batas kontras terukur (`border-slate-200`), dan hilangkan karakter em-dash (`—`).

## Evidence on Hand

- Bukti nota fisik & invoice digital registrasi Garansi 30 Hari resmi.
- Legalitas korporat: NIB OSS Kementerian Investasi/BKPM, NPWP & SPPKP resmi Ditjen Pajak, dan penerbitan e-Faktur PPN 11%.
- Dokumentasi foto nyata before-after pengerjaan residensial dan restoran komersial di direktori aset proyek.
- Ulasan nyata pelanggan terverifikasi bintang 5.0 di Google Maps.

## Product Principles

1. **100% Non-Destruktif & Bebas Kimia Berbahaya:** Mengutamakan keselamatan struktur properti klien tanpa pembongkaran ubin dan tanpa soda api.
2. **Transparansi Harga & Kepastian Hasil:** Estimasi biaya jelas di awal dengan komitmen *No Result No Pay*.
3. **Higienitas & Disiplin K3:** Teknisi wajib mengenakan pelindung sepatu (cover shoes) dan membersihkan kembali area kerja pasca tindakan.
4. **Respon Darurat Cepat & Aksesibel:** Desain antarmuka ponsel yang memudahkan pengguna segala usia memanggil teknisi terdekat dalam hitungan detik.
5. **Jaminan Purna Jual Nyata:** Perlindungan garansi 30 hari kalender dengan kunjungan ulang gratis jika masalah berulang pada titik yang sama.

## Accessibility & Inclusion

- Mematuhi standar WCAG 2.1 Level AA (kontras teks tinggi, navigasi keyboard ramah fokus).
- Target sentuh ergonomis (Touch Targets) min. 48px untuk tombol utama dan bottom navigation bar pada tampilan ponsel.
- Navigasi ramah lansia: Teks terbaca jelas dengan hierarki visual terarah, tanpa istilah jargon yang membingungkan orang awam.
