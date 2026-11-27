@extends('layouts.app')

@section('content')
<section class="relative bg-slate-950 text-white border-b border-slate-800 overflow-x-clip pt-7 pb-16 sm:pt-14 sm:pb-24">
    <div class="absolute inset-0 z-0 pointer-events-none">
        <img src="{{ asset('assets/banner/hero-peralatan-drainusantara.webp') }}"
             alt="Peralatan mesin rooter spiral dan inspeksi kamera CCTV Drainusantara"
             width="1920"
             height="960"
             loading="eager"
             decoding="async"
             class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-slate-950/88 to-slate-950/75"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <nav class="flex items-center gap-2 text-xs text-slate-300 mb-4 sm:mb-6 font-medium overflow-x-auto no-scrollbar whitespace-nowrap" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="hover:text-sky-300 transition-colors">Beranda</a>
            <span class="text-slate-500">/</span>
            <a href="{{ route('customer-service.index') }}" class="hover:text-sky-300 transition-colors">Customer Service</a>
            <span class="text-slate-500">/</span>
            <span class="text-sky-300 font-bold">Customer Service YouTube</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-7 lg:gap-10 items-center">
            <div class="lg:col-span-7 space-y-4 sm:space-y-5 min-w-0">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-red-950/80 border border-red-700/70 text-red-200 text-xs font-bold">
                    <x-customer-service.channel-icon channel="youtube" class="w-4 h-4" />
                    <span>Channel YouTube Resmi {{ $channel['handle'] }}</span>
                </div>

                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
                    Customer Service &amp; Konsultasi Teknis YouTube @drainusantara
                </h1>
                <p class="text-sm sm:text-base text-slate-200 leading-relaxed max-w-2xl">
                    Ingin menjadwalkan mesin spiral rotary Ridgid atau inspeksi kamera endoskopi CCTV IP68 seperti yang Anda tonton di channel YouTube kami? Pilih wilayah dan titik pipa Anda pada panel komando di bawah.
                </p>

                <div class="space-y-1.5">
                    <div class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-2.5 -mx-4 px-4 pb-1 sm:mx-0 sm:px-0 sm:grid sm:grid-cols-3 sm:gap-3 sm:overflow-visible sm:pb-0 text-xs sm:text-sm">
                        <div class="w-[76vw] max-w-[260px] sm:w-auto sm:max-w-none shrink-0 snap-start p-3.5 rounded-md bg-slate-900/90 border border-slate-700">
                            <span class="font-bold text-sky-300 block">Spiral Rotary 400 RPM</span>
                            <span class="text-slate-300 block mt-1">Kabel baja fleksibel 16mm hingga 22mm untuk pipa 1,5 sampai 4 inci.</span>
                        </div>
                        <div class="w-[76vw] max-w-[260px] sm:w-auto sm:max-w-none shrink-0 snap-start p-3.5 rounded-md bg-slate-900/90 border border-slate-700">
                            <span class="font-bold text-sky-300 block">Kamera CCTV IP68 30M</span>
                            <span class="text-slate-300 block mt-1">Diagnostik visual kondisi dalam pipa hingga jangkauan 30 meter.</span>
                        </div>
                        <div class="w-[76vw] max-w-[260px] sm:w-auto sm:max-w-none shrink-0 snap-start p-3.5 rounded-md bg-slate-900/90 border border-slate-700">
                            <span class="font-bold text-sky-300 block">Hydro-Jetting 100-200 Bar</span>
                            <span class="text-slate-300 block mt-1">Semprotan air tekanan tinggi untuk kerak lemak jalur induk berat.</span>
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-300 sm:hidden">
                        Geser ke samping untuk melihat seluruh spesifikasi unit.
                    </p>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="bg-slate-900 border border-slate-700 rounded-lg p-3 space-y-2.5 sm:space-y-3">
                    <div class="aspect-[16/10] rounded-md overflow-hidden bg-slate-950 border border-slate-800">
                        <img src="{{ asset('assets/TOOLKIT/inspeksi-cctv-set-lengkap-drainusantara.webp') }}"
                             alt="Set kamera inspeksi endoskopi CCTV pipa waterproof IP68 Drainusantara"
                             width="800"
                             height="500"
                             loading="eager"
                             decoding="async"
                             class="w-full h-full object-cover">
                    </div>
                    <div class="flex items-center justify-between gap-2 px-1">
                        <span class="text-xs font-semibold text-slate-200">Unit Monitor &amp; Kabel Endoskopi IP68 30M</span>
                        @if(!empty($socialUrl))
                            <a href="{{ $socialUrl }}" target="_blank" rel="noopener noreferrer" class="min-h-11 inline-flex items-center px-2 text-xs font-bold text-sky-300 hover:underline shrink-0">
                                Buka YouTube
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="relative z-20 -mt-8 sm:-mt-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <x-customer-service.wa-area-builder
        layout="bar"
        channel-code="youtube"
        channel-slug="youtube"
        channel-name="YouTube"
        :whatsapp-number="$whatsappNumber"
        :region-selector-data="$regionSelectorData"
        heading="Konsultasi Alat & Jadwal ke Admin YouTube"
        subheading="Pilih kota dan jenis pipa untuk mengirim format pesan resmi admin YouTube."
        track-location="cs_youtube_hero"
        surface="dark"
    />
</section>

<section class="py-9 sm:py-16 bg-white border-b border-slate-200 overflow-x-clip">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Armada Mesin &amp; Kamera Inspeksi Lapangan
                </h2>
                <p class="mt-1.5 text-sm text-slate-600">
                    Unit teknis yang dioperasikan langsung oleh teknisi Drainusantara untuk penanganan non-destruktif.
                </p>
            </div>
            <a href="{{ route('about.equipment') }}" class="min-h-11 inline-flex items-center text-sm font-bold text-sky-700 hover:underline">
                Lihat Katalog Peralatan Lengkap
            </a>
        </div>

        @if($equipments->isNotEmpty())
            <div x-data="mobileCarousel({{ $equipments->count() }}, 5500)" x-init="stopped = true">
                <div x-ref="slider"
                     tabindex="0"
                     role="region"
                     aria-label="Armada mesin dan kamera inspeksi lapangan"
                     @scroll.passive="onScroll()"
                     @touchstart="pause()"
                     @touchend="resume()"
                     @touchcancel="resume()"
                     class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-4 -mx-4 px-4 pb-2 md:mx-0 md:px-0 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-5 md:overflow-visible md:pb-0">
                    @foreach($equipments as $eq)
                        @php
                            $fallbackToolkit = match ($loop->index % 3) {
                                0 => asset('assets/TOOLKIT/mesin-rooter-ridgid-k50-spiral-baja.webp'),
                                1 => asset('assets/TOOLKIT/inspeksi-cctv-set-lengkap-drainusantara.webp'),
                                default => asset('assets/TOOLKIT/hydro-jetting-high-pressure-hose.webp'),
                            };
                            $rawEqImg = $eq->image;
                            $eqImg = $rawEqImg
                                ? (filter_var($rawEqImg, FILTER_VALIDATE_URL) ? $rawEqImg : asset(ltrim($rawEqImg, '/')))
                                : $fallbackToolkit;
                        @endphp
                        <article class="w-[84vw] max-w-[330px] md:w-auto md:max-w-none shrink-0 snap-start border border-slate-200 rounded-lg overflow-hidden bg-slate-50 flex flex-col justify-between card-lift">
                            <div class="aspect-[16/10] bg-slate-900 border-b border-slate-200 overflow-hidden">
                                <img src="{{ $eqImg }}" alt="{{ $eq->name }}" loading="lazy" decoding="async" class="w-full h-full object-cover">
                            </div>
                            <div class="p-4 sm:p-6 flex-1 flex flex-col justify-between gap-4">
                                <div class="space-y-2.5">
                                    @if($eq->category)
                                        <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block">{{ $eq->category }}</span>
                                    @endif
                                    <h3 class="text-lg font-extrabold text-slate-900">{{ $eq->name }}</h3>
                                    <p class="text-sm text-slate-700 leading-relaxed">
                                        {{ $eq->short_description ?: $eq->description }}
                                    </p>
                                    @if(!empty($eq->specs_list))
                                        <ul class="text-xs text-slate-700 space-y-1 pt-2 border-t border-slate-200 list-disc pl-4">
                                            @foreach(array_slice($eq->specs_list, 0, 3) as $spec)
                                                <li>{{ $spec }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                @if($eq->slug)
                                    <a href="{{ route('equipment.show', ['slug' => $eq->slug]) }}"
                                       class="min-h-11 inline-flex items-center justify-center px-4 py-2.5 rounded-md bg-white hover:bg-slate-100 border border-slate-300 text-xs sm:text-sm font-bold text-slate-800 transition-colors">
                                        Spesifikasi Teknis Unit
                                    </a>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                <x-customer-service.carousel-controls label="Unit" surface="light" hide-at="md" :count="$equipments->count()" />
            </div>
        @else
            <div x-data="mobileCarousel(3, 5500)" x-init="stopped = true">
                <div x-ref="slider"
                     tabindex="0"
                     role="region"
                     aria-label="Armada mesin dan kamera inspeksi lapangan"
                     @scroll.passive="onScroll()"
                     @touchstart="pause()"
                     @touchend="resume()"
                     @touchcancel="resume()"
                     class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-4 -mx-4 px-4 pb-2 md:mx-0 md:px-0 md:grid md:grid-cols-3 md:gap-5 md:overflow-visible md:pb-0">
                    <article class="w-[84vw] max-w-[330px] md:w-auto md:max-w-none shrink-0 snap-start border border-slate-200 rounded-lg overflow-hidden bg-slate-50">
                        <div class="aspect-[16/10] bg-slate-900 border-b border-slate-200 overflow-hidden">
                            <img src="{{ asset('assets/TOOLKIT/mesin-rooter-ridgid-k50-spiral-baja.webp') }}" alt="Mesin spiral baja Ridgid K-50 Drainusantara" loading="lazy" decoding="async" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 sm:p-5 space-y-2">
                            <span class="text-xs font-bold text-sky-700 block">Mesin Spiral Baja</span>
                            <h3 class="text-base font-extrabold text-slate-900">Ridgid K-50 &amp; K-60 Rooter</h3>
                            <p class="text-sm text-slate-700 leading-relaxed">Mengikis kerak lemak, menarik gumpalan rambut, dan menembus sumbatan benda padat di belokan leher angsa.</p>
                        </div>
                    </article>
                    <article class="w-[84vw] max-w-[330px] md:w-auto md:max-w-none shrink-0 snap-start border border-slate-200 rounded-lg overflow-hidden bg-slate-50">
                        <div class="aspect-[16/10] bg-slate-900 border-b border-slate-200 overflow-hidden">
                            <img src="{{ asset('assets/TOOLKIT/inspeksi-cctv-set-lengkap-drainusantara.webp') }}" alt="Kamera endoskopi CCTV IP68 30 meter Drainusantara" loading="lazy" decoding="async" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 sm:p-5 space-y-2">
                            <span class="text-xs font-bold text-sky-700 block">Kamera Diagnostik</span>
                            <h3 class="text-base font-extrabold text-slate-900">Endoskopi CCTV Pipa IP68</h3>
                            <p class="text-sm text-slate-700 leading-relaxed">Kabel dorong fiber optic hingga 30 meter dengan pemancar sonde untuk memetakan pipa retak atau jalur tertimbun.</p>
                        </div>
                    </article>
                    <article class="w-[84vw] max-w-[330px] md:w-auto md:max-w-none shrink-0 snap-start border border-slate-200 rounded-lg overflow-hidden bg-slate-50">
                        <div class="aspect-[16/10] bg-slate-900 border-b border-slate-200 overflow-hidden">
                            <img src="{{ asset('assets/TOOLKIT/hydro-jetting-high-pressure-hose.webp') }}" alt="Selang high pressure hydro-jetting 100 sampai 200 bar" loading="lazy" decoding="async" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 sm:p-5 space-y-2">
                            <span class="text-xs font-bold text-sky-700 block">Tekanan Tinggi</span>
                            <h3 class="text-base font-extrabold text-slate-900">Unit High Pressure Hydro-Jetting</h3>
                            <p class="text-sm text-slate-700 leading-relaxed">Membersihkan dinding dalam pipa jalur utama dari kerak lemak membatu dan lumpur di area komersial.</p>
                        </div>
                    </article>
                </div>

                <x-customer-service.carousel-controls label="Unit" surface="light" hide-at="md" :count="3" />
            </div>
        @endif
    </div>
</section>

<section class="py-9 sm:py-16 bg-slate-50 overflow-x-clip">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">
        <div class="max-w-2xl">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Kapan Memakai Spiral Rooter vs Inspeksi CCTV Pipa?
            </h2>
            <p class="mt-2 text-sm sm:text-base text-slate-600 leading-relaxed">
                Penentuan unit alat yang tepat menghemat waktu pengerjaan dan menghindarkan pembongkaran lantai yang tidak perlu.
            </p>
        </div>

        <div x-data="mobileCarousel(2, 5500)" x-init="stopped = true">
            <div x-ref="slider"
                 tabindex="0"
                 role="region"
                 aria-label="Panduan memilih spiral rooter vs inspeksi CCTV pipa"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
                 @touchcancel="resume()"
                 class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-4 -mx-4 px-4 pb-2 md:mx-0 md:px-0 md:grid md:grid-cols-2 md:gap-6 md:overflow-visible md:pb-0">
                <div class="w-[84vw] max-w-[330px] md:w-auto md:max-w-none shrink-0 snap-start bg-white border border-slate-200 rounded-lg overflow-hidden flex flex-col">
                    <div class="aspect-[16/9] bg-slate-900 border-b border-slate-200 overflow-hidden">
                        <img src="{{ asset('assets/TOOLKIT/kabel-spiral-baja-flexible-rotary.webp') }}" alt="Kabel spiral baja lentur rotary rooter" loading="lazy" decoding="async" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4 sm:p-6 space-y-3">
                        <h3 class="text-lg font-extrabold text-slate-900">Cukup Mesin Spiral Rotary Rooter</h3>
                        <ul class="space-y-2 text-sm text-slate-700 list-disc pl-5">
                            <li>Air wastafel dapur menggenang akibat penumpukan minyak goreng dan sisa makanan.</li>
                            <li>Floor drain kamar mandi melambat karena ikatan rambut rontok dan kerak sabun.</li>
                            <li>Kloset baru pertama kali tersumbat tisu basah atau benda jatuh ke leher angsa.</li>
                            <li>Saluran talang atap mampet oleh daun kering dan endapan pasir.</li>
                        </ul>
                    </div>
                </div>
                <div class="w-[84vw] max-w-[330px] md:w-auto md:max-w-none shrink-0 snap-start bg-white border border-slate-200 rounded-lg overflow-hidden flex flex-col">
                    <div class="aspect-[16/9] bg-slate-900 border-b border-slate-200 overflow-hidden">
                        <img src="{{ asset('images/dokumentasi/inspeksi-cctv-saluran-kloset-mampet.webp') }}" alt="Inspeksi visual kamera CCTV dalam saluran pipa mampet" loading="lazy" decoding="async" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4 sm:p-6 space-y-3">
                        <h3 class="text-lg font-extrabold text-slate-900">Perlu Inspeksi Kamera CCTV IP68 30M</h3>
                        <ul class="space-y-2 text-sm text-slate-700 list-disc pl-5">
                            <li>Saluran terus mampet berulang kali dalam hitungan minggu setelah dilancarkan.</li>
                            <li>Dicurigai ada pipa pecah, sambungan bergeser karena tanah amblas, atau masuk akar pohon.</li>
                            <li>Bak kontrol dan rute pipa bawah tanah bangunan lama tidak diketahui petanya.</li>
                            <li>Membutuhkan rekaman video kondisi dalam pipa sebelum serah terima bangunan atau audit gedung.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <x-customer-service.carousel-controls label="Panduan" surface="light" hide-at="md" :count="2" />
        </div>

        <div class="bg-white border border-slate-200 rounded-lg p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Ingin Mempelajari 5 Tahap Kerja Standar Lapangan?</h3>
                <p class="text-sm text-slate-600 mt-1">Lihat prosedur lengkap mulai dari inspeksi awal, penetrasi mekanis, hingga uji debit air dan nota garansi.</p>
            </div>
            <a href="{{ route('how-it-works') }}" class="w-full sm:w-auto min-h-11 inline-flex items-center justify-center px-4 py-2.5 rounded-md bg-sky-700 hover:bg-sky-800 text-white text-sm font-bold shrink-0">
                Pelajari Cara Kerja
            </a>
        </div>
    </div>
</section>

<x-customer-service.channel-faq
    :faqs="$channel['faqs']"
    :other-channels="$otherChannels"
    heading="Tanya Jawab Teknis Pemirsa YouTube"
    subheading="Informasi spesifikasi diameter kabel spiral, keamanan dinding pipa PVC, dan dokumentasi video CCTV."
    channel-slug="youtube"
    variant="dark"
/>
@endsection
