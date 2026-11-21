@extends('layouts.app')

@section('content')
<section class="bg-slate-950 text-slate-100 border-b border-slate-800 py-7 sm:py-14 overflow-x-clip">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-slate-300 mb-4 sm:mb-6 font-medium overflow-x-auto no-scrollbar whitespace-nowrap" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="hover:text-sky-300 transition-colors">Beranda</a>
            <span class="text-slate-500">/</span>
            <a href="{{ route('customer-service.index') }}" class="hover:text-sky-300 transition-colors">Customer Service</a>
            <span class="text-slate-500">/</span>
            <span class="text-sky-300 font-bold">{{ $channel['breadcrumb_label'] }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-7 lg:gap-10 items-start">
            <div class="lg:col-span-5 space-y-4 sm:space-y-5 reveal-soft">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-slate-900 border border-slate-700 text-slate-100 text-xs font-bold">
                    <x-customer-service.channel-icon channel="x" class="w-4 h-4 text-white" />
                    <span>Tautan Resmi Bio X (Twitter) {{ $channel['handle'] }}</span>
                </div>

                <h1 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">
                    Customer Service Resmi X (Twitter) {{ $channel['handle'] }}
                </h1>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                    Baru membaca utasan sanitasi, mengirim mention, atau membalas DM di X? Pilih kota dan kecamatan Anda untuk terhubung langsung ke operator posko via WhatsApp tanpa membongkar keramik.
                </p>

                <div class="bg-slate-900 border border-slate-800 rounded-lg p-4 space-y-2.5 text-xs sm:text-sm">
                    <div class="flex items-center justify-between gap-2 pb-2 border-b border-slate-800">
                        <span class="text-slate-400">Akun X Resmi</span>
                        <span class="font-bold text-white">{{ $channel['handle'] }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-2 pb-2 border-b border-slate-800">
                        <span class="text-slate-400">Hotline Darurat 24 Jam</span>
                        <a href="tel:085609009009" class="font-bold text-sky-300 hover:underline">0856-0900-9009</a>
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-slate-400">Jaminan Layanan</span>
                        <span class="font-bold text-emerald-300">No Cure No Pay &amp; Garansi 30 Hari</span>
                    </div>
                </div>

                @if(!empty($socialUrl))
                    <a href="{{ $socialUrl }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="w-full sm:w-auto min-h-11 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-md border border-slate-700 bg-slate-900 hover:bg-slate-800 text-xs sm:text-sm font-bold text-slate-100 transition-colors focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-400">
                        <x-customer-service.channel-icon channel="x" class="w-4 h-4 text-white" />
                        <span>Buka Profil X {{ $channel['handle'] }}</span>
                    </a>
                @endif
            </div>

            <div class="lg:col-span-7 reveal-soft delay-100 min-w-0">
                <x-customer-service.wa-area-builder
                    channel-code="x"
                    channel-slug="x"
                    channel-name="X (Twitter)"
                    :whatsapp-number="$whatsappNumber"
                    :region-selector-data="$regionSelectorData"
                    cta-label="Hubungi Admin Drainusantara"
                    heading="Kirim Laporan dari X (Twitter) ke WhatsApp Posko"
                    subheading="Pilih kota, kecamatan, dan titik saluran agar pesan otomatis ke admin X langsung diproses."
                    track-location="cs_x_hero"
                    surface="dark"
                    layout="card"
                />
            </div>
        </div>
    </div>
</section>

<section class="py-9 sm:py-16 bg-white border-b border-slate-200 overflow-x-clip">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="max-w-2xl">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Alur Respon Cepat dari Mention &amp; DM X ke Teknisi Lapangan
            </h2>
            <p class="mt-1.5 text-sm sm:text-base text-slate-600">
                Pengiriman pin lokasi alamat tidak perlu ditulis di kolom komentar publik X. Cukup lanjutkan ke WhatsApp dispatch agar teknisi Spiral Baja segera menuju lokasi.
            </p>
        </div>

        <div x-data="mobileCarousel(3, 5500)" x-init="stopped = true">
            <div x-ref="slider"
                 tabindex="0"
                 role="region"
                 aria-label="Alur respon cepat dari X ke teknisi lapangan"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
                 @touchcancel="resume()"
                 class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-3.5 -mx-4 px-4 pb-2 md:mx-0 md:px-0 md:grid md:grid-cols-3 md:gap-5 md:overflow-visible md:pb-0">
                <article class="w-[82vw] max-w-[310px] md:w-auto md:max-w-none shrink-0 snap-start border border-slate-200 rounded-lg p-4 sm:p-5 bg-slate-50 space-y-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-slate-900 text-white text-xs font-extrabold">01</span>
                    <h3 class="text-base font-extrabold text-slate-900">Tentukan Kota &amp; Titik Saluran</h3>
                    <p class="text-sm text-slate-700 leading-relaxed">
                        Isi pemilih wilayah dan jenis sumbatan (wastafel, leher angsa kloset, floor drain, atau grease trap) agar format pesan otomatis ke admin X tersusun lengkap.
                    </p>
                </article>
                <article class="w-[82vw] max-w-[310px] md:w-auto md:max-w-none shrink-0 snap-start border border-slate-200 rounded-lg p-4 sm:p-5 bg-slate-50 space-y-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-slate-900 text-white text-xs font-extrabold">02</span>
                    <h3 class="text-base font-extrabold text-slate-900">Kirim Foto Sumbatan &amp; Pin Lokasi</h3>
                    <p class="text-sm text-slate-700 leading-relaxed">
                        Operator mengonfirmasi ketersediaan armada posko kota terdekat beserta estimasi tarif dasar sebelum teknisi Rooter diberangkatkan.
                    </p>
                </article>
                <article class="w-[82vw] max-w-[310px] md:w-auto md:max-w-none shrink-0 snap-start border border-slate-200 rounded-lg p-4 sm:p-5 bg-slate-50 space-y-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-slate-900 text-white text-xs font-extrabold">03</span>
                    <h3 class="text-base font-extrabold text-slate-900">Uji Alir &amp; Nota Garansi 30 Hari</h3>
                    <p class="text-sm text-slate-700 leading-relaxed">
                        Setelah spiral baja membersihkan kerak hingga aliran bak kontrol kembali lancar, Anda menerima nota garansi resmi 30 hari dari PT Jawa Jaya Rooter.
                    </p>
                </article>
            </div>

            <x-customer-service.carousel-controls label="Tahapan" surface="light" hide-at="md" :count="3" />
        </div>
    </div>
</section>

<section class="py-9 sm:py-16 bg-slate-50 border-b border-slate-200 overflow-x-clip">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Ringkasan Panduan &amp; Utasan Teknis Sanitasi Terbaru
                </h2>
                <p class="mt-1.5 text-sm sm:text-base text-slate-600">
                    Arsip referensi lengkap seputar larangan soda api, perawatan pipa PVC, mesin Rooter, dan Inspeksi CCTV IP68.
                </p>
            </div>
            <a href="{{ route('articles.index') }}" class="min-h-11 inline-flex items-center text-sm font-bold text-sky-700 hover:underline shrink-0">
                Semua Artikel Sanitasi
            </a>
        </div>

        @if($articles->isNotEmpty())
            <div x-data="mobileCarousel({{ $articles->count() }}, 5500)" x-init="stopped = true">
                <div x-ref="slider"
                     tabindex="0"
                     role="region"
                     aria-label="Ringkasan panduan dan utasan teknis sanitasi terbaru"
                     @scroll.passive="onScroll()"
                     @touchstart="pause()"
                     @touchend="resume()"
                     @touchcancel="resume()"
                     class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-3.5 -mx-4 px-4 pb-2 md:mx-0 md:px-0 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-5 md:overflow-visible md:pb-0">
                    @foreach($articles as $article)
                        @php
                            $categoryLabel = $article->categoryRelation?->name ?: ($article->category ?: 'Edukasi Sanitasi');
                            $articleSummary = \Illuminate\Support\Str::limit(strip_tags((string) ($article->excerpt ?: $article->content)), 120);
                        @endphp
                        <article class="w-[82vw] max-w-[310px] md:w-auto md:max-w-none shrink-0 snap-start bg-white border border-slate-200 rounded-lg p-4 sm:p-5 flex flex-col justify-between gap-4 card-lift">
                            <div class="space-y-2">
                                <span class="inline-block text-xs font-bold text-sky-800 bg-sky-50 border border-sky-200 px-2 py-0.5 rounded-sm">
                                    {{ $categoryLabel }}
                                </span>
                                <h3 class="text-base font-extrabold text-slate-900 leading-snug">
                                    {{ $article->title }}
                                </h3>
                                @if($articleSummary !== '')
                                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                        {{ $articleSummary }}
                                    </p>
                                @endif
                            </div>

                            <a href="{{ $article->silo_url ?? route('articles.index') }}"
                               class="min-h-11 inline-flex items-center text-xs sm:text-sm font-bold text-sky-700 hover:underline mt-auto focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 rounded-sm">
                                Baca Panduan Lengkap &rarr;
                            </a>
                        </article>
                    @endforeach
                </div>

                <x-customer-service.carousel-controls label="Panduan" surface="light" hide-at="md" :count="$articles->count()" />
            </div>
        @else
            <div class="bg-white border border-slate-200 rounded-lg p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Pelajari Bahaya Soda Api &amp; Teknik Tanpa Bongkar</h3>
                    <p class="text-sm text-slate-600 mt-1">
                        Kunjungi basis pengetahuan teknis kami atau langsung konsultasikan kondisi saluran rumah Anda lewat WhatsApp admin X Drainusantara.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2.5 shrink-0">
                    <a href="{{ route('articles.index') }}"
                       class="min-h-11 inline-flex items-center justify-center px-4 py-2.5 rounded-md bg-white hover:bg-slate-100 text-slate-800 text-sm font-bold border border-slate-300 transition-colors">
                        Buka Artikel Edukasi
                    </a>
                    <a href="{{ $contextualWaUrl }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="min-h-11 inline-flex items-center justify-center px-4 py-2.5 rounded-md bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-bold transition-colors">
                        Tanya Admin via WA
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<x-customer-service.channel-faq
    :faqs="$channel['faqs']"
    :other-channels="$otherChannels"
    heading="Tanya Jawab Layanan X (Twitter) Drainusantara"
    subheading="Panduan lanjut dari DM atau mention X ke WhatsApp dispatch, standar tarif, dan jangkauan armada 24 jam."
    channel-slug="x"
    variant="compact"
/>
@endsection
