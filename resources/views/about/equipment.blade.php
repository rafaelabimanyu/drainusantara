@extends('layouts.app')

@section('content')
<x-about.subnav 
    active-title="Peralatan & Teknologi"
    eyebrow="Spesifikasi Peralatan"
    heading="Peralatan Mekanis Spiral Baja & Kamera Inspeksi CCTV"
    subheading="Peralatan berstandar industri internasional untuk menembus, mengikis, dan menarik sumbatan tanpa merusak dinding pipa PVC."
    :bg-image="asset('assets/banner/hero-peralatan-drainusantara.webp')"
/>

@php
    $equipmentList = (isset($equipments) && $equipments->isNotEmpty()) 
        ? $equipments 
        : \App\Models\Equipment::where('is_active', true)->orderBy('order')->get();

    $mainMachines = $equipmentList->where('category', '!=', 'Mata Cutter');
    $cutterUnits = $equipmentList->where('category', 'Mata Cutter');
@endphp

<section id="peralatan" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-12 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Teknologi Tanpa Bongkar
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                Standar Mesin Pelancar Pipa Modern
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Kami tidak mengandalkan bahan kimia korosif seperti soda api yang merusak pipa. Kami menginvestasikan armada mesin drain cleaning berstandar internasional yang bekerja secara mekanis, terukur, dan aman untuk jangka panjang.
            </p>
        </div>

        @if($mainMachines->isNotEmpty())
        <!-- Main Machine Cards (Mobile Carousel, Tablet/Desktop Grid) -->
        <div x-data="mobileCarousel({{ $mainMachines->count() }}, 4000)"
             class="mb-14">
            
            <div x-ref="slider" tabindex="0" role="region" aria-label="Peralatan kerja — geser untuk melihat lainnya"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
             @touchcancel="resume()"
                 class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-5 pb-4 pt-1 px-1 -mx-4 sm:mx-0 sm:px-0 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-8 md:overflow-visible md:pb-0">
                @foreach($mainMachines as $machine)
                <div class="w-[85vw] sm:w-[360px] md:w-auto shrink-0 snap-center bg-white rounded-xl border border-slate-200 p-6 sm:p-7 shadow-2xs flex flex-col justify-between card-lift reveal-soft stagger-{{ ($loop->iteration % 3) + 1 }}">
                    <div>
                        <div class="relative aspect-[16/10] bg-slate-900 rounded-lg overflow-hidden border border-slate-200 mb-6 group">
                            <img 
                                src="{{ $machine->image ?: asset('assets/TOOLKIT/mesin-rooter-ridgid-k50-spiral-baja.webp') }}" 
                                alt="{{ $machine->name }}" 
                                width="800" 
                                height="500" 
                                loading="lazy" 
                                decoding="async" 
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                onerror="this.onerror=null; this.src='{{ asset('assets/TOOLKIT/mesin-rooter-ridgid-k50-spiral-baja.webp') }}';"
                            >
                            @if($machine->badge)
                            <div class="absolute top-2.5 left-2.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded bg-slate-900/85 backdrop-blur-xs text-[11px] font-bold text-white border border-slate-700">
                                    {{ $machine->badge }}
                                </span>
                            </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-sky-700">
                                {{ $machine->category ?? 'Unit Armada' }}
                            </span>
                            <span class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-md">
                                100% Mekanis
                            </span>
                        </div>

                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2.5 leading-snug">
                            {{ $machine->name }}
                        </h3>
                        @if($machine->short_description)
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                            {{ $machine->short_description }}
                        </p>
                        @endif
                        
                        @php
                            $specs = $machine->specs_list;
                        @endphp
                        @if(!empty($specs))
                        <div class="space-y-2 text-xs text-slate-700 border-t border-slate-100 pt-4">
                            @foreach($specs as $spec)
                            <div class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-sky-600 mt-1.5 shrink-0"></span>
                                <span>{{ $spec }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <span>Standar Industri Plumbing</span>
                        <span class="text-sky-700 font-bold">Tanpa Bongkar Pipa</span>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Mobile Carousel Indicators -->
            @if($mainMachines->count() > 1)
            <div class="flex items-center justify-center gap-2 mt-4 md:hidden">
                <template x-for="i in total" :key="i">
                    <button :aria-current="active === i - 1 ? 'true' : 'false'" type="button"
                            @click="goTo(i - 1)"
                            class="carousel-dot"

                            :aria-label="'Peralatan ' + i">
                    <span aria-hidden="true" class="h-2 rounded-full transition-all duration-300" :class="active === (i - 1) ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300'"></span></button>
                </template>
            </div>
            @endif
        </div>
        @else
        <!-- Fallback Default 3 Main Machine Cards (Mobile Carousel, Tablet/Desktop Grid) -->
        <div x-data="mobileCarousel(3, 4000)"
             class="mb-14">
            
            <div x-ref="slider" tabindex="0" role="region" aria-label="Peralatan kerja — geser untuk melihat lainnya"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
             @touchcancel="resume()"
                 class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-5 pb-4 pt-1 px-1 -mx-4 sm:mx-0 sm:px-0 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-8 md:overflow-visible md:pb-0">
                
                <div class="w-[85vw] sm:w-[360px] md:w-auto shrink-0 snap-center bg-white rounded-xl border border-slate-200 p-6 sm:p-7 shadow-2xs flex flex-col justify-between card-lift reveal-soft stagger-1">
                    <div>
                        <div class="relative aspect-[16/10] bg-slate-900 rounded-lg overflow-hidden border border-slate-200 mb-6 group">
                            <img 
                                src="{{ asset('assets/TOOLKIT/mesin-spiral-rotary.webp') }}" 
                                alt="Mesin Drain Rooter Spiral Baja Rotary Ridgid K-50 &amp; K-60" 
                                width="800" 
                                height="500" 
                                loading="lazy" 
                                decoding="async" 
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                onerror="this.onerror=null; this.src='{{ asset('assets/TOOLKIT/mesin-rooter-ridgid-k50-spiral-baja.webp') }}';"
                            >
                            <div class="absolute top-2.5 left-2.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded bg-slate-900/85 backdrop-blur-xs text-[11px] font-bold text-white border border-slate-700">
                                    Unit Utama Lapangan
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-sky-700">Rotary Rooter</span>
                            <span class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-md">100% Mekanis</span>
                        </div>

                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2.5 leading-snug">
                            Mesin Drain Rooter Spiral Baja Rotary Ridgid K-50 &amp; K-60
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                            Mesin drain cleaner bertenaga motor elektrik berkecepatan 400 RPM yang memutar kabel spiral baja lentur berinti kawat karbon. Mampu meluncur melewati belokan leher angsa dan elbow 90 derajat tanpa melubangi pipa PVC.
                        </p>
                        
                        <div class="space-y-2 text-xs text-slate-700 border-t border-slate-100 pt-4">
                            <div class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-sky-600 mt-1.5 shrink-0"></span>
                                <span><strong>Jangkauan:</strong> Hingga 30 meter sambung modular</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-sky-600 mt-1.5 shrink-0"></span>
                                <span><strong>Diameter Pipa:</strong> Efektif untuk pipa 1.5 sampai 6 inci</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-sky-600 mt-1.5 shrink-0"></span>
                                <span><strong>Aksi Kerja:</strong> Mengikis lemak padat, menarik rambut, dan memotong akar</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <span>Motor Listrik 220V</span>
                        <span class="text-sky-700 font-bold">Standard Industri</span>
                    </div>
                </div>

                <div class="w-[85vw] sm:w-[360px] md:w-auto shrink-0 snap-center bg-white rounded-xl border border-slate-200 p-6 sm:p-7 shadow-2xs flex flex-col justify-between card-lift">
                    <div>
                        <div class="relative aspect-[16/10] bg-slate-900 rounded-lg overflow-hidden border border-slate-200 mb-6 group">
                            <img 
                                src="{{ asset('assets/TOOLKIT/kamera-cctv-pipa.webp') }}" 
                                alt="Kamera Inspeksi Endoskopi CCTV Pipa IP68 30 Meter" 
                                width="800" 
                                height="500" 
                                loading="lazy" 
                                decoding="async" 
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                onerror="this.onerror=null; this.src='{{ asset('assets/TOOLKIT/inspeksi-cctv-set-lengkap-drainusantara.webp') }}';"
                            >
                            <div class="absolute top-2.5 left-2.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded bg-sky-950/85 backdrop-blur-xs text-[11px] font-bold text-sky-300 border border-sky-700">
                                    Diagnosis Visual
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-sky-700">Pipe Inspection</span>
                            <span class="text-xs font-bold text-sky-700 bg-sky-50 border border-sky-200 px-2 py-0.5 rounded-md">Kamera IP68 Digital</span>
                        </div>

                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2.5 leading-snug">
                            Kamera CCTV Endoskopi Pipa IP68 30 Meter
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                            Unit kamera industri tahan air beresolusi tinggi dengan lampu LED sorot adjustable dan kabel dorong fleksibel kaku. Memberikan inspeksi visual real-time kondisi bagian dalam pipa pada layar monitor LCD.
                        </p>
                        
                        <div class="space-y-2 text-xs text-slate-700 border-t border-slate-100 pt-4">
                            <div class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-sky-600 mt-1.5 shrink-0"></span>
                                <span><strong>Jangkauan:</strong> Push-rod fiberglass tahan tekuk 30M</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-sky-600 mt-1.5 shrink-0"></span>
                                <span><strong>Pencahayaan:</strong> 12 LED ultra-bright + lensa safir</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-sky-600 mt-1.5 shrink-0"></span>
                                <span><strong>Dokumentasi:</strong> Video MP4 &amp; foto detail posisi sumbatan</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <span>IP68 Submersible</span>
                        <span class="text-sky-700 font-bold">Titik Pasti</span>
                    </div>
                </div>

                <div class="w-[85vw] sm:w-[360px] md:w-auto shrink-0 snap-center bg-white rounded-xl border border-slate-200 p-6 sm:p-7 shadow-2xs flex flex-col justify-between card-lift">
                    <div>
                        <div class="relative aspect-[16/10] bg-slate-900 rounded-lg overflow-hidden border border-slate-200 mb-6 group">
                            <img 
                                src="{{ asset('assets/TOOLKIT/hydro-jetting.webp') }}" 
                                alt="Unit High Pressure Hydro Jetting Drainusantara" 
                                width="800" 
                                height="500" 
                                loading="lazy" 
                                decoding="async" 
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                onerror="this.onerror=null; this.src='{{ asset('assets/TOOLKIT/hydro-jetting-high-pressure-hose.webp') }}';"
                            >
                            <div class="absolute top-2.5 left-2.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded bg-amber-950/85 backdrop-blur-xs text-[11px] font-bold text-amber-300 border border-amber-700">
                                    Lemak &amp; Restoran
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-amber-700">Hydro Jetting</span>
                            <span class="text-xs font-bold text-amber-800 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-md">Tekanan Tinggi</span>
                        </div>

                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2.5 leading-snug">
                            Unit Pembersih Saluran High Pressure Hydro Jetting
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                            Menembakkan semburan air mikro bertekanan 100-200 bar untuk mengikis dan membilas bersih tumpukan minyak beku, kerak lumpur, dan sisa limbah padat di restoran, ruko, serta instalasi industri.
                        </p>
                        
                        <div class="space-y-2 text-xs text-slate-700 border-t border-slate-100 pt-4">
                            <div class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-600 mt-1.5 shrink-0"></span>
                                <span><strong>Tekanan Air:</strong> 100 - 200 Bar nozel multifungsi</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-600 mt-1.5 shrink-0"></span>
                                <span><strong>Target Masalah:</strong> Grease trap, pipa dapur resto, sedimentasi pasir</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-600 mt-1.5 shrink-0"></span>
                                <span><strong>Hasil:</strong> Dinding pipa bersih total seperti baru dipasang</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <span>Eco-Friendly (Tanpa Kimia)</span>
                        <span class="text-amber-700 font-bold">Bilas Bersih Total</span>
                    </div>
                </div>

            </div>

            <!-- Mobile Carousel Indicators -->
            <div class="flex items-center justify-center gap-2 mt-4 md:hidden">
                <template x-for="i in total" :key="i">
                    <button :aria-current="active === i - 1 ? 'true' : 'false'" type="button"
                            @click="goTo(i - 1)"
                            class="carousel-dot"

                            :aria-label="'Peralatan ' + i">
                    <span aria-hidden="true" class="h-2 rounded-full transition-all duration-300" :class="active === (i - 1) ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300'"></span></button>
                </template>
            </div>
        </div>
        @endif

        @php
            $equipWaNumber = config('app.whatsapp_number') ?: '6281234567890';
            $equipWaText = urlencode('Halo Admin Drainusantara, saya ingin konsultasi penanganan saluran menggunakan unit mesin spiral rotary / kamera CCTV.');
            $equipWaUrl = "https://wa.me/{$equipWaNumber}?text={$equipWaText}";
        @endphp
        <div class="mt-12 bg-slate-900 text-white p-6 sm:p-8 rounded-xl border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-6 reveal-soft">
            <div class="max-w-2xl">
                <span class="text-xs font-bold uppercase tracking-wider text-sky-400 block mb-1">
                    Armada Mesin Siaga 24 Jam
                </span>
                <h3 class="text-xl font-bold text-white tracking-tight">
                    Butuh Penanganan dengan Mesin Spiral Rotary atau Inspeksi CCTV?
                </h3>
                <p class="text-slate-300 text-xs sm:text-sm mt-1 leading-relaxed">
                    Teknisi Drainusantara siaga membawa unit alat lengkap langsung ke lokasi Anda. Tanpa bongkar keramik, tuntas baru bayar, dan bergaransi resmi 30 hari.
                </p>
            </div>
            <div class="shrink-0">
                <a href="{{ $equipWaUrl }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="btn-press inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-xs sm:text-sm shadow-xs transition-colors min-h-[44px]">
                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Konsultasi Alat &amp; Panggil Teknisi</span>
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
