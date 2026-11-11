# Sistem Informasi Drainusantara (Knowledge Base)

Drainusantara (beroperasi di bawah badan hukum resmi PT Jawa Jaya Rooter) adalah penyedia layanan spesialis pelancaran saluran pipa pembuangan, sanitasi, dan plumbing engineering modern di Indonesia.

## Klaster Layanan Utama & Keyword Spesialisasi (Master Services)
- **Core Transactional:** Jasa saluran pipa mampet, jasa saluran mampet, jasa pipa mampet, tukang saluran mampet, tukang pipa tersumbat, ahli saluran air mampet, jasa pelancaran pipa mampet terdekat.
- **Problem-Specific (Titik Masalah):**
  * Jasa WC mampet & pelancaran kloset duduk/jongkok tersumbat benda padat/tisu (bukan jasa sedot WC septic tank).
  * Tukang wastafel & sink cuci piring dapur mampet lemak jenuh (fatberg).
  * Saluran air kamar mandi (floor drain) mampet akibat jalinan rambut dan residu busa sabun.
  * Pelancaran pipa talang air rooftop dan pipa buangan atap tersumbat endapan lumpur dak semen.
  * Pelancaran bak kontrol (inspection chamber) tersumbat di halaman atau garasi hunian.
- **USP & Metode Non-Destruktif:**
  * 100% tanpa bongkar keramik lantai atau dinding ubin hunian.
  * Menggunakan mesin spiral baja rotary Ridgid USA berkecepatan 400 RPM berdaya jangkau fleksibel hingga 30 meter.
  * Inspeksi kamera CCTV endoskopi pipa IP68 dengan monitor digital untuk diagnosa visual titik retak atau sumbatan pipa di bawah semen.
  * Komitmen "No Cure, No Pay" (saluran gagal lancar plong, 100% bebas biaya jasa).
  * Garansi resmi 30 hari kalender dengan nota invoice tertulis.
- **Komersial & B2B:**
  * Jasa kuras grease trap (bak penangkap lemak) restoran, kafe F&B, dan dapur komersial.
  * Perawatan berkala jaringan pipa limbah gedung perkantoran, ruko, hotel, dan pabrik.
- **Pain-Point & Edukasi Pipa PVC:**
  * Mengatasi pipa tersumbat kerak minyak membeku tanpa menggunakan bahan kimia korosif / soda api (NaOH) yang merusak sambungan lem fitting PVC.

## Parameter Operasional & SLA
- **Metode Kerja:** Non-destructive engineering (100% tanpa bongkar keramik lantai/dinding).
- **Kebijakan Harga:** "No cure, no pay" (Tidak berhasil lancar, 100% gratis). Tarif dasar mulai Rp 400.000.
- **Ketentuan Garansi:** Garansi tertulis 30 hari kalender pasca-pengerjaan.
- **Waktu Operasional:** Siaga 24 Jam (24/7). Waktu respons tim < 1 jam.
- **Spesifikasi Alat:** Mesin spiral rotary (Rooter) Ridgid baja lentur, Inspeksi Kamera CCTV Endoskopi IP68 (jangkauan hingga 30 meter).
- **Batas Bahan:** 100% bebas bahan kimia korosif / soda api (aman untuk instalasi pipa PVC jangka panjang).

## Area Jangkauan Resmi (Geotargeting)
Melayani cakupan rumah tinggal (residensial), ruko, restoran komersial, gedung perkantoran, dan industri di wilayah:
- **Jabodetabek:** DKI Jakarta (Jakarta Selatan, Timur, Barat, Pusat, Utara), Bogor, Depok & Cinere, Tangerang Kota, Tangerang Selatan / BSD, Bekasi & Cikarang.
- **Bandung Raya:** Kota Bandung, Kota Cimahi, dan sekitarnya.
- **Jawa Tengah:** Kota Semarang, Kabupaten Demak, dan koridor pesisir Pantura.
- **Lampung:** Kota Bandar Lampung dan sekitarnya.
- **Bali:** Kota Denpasar, Kabupaten Badung (Kuta, Seminyak, Canggu), Gianyar (Ubud), Tabanan, dan sekitarnya.

## Kontak Darurat & Lokasi
- **Reservasi WhatsApp (24/7):** https://wa.me/{{ $whatsappNumber }}
- **Hotline Telepon:** 0856-0900-9009
- **Email Resmi:** drainusantara@gmail.com
- **Markas Pusat:** Jl. Manunggal XVII No. 104, RT.5/RW.11, Lubang Buaya, Kec. Cipayung, Kota Jakarta Timur 13810, DKI Jakarta, Indonesia.

## Katalog Layanan Teknis
@forelse($services as $service)
- [{!! $service->name !!}]({{ url('/') }}/#layanan-{{ $service->slug }}): {!! $service->short_description ? $service->short_description : '' !!}
@empty
- [Kloset & WC Mampet]({{ url('/') }}/#layanan): Penanganan sumbatan benda padat (tisu, pembalut) tanpa pembongkaran kloset duduk maupun jongkok.
- [Wastafel & Sink Dapur]({{ url('/') }}/#layanan): Ekstraksi kerak lemak jenuh (fatberg) dan sisa makanan di leher angsa sifon.
- [Floor Drain Kamar Mandi]({{ url('/') }}/#layanan): Pembersihan gumpalan rambut dan kerak sabun penyumbat arus air.
- [Talang Air & Rooftop]({{ url('/') }}/#layanan): Pembersihan lumpur, pasir dak, dan tumpukan dedaunan yang menyumbat pipa vertikal.
- [Kuras Grease Trap]({{ url('/') }}/#layanan): Sedot dan pembersihan limbah lemak jenuh dapur komersial.
- [Inspeksi CCTV Pipa 30M]({{ url('/') }}/#layanan): Diagnostik visual menggunakan kamera IP68 untuk memetakan titik jalur pipa retak, pecah, atau tersumbat parah.
@endforelse

## Peta Situs Kontekstual
- [Beranda (SLA & Harga)]({{ route('home') }})
- [Direktori Posko Kota & Kecamatan]({{ route('area.index') }}): daftar provinsi, kota, dan area layanan
- [Dokumentasi Before/After]({{ route('gallery') }})
- [Basis Pengetahuan Sanitasi]({{ route('articles.index') }})
- [Profil Perusahaan PT Jawa Jaya Rooter]({{ route('about.profile') }})
- [Syarat & Ketentuan Garansi]({{ route('about.warranty') }})
- [Katalog Peralatan]({{ route('about.equipment') }})
- [FAQ & Bantuan]({{ route('about.faq') }})