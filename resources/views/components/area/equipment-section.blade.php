@props([
    'sectionId' => 'peralatan-armada',
    'areaName' => null,
    'eyebrow' => 'STANDAR OPERASIONAL TEKNISI',
    'title' => null,
    'description' => null,
    'bgColor' => 'bg-white'
])

@php
    $resolvedTitle = $title ?? ($areaName ? "Peralatan Canggih Siaga di {$areaName}" : "Peralatan Canggih Standar Armada Drainusantara");
    $resolvedDesc = $description ?? ($areaName 
        ? "Armada teknisi kami yang bertugas di {$areaName} selalu dilengkapi unit mesin drain cleaner mekanis berstandar internasional. Menuntaskan sumbatan tanpa bongkar lantai keramik dan tanpa bahan kimia perusak."
        : "Setiap armada teknisi Drainusantara yang ditugaskan ke lokasi Anda dilengkapi unit mesin drain cleaner berstandar internasional. Menuntaskan saluran mampet secara mekanis, aman untuk dinding pipa PVC, dan bergaransi.");

    $dbEquipments = \App\Models\Equipment::where('is_active', true)->orderBy('order')->get();
    if ($dbEquipments->isEmpty()) {
        $dbEquipments = collect([
            (object) [
                'name' => 'Mesin Spiral Rotary Ridgid K-6200',
                'slug' => 'mesin-spiral-rotary-ridgid-k6200',
                'category' => 'PENGHANCUR LEMAK BEKU',
                'badge' => 'STANDARD HEAVY DUTY',
                'short_description' => 'Motor torsi tinggi dengan kabel baja tempered 16mm-20mm yang meliuk fleksibel di dalam pipa PVC hingga 30 meter tanpa memecahkan sambungan fitting.',
                'image' => asset('images/equipments/mesin-spiral-rotary-ridgid-k6200.webp'),
                'specs_list' => ['Jangkauan hingga 30 meter', 'Motor listrik 400 RPM torsi tinggi', 'Non-destruktif pipa PVC'],
            ],
            (object) [
                'name' => 'Hand Rooter Ridgid K-50 Elektrik',
                'slug' => 'hand-rooter-ridgid-k50',
                'category' => 'SPESIALIS WASTAFEL & SINK',
                'badge' => 'PRESTASI TINGGI',
                'short_description' => 'Alat rotasi presisi untuk saluran diameter 2 - 3 inci seperti kitchen sink, floor drain kamar mandi, dan pipa talang sempit.',
                'image' => asset('images/equipments/hand-rooter-ridgid-k50.webp'),
                'specs_list' => ['Diameter kabel 8mm - 16mm', 'Aman untuk leher angsa sifon', 'Desain portabel compact'],
            ],
            (object) [
                'name' => 'Kamera Inspeksi CCTV Endoskopi 30M',
                'slug' => 'kamera-inspeksi-cctv-saluran-pipa',
                'category' => 'DIAGNOSTIK DIGITAL',
                'badge' => 'MONITOR HIGH DEF',
                'short_description' => 'Kamera water-proof resolusi tinggi dengan lampu LED sorot untuk melihat titik retak, akar pohon, atau pipa melorot di bawah lantai semen.',
                'image' => asset('images/equipments/kamera-inspeksi-cctv-saluran-pipa.webp'),
                'specs_list' => ['Kamera IP68 waterproof', 'Panjang probe kabel 30 meter', 'Resolusi warna ultra-clear'],
            ],
            (object) [
                'name' => 'High-Pressure Hydro Jetting Unit',
                'slug' => 'hydro-jetting-high-pressure',
                'category' => 'PEMBERSIH TOTAL GOT & LEMAK',
                'badge' => 'FLUSHING INDUSTRI',
                'short_description' => 'Semburan air bertekanan terarah untuk mengikis kerak minyak restoran dan lumpur got hingga dinding pipa bersih total 100%.',
                'image' => asset('images/equipments/hydro-jetting-high-pressure.webp'),
                'specs_list' => ['Tekanan hingga 250 Bar', 'Nosel putar 360 derajat', 'Mengikis lemak beku membatu'],
            ],
        ]);
    }
    $equipCount = $dbEquipments->count();
@endphp

<section id="{{ $sectionId }}" class="py-16 lg:py-20 {{ $bgColor }} border-b border-slate-200" @if($equipCount > 0) x-data="mobileCarousel({{ $equipCount }}, 4500)" @endif>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row items-start lg:items-end justify-between gap-6 mb-10 md:mb-12 reveal-soft">
            <div class="max-w-3xl">
                <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-2.5">
                    {{ $eyebrow }}
                </p>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    {{ $resolvedTitle }}
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-2.5 leading-relaxed">
                    {{ $resolvedDesc }}
                </p>
                @if($equipCount > 0)
                <div class="flex items-center justify-start gap-1.5 text-xs text-sky-700 font-medium mt-3" aria-hidden="true">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                    <span>Geser katalog peralatan &bull; Auto-scroll aktif</span>
                </div>
                @endif
            </div>

            <div class="flex items-center gap-3 shrink-0 self-end lg:self-auto">
                @if($equipCount > 1)
                <div class="flex items-center gap-2">
                    <button type="button" @click="goTo(Math.max(0, active - 1))"
                            :disabled="active === 0"
                            :class="active === 0 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 text-slate-800 cursor-pointer'"
                            class="w-9 h-9 rounded-lg border border-slate-300 bg-white text-slate-700 flex items-center justify-center transition-colors shadow-2xs"
                            aria-label="Peralatan sebelumnya">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button type="button" @click="goTo(Math.min({{ $equipCount - 1 }}, active + 1))"
                            :disabled="active === {{ $equipCount - 1 }}"
                            :class="active === {{ $equipCount - 1 }} ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 text-slate-800 cursor-pointer'"
                            class="w-9 h-9 rounded-lg border border-slate-300 bg-white text-slate-700 flex items-center justify-center transition-colors shadow-2xs"
                            aria-label="Peralatan berikutnya">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
                @endif

                <a href="{{ route('about.equipment') }}" 
                   class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-sky-700 hover:text-sky-800 bg-sky-50 hover:bg-sky-100 border border-sky-200 px-4 py-2.5 rounded-lg transition-colors shadow-2xs btn-press">
                    <span>Spesifikasi Teknis</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>

        @if($dbEquipments->isNotEmpty())
        <!-- 1-Row Horizontal Carousel for Desktop & Mobile -->
            <div x-ref="slider" tabindex="0" role="region" aria-label="Peralatan armada 1 baris - geser untuk melihat lainnya"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @touchcancel="resume()"
             class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-5 sm:gap-6 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0">
            @foreach($dbEquipments as $index => $equip)
            <div class="w-[84vw] max-w-[280px] sm:w-[280px] lg:w-[290px] shrink-0 snap-start bg-white rounded-xl border border-slate-200 shadow-2xs overflow-hidden flex flex-col justify-between card-lift reveal-soft stagger-{{ ($index % 4) + 1 }} hover:border-sky-300 transition-all">
                <div>
                    <!-- Container Gambar Peralatan -->
                    <div class="relative aspect-16/9 sm:aspect-16/10 bg-slate-900 overflow-hidden border-b border-slate-200 group">
                        @if($equip->slug)
                        <a href="{{ route('equipment.show', $equip->slug) }}" class="block w-full h-full">
                            <img 
                                src="{{ $equip->image ?: asset('assets/TOOLKIT/mesin-rooter-ridgid-k50-spiral-baja.webp') }}" 
                                alt="{{ $equip->name }}" 
                                width="600" 
                                height="338" 
                                loading="lazy" 
                                decoding="async" 
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                onerror="this.onerror=null; this.src='{{ asset('assets/TOOLKIT/mesin-rooter-ridgid-k50-spiral-baja.webp') }}';"
                            >
                        </a>
                        @else
                        <img 
                            src="{{ $equip->image ?: asset('assets/TOOLKIT/mesin-rooter-ridgid-k50-spiral-baja.webp') }}" 
                            alt="{{ $equip->name }}" 
                            width="600" 
                            height="338" 
                            loading="lazy" 
                            decoding="async" 
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            onerror="this.onerror=null; this.src='{{ asset('assets/TOOLKIT/mesin-rooter-ridgid-k50-spiral-baja.webp') }}';"
                        >
                        @endif
                    </div>

                    <div class="p-3.5 sm:p-5">
                        <div class="flex items-center justify-between gap-1.5 mb-1 text-[10px] sm:text-[11px]">
                            @if($equip->category)
                            <span class="font-bold uppercase tracking-wider text-sky-800 truncate">
                                {{ $equip->category }}
                            </span>
                            @endif
                            @if($equip->badge)
                            <span class="font-semibold text-slate-500 shrink-0">
                                {{ $equip->badge }}
                            </span>
                            @endif
                        </div>
                        <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug mb-1.5 line-clamp-1">
                            @if($equip->slug)
                            <a href="{{ route('equipment.show', $equip->slug) }}" class="hover:text-sky-700 transition-colors">
                                {{ $equip->name }}
                            </a>
                            @else
                            {{ $equip->name }}
                            @endif
                        </h3>
                        @if($equip->short_description)
                        <p class="text-xs text-slate-600 leading-relaxed mb-3 line-clamp-2">
                            {{ $equip->short_description }}
                        </p>
                        @endif

                        @php
                            $specs = $equip->specs_list;
                        @endphp
                        @if(!empty($specs))
                        <div class="space-y-1 text-[10px] sm:text-[11px] text-slate-700 border-t border-slate-100 pt-2.5">
                            @foreach(array_slice($specs, 0, 3) as $spec)
                            <div class="flex items-start gap-1.5 text-slate-600">
                                <span class="text-sky-600 font-bold shrink-0">&bull;</span>
                                <span class="line-clamp-1">{{ $spec }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>

                @if($equip->slug)
                <div class="px-3.5 pb-3.5 sm:px-5 sm:pb-5 pt-0">
                    <a href="{{ route('equipment.show', $equip->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-sky-700 hover:text-sky-800 group/link">
                        <span>Spesifikasi &amp; Detail</span>
                        <svg class="w-3.5 h-3.5 transition-transform group-hover/link:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Slide Counter & Pagination -->
        <div class="flex items-center justify-center gap-2 mt-6 text-xs text-slate-500 font-mono">
            <button type="button" @click="goTo(Math.max(0, active - 1))"
                    :disabled="active === 0"
                    :class="active === 0 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 hover:text-slate-900 cursor-pointer'"
                    class="p-1.5 rounded-md border border-slate-200 transition-colors"
                    aria-label="Peralatan sebelumnya">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <div class="flex items-center gap-1">
                @for($i = 0; $i < $equipCount; $i++)
                    <button type="button" 
                            @click="goTo({{ $i }})"
                            :class="active === {{ $i }} ? 'bg-slate-900 text-white font-bold' : 'text-slate-600 hover:bg-slate-100'"
                            class="w-6 h-6 rounded-md text-xs flex items-center justify-center border border-slate-200 transition-colors cursor-pointer"
                            aria-label="Peralatan {{ $i + 1 }}">
                        {{ $i + 1 }}
                    </button>
                @endfor
            </div>
            <button type="button" @click="goTo(Math.min({{ $equipCount - 1 }}, active + 1))"
                    :disabled="active === {{ $equipCount - 1 }}"
                    :class="active === {{ $equipCount - 1 }} ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 hover:text-slate-900 cursor-pointer'"
                    class="p-1.5 rounded-md border border-slate-200 transition-colors"
                    aria-label="Peralatan berikutnya">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
        @else
        <!-- Fallback if empty in DB -->
        <div class="p-8 text-center bg-slate-50 rounded-xl border border-slate-200">
            <p class="text-slate-500 text-sm">Peralatan armada sedang diperbarui di sistem CMS.</p>
        </div>
        @endif

    </div>
</section>
