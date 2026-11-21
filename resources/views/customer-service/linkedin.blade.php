@extends('layouts.app')

@section('content')
@php
    $linkedinProblems = [
        'Grease Trap Restoran & Dapur Komersial',
        'Pipa Induk & Bak Kontrol Gedung',
        'Inspeksi Kamera CCTV Pipa IP68 30M',
        'High Pressure Hydro-Jetting Pipa Lemak',
        'Kloset & Floor Drain Area Perkantoran',
        'Saluran Roof Drain & Kawasan Pabrik',
    ];
@endphp

<section class="relative bg-slate-900 text-white border-b border-slate-800 overflow-hidden py-7 sm:py-14">
    <div class="absolute inset-0 z-0 pointer-events-none">
        <img src="{{ asset('assets/banner/hero-JnJ-drainusantara.webp') }}"
             alt="PT Jawa Jaya Rooter layanan infrastruktur sanitasi komersial B2B"
             width="1920"
             height="960"
             loading="eager"
             decoding="async"
             class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-slate-950/90 to-slate-900/80"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-5 sm:space-y-6">
        <nav class="flex items-center gap-2 text-xs text-slate-300 font-medium overflow-x-auto no-scrollbar whitespace-nowrap" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="hover:text-sky-300 transition-colors">Beranda</a>
            <span class="text-slate-500">/</span>
            <a href="{{ route('customer-service.index') }}" class="hover:text-sky-300 transition-colors">Customer Service</a>
            <span class="text-slate-500">/</span>
            <span class="text-sky-300 font-bold">LinkedIn B2B</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-end">
            <div class="lg:col-span-8 space-y-3.5 sm:space-y-4 reveal-soft">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-sky-950/90 border border-sky-700/70 text-sky-200 text-xs font-bold">
                    <x-customer-service.channel-icon channel="linkedin" class="w-4 h-4" />
                    <span>Desk Korporat PT Jawa Jaya Rooter</span>
                </div>

                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
                    Customer Service Korporat &amp; B2B LinkedIn Drainusantara
                </h1>
                <p class="text-sm sm:text-base text-slate-200 leading-relaxed max-w-2xl">
                    Layanan pemeliharaan drainase, kuras grease trap, dan inspeksi kamera CCTV pipa untuk jaringan restoran F&amp;B, hotel, perkantoran, ritel, serta kawasan industri di bawah badan hukum PT Jawa Jaya Rooter.
                </p>
            </div>

            <div class="lg:col-span-4 flex flex-col sm:flex-row lg:flex-col gap-2.5 reveal-soft delay-100">
                <a href="#form-penawaran-b2b"
                   class="min-h-12 inline-flex items-center justify-center px-4 py-3 rounded-md bg-sky-700 hover:bg-sky-800 text-white text-sm font-bold border border-sky-600 transition-colors focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-400">
                    Ajukan Survei &amp; Penawaran B2B
                </a>
                @if(!empty($socialUrl))
                    <a href="{{ $socialUrl }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="min-h-11 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-md bg-slate-950/80 hover:bg-slate-800 border border-slate-700 text-xs sm:text-sm font-bold text-slate-100 transition-colors focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-400">
                        <x-customer-service.channel-icon channel="linkedin" class="w-4 h-4 text-sky-300" />
                        <span>Profil Perusahaan di LinkedIn</span>
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3 pt-2 border-t border-slate-800 text-xs">
            <div class="p-3 sm:p-3.5 rounded-md bg-slate-950/75 border border-slate-800">
                <span class="font-bold text-sky-300 block">Legalitas NIB OSS</span>
                <span class="text-slate-300 block mt-0.5">Entitas PT Jawa Jaya Rooter</span>
            </div>
            <div class="p-3 sm:p-3.5 rounded-md bg-slate-950/75 border border-slate-800">
                <span class="font-bold text-sky-300 block">NPWP &amp; SPPKP</span>
                <span class="text-slate-300 block mt-0.5">e-Faktur PPN 11% Resmi</span>
            </div>
            <div class="p-3 sm:p-3.5 rounded-md bg-slate-950/75 border border-slate-800">
                <span class="font-bold text-sky-300 block">SPK &amp; BAPP Kerja</span>
                <span class="text-slate-300 block mt-0.5">Dokumen Pengadaan Lengkap</span>
            </div>
            <div class="p-3 sm:p-3.5 rounded-md bg-slate-950/75 border border-slate-800">
                <span class="font-bold text-sky-300 block">Jadwal After-Hours</span>
                <span class="text-slate-300 block mt-0.5">Siaga di Luar Jam Operasional</span>
            </div>
        </div>
    </div>
</section>

<section class="py-9 sm:py-16 bg-slate-50 border-b border-slate-200 overflow-x-clip">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <div class="lg:col-span-7 space-y-8 sm:space-y-10 min-w-0">
            <div class="space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                            Rekam Jejak Kemitraan &amp; Klien Komersial
                        </h2>
                        <p class="mt-1 text-sm text-slate-600">
                            Dokumentasi penanganan saluran untuk restoran, ritel, dan fasilitas publik.
                        </p>
                    </div>
                    <a href="{{ route('about.portfolio') }}" class="min-h-11 inline-flex items-center text-sm font-bold text-sky-700 hover:underline shrink-0">
                        Halaman Kemitraan
                    </a>
                </div>

                @if($portfolios->isNotEmpty())
                    <div x-data="mobileCarousel({{ $portfolios->count() }}, 5500)" x-init="stopped = true">
                        <div x-ref="slider"
                             tabindex="0"
                             role="region"
                             aria-label="Rekam jejak kemitraan dan klien komersial"
                             @scroll.passive="onScroll()"
                             @touchstart="pause()"
                             @touchend="resume()"
                             @touchcancel="resume()"
                             class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-4 -mx-4 px-4 pb-2 sm:mx-0 sm:px-0 sm:grid sm:grid-cols-2 sm:gap-4 sm:overflow-visible sm:pb-0">
                            @foreach($portfolios as $partner)
                                <article class="w-[84vw] max-w-[330px] sm:w-auto sm:max-w-none shrink-0 snap-start bg-white border border-slate-200 rounded-lg p-4 sm:p-5 flex flex-col justify-between gap-4 card-lift">
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between gap-2 flex-wrap">
                                            <span class="text-xs font-bold text-sky-700">{{ $partner->client_type ?: 'Komersial B2B' }}</span>
                                            @if($partner->location)
                                                <span class="text-xs text-slate-600">{{ $partner->location }}</span>
                                            @endif
                                        </div>
                                        <h3 class="text-base font-extrabold text-slate-900">{{ $partner->client_name }}</h3>
                                        @if($partner->project_title)
                                            <p class="text-xs font-bold text-slate-800">{{ $partner->project_title }}</p>
                                        @endif
                                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                                            {{ $partner->scope_of_work ?: $partner->description }}
                                        </p>
                                    </div>
                                    @if($partner->slug)
                                        <a href="{{ route('partnership.show', ['slug' => $partner->slug]) }}"
                                           class="min-h-11 inline-flex items-center justify-center px-3.5 py-2 rounded-md border border-slate-300 bg-slate-50 hover:bg-slate-100 text-xs font-bold text-slate-800 transition-colors">
                                            Detail Lingkup Pekerjaan
                                        </a>
                                    @endif
                                </article>
                            @endforeach
                        </div>

                        <x-customer-service.carousel-controls label="Kemitraan" surface="light" hide-at="sm" :count="$portfolios->count()" />
                    </div>
                @else
                    <div x-data="mobileCarousel(2, 5500)" x-init="stopped = true">
                        <div x-ref="slider"
                             tabindex="0"
                             role="region"
                             aria-label="Portofolio layanan komersial B2B"
                             @scroll.passive="onScroll()"
                             @touchstart="pause()"
                             @touchend="resume()"
                             @touchcancel="resume()"
                             class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-4 -mx-4 px-4 pb-2 sm:mx-0 sm:px-0 sm:grid sm:grid-cols-2 sm:gap-4 sm:overflow-visible sm:pb-0">
                            <article class="w-[84vw] max-w-[330px] sm:w-auto sm:max-w-none shrink-0 snap-start bg-white border border-slate-200 rounded-lg overflow-hidden">
                                <div class="aspect-[16/10] bg-slate-900 border-b border-slate-200 overflow-hidden">
                                    <img src="{{ asset('images/dokumentasi/pembersihan-grease-trap-restoran.webp') }}" alt="Pembersihan grease trap dan pipa lemak dapur restoran" loading="lazy" decoding="async" class="w-full h-full object-cover">
                                </div>
                                <div class="p-4 space-y-1">
                                    <span class="text-xs font-bold text-sky-700 block">Dapur Restoran &amp; F&amp;B</span>
                                    <h3 class="text-sm font-extrabold text-slate-900">Pengikisan Kerak Lemak &amp; Grease Trap</h3>
                                    <p class="text-xs text-slate-600">Dikerjakan terjadwal di luar jam buka agar operasional dapur tetap bersih dan lancar.</p>
                                </div>
                            </article>
                            <article class="w-[84vw] max-w-[330px] sm:w-auto sm:max-w-none shrink-0 snap-start bg-white border border-slate-200 rounded-lg overflow-hidden">
                                <div class="aspect-[16/10] bg-slate-900 border-b border-slate-200 overflow-hidden">
                                    <img src="{{ asset('images/dokumentasi/proyek-pelancaran-saluran-stasiun-kai-1.webp') }}" alt="Pelancaran saluran fasilitas publik dan area komersial" loading="lazy" decoding="async" class="w-full h-full object-cover">
                                </div>
                                <div class="p-4 space-y-1">
                                    <span class="text-xs font-bold text-sky-700 block">Fasilitas Publik &amp; Gedung</span>
                                    <h3 class="text-sm font-extrabold text-slate-900">Pelancaran Jalur Induk &amp; Inspeksi CCTV</h3>
                                    <p class="text-xs text-slate-600">Dilengkapi laporan foto kondisi pipa dan berita acara penyelesaian pekerjaan.</p>
                                </div>
                            </article>
                        </div>

                        <x-customer-service.carousel-controls label="Kemitraan" surface="light" hide-at="sm" :count="2" />
                    </div>
                @endif
            </div>

            <div id="form-penawaran-b2b" class="bg-white border border-slate-200 rounded-lg p-4 sm:p-8 space-y-5">
                <div class="space-y-1.5">
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                        Form Permintaan Survei &amp; Penawaran B2B
                    </h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Kirim kebutuhan perawatan berkala atau penanganan darurat gedung Anda. Data dicatat langsung ke sistem dispatcher PT Jawa Jaya Rooter.
                    </p>
                </div>

                @if(session('success'))
                    <div class="rounded-lg bg-emerald-50 border border-emerald-300 p-5 space-y-3" role="status">
                        <div>
                            <h3 class="text-sm font-bold text-emerald-900">Permohonan B2B Diterima</h3>
                            <p class="text-sm text-emerald-800 mt-1">{{ session('success') }}</p>
                        </div>
                        @if(session('direct_wa_url'))
                            <a href="{{ session('direct_wa_url') }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="min-h-11 inline-flex items-center px-4 py-2.5 rounded-md bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-bold">
                                Lanjut Konfirmasi via WhatsApp Desk LinkedIn
                            </a>
                        @endif
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.submit') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="source_channel" value="linkedin">

                    <div class="hidden" aria-hidden="true">
                        <label for="linkedin_website_url">Website URL</label>
                        <input type="text" name="website_url" id="linkedin_website_url" autocomplete="off" tabindex="-1">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="linkedin_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Nama PIC / Perusahaan <span class="text-rose-700">*</span>
                            </label>
                            <input id="linkedin_name"
                                   type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required
                                   placeholder="Nama Anda atau Nama Perusahaan"
                                   class="w-full min-h-11 rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-base sm:text-sm text-slate-900 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                            @error('name')
                                <p class="text-xs text-rose-700 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="linkedin_phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Nomor WhatsApp / Telepon <span class="text-rose-700">*</span>
                            </label>
                            <input id="linkedin_phone"
                                   type="tel"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   required
                                   placeholder="0812xxxxxxxx"
                                   class="w-full min-h-11 rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-base sm:text-sm text-slate-900 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                            @error('phone')
                                <p class="text-xs text-rose-700 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @php
                        $linkedinCityGroups = array_values(array_map(static fn (array $prov): array => [
                            'label' => (string) ($prov['name'] ?? ''),
                            'options' => array_values(array_map(static fn (array $city): array => [
                                'value' => (string) ($city['name'] ?? ''),
                                'label' => (string) ($city['name'] ?? ''),
                            ], $prov['cities'] ?? [])),
                        ], $provinces));
                        $linkedinPropertyOptions = [
                            ['value' => 'Restoran Kafe FNB', 'label' => 'Restoran, Kafe & F&B'],
                            ['value' => 'Gedung Perkantoran / Hotel', 'label' => 'Gedung Perkantoran & Hotel'],
                            ['value' => 'Ruko Bisnis & Rukan', 'label' => 'Ruko Bisnis & Ritel'],
                            ['value' => 'Apartemen Kondominium', 'label' => 'Apartemen & Kondominium'],
                            ['value' => 'Pabrik & Industri', 'label' => 'Pabrik & Kawasan Industri'],
                        ];
                    @endphp
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label for="linkedin_city" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Kota Lokasi Proyek
                            </label>
                            <x-ui.compact-select
                                id="linkedin_city"
                                name="city"
                                :value="old('city', '')"
                                :groups="$linkedinCityGroups"
                                placeholder="Pilih kota terdekat"
                                :searchable="true"
                                search-placeholder="Cari kota proyek..."
                            />
                        </div>
                        <div>
                            <label for="linkedin_district" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Kawasan / Kecamatan
                            </label>
                            <input id="linkedin_district"
                                   type="text"
                                   name="district"
                                   value="{{ old('district') }}"
                                   placeholder="Contoh: SCBD / Cikarang / Kuningan"
                                   class="w-full h-10 rounded-md border border-slate-300 bg-white px-3 py-1.5 text-xs sm:text-sm text-slate-900 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label for="linkedin_service_type" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Lingkup Pekerjaan
                            </label>
                            <x-ui.compact-select
                                id="linkedin_service_type"
                                name="service_type"
                                :value="old('service_type', $linkedinProblems[0] ?? '')"
                                :options="$linkedinProblems"
                                :allow-clear="false"
                            />
                        </div>
                        <div>
                            <label for="linkedin_property_type" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Sektor Properti
                            </label>
                            <x-ui.compact-select
                                id="linkedin_property_type"
                                name="property_type"
                                :value="old('property_type', 'Restoran Kafe FNB')"
                                :options="$linkedinPropertyOptions"
                                :allow-clear="false"
                            />
                        </div>
                    </div>

                    <div>
                        <label for="linkedin_message" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Rincian Kebutuhan &amp; Jadwal Kerja <span class="text-rose-700">*</span>
                        </label>
                        <textarea id="linkedin_message"
                                  name="message"
                                  rows="4"
                                  required
                                  placeholder="Jelaskan jumlah titik saluran, kebutuhan pengerjaan after-hours, atau permintaan e-Faktur &amp; SPK..."
                                  class="w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-base sm:text-sm text-slate-900 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-xs text-rose-700 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="w-full min-h-12 inline-flex items-center justify-center px-6 py-3 rounded-lg bg-sky-700 hover:bg-sky-800 text-white text-sm sm:text-base font-extrabold transition-colors cursor-pointer focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 focus-visible:ring-offset-2">
                        Kirim Permohonan Penawaran B2B
                    </button>
                </form>
            </div>
        </div>

        <aside class="lg:col-span-5 lg:sticky lg:top-24 space-y-5">
            <x-customer-service.wa-area-builder
                layout="card"
                channel-code="linkedin"
                channel-slug="linkedin"
                channel-name="LinkedIn"
                :whatsapp-number="$whatsappNumber"
                :region-selector-data="$regionSelectorData"
                :problem-options="$linkedinProblems"
                heading="Kirim Permintaan B2B ke Admin LinkedIn"
                subheading="Pilih kota proyek dan sistem saluran komersial untuk chat langsung via WhatsApp."
                track-location="cs_linkedin_hero"
                surface="light"
            />

            <div class="bg-white border border-slate-200 rounded-lg p-4 sm:p-5 space-y-3 text-xs sm:text-sm text-slate-700">
                <h3 class="text-sm font-extrabold text-slate-900">Korespondensi Resmi Perusahaan</h3>
                <div>
                    <span class="font-bold text-slate-900 block">Email Pengadaan &amp; Penawaran:</span>
                    <a href="mailto:{{ config('services.company.email', 'drainusantara@gmail.com') }}" class="min-h-11 inline-flex items-center break-all text-sky-700 font-semibold hover:underline">
                        {{ config('services.company.email', 'drainusantara@gmail.com') }}
                    </a>
                </div>
                <div>
                    <span class="font-bold text-slate-900 block">Kantor Pusat PT Jawa Jaya Rooter:</span>
                    <span>Jl. Manunggal XVII No. 104, Lubang Buaya, Cipayung, Kota Jakarta Timur 13810</span>
                </div>
            </div>
        </aside>
    </div>
</section>

<x-customer-service.channel-faq
    :faqs="$channel['faqs']"
    :other-channels="$otherChannels"
    heading="Tanya Jawab Pengadaan & Layanan Korporat"
    subheading="Kelengkapan legalitas PT Jawa Jaya Rooter, penjadwalan malam hari, dan kontrak perawatan berkala."
    channel-slug="linkedin"
    variant="split"
/>
@endsection
