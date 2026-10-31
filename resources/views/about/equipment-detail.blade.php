@extends('layouts.app')

@section('content')
<!-- 1. Breadcrumbs & Hero Header -->
<header class="bg-slate-900 border-b border-slate-800 text-white py-10 lg:py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb Navigation -->
        <nav aria-label="Breadcrumb" class="mb-6">
            <ol class="flex items-center flex-wrap gap-2 text-xs text-slate-400">
                <li>
                    <a href="{{ url('/') }}" class="hover:text-white transition-colors">Beranda</a>
                </li>
                <li aria-hidden="true" class="text-slate-600">/</li>
                <li>
                    <a href="{{ route('about') }}" class="hover:text-white transition-colors">Tentang Kami</a>
                </li>
                <li aria-hidden="true" class="text-slate-600">/</li>
                <li>
                    <a href="{{ route('about.equipment') }}" class="hover:text-white transition-colors">Peralatan &amp; Teknologi</a>
                </li>
                <li aria-hidden="true" class="text-slate-600">/</li>
                <li class="text-sky-400 font-semibold line-clamp-1 max-w-xs sm:max-w-md" aria-current="page">
                    {{ $equipment->name }}
                </li>
            </ol>
        </nav>

        <div class="max-w-4xl">
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-3 flex-wrap">
                <span class="text-sky-400 uppercase tracking-wider">{{ $equipment->category ?? 'Unit Armada' }}</span>
                @if($equipment->badge)
                    <span class="text-slate-600" aria-hidden="true">&bull;</span>
                    <span class="text-slate-300">{{ $equipment->badge }}</span>
                @endif
                <span class="text-slate-600" aria-hidden="true">&bull;</span>
            </div>

            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight">
                {{ $equipment->name }}
            </h1>

            @if($equipment->short_description)
            <p class="text-slate-300 text-sm sm:text-base mt-4 leading-relaxed max-w-3xl">
                {{ $equipment->short_description }}
            </p>
            @endif
        </div>
    </div>
</header>

@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6285609009009';
    $waText = "Halo Admin Drainusantara, saya ingin konsultasi penanganan saluran menggunakan unit {$equipment->name}. Mohon info estimasi biaya dan jadwal kedatangan teknisi.";
    $waUrl = "https://wa.me/{$whatsappNumber}?text=" . rawurlencode($waText);
@endphp

<!-- 2. Main Content & Sidebar -->
<main class="py-12 lg:py-16 bg-slate-50 border-b border-slate-200" id="main-content">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12 items-start">
            
            <!-- Left Column: Detailed Technical Content (lg:col-span-2) -->
            <div class="lg:col-span-2 space-y-10">
                
                <!-- High-Res Equipment Image Container -->
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs">
                    <div class="relative aspect-16/10 bg-slate-900 overflow-hidden group">
                        <img 
                            src="{{ $equipment->image ?: asset('assets/TOOLKIT/mesin-rooter-ridgid-k50-spiral-baja.webp') }}" 
                            alt="{{ $equipment->name }}" 
                            width="1200" 
                            height="750" 
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-102"
                            onerror="this.onerror=null; this.src='{{ asset('assets/TOOLKIT/mesin-rooter-ridgid-k50-spiral-baja.webp') }}';">
                    </div>
                </div>

                <!-- Prinsip Kerja Mekanis & Deskripsi Mendalam -->
                <section class="bg-white rounded-xl border border-slate-200 p-6 sm:p-8 shadow-2xs space-y-4">
                    <div class="border-b border-slate-100 pb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-1">
                            Mekanisme Kerja
                        </span>
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                            Prinsip Kerja &amp; Penanganan Tanpa Bongkar
                        </h2>
                    </div>

                    <div class="text-slate-700 text-sm sm:text-base leading-relaxed space-y-3 prose prose-slate max-w-none">
                        @if($equipment->description)
                            {!! nl2br(e($equipment->description)) !!}
                        @else
                            <p>
                                Unit <strong>{{ $equipment->name }}</strong> adalah mesin spesialis yang digunakan teknisi Drainusantara untuk melancarkan saluran pembuangan air secara mekanis murni. Tanpa mengandalkan cairan kimia asam atau soda api yang merusak sambungan pipa PVC.
                            </p>
                            <p>
                                Bekerja langsung melalui lubang pipa eksisting (leher angsa wastafel, floor drain, atau lubang kloset), mesin ini mampu menembus titik sumbatan hingga puluhan meter tanpa merusak lantai keramik bangunan Anda.
                            </p>
                        @endif
                    </div>
                </section>

                <!-- Fitur Utama & Keunggulan Mesin -->
                @php
                    $features = $equipment->features_list;
                @endphp
                @if(!empty($features))
                <section class="bg-white rounded-xl border border-slate-200 p-6 sm:p-8 shadow-2xs space-y-5">
                    <div class="border-b border-slate-100 pb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-1">
                            Keunggulan Mesin
                        </span>
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                            Fitur &amp; Kemampuan Teknis Lapangan
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        @foreach($features as $feature)
                        <div class="flex items-start gap-3 p-3.5 rounded-lg bg-slate-50 border border-slate-200/80">
                            <div class="w-5 h-5 rounded-full text-sky-700 flex items-center justify-center shrink-0 mt-0.5" aria-hidden="true">
                               <span>&#11044;</span>
                            </div>
                            <span class="text-xs sm:text-sm text-slate-800 font-medium leading-snug">
                                {{ $feature }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif

                <!-- Skenario Aplikasi Titik Saluran -->
                @php
                    $applications = $equipment->applications_list;
                @endphp
                @if(!empty($applications))
                <section class="bg-white rounded-xl border border-slate-200 p-6 sm:p-8 shadow-2xs space-y-5">
                    <div class="border-b border-slate-100 pb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-1">
                            Skenario Masalah
                        </span>
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                            Aplikasi Titik Saluran yang Ditangani
                        </h2>
                    </div>

                    <ul class="space-y-2.5">
                        @foreach($applications as $app)
                        <li class="flex items-start gap-3 text-xs sm:text-sm text-slate-700">
                            <span class="w-2 h-2 rounded-full bg-sky-700 mt-1.5 shrink-0" aria-hidden="true"></span>
                            <span>{{ $app }}</span>
                        </li>
                        @endforeach
                    </ul>
                </section>
                @endif

                <!-- Standar Keselamatan & SOP K3 -->
                @if($equipment->safety_k3)
                <section class="bg-white rounded-xl border border-slate-200 p-6 sm:p-8 shadow-2xs space-y-4">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                        <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 border border-sky-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-sky-800 block">Standar K3 Teknisi</span>
                            <h2 class="text-lg sm:text-xl font-bold text-slate-900">Prosedur Keamanan &amp; Perlindungan Pipa</h2>
                        </div>
                    </div>

                    <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                        {{ $equipment->safety_k3 }}
                    </p>
                </section>
                @endif

                <!-- Studi Kasus Nyata / Portofolio Terkait -->
                @if($equipment->galleries && $equipment->galleries->isNotEmpty())
                <section class="bg-white rounded-xl border border-slate-200 p-6 sm:p-8 shadow-2xs space-y-5">
                    <div class="border-b border-slate-100 pb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-1">
                            Bukti Lapangan
                        </span>
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                            Pekerjaan Nyata Menggunakan {{ $equipment->name }}
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($equipment->galleries->take(4) as $case)
                        <div class="border border-slate-200 rounded-lg p-3 bg-slate-50 flex flex-col justify-between">
                            <div>
                                <div class="aspect-16/10 rounded overflow-hidden bg-slate-900 mb-2.5">
                                    <img src="{{ $case->after_image ?: ($case->image ?: asset('assets/TOOLKIT/mesin-spiral-rotary.webp')) }}" 
                                         alt="{{ $case->title }}" 
                                         width="400" 
                                         height="250" 
                                         class="w-full h-full object-cover"
                                         loading="lazy">
                                </div>
                                <h3 class="font-bold text-slate-900 text-xs sm:text-sm line-clamp-2 mb-1">
                                    {{ $case->title }}
                                </h3>
                                @if($case->location)
                                <div class="text-[11px] text-slate-500 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                    <span>{{ $case->location }}</span>
                                </div>
                                @endif
                            </div>
                            @if($case->slug)
                            <a href="{{ route('case-study.show', $case->slug) }}" class="mt-3 text-xs font-bold text-sky-700 hover:text-sky-800 inline-flex items-center gap-1">
                                <span>Lihat Studi Kasus</span>
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif

            </div>

            <!-- Right Column: Sticky Technical Specs Sidebar & WhatsApp CTA (lg:col-span-1) -->
            <aside class="space-y-6 lg:sticky lg:top-24">

                <!-- WhatsApp Direct CTA Card -->
                <div class="bg-slate-900 text-white rounded-xl border border-slate-800 p-6 shadow-md space-y-4">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-sky-400 block">
                        Pesan Armada Teknisi
                    </span>
                    <h3 class="text-lg font-bold text-white tracking-tight leading-snug">
                        Saluran Air Sedang Tersumbat Parah?
                    </h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Hubungi admin WhatsApp sekarang. Tim teknisi siaga membawa unit <strong>{{ $equipment->name }}</strong> langsung ke lokasi Anda.
                    </p>

                    <a href="{{ $waUrl }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="btn-press w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 active:bg-emerald-700 text-white font-bold text-sm shadow-xs transition-colors min-h-[44px]">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Konsultasi &amp; Panggil Unit</span>
                    </a>
                </div>

                <!-- Quick Specs Card -->
                @php
                    $specs = $equipment->specs_list;
                @endphp
                @if(!empty($specs) || $equipment->reach || $equipment->diameter || $equipment->specification)
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-2xs space-y-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-700 block">
                        Spesifikasi Teknis Cepat
                    </span>
                    <div class="text-xs space-y-2">
                        @foreach($specs as $spec)
                        <div class="py-1 border-b border-slate-100 font-medium text-slate-800 flex items-center justify-between">
                            <span>{{ $spec }}</span>
                        </div>
                        @endforeach
                        @if($equipment->reach)
                        <div class="flex justify-between py-1 border-b border-slate-100">
                            <span class="text-slate-500">Jangkauan Kerja</span>
                            <span class="font-bold text-slate-800">Jangkauan: {{ $equipment->reach }}</span>
                        </div>
                        @endif
                        @if($equipment->diameter)
                        <div class="flex justify-between py-1 border-b border-slate-100">
                            <span class="text-slate-500">Diameter Pipa</span>
                            <span class="font-bold text-slate-800">{{ $equipment->diameter }}</span>
                        </div>
                        @endif
                        @if($equipment->specification)
                        <div class="pt-1">
                            <div class="text-slate-500 mb-1">Spesifikasi Unit</div>
                            <div class="font-medium text-slate-700 leading-relaxed">{{ $equipment->specification }}</div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Related Equipments Navigation -->
                @if($relatedEquipments->isNotEmpty())
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-2xs space-y-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-700 block">
                        Peralatan Armada Lainnya
                    </span>
                    <div class="space-y-2">
                        @foreach($relatedEquipments as $other)
                        <a href="{{ route('equipment.show', $other->slug) }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 transition-colors group">
                            <div class="w-12 h-10 rounded overflow-hidden bg-slate-900 shrink-0 border border-slate-200">
                                <img src="{{ $other->image ?: asset('assets/TOOLKIT/mesin-rooter-ridgid-k50-spiral-baja.webp') }}" 
                                     alt="{{ $other->name }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="text-xs font-bold text-slate-900 group-hover:text-sky-700 transition-colors line-clamp-1">
                                    {{ $other->name }}
                                </h4>
                                <span class="text-[10px] text-slate-500 uppercase tracking-wider">{{ $other->category ?? 'Peralatan' }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

            </aside>

        </div>
    </div>
</main>
@endsection

