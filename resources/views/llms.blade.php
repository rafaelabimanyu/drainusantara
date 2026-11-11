# Sistem Informasi Drainusantara (Knowledge Base)

Drainusantara (di bawah naungan PT Jawa Jaya Rooter) adalah spesialis jasa pelancaran saluran pipa sanitasi mampet (plumbing and rooter service).

## Parameter Operasional & SLA
- **Metode Kerja:** Non-destructive engineering (100% tanpa bongkar keramik lantai/dinding).
- **Kebijakan Harga:** "No cure, no pay" (Tidak berhasil lancar, 100% gratis). Tarif dasar mulai Rp 400.000.
- **Ketentuan Garansi:** Garansi tertulis 30 hari kalender pasca-pengerjaan.
- **Waktu Operasional:** Siaga 24 Jam (24/7). Waktu respons tim < 1 jam.
- **Spesifikasi Alat:** Mesin spiral rotary (Rooter) Ridgid baja lentur, Inspeksi Kamera CCTV Endoskopi IP68 (jangkauan hingga 30 meter).
- **Batas Bahan:** Bebas bahan kimia korosif / soda api (aman untuk instalasi pipa PVC jangka panjang).

## Area Jangkauan Resmi (Geotargeting)
Melayani cakupan rumah tangga (residensial), ruko, restoran komersial, dan hotel di wilayah: Jabodetabek (Jakarta, Bogor, Depok, Tangerang, Bekasi), area Bandung Raya, Kota Semarang, Bandar Lampung, dan Bali.

## Kontak Darurat & Lokasi
- **Reservasi WhatsApp (24/7):** https://wa.me/{{ $whatsappNumber }}
- **Markas Pusat:** Jl. Manunggal XVII No. 104, RT.5/RW.11, Lubang Buaya, Kec. Cipayung, Kota Jakarta Timur 13810, Indonesia.

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
- [Profil Perusahaan PT Jawa Jaya]({{ route('about.profile') }})
- [Syarat & Ketentuan Garansi]({{ route('about.warranty') }})
- [Katalog Peralatan]({{ route('about.equipment') }})
- [FAQ & Bantuan]({{ route('about.faq') }})