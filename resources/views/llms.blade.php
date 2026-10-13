# Drainusantara

> Jasa pelancaran saluran pipa mampet tanpa bongkar keramik untuk rumah, ruko, dan restoran di Jabodetabek, Semarang, dan Bandar Lampung. Memakai mesin spiral baja (rooter) dan inspeksi kamera CCTV pipa. Garansi tertulis 30 hari.

Tarif mulai Rp 400.000. Siaga 24 jam. Kontak WhatsApp: https://wa.me/{{ $whatsappNumber }}
Workshop pusat: Jl. Duren Sawit Raya No. 45, Duren Sawit, Jakarta Timur 13440.

## Layanan

@forelse($services as $service)
- [{!! $service->name !!}]({{ url('/') }}/#layanan-{{ $service->slug }}){!! $service->short_description ? ': ' . $service->short_description : '' !!}
@empty
- [Wastafel & Cuci Piring Mampet]({{ url('/') }}/#layanan): kerak minyak dan lemak di leher angsa sifon
- [Kloset & WC Meluap]({{ url('/') }}/#layanan): sumbatan tisu, pembalut, dan kain tanpa bongkar kloset
- [Floor Drain Kamar Mandi]({{ url('/') }}/#layanan): gumpalan rambut dan kerak sabun
- [Talang Rooftop & Pipa Atap]({{ url('/') }}/#layanan): lumut, pasir dak, dan dedaunan
- [Kuras Grease Trap]({{ url('/') }}/#layanan): lemak jenuh dapur restoran dan kafe
- [Inspeksi CCTV Pipa 30M]({{ url('/') }}/#layanan): kamera IP68 untuk menemukan titik pipa retak atau tersumbat
@endforelse

## Informasi Utama

- [Beranda]({{ route('home') }}): ringkasan layanan, alur kerja, dan harga
- [Wilayah Layanan]({{ route('area.index') }}): daftar provinsi, kota, dan area layanan
- [Galeri Before & After]({{ route('gallery') }}): dokumentasi pengerjaan lapangan
- [Artikel & Edukasi]({{ route('articles.index') }}): panduan perawatan saluran pipa

## Tentang Kami

- [Profil]({{ route('about.profile') }})
- [Ketentuan Garansi]({{ route('about.warranty') }})
- [Peralatan]({{ route('about.equipment') }})
- [Portofolio Mitra B2B]({{ route('about.portfolio') }})
- [SOP K3]({{ route('about.k3') }})
- [FAQ]({{ route('about.faq') }})
