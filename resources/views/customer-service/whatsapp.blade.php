@extends('layouts.app')

@section('content')
<section class="relative bg-slate-900 text-white border-b border-slate-800 overflow-hidden pt-7 pb-16 sm:pt-14 sm:pb-24">
    <div class="absolute inset-0 z-0 pointer-events-none">
        <img src="{{ asset('assets/banner/Drainusantara-jasa-saluran-mampet-profesional-desktop.webp') }}"
             alt="Armada dan teknisi siaga 24 jam Drainusantara"
             width="1920"
             height="960"
             loading="eager"
             decoding="async"
             class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-slate-950/85 to-slate-900/75"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <nav class="flex items-center gap-2 text-xs text-slate-300 mb-4 sm:mb-6 font-medium overflow-x-auto no-scrollbar whitespace-nowrap" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="hover:text-sky-300 transition-colors">Beranda</a>
            <span class="text-slate-500">/</span>
            <a href="{{ route('customer-service.index') }}" class="hover:text-sky-300 transition-colors">Customer Service</a>
            <span class="text-slate-500">/</span>
            <span class="text-sky-300 font-bold">Customer Service WhatsApp</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-end">
            <div class="lg:col-span-8 space-y-3.5 sm:space-y-4 reveal-soft">
                <div class="inline-flex items-center gap-2.5 text-xs font-bold uppercase tracking-wider text-emerald-300">
                    <x-customer-service.channel-icon channel="whatsapp" class="w-4 h-4" />
                    <span>Jalur Dispatch Darurat 24 Jam</span>
                </div>
                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
                    Customer Service WhatsApp 24 Jam Drainusantara
                </h1>
                <p class="text-sm sm:text-base text-slate-200 leading-relaxed max-w-2xl">
                    Pengiriman teknisi cepat untuk saluran mampet darurat di rumah, ruko, atau dapur restoran. Dikerjakan tanpa bongkar keramik, bebas soda api, dan berlaku jaminan No Cure No Pay.
                </p>
                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-xs sm:text-sm font-semibold text-white pt-1">
                    <span>No Cure No Pay</span>
                    <span>Garansi Nota 30 Hari</span>
                    <span>Tarif Dasar Mulai Rp 400.000</span>
                </div>
            </div>

            <div class="lg:col-span-4 bg-slate-950/90 border border-slate-700 rounded-lg p-4 sm:p-5 space-y-2.5 reveal-soft delay-100">
                <span class="text-xs font-bold uppercase tracking-wider text-sky-300 block">Telepon Langsung Posko</span>
                <a href="tel:{{ preg_replace('/[^0-9]/', '', $whatsappNumber) }}"
                   data-track-location="cs_whatsapp_phone"
                   class="min-h-11 inline-flex items-center text-2xl font-extrabold text-white hover:text-emerald-300 transition-colors focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-400 rounded-sm">
                    {{ $channel['handle'] }}
                </a>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Untuk kondisi air meluap darurat, Anda dapat langsung menelepon atau mengirim pesan berformat wilayah di bawah.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="relative z-20 -mt-8 sm:-mt-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <x-customer-service.wa-area-builder
        layout="bar"
        channel-code="wa"
        channel-slug="whatsapp"
        channel-name="WhatsApp"
        :whatsapp-number="$whatsappNumber"
        :region-selector-data="$regionSelectorData"
        heading="Kirim Tiket Dispatch ke Admin WhatsApp"
        subheading="Pilih kota dan kecamatan Anda agar operator posko langsung mengecek armada terdekat."
        track-location="cs_whatsapp_hero"
        surface="light"
    />
</section>

<section class="py-9 sm:py-16 bg-white border-b border-slate-200 overflow-x-clip">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        <div class="lg:col-span-5 reveal-soft">
            <div class="rounded-lg overflow-hidden border border-slate-200 bg-slate-900 aspect-[16/11]">
                <img src="{{ asset('images/dokumentasi/pelancaran-wastafel-mampet-rumah-warga.webp') }}"
                     alt="Penanganan saluran wastafel mampet di rumah warga oleh teknisi Drainusantara"
                     width="800"
                     height="550"
                     loading="lazy"
                     decoding="async"
                     class="w-full h-full object-cover">
            </div>
        </div>

        <div class="lg:col-span-7 space-y-6 min-w-0">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    3 Data Singkat agar Estimasi WhatsApp Lebih Cepat
                </h2>
                <p class="mt-2 text-sm sm:text-base text-slate-600 leading-relaxed">
                    Menyiapkan detail singkat di bawah ini membantu admin WA menugaskan teknisi dengan ukuran kabel spiral yang tepat sejak kedatangan pertama.
                </p>
            </div>

            <div x-data="mobileCarousel(3, 5500)" x-init="stopped = true">
                <div x-ref="slider"
                     tabindex="0"
                     role="region"
                     aria-label="Tiga data singkat untuk estimasi WhatsApp"
                     @scroll.passive="onScroll()"
                     @touchstart="pause()"
                     @touchend="resume()"
                     @touchcancel="resume()"
                     class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-3 -mx-4 px-4 pb-2 sm:mx-0 sm:px-0 sm:block sm:divide-y sm:divide-slate-200 sm:border-y sm:border-slate-200 sm:overflow-visible sm:pb-0">
                    <div class="w-[82vw] max-w-[310px] sm:w-auto sm:max-w-none shrink-0 snap-start bg-slate-50 border border-slate-200 rounded-lg p-4 sm:bg-transparent sm:border-0 sm:rounded-none sm:px-0 sm:py-4 flex items-start gap-3.5 sm:gap-4">
                        <span class="w-9 h-9 rounded-md bg-sky-700 text-white font-extrabold text-sm flex items-center justify-center shrink-0">01</span>
                        <div class="min-w-0">
                            <h3 class="text-base font-extrabold text-slate-900">Foto Titik Saluran Tersumbat</h3>
                            <p class="text-sm text-slate-700 mt-1 leading-relaxed">Ambil foto area wastafel, lubang floor drain, kloset, atau bak kontrol luar agar teknisi mengetahui akses pipa dan posisi leher angsa.</p>
                        </div>
                    </div>
                    <div class="w-[82vw] max-w-[310px] sm:w-auto sm:max-w-none shrink-0 snap-start bg-slate-50 border border-slate-200 rounded-lg p-4 sm:bg-transparent sm:border-0 sm:rounded-none sm:px-0 sm:py-4 flex items-start gap-3.5 sm:gap-4">
                        <span class="w-9 h-9 rounded-md bg-sky-700 text-white font-extrabold text-sm flex items-center justify-center shrink-0">02</span>
                        <div class="min-w-0">
                            <h3 class="text-base font-extrabold text-slate-900">Video Uji Siram 5 Detik</h3>
                            <p class="text-sm text-slate-700 mt-1 leading-relaxed">Rekam sesaat ketika keran dibuka atau air disiram untuk membedakan sumbatan total, aliran melambat, atau air balik dari bak kontrol.</p>
                        </div>
                    </div>
                    <div class="w-[82vw] max-w-[310px] sm:w-auto sm:max-w-none shrink-0 snap-start bg-slate-50 border border-slate-200 rounded-lg p-4 sm:bg-transparent sm:border-0 sm:rounded-none sm:px-0 sm:py-4 flex items-start gap-3.5 sm:gap-4">
                        <span class="w-9 h-9 rounded-md bg-sky-700 text-white font-extrabold text-sm flex items-center justify-center shrink-0">03</span>
                        <div class="min-w-0">
                            <h3 class="text-base font-extrabold text-slate-900">Catatan Riwayat Soda Api</h3>
                            <p class="text-sm text-slate-700 mt-1 leading-relaxed">Sampaikan jika saluran pernah dituangi cairan kimia keras agar teknisi menyiapkan perlengkapan K3 dan mengecek kondisi pipa PVC.</p>
                        </div>
                    </div>
                </div>

                <x-customer-service.carousel-controls label="Data" surface="light" hide-at="sm" :count="3" />
            </div>
        </div>
    </div>
</section>

<section class="py-9 sm:py-16 bg-slate-50 border-b border-slate-200 overflow-x-clip">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Cakupan Titik Saluran &amp; Pesan Cepat WhatsApp
                </h2>
                <p class="mt-1.5 text-sm text-slate-600">
                    Pilih jenis masalah untuk langsung membuka chat WhatsApp dengan keterangan titik saluran yang sesuai.
                </p>
            </div>
            <a href="{{ route('how-it-works') }}" class="min-h-11 inline-flex items-center text-sm font-bold text-sky-700 hover:text-sky-800 hover:underline">
                Lihat 5 Tahap Cara Kerja Tanpa Bongkar
            </a>
        </div>

        @if($services->isNotEmpty())
            <div x-data="mobileCarousel({{ $services->count() }}, 5500)" x-init="stopped = true">
                <div x-ref="slider"
                     tabindex="0"
                     role="region"
                     aria-label="Cakupan titik saluran dan pesan cepat WhatsApp"
                     @scroll.passive="onScroll()"
                     @touchstart="pause()"
                     @touchend="resume()"
                     @touchcancel="resume()"
                     class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-3.5 -mx-4 px-4 pb-2 md:mx-0 md:px-0 md:block md:bg-white md:border md:border-slate-200 md:rounded-lg md:divide-y md:divide-slate-200 md:overflow-visible md:pb-0">
                    @foreach($services as $service)
                        @php
                            $svcMsg = "Hallo admin wa drainusantara, saluran saya mampet di daerah (mohon info posko terdekat) (titik saluran: {$service->name})";
                            $svcWaUrl = "https://wa.me/{$whatsappNumber}?text=".rawurlencode($svcMsg);
                        @endphp
                        <div class="w-[84vw] max-w-[320px] md:w-auto md:max-w-none shrink-0 snap-start bg-white border border-slate-200 rounded-lg md:bg-transparent md:border-0 md:rounded-none p-4 sm:p-5 md:px-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-slate-50/70 transition-colors">
                            <div class="space-y-1.5 min-w-0 flex-1">
                                <div class="flex items-center gap-2.5 flex-wrap">
                                    <h3 class="text-base font-extrabold text-slate-900">{{ $service->name }}</h3>
                                    @if($service->price_starting_from > 0)
                                        <span class="text-xs font-bold text-emerald-800 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-sm">
                                            Mulai Rp {{ number_format((int) $service->price_starting_from, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                                    {{ $service->short_description ?: 'Pelancaran mekanis dengan kabel spiral baja rotary tanpa membongkar keramik.' }}
                                </p>
                            </div>
                            <a href="{{ $svcWaUrl }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               data-track-location="cs_whatsapp_service_item"
                               class="w-full md:w-auto min-h-11 inline-flex items-center justify-center px-4 py-2.5 rounded-md bg-emerald-700 hover:bg-emerald-800 text-white text-xs sm:text-sm font-bold shrink-0 mt-auto md:mt-0 transition-colors focus:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-600">
                                Tanya {{ $service->name }} via WA
                            </a>
                        </div>
                    @endforeach
                </div>

                <x-customer-service.carousel-controls label="Layanan" surface="light" hide-at="md" :count="$services->count()" />
            </div>
        @else
            <div class="bg-white border border-slate-200 rounded-lg p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Semua Jenis Saluran Hunian &amp; Komersial</h3>
                    <p class="text-sm text-slate-600 mt-1">
                        Meliputi wastafel dapur, kloset duduk/jongkok, floor drain kamar mandi, talang air hujan, grease trap restoran, dan inspeksi CCTV pipa 30 meter.
                    </p>
                </div>
                <a href="{{ $contextualWaUrl }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="w-full sm:w-auto min-h-11 inline-flex items-center justify-center px-4 py-2.5 rounded-md bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-bold shrink-0">
                    Konsultasi via WA
                </a>
            </div>
        @endif
    </div>
</section>

<section class="py-9 sm:py-16 bg-white overflow-x-clip">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Kesiapan Posko Armada Per Wilayah
                </h2>
                <p class="mt-1.5 text-sm text-slate-600">
                    Teknisi diberangkatkan dari posko kota terdekat untuk menekan waktu tunggu kedatangan.
                </p>
            </div>
            <a href="{{ route('area.index') }}" class="min-h-11 inline-flex items-center text-sm font-bold text-sky-700 hover:underline">
                Direktori Semua Wilayah &amp; Kecamatan
            </a>
        </div>

        <div x-data="mobileCarousel({{ count($provinces) }}, 5500)" x-init="stopped = true">
            <div x-ref="slider"
                 tabindex="0"
                 role="region"
                 aria-label="Kesiapan posko armada per wilayah"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
                 @touchcancel="resume()"
                 class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-3.5 -mx-4 px-4 pb-2 md:mx-0 md:px-0 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-4 md:overflow-visible md:pb-0">
                @foreach($provinces as $provSlug => $prov)
                    <div class="w-[84vw] max-w-[330px] md:w-auto md:max-w-none shrink-0 snap-start border border-slate-200 rounded-lg p-4 sm:p-5 bg-slate-50 space-y-3">
                        <div class="flex items-center justify-between gap-2 border-b border-slate-200 pb-2.5">
                            <a href="{{ route('area.province', ['province' => $provSlug]) }}" class="min-h-11 sm:min-h-0 inline-flex items-center text-base font-extrabold text-slate-900 hover:text-sky-700">
                                {{ $prov['name'] }}
                            </a>
                            <span class="text-xs font-semibold text-slate-600 shrink-0">
                                {{ count($prov['cities']) }} Kota/Area
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($prov['cities'] as $citySlug => $city)
                                <a href="{{ route('area.city', ['city' => $citySlug]) }}"
                                   class="min-h-11 sm:min-h-9 inline-flex items-center px-3 py-1.5 sm:px-2.5 sm:py-1 rounded-sm bg-white border border-slate-200 hover:border-sky-600 text-xs font-medium text-slate-800 hover:text-sky-700 transition-colors">
                                    {{ $city['name'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <x-customer-service.carousel-controls label="Wilayah" surface="light" hide-at="md" :count="count($provinces)" />
        </div>
    </div>
</section>

<x-customer-service.channel-faq
    :faqs="$channel['faqs']"
    :other-channels="$otherChannels"
    heading="Tanya Jawab Dispatch WhatsApp Drainusantara"
    subheading="Informasi waktu operasional, persiapan foto keluhan, dan sistem pembayaran No Cure No Pay."
    channel-slug="whatsapp"
    variant="compact"
/>
@endsection
