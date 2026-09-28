@extends('layouts.app')

@section('content')
@include('about.partials.nav', [
    'activeTitle' => 'Klien & Portofolio',
    'eyebrow' => 'Perusahaan Yang Menggunakan Jasa Kami',
    'heading' => 'Dipercaya Restoran F&B, Perhotelan & Gedung Komersial',
    'subheading' => 'Bukti nyata penanganan profesional pembersihan pipa pembuangan dan grease trap bagi mitra bisnis tanpa mengganggu jam operasional.'
])

<!-- Main Portfolio Content -->
<section id="portofolio-page" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Showcase Anchor Banner to Homepage Section -->
        <div class="mb-10 p-5 bg-white border border-sky-200 rounded-2xl shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-sky-50 text-sky-700 border border-sky-100 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900">Showcase Interaktif di Beranda</h3>
                    <p class="text-xs text-slate-600 mt-0.5">Lihat slider interaktif rekam jejak perusahaan dan penanganan pipa komersial langsung di beranda.</p>
                </div>
            </div>
            <a href="{{ url('/#portofolio-b2b') }}" class="btn-press shrink-0 inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-sky-700 hover:bg-sky-800 text-white text-xs font-bold rounded-xl transition-colors shadow-2xs min-h-[44px]">
                <span>Buka Bagian Perusahaan di Beranda</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>

        <div class="max-w-3xl mb-12">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Perusahaan Yang Menggunakan Jasa Kami
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Portofolio Penanganan Saluran Komersial &amp; Residensial
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Dari dapur komersial restoran mall hingga gedung perhotelan berbintang, teknisi Drainusantara terbiasa bekerja di bawah standar kepatuhan operasional tinggi, higienis, dan bergaransi resmi.
            </p>
        </div>

        @php
            $displayPortfolios = ($portfolios && $portfolios->isNotEmpty()) ? $portfolios : collect([
                (object)[
                    'client_name' => "D'Cost Seafood Restaurant",
                    'client_type' => 'Restoran & F&B Komersial',
                    'location' => 'Mall Kelapa Gading, Jakarta Utara',
                    'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=800&q=80',
                    'project_title' => 'Pengurasan & De-Greasing Grease Trap 800 Liter',
                    'description' => 'Pembersihan kerak minyak jenuh dan lumpur lemak pada bak perangkap lemak dapur komersial sepanjang 25 meter. Dikerjakan malam hari (after-hours) tanpa mengganggu operasional restoran.',
                    'specs' => ['Mesin Rooter Spiral K-60', 'After-Hours Service', 'Faktur Pajak B2B & BAST'],
                    'guarantee' => 'Garansi Resmi 30 Hari'
                ],
                (object)[
                    'client_name' => 'The Alana Hotel & Conference Center',
                    'client_type' => 'Perhotelan Bintang 4',
                    'location' => 'Sentul City, Bogor',
                    'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
                    'project_title' => 'Pelancaran Saluran Pembuangan Kamar Mandi 42 Kamar',
                    'description' => 'Pembersihan endapan busa sabun dan gumpalan rambut pada jalur pipa vertikal kamar mandi tamu. Teknisi ber-APD higienis, pengerjaan cepat dan hening tanpa keluhan dari tamu menginap.',
                    'specs' => ['Spiral Baja Lentur 16mm', 'Bebas Suara Bising', 'APD Steril & Rapi'],
                    'guarantee' => 'Garansi Resmi 30 Hari'
                ],
                (object)[
                    'client_name' => 'Food Court Living World',
                    'client_type' => 'Pusat Kuliner Komersial',
                    'location' => 'Alam Sutera, Tangerang Selatan',
                    'image' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=800&q=80',
                    'project_title' => 'Inspeksi CCTV & Pelancaran Manhole Utama 16 Tenant',
                    'description' => 'Penanganan pipa buang komunal grease trap yang meluap ke area servis. Deteksi koordinat endapan lemak beku dengan kamera CCTV pipa 30 meter dan pembersihan mekanis tuntas.',
                    'specs' => ['Kamera CCTV IP68 30M', 'Spiral Heavy Duty 22mm', '100% Tanpa Bongkar'],
                    'guarantee' => 'Garansi Resmi 30 Hari'
                ],
                (object)[
                    'client_name' => 'Gedung Menara Sudirman',
                    'client_type' => 'Gedung Perkantoran Bertingkat',
                    'location' => 'SCBD, Jakarta Selatan',
                    'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80',
                    'project_title' => 'Pelancaran Saluran Pipa Talang Rooftop Vertikal 18 Lantai',
                    'description' => 'Ekstraksi endapan lumpur dak beton, lumut, dan dedaunan yang menyumbat jalur pembuangan air hujan utama menjelang musim penghujan agar terhindar dari rembesan ke plafon tenant.',
                    'specs' => ['Rooter Baja Jangkauan Panjang', 'Sertifikasi K3 Ketinggian', 'Dokumentasi Video CCTV'],
                    'guarantee' => 'Garansi Resmi 30 Hari'
                ],
                (object)[
                    'client_name' => 'PT Indofood CBP Sukses Makmur',
                    'client_type' => 'Fasilitas Manufaktur & Industri',
                    'location' => 'Kawasan Industri Cikarang, Bekasi',
                    'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80',
                    'project_title' => 'Pembersihan Jalur Limbah Domestik Kantin Kapasitas 1.200 Porsi',
                    'description' => 'Pengerukan kerak lemak dan residu sisa makanan pada bak kontrol utama kantin pabrik. Menggunakan mesin spiral torsi tinggi bebas bahan kimia berbahaya sehingga aman bagi lingkungan.',
                    'specs' => ['Rotary Cleaner Industri', 'Metode Ramah Lingkungan', 'Dokumen BAST Lengkap'],
                    'guarantee' => 'Garansi Resmi 30 Hari'
                ],
            ]);
        @endphp

        <!-- Portfolio Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            @foreach($displayPortfolios as $item)
                @php
                    $waText = urlencode("Halo Tim Drainusantara, saya tertarik dengan portofolio '{$item->project_title}' untuk tempat usaha saya. Mohon informasi konsultasi B2B.");
                    $waUrl = "https://wa.me/" . (config('app.whatsapp_number') ?: '6281234567890') . "?text={$waText}";
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                    <div>
                        <!-- Single Photo Header -->
                        <div class="relative aspect-[16/10] bg-slate-900 overflow-hidden border-b border-slate-100">
                            @if(!empty($item->image))
                                <img src="{{ $item->image }}" 
                                     alt="{{ $item->project_title }}" 
                                     class="w-full h-full object-cover"
                                     width="800"
                                     height="500"
                                     loading="lazy"
                                     decoding="async">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400 text-xs">
                                    Dokumentasi Portofolio Proyek
                                </div>
                            @endif

                            <span class="absolute top-3 left-3 bg-slate-950/85 backdrop-blur-xs border border-amber-500/40 text-amber-300 text-[11px] font-bold px-2.5 py-1 rounded-md shadow-xs">
                                {{ $item->client_type ?? 'Komersial B2B' }}
                            </span>
                            <span class="absolute top-3 right-3 bg-emerald-950/85 backdrop-blur-xs border border-emerald-500/40 text-emerald-300 text-[11px] font-bold px-2.5 py-1 rounded-md shadow-xs">
                                ✓ Plong Lancar
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6">
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                                <span class="font-bold text-sky-700 uppercase">{{ $item->client_name }}</span>
                                <span>{{ $item->location }}</span>
                            </div>
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-2 leading-snug">
                                {{ $item->project_title }}
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                                {{ $item->description }}
                            </p>

                            @if(!empty($item->specs) && is_array($item->specs))
                                <div class="flex flex-wrap gap-1.5 pt-3 border-t border-slate-100">
                                    @foreach($item->specs as $spec)
                                        <span class="text-[11px] font-semibold text-slate-600 bg-slate-50 border border-slate-200 px-2 py-0.5 rounded-md">
                                            {{ $spec }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="p-6 pt-0 border-t border-slate-100 mt-2 flex items-center justify-between gap-3 text-xs bg-slate-50/50">
                        <span class="text-emerald-700 font-bold">100% Bebas Bongkar</span>
                        <a href="{{ $waUrl }}" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="btn-press font-bold text-sky-700 hover:text-sky-800 underline underline-offset-2 min-h-[44px] inline-flex items-center">
                            Konsultasi Kasus Serupa &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- B2B Service Level Agreement (SLA) Banner -->
        <div class="bg-slate-900 text-white p-8 rounded-2xl border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-sky-400 block mb-1">Kemitraan Resto &amp; Hotel</span>
                <h3 class="text-xl font-bold text-white">Butuh Jadwal Perawatan Rutin Grease Trap &amp; Pipa Dapur?</h3>
                <p class="text-slate-400 text-xs sm:text-sm mt-1 max-w-2xl">
                    Drainusantara menyediakan kontrak SLA berkala bulanan dengan faktur pajak resmi, pengerjaan after-hours (malam/dini hari), dan garansi anti-mampet 30 hari.
                </p>
            </div>
            <div class="shrink-0">
                <a href="https://wa.me/{{ config('app.whatsapp_number') ?: '6281234567890' }}?text={{ urlencode('Halo Admin Drainusantara, saya tertarik dengan kontrak perawatan rutin B2B untuk restoran/hotel.') }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="btn-press inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs shadow-md transition-colors min-h-[44px]">
                    <span>Ajukan Penawaran B2B</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
