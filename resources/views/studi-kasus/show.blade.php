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
                    <span>Galeri Pengerjaan</span>
                </a>
                <span class="text-slate-300" aria-hidden="true">/</span>
                <span class="text-slate-800 truncate font-semibold" aria-current="page">{{ $caseStudy->title }}</span>
            </nav>

            <!-- Context Eyebrow -->
            <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-2">
                Studi Kasus &amp; Dokumentasi Lapangan
            </p>

            <!-- H1 -->
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight max-w-4xl leading-tight">
                {{ $caseStudy->title }}
            </h1>

            <!-- Subheadline -->
            @if(!empty($caseStudy->description))
                <p class="mt-3 text-sm text-slate-600 max-w-3xl leading-relaxed">
                    {{ \Illuminate\Support\Str::limit(strip_tags($caseStudy->description), 200) }}
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

                <span class="text-sky-800 font-semibold">{{ $caseStudy->category_label }}</span>
                <span class="text-slate-300" aria-hidden="true">&bull;</span>

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

    <!-- 2. FOTO DOKUMENTASI (BEFORE-AFTER ATAU SINGLE FOTO CMS) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10" aria-label="Foto Dokumentasi Pengerjaan">
        @if($caseStudy->hasBeforeAfter())
            <!-- JIKA ADA FOTO BEFORE & AFTER: TAMPILKAN KOMPARASI 2 KOLOM -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kiri: Foto Sebelum -->
                <div class="relative rounded-lg border border-slate-200 overflow-hidden bg-slate-900 shadow-2xs group cursor-zoom-in"
                     onclick="if(window.__openLightbox){window.__openLightbox('{{ $caseStudy->before_image }}', 'Kondisi Awal (Tersumbat) - {{ addslashes($caseStudy->title) }}');}"
                     title="Klik untuk memperbesar foto kondisi awal">
                    <span class="absolute top-3 left-3 z-10 text-[11px] font-bold uppercase tracking-wider bg-rose-900/90 text-white px-2.5 py-1 rounded-sm shadow-xs">
                        Kondisi Awal (Tersumbat)
                    </span>
                    <img src="{{ $caseStudy->before_image }}" 
                         alt="Foto sebelum pengerjaan: {{ !empty($problemTypes) ? implode(', ', $problemTypes) : 'kendala saluran pipa mampet' }} di {{ $caseStudy->location ?: 'lokasi kerja' }}"
                         width="800" 
                         height="600" 
                         loading="eager" 
                         decoding="async" 
                         class="object-cover w-full aspect-[4/3] group-hover:scale-[1.02] transition-transform duration-300">
                    <div class="absolute bottom-12 right-3 z-10 bg-slate-900/80 backdrop-blur-xs text-white text-[10px] font-semibold px-2.5 py-1 rounded-md border border-white/20 flex items-center gap-1 shadow-xs pointer-events-none">
                        <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                        <span>Perbesar</span>
                    </div>
                    <div class="bg-white px-3.5 py-2.5 border-t border-slate-200 text-xs text-slate-700 flex items-center justify-between">
                        <span class="font-medium text-slate-800">Titik Masalah: {{ $caseStudy->drain_type ?: (!empty($problemTypes) ? implode(', ', $problemTypes) : 'Saluran Pipa') }}</span>
                        <span class="text-rose-700 font-bold">Mampet Total</span>
                    </div>
                </div>

                <!-- Kanan: Foto Sesudah -->
                <div class="relative rounded-lg border border-slate-200 overflow-hidden bg-slate-900 shadow-2xs group cursor-zoom-in"
                     onclick="if(window.__openLightbox){window.__openLightbox('{{ $caseStudy->after_image }}', 'Hasil Akhir (Lancar) - {{ addslashes($caseStudy->title) }}');}"
                     title="Klik untuk memperbesar foto hasil akhir">
                    <span class="absolute top-3 left-3 z-10 text-[11px] font-bold uppercase tracking-wider bg-emerald-900/90 text-white px-2.5 py-1 rounded-sm shadow-xs">
                        Hasil Akhir (Lancar)
                    </span>
                    <img src="{{ $caseStudy->after_image }}" 
                         alt="Foto sesudah pengerjaan: saluran lancar tuntas di {{ $caseStudy->location ?: 'lokasi kerja' }}"
                         width="800" 
                         height="600" 
                         loading="lazy" 
                         decoding="async" 
                         class="object-cover w-full aspect-[4/3] group-hover:scale-[1.02] transition-transform duration-300">
                    <div class="absolute bottom-12 right-3 z-10 bg-slate-900/80 backdrop-blur-xs text-white text-[10px] font-semibold px-2.5 py-1 rounded-md border border-white/20 flex items-center gap-1 shadow-xs pointer-events-none">
                        <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                        <span>Perbesar</span>
                    </div>
                    <div class="bg-white px-3.5 py-2.5 border-t border-slate-200 text-xs text-slate-700 flex items-center justify-between">
                        <span class="font-medium text-slate-800">Metode: {{ $caseStudy->method ?: 'Spiral Rotary Ridgid' }}</span>
                        <span class="text-emerald-700 font-bold">Aliran Air Lancar 100%</span>
                    </div>
                </div>
            </div>
        @elseif($caseStudy->main_image)
            <!-- JIKA TIDAK ADA BEFORE-AFTER: TAMPILKAN 1 FOTO UTAMA CMS SECARA TERPUSAT -->
            <div class="max-w-4xl mx-auto">
                <div class="relative rounded-lg border border-slate-200 overflow-hidden bg-slate-900 shadow-2xs group cursor-zoom-in"
                     onclick="if(window.__openLightbox){window.__openLightbox('{{ $caseStudy->main_image }}', 'Dokumentasi: {{ addslashes($caseStudy->title) }}');}"
                     title="Klik untuk memperbesar foto dokumentasi">
                    <img src="{{ $caseStudy->main_image }}" 
                         alt="Foto dokumentasi: {{ $caseStudy->title }} di {{ $caseStudy->location ?: 'lokasi kerja' }}"
                         width="1200" 
                         height="700" 
                         loading="eager" 
                         decoding="async" 
                         class="object-cover w-full max-h-[500px] group-hover:scale-[1.01] transition-transform duration-300">
                    <div class="absolute bottom-12 right-3 z-10 bg-slate-900/80 backdrop-blur-xs text-white text-[10px] font-semibold px-2.5 py-1 rounded-md border border-white/20 flex items-center gap-1 shadow-xs pointer-events-none">
                        <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                        <span>Perbesar</span>
                    </div>
                    <div class="bg-white px-4 py-2.5 border-t border-slate-200 text-xs text-slate-700 flex flex-wrap items-center justify-between gap-2">
                        <span class="font-medium text-slate-800 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Foto Dokumentasi Pelaksanaan Teknis di Lapangan</span>
                        </span>
                    </div>
                </div>
            </div>
        @else
            <!-- PLACEHOLDER JIKA BELUM ADA FOTO -->
            <div class="max-w-4xl mx-auto">
                <div class="w-full aspect-[21/9] rounded-lg border border-slate-200 bg-slate-50 flex flex-col items-center justify-center text-slate-400 p-6 text-center">
                    <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-xs font-semibold text-slate-500">Dokumentasi Teknis Lapangan Drainusantara</span>
                </div>
            </div>
        @endif
    </section>

    <!-- CONTENT BODY: 2-COLUMN ON LG (CONTENT + SIDEBAR 320PX) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 lg:pb-16">
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-8 items-start">
            
            <!-- KOLOM UTAMA (DATA TEKNIS, ALAT, NARASI) -->
            <div class="min-w-0 space-y-10">
                
                <!-- 3. LEMBAR DATA TEKNIS & DIAGNOSIS LENGKAP -->
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
                                <p class="text-[11px] text-slate-500">Spesifikasi komprehensif penanganan saluran di lokasi</p>
                            </div>
                        </div>
                       
                    </div>

                    <!-- Grid Data Spesifikasi Teknis -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-5 gap-x-6 text-xs">
                        
                        <!-- 1. Metode Perbaikan -->
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Metode Perbaikan</span>
                            <p class="text-sm font-semibold text-slate-900">
                                {{ $caseStudy->method ?: 'Mesin Spiral Rotary Ridgid K-50 / K-60' }}
                            </p>
                        </div>

                        <!-- 2. Saluran yang Dikerjakan -->
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Saluran yang Dikerjakan</span>
                            <p class="text-sm font-semibold text-slate-900">
                                {{ $caseStudy->drain_type ?: (optional($caseStudy->service)->name ?: 'Pipa Pembuangan Air Kotor') }}
                            </p>
                        </div>

                        <!-- 3. Layanan yang Dipilih -->
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Layanan yang Dipilih</span>
                            @if($caseStudy->service)
                                <a href="{{ url('/#layanan') }}" 
                                   class="text-sm font-semibold text-sky-700 hover:text-sky-800 underline inline-flex items-center gap-1">
                                    <span>{{ $caseStudy->service->name }}</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            @else
                                <p class="text-sm font-semibold text-slate-900">Spesialis Plumbing Pelancar Pipa</p>
                            @endif
                        </div>

                        <!-- 4. Estimasi Biaya / Harga Pengerjaan -->
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Biaya / Harga Pengerjaan</span>
                            <p class="text-sm font-bold text-slate-900">
                                {{ $caseStudy->formatted_price ?: (optional($caseStudy->service)->price ? 'Mulai ' . optional($caseStudy->service)->formatted_price : 'Estimasi Sesuai Titik') }}
                            </p>
                        </div>

                        <!-- 5. Durasi Pengerjaan -->
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Durasi Pengerjaan</span>
                            <p class="text-sm font-semibold text-slate-900">
                                {{ $caseStudy->duration ?: 'Estimasi 35 - 60 Menit' }}
                            </p>
                        </div>

                        <!-- 6. Titik & Area Kerja (Lokasi) -->
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Lokasi Pengerjaan</span>
                            <p class="text-sm font-semibold text-slate-900">
                                {{ $caseStudy->location ?: 'Area Layanan Terdaftar' }}
                            </p>
                        </div>

                        <!-- 7. Tipe Sektor & Properti -->
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Sektor &amp; Properti</span>
                            <p class="text-sm font-semibold text-slate-900">
                                {{ $caseStudy->category_label }} {{ !empty($propertyTypes) ? '(' . implode(', ', $propertyTypes) . ')' : '' }}
                            </p>
                        </div>

                        <!-- 8. Tingkat Hambatan -->
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Tingkat Hambatan</span>
                            <p class="text-sm font-semibold text-slate-900">
                                Tingkat {{ $severityLabel }}
                            </p>
                        </div>

                        <!-- 9. Garansi Pengerjaan -->
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Status Garansi</span>
                            <p class="text-sm font-semibold text-emerald-700">
                                Garansi Nota Resmi 30 Hari
                            </p>
                        </div>
                    </div>

                    <!-- Diagnosa Masalah Saluran (Box Khusus) -->
                    <div class="mt-6 p-4 rounded-lg bg-slate-50 border border-slate-200">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-700 block mb-1">
                            Diagnosa Hambatan Masalah Saluran:
                        </span>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                            {{ $caseStudy->diagnosis ?: (!empty($problemTypes) ? 'Sumbatan disebabkan oleh ' . implode(', ', $problemTypes) . ' yang menumpuk pada dinding pipa saluran pembuangan.' : 'Penumpukan kerak dan sisa residu yang menghambat laju debit air kotor di belokan pipa.') }}
                        </p>
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

            <!-- 6. SIDEBAR CTA (DESKTOP: STICKY, MOBILE: IN-FLOW) -->
            <aside class="mt-8 lg:mt-0 lg:sticky lg:top-24">
                <div class="bg-white rounded-lg border border-slate-200 p-5 space-y-4 shadow-2xs">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-sky-800 mb-1">
                            Konsultasi Teknis
                        </p>
                        <h3 class="text-sm font-bold text-slate-900 leading-snug">Saluran Mengalami Kendala Serupa?</h3>
                        <p class="mt-1.5 text-xs text-slate-600 leading-relaxed">
                            Konsultasikan titik mampet saluran Anda di {{ $caseStudy->location ?: 'lokasi Anda' }}. Teknisi Drainusantara siaga meluncur dengan mesin spiral rotary tanpa membongkar keramik.
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
                            <span>Dikerjakan mesin spiral rotary Ridgid</span>
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

    <!-- 7. RELATED CASE STUDIES SECTION -->
    @if(isset($relatedCaseStudies) && $relatedCaseStudies->isNotEmpty())
    <section class="bg-slate-50 border-t border-slate-200 py-12" aria-label="Studi Kasus Lainnya">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 text-center mb-8">
                Studi Kasus Lainnya
            </h2>
            
            <div class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-4 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0 sm:grid sm:grid-cols-2 lg:grid-cols-3 sm:gap-6 sm:overflow-visible sm:pb-0">
                @foreach($relatedCaseStudies as $item)
                    @php
                        $thumb = $item->image ?: ($item->after_image ?: $item->before_image);
                    @endphp
                    <div class="w-[82vw] max-w-[340px] shrink-0 snap-center sm:w-auto h-full flex flex-col">
                        <x-case-study-card 
                            :slug="$item->slug" 
                            :title="$item->title" 
                            :location="$item->location" 
                            :propertyTypes="$item->property_type" 
                            :beforeImage="$thumb" 
                            :duration="$item->duration" 
                            :problemTypes="$item->problem_type" 
                            :category="$item->category_label"
                            :drainType="$item->drain_type"
                        />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <x-media.lightbox-viewer />
</article>
@endsection
