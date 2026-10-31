@extends('layouts.app')

@php
    $whatsappNumber = config('app.whatsapp_number', '6285609009009');
    $waUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode("Halo Drainusantara, saya mengalami masalah saluran mirip studi kasus {$caseStudy->title} di {$caseStudy->location}. Mohon info ketersediaan teknisi.");

    $propList = is_array($caseStudy->property_type) 
        ? $caseStudy->property_type 
        : (is_string($caseStudy->property_type) ? (json_decode($caseStudy->property_type, true) ?? array_filter(array_map('trim', explode(',', $caseStudy->property_type)))) : []);
    $propertyTypes = is_array($propList) ? array_values(array_filter($propList)) : [];

    $probList = is_array($caseStudy->problem_type) 
        ? $caseStudy->problem_type 
        : (is_string($caseStudy->problem_type) ? (json_decode($caseStudy->problem_type, true) ?? array_filter(array_map('trim', explode(',', $caseStudy->problem_type)))) : []);
    $problemTypes = is_array($probList) ? array_values(array_filter($probList)) : [];

    $severityRaw = strtolower(trim((string) ($caseStudy->severity ?? 'sedang')));
    $severityLabel = ucfirst($severityRaw);
    if ($severityRaw === 'berat') {
        $severityBadgeClass = 'bg-amber-50 text-amber-800 border-amber-200';
    } elseif ($severityRaw === 'ringan') {
        $severityBadgeClass = 'bg-emerald-50 text-emerald-800 border-emerald-200';
    } else {
        $severityBadgeClass = 'bg-amber-50 text-amber-800 border-amber-200';
    }

    $equipmentList = $caseStudy->equipment ?? collect();
    $equipmentNames = $equipmentList->pluck('name')->filter()->values()->all();

    $rawImage = $caseStudy->before_image ?: ($caseStudy->image ?: $caseStudy->after_image);
    $articleImageUrl = $rawImage 
        ? (filter_var($rawImage, FILTER_VALIDATE_URL) ? $rawImage : asset($rawImage)) 
        : asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp');

    $articleJsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $caseStudy->title,
        'description' => \Illuminate\Support\Str::limit(strip_tags($caseStudy->description ?? ''), 160),
        'image' => $articleImageUrl,
        'datePublished' => optional($caseStudy->created_at)->toIso8601String() ?? now()->toIso8601String(),
        'dateModified' => optional($caseStudy->updated_at)->toIso8601String() ?? optional($caseStudy->created_at)->toIso8601String(),
        'author' => [
            '@type' => 'Organization',
            'name' => 'Drainusantara',
            'url' => url('/'),
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Drainusantara',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('images/logo/WebIcon.webp'),
            ],
        ],
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => url()->current(),
        ],
    ];

    if (!empty($equipmentNames)) {
        $articleJsonLd['about'] = [
            '@type' => 'ItemList',
            'itemListElement' => array_map(function ($name, $index) {
                return [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $name,
                ];
            }, $equipmentNames, array_keys($equipmentNames)),
        ];
    }
@endphp

@push('head')
<script type="application/ld+json">
{!! json_encode($articleJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR) !!}
</script>
@endpush

@push('styles')
<style>
    @media (max-width: 1023px) {
        .mobile-nav-dock { display: none !important; }
    }
</style>
@endpush

@section('content')
<article class="bg-white text-slate-800">
    <!-- 1. HERO SECTION -->
    <header class="bg-slate-50 border-b border-slate-200 pt-8 pb-12 lg:pt-12 lg:pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-5 font-medium overflow-x-auto no-scrollbar" aria-label="Breadcrumb">
                <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5 shrink-0">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Beranda</span>
                </a>
                <span class="text-slate-300" aria-hidden="true">/</span>
                <a href="{{ route('gallery') }}" class="hover:text-sky-700 transition-colors shrink-0">
                    <span>Studi Kasus</span>
                </a>
                <span class="text-slate-300" aria-hidden="true">/</span>
                <span class="text-slate-800 truncate font-semibold" aria-current="page">{{ $caseStudy->title }}</span>
            </nav>

            <!-- Context Eyebrow -->
            <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-2">
                Dokumentasi Teknis Lapangan
            </p>

            <!-- H1 -->
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight max-w-3xl leading-tight">
                {{ $caseStudy->title }}
            </h1>

            <!-- Subheadline -->
            @if(!empty($caseStudy->description))
                <p class="mt-3 text-sm text-slate-600 max-w-2xl leading-relaxed">
                    {{ \Illuminate\Support\Str::limit(strip_tags($caseStudy->description), 150) }}
                </p>
            @endif

            <!-- Metadata Line -->
            <div class="mt-4 flex flex-wrap items-center gap-x-3 gap-y-1.5 text-xs text-slate-600 font-medium">
                @if(!empty($caseStudy->location))
                    <span class="text-slate-900 font-semibold flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-sky-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ $caseStudy->location }}</span>
                    </span>
                    <span class="text-slate-300" aria-hidden="true">&bull;</span>
                @endif

                @if(!empty($propertyTypes))
                    <span>{{ implode(', ', $propertyTypes) }}</span>
                    <span class="text-slate-300" aria-hidden="true">&bull;</span>
                @endif

                <span class="text-slate-900 font-semibold">Tingkat {{ $severityLabel }}</span>

                @if($caseStudy->service)
                    <span class="text-slate-300" aria-hidden="true">&bull;</span>
                    <span class="text-sky-800 font-semibold">{{ $caseStudy->service->name }}</span>
                @endif
            </div>
        </div>
    </header>

    <!-- 2. BEFORE/AFTER IMAGES SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10" aria-label="Foto Dokumentasi Sebelum dan Sesudah Pengerjaan">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kiri: Foto Sebelum -->
            <div class="relative rounded-lg border border-slate-200 overflow-hidden bg-slate-100 shadow-2xs">
                <span class="absolute top-3 left-3 z-10 text-[11px] font-bold uppercase tracking-wider bg-slate-900/90 text-white px-2.5 py-1 rounded-sm">
                    Kondisi Awal
                </span>
                @if(!empty($caseStudy->before_image))
                    <img src="{{ $caseStudy->before_image }}" 
                         alt="Foto sebelum pengerjaan: {{ !empty($problemTypes) ? implode(', ', $problemTypes) : 'kendala saluran pipa mampet' }} di {{ $caseStudy->location ?: 'lokasi kerja' }}"
                         width="800" 
                         height="600" 
                         loading="eager" 
                         decoding="async" 
                         class="object-cover w-full aspect-[4/3]">
                @else
                    <div class="w-full aspect-[4/3] bg-slate-100 flex flex-col items-center justify-center text-slate-400 p-6 text-center">
                        <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs font-semibold text-slate-500">Foto sebelum pengerjaan belum tersedia</span>
                    </div>
                @endif
                <div class="bg-white px-3.5 py-2 border-t border-slate-200 text-[11px] text-slate-600 flex items-center justify-between">
                    <span class="font-medium text-slate-700">Titik Masalah: {{ !empty($problemTypes) ? implode(', ', $problemTypes) : 'Saluran Mampet' }}</span>
                    <span class="text-rose-600 font-semibold">Tersumbat Total</span>
                </div>
            </div>

            <!-- Kanan: Foto Sesudah -->
            <div class="relative rounded-lg border border-slate-200 overflow-hidden bg-slate-100 shadow-2xs">
                <span class="absolute top-3 left-3 z-10 text-[11px] font-bold uppercase tracking-wider bg-slate-900/90 text-white px-2.5 py-1 rounded-sm">
                    Hasil Akhir
                </span>
                @if(!empty($caseStudy->after_image))
                    <img src="{{ $caseStudy->after_image }}" 
                         alt="Foto sesudah pengerjaan: saluran lancar tuntas di {{ $caseStudy->location ?: 'lokasi kerja' }}"
                         width="800" 
                         height="600" 
                         loading="lazy" 
                         decoding="async" 
                         class="object-cover w-full aspect-[4/3]">
                @else
                    <div class="w-full aspect-[4/3] bg-slate-100 flex flex-col items-center justify-center text-slate-400 p-6 text-center">
                        <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs font-semibold text-slate-500">Foto sesudah pengerjaan belum tersedia</span>
                    </div>
                @endif
                <div class="bg-white px-3.5 py-2 border-t border-slate-200 text-[11px] text-slate-600 flex items-center justify-between">
                    <span class="font-medium text-slate-700">Metode: Spiral Baja Mekanis Rotary</span>
                    <span class="text-emerald-700 font-semibold">Aliran Air Lancar 100%</span>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTENT BODY: 2-COLUMN ON LG (CONTENT + SIDEBAR 320PX) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 lg:pb-16">
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-8 items-start">
            
            <!-- KOLOM UTAMA (DATA TEKNIS, ALAT, NARASI) -->
            <div class="min-w-0 space-y-10">
                
                <!-- 3. LEMBAR DATA TEKNIS & DIAGNOSIS -->
                <section class="bg-white rounded-lg border border-slate-200 p-5 sm:p-6 shadow-2xs" aria-label="Lembar Kerja Teknis Lapangan">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 pb-4 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-md bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-slate-900 tracking-tight">Lembar Data Teknis &amp; Diagnosis Pengerjaan</h2>
                                <p class="text-[11px] text-slate-500">Spesifikasi penanganan di lokasi hunian / tempat usaha</p>
                            </div>
                        </div>
                        <span class="text-xs font-semibold text-emerald-700 flex items-center gap-1.5 self-start sm:self-auto">
                            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span>Metode Tanpa Bongkar Lantai</span>
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-5 gap-x-6 text-xs">
                        <!-- Titik & Area Kerja -->
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Titik &amp; Area Kerja</span>
                            <p class="text-sm font-semibold text-slate-900">{{ $caseStudy->location ?: 'Area Layanan Terdaftar' }}</p>
                        </div>

                        <!-- Tipe Properti -->
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Tipe Properti</span>
                            <p class="text-sm font-semibold text-slate-900">{{ !empty($propertyTypes) ? implode(', ', $propertyTypes) : '-' }}</p>
                        </div>

                        <!-- Jenis Hambatan -->
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Diagnosis Hambatan</span>
                            <p class="text-sm font-semibold text-slate-900">{{ !empty($problemTypes) ? implode(', ', $problemTypes) : 'Pipa Tersumbat' }}</p>
                        </div>

                        <!-- Tingkat Keparahan -->
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Tingkat Hambatan</span>
                            <p class="text-sm font-semibold text-slate-900">Tingkat {{ $severityLabel }}</p>
                        </div>

                        <!-- Durasi Pengerjaan -->
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Durasi Pengerjaan</span>
                            <p class="text-sm font-semibold text-slate-900">{{ $caseStudy->duration ?: 'Estimasi 1 - 2 Jam' }}</p>
                        </div>

                        <!-- Kategori Layanan -->
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Kategori Layanan</span>
                            <p class="text-sm font-semibold text-slate-900">{{ optional($caseStudy->service)->name ?: 'Spesialis Pipa' }}</p>
                        </div>
                    </div>

                    <!-- Technical Guarantee Banner -->
                    <div class="mt-6 pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-600 bg-slate-50 -mx-5 sm:-mx-6 -mb-5 sm:-mb-6 p-4 rounded-b-lg border-t">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                            <span><strong>Garansi Nota 30 Hari:</strong> Jika saluran mampet kembali dalam masa garansi, teknisi datang tanpa biaya.</span>
                        </div>
                        <span class="text-[11px] text-slate-500 font-medium">Bebas Soda Api & Kimia Korosif</span>
                    </div>
                </section>

                <!-- 4. ALAT/MESIN DIGUNAKAN -->
                @if($equipmentList->isNotEmpty())
                <section aria-label="Peralatan yang Digunakan">
                    <h2 class="text-lg sm:text-xl font-bold text-slate-900 mb-5">
                        Peralatan yang Digunakan
                    </h2>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($equipmentList as $tool)
                        <div class="bg-slate-50 rounded-lg border border-slate-200 p-3 flex flex-col items-center text-center shadow-2xs hover:border-slate-300 transition-colors">
                            <div class="w-16 h-16 bg-white rounded-md border border-slate-200 flex items-center justify-center p-1 mb-2 overflow-hidden shrink-0">
                                @if(!empty($tool->image))
                                    <img src="{{ $tool->image }}" 
                                         alt="Peralatan kerja: {{ $tool->name }}"
                                         width="64"
                                         height="64"
                                         loading="lazy"
                                         decoding="async"
                                         class="w-16 h-16 object-contain">
                                @else
                                    <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    </svg>
                                @endif
                            </div>
                            <h3 class="text-xs font-bold text-slate-900 leading-snug">{{ $tool->name }}</h3>
                            @if(!empty($tool->short_description))
                                <p class="text-[11px] text-slate-600 line-clamp-2 mt-1 leading-tight">{{ $tool->short_description }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif

                <!-- 5. KONTEN NARATIF -->
                <section class="pt-2" aria-label="Narasi Pelaksanaan Lapangan">
                    <h2 class="text-lg sm:text-xl font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">
                        Catatan Teknis Pengerjaan
                    </h2>
                    @if(!empty($caseStudy->content))
                        <div class="prose prose-slate prose-sm sm:prose-base max-w-none text-slate-700 leading-relaxed">
                            {!! nl2br(e($caseStudy->content)) !!}
                        </div>
                    @else
                        <p class="text-slate-700 text-sm sm:text-base leading-relaxed">
                            {{ $caseStudy->description ?: 'Dokumentasi penanganan saluran pipa tersumbat oleh teknisi Drainusantara menggunakan mesin mekanis spiral baja dan peralatan pendukung berstandar teknis.' }}
                        </p>
                    @endif
                </section>

            </div>

            <!-- 6. SIDEBAR CTA (DESKTOP: STICKY) -->
            <aside class="hidden lg:block lg:sticky lg:top-24">
                <div class="bg-white rounded-lg border border-slate-200 p-5 space-y-4 shadow-2xs">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-sky-800 mb-1">
                            Konsultasi Teknis
                        </p>
                        <h3 class="text-sm font-bold text-slate-900 leading-snug">Saluran Mengalami Kendala Serupa?</h3>
                        <p class="mt-1.5 text-xs text-slate-600 leading-relaxed">
                            Konsultasikan titik mampet saluran Anda. Teknisi Drainusantara siaga meluncur dengan mesin spiral baja rotary tanpa membongkar lantai hunian Anda.
                        </p>
                    </div>

                    <a href="{{ $waUrl }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-sm rounded-lg px-5 py-3 min-h-[48px] w-full flex items-center justify-center gap-2 transition-colors shadow-2xs focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-500">
                        <!-- WhatsApp SVG Icon -->
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Hubungi Teknisi via WA</span>
                    </a>

                    <div class="pt-3 border-t border-slate-100 space-y-2 text-[11px] text-slate-500">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Dikerjakan dengan mesin spiral rotary</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Proteksi garansi pengerjaan 30 hari</span>
                        </div>
                    </div>
                </div>
            </aside>

        </div>
    </div>

    <!-- 6. MOBILE FIXED BOTTOM CTA BAR (< lg) -->
    <div class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-white border-t border-slate-200 px-4 py-3 shadow-md" aria-label="Aksi Cepat Mobile">
        <div class="max-w-md mx-auto flex items-center justify-between gap-3">
            <div class="min-w-0 flex-1">
                <p class="text-xs font-bold text-slate-900 truncate">Saluran Mampet di Rumah Anda?</p>
                <p class="text-[11px] text-slate-600 truncate">Teknisi siaga dengan mesin spiral rotary</p>
            </div>
            <a href="{{ $waUrl }}" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="shrink-0 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs rounded-lg px-4 py-2.5 min-h-[48px] flex items-center justify-center gap-2 shadow-xs transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-500">
                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                <span>Hubungi WA</span>
            </a>
        </div>
    </div>

    <!-- 7. RELATED CASE STUDIES SECTION -->
    @if(isset($relatedCaseStudies) && $relatedCaseStudies->isNotEmpty())
    <section class="bg-slate-50 border-t border-slate-200 py-12" aria-label="Studi Kasus Lainnya">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 text-center mb-8">
                Studi Kasus Lainnya
            </h2>
            
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($relatedCaseStudies as $item)
                @php
                    $thumb = $item->before_image ?: ($item->image ?: $item->after_image);
                @endphp
                <x-case-study-card 
                    :slug="$item->slug" 
                    :title="$item->title" 
                    :location="$item->location" 
                    :propertyTypes="$item->property_type" 
                    :beforeImage="$thumb" 
                    :duration="$item->duration" 
                    :problemTypes="$item->problem_type" 
                />
            @endforeach
        </div>
        </div>
    </section>
    @endif
</article>
@endsection

