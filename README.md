# Drainusantara

Website layanan saluran pipa dengan halaman wilayah, artikel edukasi, galeri, portofolio, serta CMS admin.

## Stack dan kebutuhan

- Laravel 13, constraint `laravel/framework: ^13.17`. Versi persis mengikuti `composer.lock`; gunakan `composer install`, bukan `composer update`, untuk setup.
- PHP `^8.3`, Composer 2. Jalankan `composer check-platform-reqs` untuk memeriksa kebutuhan dependency terkunci.
- Blade, Tailwind CSS 4, Alpine.js 3, Vite 8. Node.js `^20.19.0 || >=22.12.0` dan npm.
- SQLite untuk pengembangan/tes; MySQL didukung melalui `pdo_mysql`.
- Ekstensi tambahan aplikasi: GD dengan dukungan WebP untuk optimasi gambar; `pdo_sqlite` untuk suite tes default. `mysqli` bukan driver database Laravel.

## Setup lokal baru

Jangan menimpa `.env` atau database instalasi yang sudah ada. Langkah berikut untuk checkout baru dan database lokal kosong.

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
```

Edit `.env`: set `APP_NAME=Drainusantara`, `APP_URL=http://localhost:8000`, dan `DB_CONNECTION=sqlite`. Untuk MySQL, siapkan database kosong dan isi `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, serta `DB_PASSWORD` sendiri. Jangan commit kredensial.

```bash
php artisan migrate
php artisan storage:link
npm ci --ignore-scripts
npm run build
php artisan serve
```

Buka `http://localhost:8000`. Untuk hot reload, jalankan `npm run dev` di terminal kedua. Folder `storage/` dan `bootstrap/cache/` harus dapat ditulis proses PHP. Aset frontend dibundel lokal, bukan Tailwind/Alpine CDN.

Seeder bersifat opsional. Periksa `database/seeders/DatabaseSeeder.php` sebelum menjalankannya; jangan seed ulang database berisi data CMS tanpa meninjau dampaknya.

## Tes dan pemeriksaan

```bash
composer check-platform-reqs
php artisan test
php artisan test tests/Feature/FrontendContentTest.php
node tests/carousel-accessibility.mjs
npm run build
```

`phpunit.xml` memakai SQLite `:memory:`, cache/session array, dan queue sync. Jangan jalankan tes migrasi terhadap database aplikasi. Jangan gunakan cache konfigurasi production saat menjalankan tes.

Regresi judul membedakan teks dengan sumber HTML: `assertSee('Panduan Perawatan & Tips')` melakukan escaping otomatis. Jangan memakai `false` untuk teks mentah yang di-escape Blade. Pemeriksaan DOM memastikan heading tampil dengan `&`, bukan `&amp;`, serta judul CMS tidak berubah menjadi markup.

Tes perilaku khusus MySQL tersedia melalui:

```bash
bash tests/run-mysql.sh
```

Runner ini memerlukan server MySQL lokal dan izin `sudo -n mysql`; membuat database/user sementara lalu menghapusnya saat selesai. Tidak memakai database aplikasi.

## Warning startup PHP / mysqli

Periksa executable dan konfigurasi yang benar sebelum mengubah ekstensi:

```bash
command -v php
php -v
php --ini
php --ri mysqli
php --ri pdo_mysql
composer check-platform-reqs
```

- `Module "mysqli" is already loaded`: sisakan satu directive aktif `extension=mysqli` di kumpulan INI milik SAPI terkait; hapus duplikat, bukan semua konfigurasi ekstensi.
- `Unable to load dynamic library 'mysqli'` atau `undefined symbol: mysqlnd_*`: pastikan paket ekstensi cocok dengan versi PHP dan `mysqlnd` dimuat sebelum `mysqli`. Pada Debian/Ubuntu, konfigurasi paket biasanya memuat `10-mysqlnd.ini` sebelum `20-mysqli.ini`. Jangan memuat `mysqli` lebih awal secara manual di `php.ini`.
- Laravel menggunakan PDO: pertahankan `pdo_mysql` untuk MySQL. Jangan menonaktifkan driver database hanya untuk menyembunyikan warning.
- PHP CLI dan PHP-FPM/Apache dapat memakai INI berbeda. Periksa SAPI yang mengeluarkan warning; reload layanan web hanya setelah konfigurasi diperbaiki.

Setelah perbaikan, ulangi `php -v`, `php --ri mysqli`, dan `php artisan test`. Jangan menyembunyikan masalah dengan `2>/dev/null` atau mematikan pelaporan error.

## Deployment

Arahkan document root ke `public/`. Set `APP_ENV=production`, `APP_DEBUG=false`, URL dan database production yang benar. Simpan `APP_KEY` existing; jangan regenerasi pada deployment rutin. Backup database sebelum migrasi. Install dependency dari lockfile, build aset, lalu jalankan migrasi yang sudah ditinjau. Jangan salin database atau kredensial tes ke production.

## Panduan proyek

- `AGENTS.md`: standar pengembangan.
- `PRODUCT.md`: konteks produk dan kebutuhan pengguna.
- `DESIGN.md`: panduan tampilan.
