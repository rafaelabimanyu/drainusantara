@extends('layouts.app')

@section('content')
<section class="bg-white border-b border-slate-200 py-7 sm:py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-ui.breadcrumb :items="[
            ['label' => 'Customer Service', 'url' => route('customer-service.index')],
            ['label' => 'Instagram'],
        ]" />

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-7 lg:gap-10 items-center">
            <div class="lg:col-span-6 space-y-4 sm:space-y-5">
                <div class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-md bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold">
                    <x-customer-service.channel-icon channel="instagram" class="w-4 h-4" />
                    <span>Tautan Resmi Bio Instagram {{ $channel['handle'] }}</span>
                </div>

                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Customer Service Resmi Instagram @drainusantara
                </h1>
                <p class="text-sm sm:text-base text-slate-700 leading-relaxed">
                    Untuk respons jadwal teknisi lebih cepat dibanding DM Instagram, pilih wilayah Anda pada pita layanan di bawah. Admin IG siap memeriksa foto atau video kondisi saluran Anda tanpa bongkar keramik.
                </p>

                <div class="grid grid-cols-1 sm:flex sm:flex-wrap items-stretch sm:items-center gap-2.5 pt-1">
                    @if(!empty($socialUrl))
                        <a href="{{ $socialUrl }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="min-h-11 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-md border border-slate-300 bg-white hover:bg-slate-100 text-xs sm:text-sm font-bold text-slate-800 transition-colors focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                            <x-customer-service.channel-icon channel="instagram" class="w-4 h-4 text-rose-700" />
                            <span>Kunjungi Profil {{ $channel['handle'] }}</span>
                        </a>
                    @endif
                    <a href="{{ route('gallery') }}"
                       class="min-h-11 inline-flex items-center justify-center px-4 py-2.5 rounded-md border border-slate-200 bg-slate-50 hover:bg-slate-100 text-xs sm:text-sm font-bold text-slate-800 transition-colors focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                        Arsip Lengkap Galeri
                    </a>
                </div>
            </div>

            <div class="lg:col-span-6" x-data="{ split: 55 }">
                <div class="bg-slate-50 border border-slate-200 rounded-lg p-3 sm:p-4 space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 text-xs font-bold text-slate-800">
                        <span>Perbandingan Nyata Sebelum &amp; Sesudah Pengerjaan</span>
                        <div class="flex items-center gap-1.5 w-full sm:w-auto">
                            <button type="button"
                                    @click="split = 10"
                                    :aria-pressed="split <= 25 ? 'true' : 'false'"
                                    :class="split <= 25 ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-800 border-slate-300 hover:bg-slate-100'"
                                    class="flex-1 sm:flex-none min-h-11 sm:min-h-9 px-2.5 py-1 rounded-sm border text-xs font-bold cursor-pointer transition-colors">
                                Sebelum
                            </button>
                            <button type="button"
                                    @click="split = 50"
                                    :aria-pressed="split > 25 && split < 75 ? 'true' : 'false'"
                                    :class="split > 25 && split < 75 ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-800 border-slate-300 hover:bg-slate-100'"
                                    class="flex-1 sm:flex-none min-h-11 sm:min-h-9 px-2.5 py-1 rounded-sm border text-xs font-bold cursor-pointer transition-colors">
                                50/50
                            </button>
                            <button type="button"
                                    @click="split = 90"
                                    :aria-pressed="split >= 75 ? 'true' : 'false'"
                                    :class="split >= 75 ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-800 border-slate-300 hover:bg-slate-100'"
                                    class="flex-1 sm:flex-none min-h-11 sm:min-h-9 px-2.5 py-1 rounded-sm border text-xs font-bold cursor-pointer transition-colors">
                                Sesudah
                            </button>
                        </div>
                    </div>

                    <div class="relative aspect-[16/10] rounded-md overflow-hidden border border-slate-300 bg-slate-950">
                        <img src="{{ asset('images/dokumentasi/before-pembersihan-talang-gutter-drainusantara.webp') }}"
                             alt="Kondisi saluran gutter sebelum dibersihkan tim Drainusantara"
                             width="800"
                             height="500"
                             loading="eager"
                             decoding="async"
                             class="w-full h-full object-cover">
                        <img src="{{ asset('images/dokumentasi/after-gutter-resto-bersih-drainusantara.webp') }}"
                             alt="Kondisi saluran gutter setelah dibersihkan dengan mesin spiral tanpa bongkar"
                             width="800"
                             height="500"
                             loading="eager"
                             decoding="async"
                             :style="`clip-path: inset(0 ${100 - split}% 0 0)`"
                             class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute inset-y-0 w-0.5 bg-white pointer-events-none" :style="`left: ${split}%`"></div>
                        <span class="absolute top-2.5 left-2.5 px-2.5 py-1 rounded-sm bg-emerald-800 text-white text-[11px] font-bold">Sesudah</span>
                        <span class="absolute top-2.5 right-2.5 px-2.5 py-1 rounded-sm bg-slate-900 text-white text-[11px] font-bold">Sebelum</span>
                    </div>

                    <div>
                        <label for="ig-compare-range" class="block text-xs font-semibold text-slate-700 mb-1">
                            Geser garis pembatas hasil pembersihan saluran (<span x-text="split + '%'">55%</span>)
                        </label>
                        <input id="ig-compare-range"
                               type="range"
                               min="5"
                               max="95"
                               x-model="split"
                               class="w-full accent-sky-700 cursor-pointer h-8 sm:h-6">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-7 sm:py-10 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-customer-service.wa-area-builder
            layout="ribbon"
            channel-code="ig"
            channel-slug="instagram"
            channel-name="Instagram"
            :whatsapp-number="$whatsappNumber"
            :region-selector-data="$regionSelectorData"
            heading="Hubungi Admin IG Drainusantara via WhatsApp"
            subheading="Pilih kota dan kecamatan Anda terlebih dulu sebelum menekan tombol chat."
            track-location="cs_instagram_hero"
            surface="light"
        />
    </div>
</section>

<section class="py-9 sm:py-16 bg-white border-b border-slate-200 overflow-x-clip">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Dokumentasi Lapangan Nyata dari Portofolio Kami
                </h2>
                <p class="mt-1.5 text-sm text-slate-600 max-w-2xl">
                    Hasil pengerjaan aktual di sektor rumah tinggal dan dapur F&amp;B tanpa pembongkaran lantai keramik.
                </p>
            </div>
            <a href="{{ route('gallery') }}" class="w-full sm:w-auto min-h-11 inline-flex items-center justify-center px-4 py-2 rounded-md border border-slate-300 bg-slate-50 hover:bg-slate-100 text-xs sm:text-sm font-bold text-slate-800 shrink-0">
                Lihat Semua Galeri
            </a>
        </div>

        @if($galleries->isNotEmpty())
            @php
                $featuredGallery = $galleries->first();
                $otherGalleries = $galleries->slice(1);
                $rawFeaturedImg = $featuredGallery->main_image;
                $featuredImg = $rawFeaturedImg
                    ? (filter_var($rawFeaturedImg, FILTER_VALIDATE_URL) ? $rawFeaturedImg : asset(ltrim($rawFeaturedImg, '/')))
                    : asset('images/dokumentasi/teknisi-pelancar-wastafel-mesin-ridgid.webp');
            @endphp

            <article class="bg-slate-50 border border-slate-200 rounded-lg overflow-hidden grid grid-cols-1 lg:grid-cols-12">
                <div class="lg:col-span-7 bg-slate-950 aspect-[16/10] lg:aspect-auto overflow-hidden">
                    <img src="{{ $featuredImg }}"
                         alt="{{ $featuredGallery->title }}"
                         loading="lazy"
                         decoding="async"
                         class="w-full h-full object-cover">
                </div>
                <div class="lg:col-span-5 p-4 sm:p-8 flex flex-col justify-between gap-5">
                    <div class="space-y-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block">
                            Studi Kasus Terbaru &bull; {{ $featuredGallery->category_label }}
                        </span>
                        <h3 class="text-xl font-extrabold text-slate-900 leading-snug">
                            {{ $featuredGallery->title }}
                        </h3>
                        <dl class="space-y-1.5 text-xs sm:text-sm text-slate-700 border-t border-slate-200 pt-3">
                            @if($featuredGallery->location)
                                <div><dt class="inline font-bold text-slate-900">Lokasi:</dt> <dd class="inline">{{ $featuredGallery->location }}</dd></div>
                            @endif
                            @if($featuredGallery->drain_type)
                                <div><dt class="inline font-bold text-slate-900">Saluran:</dt> <dd class="inline">{{ $featuredGallery->drain_type }}</dd></div>
                            @endif
                            @if($featuredGallery->method)
                                <div><dt class="inline font-bold text-slate-900">Metode:</dt> <dd class="inline">{{ $featuredGallery->method }}</dd></div>
                            @endif
                        </dl>
                    </div>
                    @if($featuredGallery->slug)
                        <a href="{{ route('case-study.show', ['slug' => $featuredGallery->slug]) }}"
                           class="min-h-11 inline-flex items-center justify-center px-4 py-2.5 rounded-md bg-sky-700 hover:bg-sky-800 text-white text-sm font-bold transition-colors focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                            Baca Detail Studi Kasus
                        </a>
                    @endif
                </div>
            </article>

            @if($otherGalleries->isNotEmpty())
                <div x-data="mobileCarousel({{ $otherGalleries->count() }}, 5500)" x-init="stopped = true">
                    <div x-ref="slider"
                         tabindex="0"
                         role="region"
                         aria-label="Dokumentasi kasus lapangan lainnya"
                         @scroll.passive="onScroll()"
                         @touchstart="pause()"
                         @touchend="resume()"
                         @touchcancel="resume()"
                         class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-4 -mx-4 px-4 pb-2 md:mx-0 md:px-0 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-5 md:overflow-visible md:pb-0">
                        @foreach($otherGalleries as $item)
                            @php
                                $rawItemImg = $item->main_image;
                                $itemImg = $rawItemImg
                                    ? (filter_var($rawItemImg, FILTER_VALIDATE_URL) ? $rawItemImg : asset(ltrim($rawItemImg, '/')))
                                    : asset('images/dokumentasi/teknisi-pelancar-wastafel-mesin-ridgid.webp');
                            @endphp
                            <article class="w-[82vw] max-w-[320px] md:w-auto md:max-w-none shrink-0 snap-start bg-white border border-slate-200 rounded-lg overflow-hidden flex flex-col justify-between card-lift">
                                <div class="aspect-[16/10] bg-slate-950 overflow-hidden border-b border-slate-100">
                                    <img src="{{ $itemImg }}"
                                         alt="{{ $item->title }}"
                                         loading="lazy"
                                         decoding="async"
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between gap-3">
                                    <div class="space-y-1.5">
                                        <span class="text-xs font-bold text-sky-700 block">
                                            {{ $item->category_label }} @if($item->location) &bull; {{ $item->location }} @endif
                                        </span>
                                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900 leading-snug">
                                            {{ $item->title }}
                                        </h3>
                                    </div>
                                    @if($item->slug)
                                        <a href="{{ route('case-study.show', ['slug' => $item->slug]) }}"
                                           class="min-h-11 inline-flex items-center text-xs sm:text-sm font-bold text-sky-700 hover:text-sky-800 hover:underline">
                                            Lihat Dokumentasi Kasus
                                        </a>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <x-customer-service.carousel-controls label="Kasus" surface="light" hide-at="md" :count="$otherGalleries->count()" />
                </div>
            @endif
        @else
            <div x-data="mobileCarousel(3, 5500)" x-init="stopped = true">
                <div x-ref="slider"
                     tabindex="0"
                     role="region"
                     aria-label="Contoh dokumentasi lapangan"
                     @scroll.passive="onScroll()"
                     @touchstart="pause()"
                     @touchend="resume()"
                     @touchcancel="resume()"
                     class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-4 -mx-4 px-4 pb-2 md:mx-0 md:px-0 md:grid md:grid-cols-3 md:gap-5 md:overflow-visible md:pb-0">
                    <article class="w-[82vw] max-w-[320px] md:w-auto md:max-w-none shrink-0 snap-start border border-slate-200 rounded-lg overflow-hidden bg-slate-50">
                        <div class="aspect-[16/10] bg-slate-950 overflow-hidden border-b border-slate-200">
                            <img src="{{ asset('images/dokumentasi/teknisi-pelancar-wastafel-mesin-ridgid.webp') }}" alt="Pelancaran pipa wastafel dapur dengan mesin Ridgid" loading="lazy" decoding="async" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 space-y-1">
                            <span class="text-xs font-bold text-sky-700 block">Wastafel Dapur</span>
                            <h3 class="text-sm font-extrabold text-slate-900">Pembersihan kerak lemak sifon tanpa melepas bak sink</h3>
                        </div>
                    </article>
                    <article class="w-[82vw] max-w-[320px] md:w-auto md:max-w-none shrink-0 snap-start border border-slate-200 rounded-lg overflow-hidden bg-slate-50">
                        <div class="aspect-[16/10] bg-slate-950 overflow-hidden border-b border-slate-200">
                            <img src="{{ asset('images/dokumentasi/proses-ridgid-spiral-floor-drain.webp') }}" alt="Proses rooter floor drain kamar mandi tanpa bongkar keramik" loading="lazy" decoding="async" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 space-y-1">
                            <span class="text-xs font-bold text-sky-700 block">Floor Drain Kamar Mandi</span>
                            <h3 class="text-sm font-extrabold text-slate-900">Penarikan gumpalan rambut dan sabun dari lubang lantai</h3>
                        </div>
                    </article>
                    <article class="w-[82vw] max-w-[320px] md:w-auto md:max-w-none shrink-0 snap-start border border-slate-200 rounded-lg overflow-hidden bg-slate-50">
                        <div class="aspect-[16/10] bg-slate-950 overflow-hidden border-b border-slate-200">
                            <img src="{{ asset('images/dokumentasi/pelancaran-kloset-spiral-baja-profesional.webp') }}" alt="Penanganan kloset tersumbat memakai spiral baja fleksibel" loading="lazy" decoding="async" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 space-y-1">
                            <span class="text-xs font-bold text-sky-700 block">Kloset &amp; Toilet</span>
                            <h3 class="text-sm font-extrabold text-slate-900">Penetrasi leher angsa tanpa mencabut dudukan porselen</h3>
                        </div>
                    </article>
                </div>

                <x-customer-service.carousel-controls label="Kasus" surface="light" hide-at="md" :count="3" />
            </div>
        @endif
    </div>
</section>

<section class="py-9 sm:py-16 bg-slate-50 overflow-x-clip">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        <div class="lg:col-span-5">
            <div class="rounded-lg overflow-hidden border border-slate-200 bg-slate-900 aspect-[16/11]">
                <img src="{{ asset('images/dokumentasi/drain-cleaner-spiral-baja-wastafel.webp') }}"
                     alt="Kabel spiral baja drain cleaner di saluran pembuangan wastafel"
                     width="800"
                     height="550"
                     loading="lazy"
                     decoding="async"
                     class="w-full h-full object-cover">
            </div>
        </div>

        <div class="lg:col-span-7 space-y-5 min-w-0">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Panduan Konsultasi Visual untuk Penonton Instagram
                </h2>
                <p class="mt-2 text-sm sm:text-base text-slate-600 leading-relaxed">
                    Kirimkan dua detail ini di chat WhatsApp admin IG agar perkiraan kepala bor spiral dan jadwal armada lebih tepat.
                </p>
            </div>

            <div x-data="mobileCarousel(2, 5500)" x-init="stopped = true">
                <div x-ref="slider"
                     tabindex="0"
                     role="region"
                     aria-label="Panduan konsultasi visual Instagram"
                     @scroll.passive="onScroll()"
                     @touchstart="pause()"
                     @touchend="resume()"
                     @touchcancel="resume()"
                     class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-3.5 -mx-4 px-4 pb-2 sm:mx-0 sm:px-0 sm:grid sm:grid-cols-2 sm:gap-4 sm:overflow-visible sm:pb-0">
                    <div class="w-[82vw] max-w-[310px] sm:w-auto sm:max-w-none shrink-0 snap-start border border-slate-200 rounded-lg p-4 sm:p-5 bg-white space-y-2">
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900">1. Foto Sudut Lebar Area Saluran</h3>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                            Perlihatkan kolong meja wastafel, jarak kloset ke tembok, atau posisi lubang floor drain agar teknisi tahu titik masuk kabel terbaik.
                        </p>
                    </div>
                    <div class="w-[82vw] max-w-[310px] sm:w-auto sm:max-w-none shrink-0 snap-start border border-slate-200 rounded-lg p-4 sm:p-5 bg-white space-y-2">
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900">2. Catatan Bak Kontrol &amp; Lantai</h3>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                            Sebutkan apakah sumbatan di lantai dasar atau lantai atas, serta apakah air ikut keluar dari saluran lain saat mesin cuci membuang air.
                        </p>
                    </div>
                </div>

                <x-customer-service.carousel-controls label="Panduan" surface="light" hide-at="sm" :count="2" />
            </div>
        </div>
    </div>
</section>

<x-customer-service.channel-faq
    :faqs="$channel['faqs']"
    :other-channels="$otherChannels"
    heading="Pertanyaan yang Sering Masuk Lewat Instagram"
    subheading="Penjelasan mengenai alur bio link Instagram @drainusantara, pengiriman video keluhan, dan keaslian akun."
    channel-slug="instagram"
    variant="split"
/>
@endsection
