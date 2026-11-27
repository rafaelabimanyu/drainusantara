@extends('layouts.app')

@section('content')
<section class="relative bg-slate-900 text-white border-b border-slate-800 overflow-hidden pt-7 pb-16 sm:pt-14 sm:pb-24">
    <div class="absolute inset-0 z-0 pointer-events-none">
        <img src="{{ asset('assets/banner/hero-profil-perusahaan-drainusantara.webp') }}"
             alt="Tim teknisi resmi Drainusantara PT Jawa Jaya Rooter"
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
            <span class="text-sky-300 font-bold">Customer Service</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-end">
            <div class="lg:col-span-8 space-y-3.5 sm:space-y-4">
                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
                    Pusat Customer Service Resmi Drainusantara
                </h1>
                <p class="text-sm sm:text-base text-slate-200 leading-relaxed max-w-2xl">
                    Pilih meja layanan sesuai kanal media sosial yang Anda kunjungi. Seluruh jalur terhubung ke operator resmi PT Jawa Jaya Rooter dengan nomor tunggal 0856-0900-9009, kebijakan No Cure No Pay, dan garansi tertulis 30 hari kalender.
                </p>
            </div>

            <div class="lg:col-span-4 bg-slate-950/90 border border-slate-700 rounded-lg p-4 sm:p-5 space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-sky-300 block">Hotline Resmi 24 Jam</span>
                <a href="tel:085609009009" class="min-h-11 inline-flex items-center text-2xl font-extrabold text-white hover:text-sky-300 transition-colors focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-400 rounded-sm">
                    0856-0900-9009
                </a>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Siaga Senin hingga Minggu di Jabodetabek, Bandung Raya, Semarang, Demak, Bandar Lampung, dan Bali.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="relative z-20 -mt-8 sm:-mt-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="bg-white border border-slate-200 rounded-lg p-2.5 sm:p-4 shadow-sm">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-2 sm:gap-2.5">
            @foreach($channels as $slug => $item)
                <a href="{{ route('customer-service.show', ['socialMedia' => $slug]) }}"
                   class="min-h-12 px-2.5 sm:px-3 py-2.5 rounded-md border border-slate-200 bg-slate-50 hover:bg-sky-50 hover:border-sky-600 text-slate-900 transition-colors card-lift flex items-center gap-2 sm:gap-2.5 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                    <span class="w-8 h-8 rounded-md bg-white border border-slate-200 text-slate-800 flex items-center justify-center shrink-0">
                        <x-customer-service.channel-icon :channel="$slug" class="w-4 h-4" />
                    </span>
                    <div class="min-w-0">
                        <span class="text-xs font-extrabold text-slate-900 block truncate">{{ $item['name'] }}</span>
                        <span class="text-[11px] text-slate-600 block truncate">{{ $item['handle'] }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="py-9 sm:py-16 bg-slate-50 overflow-x-clip">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @php
            $waChannel = $channels['whatsapp'] ?? null;
            $socialChannels = array_filter($channels, static fn (string $key): bool => $key !== 'whatsapp', ARRAY_FILTER_USE_KEY);
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <div class="lg:col-span-5 lg:sticky lg:top-24 space-y-5 reveal-soft">
                @if($waChannel)
                <div class="bg-white border border-slate-200 rounded-lg overflow-hidden shadow-xs">
                    <div class="aspect-[16/10] bg-slate-900 overflow-hidden border-b border-slate-200">
                        <img src="{{ asset('images/dokumentasi/teknisi-pelancar-wastafel-mesin-ridgid.webp') }}"
                             alt="Teknisi Drainusantara menangani saluran wastafel dengan mesin Ridgid"
                             width="800"
                             height="500"
                             loading="lazy"
                             decoding="async"
                             class="w-full h-full object-cover">
                    </div>
                    <div class="p-4 sm:p-6 space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-center shrink-0">
                                <x-customer-service.channel-icon channel="whatsapp" class="w-5 h-5" />
                            </span>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 block">Jalur Prioritas 24/7</span>
                                <h2 class="text-lg font-extrabold text-slate-900">CS {{ $waChannel['name'] }} ({{ $waChannel['handle'] }})</h2>
                            </div>
                        </div>
                        <p class="text-sm text-slate-700 leading-relaxed">
                            {{ $waChannel['summary'] }} Pilih kota dan kecamatan untuk langsung melihat posko armada terdekat.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-2.5">
                            <a href="{{ route('customer-service.show', ['socialMedia' => 'whatsapp']) }}"
                               class="flex-1 min-h-12 inline-flex items-center justify-center px-4 py-3 rounded-md bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-bold border border-emerald-800 transition-colors btn-press focus:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-600">
                                Buka CS WhatsApp
                            </a>
                            <a href="{{ route('contact') }}"
                               class="min-h-12 inline-flex items-center justify-center px-4 py-3 rounded-md bg-white hover:bg-slate-100 text-slate-800 text-sm font-bold border border-slate-300 transition-colors focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                                Form Kontak
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="lg:col-span-7 space-y-4 min-w-0">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Direktori Meja Layanan Media Sosial
                    </h2>
                    <p class="text-sm text-slate-600 mt-1">
                        Setiap halaman memiliki panduan, data lapangan, dan pemilih wilayah otomatis sesuai karakter pengunjung platformnya.
                    </p>
                </div>

                <div x-data="mobileCarousel({{ count($socialChannels) }}, 5500)" x-init="stopped = true">
                    <div x-ref="slider"
                         tabindex="0"
                         role="region"
                         aria-label="Direktori meja layanan media sosial"
                         @scroll.passive="onScroll()"
                         @touchstart="pause()"
                         @touchend="resume()"
                         @touchcancel="resume()"
                         class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-3.5 -mx-4 px-4 pb-2 md:mx-0 md:px-0 md:block md:bg-white md:border md:border-slate-200 md:rounded-lg md:divide-y md:divide-slate-200 md:overflow-visible md:pb-0">
                        @foreach($socialChannels as $slug => $item)
                            <article class="w-[84vw] max-w-[330px] md:w-auto md:max-w-none shrink-0 snap-start bg-white border border-slate-200 rounded-lg md:bg-transparent md:border-0 md:rounded-none p-4 sm:p-5 md:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-slate-50/70 transition-colors">
                                <div class="space-y-1.5 min-w-0 flex-1">
                                    <div class="flex items-center gap-2.5 flex-wrap">
                                        <span class="w-8 h-8 rounded-md bg-slate-100 border border-slate-200 text-slate-800 flex items-center justify-center shrink-0">
                                            <x-customer-service.channel-icon :channel="$slug" class="w-4 h-4" />
                                        </span>
                                        <h3 class="text-base sm:text-lg font-extrabold text-slate-900">
                                            CS {{ $item['name'] }}
                                        </h3>
                                        <span class="text-xs font-bold text-sky-700 bg-sky-50 border border-sky-200 px-2 py-0.5 rounded-sm">
                                            {{ $item['handle'] }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-slate-700 leading-relaxed">
                                        {{ $item['summary'] }}
                                    </p>
                                    <p class="text-xs text-slate-600">
                                        Format WA: <span class="font-semibold text-slate-800">Hallo admin {{ $item['admin_code'] }} drainusantara, saluran saya mampet di daerah (kota Anda)</span>
                                    </p>
                                </div>

                                <div class="flex flex-col sm:flex-row md:flex-col items-stretch gap-2 shrink-0 mt-auto md:mt-0">
                                    <a href="{{ route('customer-service.show', ['socialMedia' => $slug]) }}"
                                       class="min-h-11 inline-flex items-center justify-center px-4 py-2 rounded-md bg-sky-700 hover:bg-sky-800 text-white text-xs sm:text-sm font-bold transition-colors focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                                        Pilih Wilayah
                                    </a>
                                    @if(!empty($item['social_url']))
                                        <a href="{{ $item['social_url'] }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="min-h-11 inline-flex items-center justify-center px-3.5 py-2 rounded-md bg-white hover:bg-slate-100 text-slate-800 text-xs font-bold border border-slate-300 transition-colors focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                                            Profil {{ $item['name'] }}
                                        </a>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <x-customer-service.carousel-controls label="Kanal" surface="light" hide-at="md" :count="count($socialChannels)" />
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-10 sm:py-16 bg-slate-900 text-slate-100 border-t border-slate-800 overflow-x-clip">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        <div class="lg:col-span-5">
            <div class="rounded-lg overflow-hidden border border-slate-700 bg-slate-950 aspect-[16/10]">
                <img src="{{ asset('assets/banner/hero-k3-drainusantara.webp') }}"
                     alt="Standar SOP K3 teknisi berseragam resmi PT Jawa Jaya Rooter"
                     width="800"
                     height="500"
                     loading="lazy"
                     decoding="async"
                     class="w-full h-full object-cover">
            </div>
        </div>

        <div class="lg:col-span-7 space-y-6 min-w-0">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                    Standar Verifikasi Akun &amp; Teknisi Resmi
                </h2>
                <p class="mt-2 text-sm sm:text-base text-slate-300 leading-relaxed">
                    Pastikan Anda hanya bertransaksi dengan saluran komunikasi resmi PT Jawa Jaya Rooter sebelum teknisi berangkat ke lokasi.
                </p>
            </div>

            <div x-data="mobileCarousel(3, 5500)" x-init="stopped = true">
                <div x-ref="slider"
                     tabindex="0"
                     role="region"
                     aria-label="Standar verifikasi akun dan teknisi resmi"
                     @scroll.passive="onScroll()"
                     @touchstart="pause()"
                     @touchend="resume()"
                     @touchcancel="resume()"
                     class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-3 -mx-4 px-4 pb-2 sm:mx-0 sm:px-0 sm:block sm:divide-y sm:divide-slate-800 sm:border-y sm:border-slate-800 sm:overflow-visible sm:pb-0">
                    <div class="w-[82vw] max-w-[310px] sm:w-auto sm:max-w-none shrink-0 snap-start bg-slate-950/75 border border-slate-800 rounded-lg p-4 sm:bg-transparent sm:border-0 sm:rounded-none sm:px-0 sm:py-4 flex items-start gap-3.5 sm:gap-4">
                        <span class="w-8 h-8 rounded-md bg-sky-950 border border-sky-700 text-sky-300 font-bold text-xs flex items-center justify-center shrink-0">01</span>
                        <div class="min-w-0">
                            <h3 class="text-sm sm:text-base font-bold text-white">Selalu Berawal drainusantara.id/customer-service</h3>
                            <p class="text-xs sm:text-sm text-slate-300 mt-1 leading-relaxed">Semua tautan bio media sosial resmi mengarah ke domain utama drainusantara.id, bukan domain acak atau tautan pihak ketiga.</p>
                        </div>
                    </div>
                    <div class="w-[82vw] max-w-[310px] sm:w-auto sm:max-w-none shrink-0 snap-start bg-slate-950/75 border border-slate-800 rounded-lg p-4 sm:bg-transparent sm:border-0 sm:rounded-none sm:px-0 sm:py-4 flex items-start gap-3.5 sm:gap-4">
                        <span class="w-8 h-8 rounded-md bg-sky-950 border border-sky-700 text-sky-300 font-bold text-xs flex items-center justify-center shrink-0">02</span>
                        <div class="min-w-0">
                            <h3 class="text-sm sm:text-base font-bold text-white">Nomor Dispatch Tunggal +62 856-0900-9009</h3>
                            <p class="text-xs sm:text-sm text-slate-300 mt-1 leading-relaxed">Penjadwalan armada dan konfirmasi estimasi biaya dikelola terpusat tanpa meminta uang muka ke rekening pribadi.</p>
                        </div>
                    </div>
                    <div class="w-[82vw] max-w-[310px] sm:w-auto sm:max-w-none shrink-0 snap-start bg-slate-950/75 border border-slate-800 rounded-lg p-4 sm:bg-transparent sm:border-0 sm:rounded-none sm:px-0 sm:py-4 flex items-start gap-3.5 sm:gap-4">
                        <span class="w-8 h-8 rounded-md bg-sky-950 border border-sky-700 text-sky-300 font-bold text-xs flex items-center justify-center shrink-0">03</span>
                        <div class="min-w-0">
                            <h3 class="text-sm sm:text-base font-bold text-white">Lancar Baru Bayar &amp; Nota Garansi 30 Hari</h3>
                            <p class="text-xs sm:text-sm text-slate-300 mt-1 leading-relaxed">Pembayaran dilakukan setelah aliran pipa teruji lancar bersama pelanggan, lengkap dengan bukti nota garansi PT Jawa Jaya Rooter.</p>
                        </div>
                    </div>
                </div>

                <x-customer-service.carousel-controls label="Standar" surface="dark" hide-at="sm" :count="3" />
            </div>
        </div>
    </div>
</section>

<x-customer-service.channel-faq
    :faqs="$hubFaqs"
    heading="Pertanyaan Umum Customer Service Multi-Kanal"
    subheading="Klarifikasi seputar keaslian akun, kesamaan standar tarif, dan pemilihan meja layanan."
    channel-slug="hub"
    variant="split"
/>
@endsection
