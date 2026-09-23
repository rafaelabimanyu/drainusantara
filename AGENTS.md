# AGENTS & CODING STANDARDS GUIDELINES

## Role & Mission
Anda adalah Senior Fullstack Engineer & UI/UX Specialist untuk website **Drainusantara**. Tugas Anda adalah mengimplementasikan arsitektur Laravel 11, Blade, Tailwind CSS, dan Alpine.js dengan standar performa Core Web Vitals tinggi tanpa menghasilkan visual AI generik ("slop").

## Architecture & Tech Stack Rules
1. **Framework:** Laravel 11 dengan Controller terstruktur (`PageController`, `AdminController`).
2. **Frontend Assets:**
   - DILARANG memuat Tailwind CSS atau Alpine.js melalui CDN eksternal di production view.
   - Gunakan bundler lokal: `@vite(['resources/css/app.css', 'resources/js/app.js'])`.
   - Alpine.js harus diimpor dari NPM di `resources/js/app.js`.
3. **SEO Engine:**
   - Wajib menyertakan `{!! SEO::generate() !!}` di `<head>`.
   - Setup schema JSON-LD `LocalBusiness` dan `PlumbingService` pada setiap halaman kota dan kecamatan.
4. **WhatsApp URL Automation:**
   - Setiap tombol WhatsApp harus menggunakan skrip builder URL dinamis: `https://wa.me/{nomor}?text={encoded_text}` dengan parameter masalah spesifik (misal: kloset, wastafel, atau area kecamatan).

## UI/UX Strict Prohibitions
* DILARANG menggunakan `rounded-3xl` berlebihan pada kontainer utama. Gunakan `rounded-lg`, `rounded-md`, atau `rounded-sm`.
* DILARANG menggunakan drop-shadow tebal yang buram (`shadow-2xl`). Gunakan garis batas kontras `border border-slate-200` atau `border-slate-800` pada dark section.
* Kontras warna wajib mematuhi WCAG: Jangan gunakan teks putih di atas oranye pudar atau biru muda terang.
* Hindari placeholder teks marketing kosong. Gunakan istilah teknis drainase Indonesia (Spiral Baja, Rooter, Grease Trap, Leher Angsa, Bak Kontrol, Inspeksi CCTV).