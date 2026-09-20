# DESIGN.md - Drainusantara Web Platform

## 1. Overview
Drainusantara adalah platform penyedia jasa penanganan saluran/pipa mampet profesional. Website ini berorientasi pada konversi pelanggan (Lead Generation) via WhatsApp dan visibilitas mesin pencari (SEO Lokal) melalui halaman dinamis per kecamatan.

## 2. Tech Stack
- **Backend:** Laravel 13 (PHP)
- **Database:** MySQL
- **Frontend:** Blade Templating, Tailwind CSS, Alpine.js
- **SEO:** Package `artesaos/seotools` (Meta, OpenGraph, Twitter, JsonLd)
- **CMS:** Custom Dashboard berbasis Laravel MVC standar

## 3. Visual & Color Palette (Tailwind)
Desain minimalis, memprioritaskan kecepatan *load* halaman, dengan palet:
- **Primary:** `sky-600` (Biru Pipa/Air)
- **CTA/Accent:** `orange-500` (Oranye K3/Safety)
- **Background:** `white` & `slate-50`
- **Text:** `slate-800` & `slate-600`
- **Animasi:** Transisi ringan berbasis CSS (`transition-all duration-300`).

## 4. UI/UX & Navigation
Layout 100% Mobile-First.
- **Desktop Navigation:** Beranda | Layanan | Tentang Kami | Galeri | Pengetahuan | Area Layanan | [CTA: Hubungi Teknisi (Button Orange)]
- **Mobile Navigation:** Bottom Navbar fixed. Beranda | Layanan | [Hubungi Teknisi (Center Prominent, icon WhatsApp)] | Artikel | Hamburger Menu.

## 5. Alur Hubungi Teknisi
Semua tombol CTA "Hubungi Teknisi" me-route pengguna ke API WhatsApp (wa.me) dengan format pesan otomatis.

## 6. Landing Page Structure (Top to Bottom)
1. **Hero Section:** Headline SEO, Sub-headline, Background teknisi bekerja, 2 CTA Button.
2. **Layanan Kami:** Grid layanan (Wastafel, Kloset, Floor Drain, Inspeksi CCTV).
3. **Keunggulan Drainusantara:** Icon list (Tanpa Bongkar Keramik, Inspeksi CCTV 30 Meter, Garansi 30 Hari, Teknisi APD Steril & K3).
4. **Area Jangkauan (Dynamic):** Peta JABODETABEK, Semarang, Bandar Lampung dengan navigasi per kecamatan.
5. **Portofolio Klien:** Logo/Nama restoran dan perkantoran.
6. **Galeri Before-After:** Dokumentasi pengerjaan lapangan.
7. **Solusi Cerdas (Edukasi):** Fokus pada pencegahan mekanis (rooter/cctv) dan menghindari bahan kimia/soda api.
8. **Rating & Ulasan:** Testimoni pelanggan.
9. **FAQ:** Akordion pertanyaan umum.
10. **Footer:** Info kontak, jam operasional, navigasi, SEO links.

## 7. Database Schema (Core Tables - MySQL)
- `services`, `coverage_areas`, `portfolios`, `galleries`, `articles`, `reviews`