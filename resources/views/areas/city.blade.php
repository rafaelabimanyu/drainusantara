@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6281234567890';
    $cityWaMsg = urlencode("Halo teknisi Drainusantara, saya butuh layanan darurat pelancaran saluran pipa mampet di area {$cityData['name']}. Mohon info estimasi kedatangan teknisi terdekat.");
    $cityWaUrl = "https://wa.me/{$whatsappNumber}?text={$cityWaMsg}";
@endphp

<!-- ====================================================================
     HERO SECTION KOTA / WILAYAH (CITY LEVEL)
==================================================================== -->
<section class="relative bg-slate-50 border-b border-slate-200 pt-8 pb-14 lg:pt-12 lg:pb-18 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6 flex-wrap font-medium" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Beranda</span>
            </a>
            <span class="text-slate-300">/</span>
            <a href="{{ route('area.index') }}" class="hover:text-sky-700 transition-colors">Area</a>
            <span class="text-slate-300">/</span>
            <a href="{{ route('area.province', ['province' => $cityData['province_slug']]) }}" class="hover:text-sky-700 transition-colors">
                Provinsi {{ $cityData['province_name'] }}
            </a>
            <span class="text-slate-300">/</span>
            <span class="text-sky-700 font-bold">{{ $cityData['name'] }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-center">
            <!-- Left Info -->
            <div class="lg:col-span-7 space-y-5 text-left fade-up">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-white border border-slate-200 rounded-full text-xs font-bold text-slate-800 shadow-2xs">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    <span>Posko Siaga {{ $cityData['name'] }} &bull; Respon Cepat {{ $cityData['eta_minutes'] }}</span>
                </div>

                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Jasa Saluran Mampet di <span class="text-sky-700 underline decoration-sky-400 decoration-2 underline-offset-4">{{ $cityData['name'] }}</span>
                </h1>

                <p class="text-base text-slate-600 leading-relaxed max-w-2xl">
                    Layanan pelancaran wastafel cuci piring, kloset toilet meluap, dan floor drain kamar mandi tanpa bongkar keramik untuk wilayah <strong>{{ $cityData['name'] }}</strong> ({{ $cityData['province_name'] }}). Dikerjakan teknisi profesional ber-APD steril dengan jaminan garansi 30 hari.
                </p>

                <!-- Estimasi Respon & Highlights -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1">
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/90 shadow-xs flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-[11px] text-slate-500 font-medium">Respon WhatsApp</div>
                            <div class="text-xs sm:text-sm font-extrabold text-emerald-700">Sigap &amp; Cepat</div>
                        </div>
                    </div>

                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/90 shadow-xs flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-200 text-amber-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-[11px] text-slate-500 font-medium">Garansi Resmi</div>
                            <div class="text-xs sm:text-sm font-extrabold text-slate-900">Garansi 30 Hari</div>
                        </div>
                    </div>

                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/90 shadow-xs flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-[11px] text-slate-500 font-medium">Metode Kerja</div>
                            <div class="text-xs sm:text-sm font-extrabold text-slate-900">Tanpa Bongkar</div>
                        </div>
                    </div>
                </div>

                <!-- CTA Actions -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
                    <a href="{{ $cityWaUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="inline-flex items-center justify-center gap-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm sm:text-base px-6 py-3.5 rounded-xl shadow-sm hover:shadow transition-all">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Panggil Teknisi {{ $cityData['name'] }}</span>
                    </a>

                    <a href="#daftar-kecamatan" 
                       class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-800 font-bold text-sm sm:text-base px-6 py-3.5 rounded-xl border border-slate-200 shadow-xs transition-colors">
                        <span>Pilih Kecamatan Anda</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Right Posko Card -->
            <div class="lg:col-span-5 fade-up delay-150">
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-6 sm:p-7 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div>
                            <span class="text-xs uppercase tracking-wider text-sky-700 font-bold block">POSKO RESMI TEKNISI</span>
                            <h3 class="text-lg font-bold text-slate-900 tracking-tight">{{ $cityData['name'] }}</h3>
                        </div>
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold rounded-full">
                            STANDBY 24/7
                        </span>
                    </div>

                    <div class="space-y-3.5 text-xs sm:text-sm text-slate-600">
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 font-bold text-xs mt-0.5">
                                📍
                            </div>
                            <div>
                                <strong class="text-slate-800 block font-semibold">Alamat Posko:</strong>
                                <span>{{ $cityData['posko_address'] }}</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 font-bold text-xs mt-0.5">
                                🗺️
                            </div>
                            <div>
                                <strong class="text-slate-800 block font-semibold">Cakupan Kecamatan:</strong>
                                <span>Melayani total {{ count($cityData['districts']) }} kecamatan di seluruh wilayah {{ $cityData['name'] }}.</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 font-bold text-xs mt-0.5">
                                📞
                            </div>
                            <div>
                                <strong class="text-slate-800 block font-semibold">Hotline Langsung:</strong>
                                <span class="font-bold text-slate-900">{{ $cityData['phone'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     DAFTAR LENGKAP KECAMATAN DI KOTA INI
==================================================================== -->
<section id="daftar-kecamatan" class="py-14 lg:py-20 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-10 fade-up">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold rounded-full uppercase tracking-wider mb-2">
                DAFTAR KECAMATAN
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Kecamatan yang Dilayani di {{ $cityData['name'] }}
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2 leading-relaxed">
                Klik nama kecamatan Anda untuk melihat detail layanan lokal, estimasi kedatangan teknisi, dan pemesanan WhatsApp darurat:
            </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($cityData['districts'] as $district)
                @php
                    $districtSlug = \Illuminate\Support\Str::slug($district);
                    $districtUrl = route('area.detail', ['city' => $cityData['slug'], 'district' => $districtSlug]);
                    $districtWaMsg = urlencode("Halo teknisi Drainusantara, saya butuh perbaikan saluran mampet di Kecamatan {$district}, {$cityData['name']}. Mohon info jadwal teknisi terdekat.");
                @endphp
                <div class="bg-slate-50/70 hover:bg-white rounded-2xl border border-slate-200/90 hover:border-sky-300 hover:shadow-sm p-4 transition-all flex flex-col justify-between group fade-up">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">KECAMATAN</span>
                            <span class="text-[10px] text-emerald-800 font-bold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                                Respon Cepat
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-sky-700 transition-colors tracking-tight">
                            <a href="{{ $districtUrl }}">
                                {{ $district }}
                            </a>
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">
                            Area {{ $district }}, {{ $cityData['name'] }}
                        </p>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-200/80 flex items-center justify-between">
                        <a href="{{ $districtUrl }}" class="text-xs font-bold text-sky-700 hover:text-sky-800">
                            <span>Detail Area &rarr;</span>
                        </a>
                        <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $districtWaMsg }}" target="_blank" rel="noopener noreferrer" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                            <span>Pesan WA</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ====================================================================
     LAYANAN YANG TERSEDIA DI KOTA INI
==================================================================== -->
<section class="py-14 lg:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12 fade-up">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-slate-200 text-slate-800 text-xs font-bold rounded-full uppercase tracking-wider mb-2 shadow-2xs">
                SPESIFIKASI LAYANAN
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Layanan Saluran Mampet di {{ $cityData['name'] }}
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2">
                Dikerjakan oleh teknisi ahli menggunakan mesin spiral torsi tinggi dan kamera CCTV pipa bergaransi 30 hari.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md hover:border-sky-300 transition-all flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-sky-700 bg-sky-50 px-2.5 py-0.5 rounded-full border border-sky-200 block w-fit mb-3">01. WASTAFEL DAPUR</span>
                    <h3 class="font-bold text-slate-900 text-lg mb-2 tracking-tight">Bak Cuci Piring Tersumbat</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Pengikisan kerak lemak beku & minyak tanpa membongkar sifon kitchen sink dapur Anda.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 text-xs text-emerald-700 font-semibold">
                    ✓ Garansi Resmi 30 Hari
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md hover:border-sky-300 transition-all flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-sky-700 bg-sky-50 px-2.5 py-0.5 rounded-full border border-sky-200 block w-fit mb-3">02. KLOSET TOILET</span>
                    <h3 class="font-bold text-slate-900 text-lg mb-2 tracking-tight">Kloset WC Meluap</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Penarikan sumbatan tisu basah & benda keras leher angsa porselen tanpa membongkar kloset.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 text-xs text-emerald-700 font-semibold">
                    ✓ Garansi Resmi 30 Hari
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md hover:border-sky-300 transition-all flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-sky-700 bg-sky-50 px-2.5 py-0.5 rounded-full border border-sky-200 block w-fit mb-3">03. FLOOR DRAIN</span>
                    <h3 class="font-bold text-slate-900 text-lg mb-2 tracking-tight">Saluran Mandi Mampet</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Pembersihan jalinan rambut & kerak busa sabun dengan kabel spiral lentur anti-knee.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 text-xs text-emerald-700 font-semibold">
                    ✓ Garansi Resmi 30 Hari
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md hover:border-sky-300 transition-all flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-sky-700 bg-sky-50 px-2.5 py-0.5 rounded-full border border-sky-200 block w-fit mb-3">04. CCTV PIPA 30M</span>
                    <h3 class="font-bold text-slate-900 text-lg mb-2 tracking-tight">Inspeksi Kamera Endoskopi</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Deteksi visual mendalam titik pipa retak, pecah, atau akar pohon dengan rekaman video HD.</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 text-xs text-emerald-700 font-semibold">
                    ✓ Diagnosa Monitor HD
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================================================
     BOTTOM CTA KOTA
==================================================================== -->
<section class="py-14 lg:py-20 bg-slate-900 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center fade-up">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-800 border border-slate-700 text-sky-400 text-xs font-bold rounded-full uppercase tracking-wider mb-3">
            RESPON CEPAT {{ strtoupper($cityData['name']) }}
        </span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
            Butuh Bantuan Teknisi di {{ $cityData['name'] }}?
        </h2>
        <p class="text-slate-400 text-sm sm:text-base mt-3 max-w-xl mx-auto leading-relaxed">
            Tim kami siap memberikan respon WhatsApp sigap dan cepat untuk penanganan saluran mampet di {{ $cityData['name'] }}. Konsultasikan masalah Anda sekarang juga.
        </p>
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ $cityWaUrl }}" target="_blank" rel="noopener noreferrer" 
               class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-6 py-3.5 rounded-xl shadow-md transition-all">
                <span>Panggil Teknisi via WhatsApp</span>
                <span class="text-base">&rarr;</span>
            </a>
            <a href="{{ route('area.province', ['province' => $cityData['province_slug']]) }}" 
               class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-sm px-6 py-3.5 rounded-xl border border-slate-700 transition-colors">
                <span>Kota Lain di {{ $cityData['province_name'] }}</span>
            </a>
        </div>
    </div>
</section>
@endsection
