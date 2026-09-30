# Panduan Asset Background Hero Wilayah (Drainusantara)

Folder ini disiapkan untuk menampung foto background hero wilayah spesifik per provinsi, per kota, dan per kecamatan.

## Struktur Direktori & Format Penamaan File

### 1. Provinsi (`public/images/areas/provinces/`) — [SUMBER UTAMA]
Format: `{slug-provinsi}.webp` atau `.jpg`
**Cukup sediakan 4–5 foto di folder ini.** Semua halaman kota dan kecamatan di bawah provinsi terkait akan otomatis mewarisi foto ini sebagai hero background.
Contoh:
- `dki-jakarta.webp`
- `jawa-barat.webp`
- `banten.webp`
- `jawa-tengah.webp`
- `lampung.webp`

### 2. Kota / Kabupaten (`public/images/areas/cities/`) — [OPSIONAL OVERRIDE]
Format: `{slug-kota}.webp` atau `.jpg`
Jika tidak diisi, otomatis mewarisi foto dari Provinsi induknya.
Contoh:
- `jakarta-selatan.webp`
- `semarang.webp`
- `depok-cinere.webp`

### 3. Kecamatan (`public/images/areas/districts/`) — [OPSIONAL OVERRIDE]
Format: `{slug-kota}-{slug-kecamatan}.webp` atau cukup `{slug-kecamatan}.webp`
Jika tidak diisi, otomatis mewarisi foto dari Provinsi induknya (dengan overlay halus).
Contoh (hanya jika ada kecamatan VIP yang ingin foto tersendiri):
- `jakarta-selatan-tebet.webp`
- `semarang-banyumanik.webp`

> **Tips:** Anda juga dapat mengisi langsung path gambar pada variabel `$customHeroBg` di bagian atas template blade masing-masing:
> - `resources/views/areas/province.blade.php`
> - `resources/views/areas/city.blade.php`
> - `resources/views/areas/district.blade.php`
