@props([
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
    $equipCount = $dbEquipments->count();
@endphp

<section id="peralatan-armada" class="py-16 lg:py-20 {{ $bgColor }} border-b border-slate-200" @if($equipCount > 0) x-data="mobileCarousel({{ $equipCount }}, 4500)" @endif>
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
                <div class="flex md:hidden items-center justify-start gap-1.5 text-xs text-sky-700 font-medium mt-3" aria-hidden="true">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                    <span>Geser katalog peralatan &bull; Auto-scroll aktif</span>
                </div>
                @endif
            </div>

            <a href="{{ route('about.equipment') }}" 
               class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-sky-700 hover:text-sky-800 bg-sky-50 hover:bg-sky-100 border border-sky-200 px-4 py-2.5 rounded-lg transition-colors shrink-0 shadow-2xs btn-press">
                <span>Spesifikasi Teknis Lengkap</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>

        @if($dbEquipments->isNotEmpty())
        <!-- Responsive Grid on Desktop / Mobile Carousel -->
            <div x-ref="slider" tabindex="0" role="region" aria-label="Peralatan armada - geser untuk melihat lainnya"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @touchcancel="resume()"
             class="flex md:grid md:grid-cols-2 lg:grid-cols-4 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-6 pb-4 pt-1 px-4 -mx-4 md:mx-0 md:px-0">
            @foreach($dbEquipments as $index => $equip)
            <div class="w-[84vw] sm:w-85 md:w-auto shrink-0 snap-center bg-white rounded-xl border border-slate-200 shadow-2xs overflow-hidden flex flex-col justify-between card-lift reveal-soft stagger-{{ ($index % 4) + 1 }}">
                <div>
                    <!-- Container Gambar Peralatan -->
                    <div class="relative aspect-16/10 bg-slate-900 overflow-hidden border-b border-slate-200 group">
                        @if($equip->slug)
                        <a href="{{ route('equipment.show', $equip->slug) }}" class="block w-full h-full">
                            <img 
                                src="{{ $equip->image ?: asset('assets/TOOLKIT/mesin-rooter-ridgid-k50-spiral-baja.webp') }}" 
                                alt="{{ $equip->name }}" 
                                width="600" 
                                height="375" 
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
                            height="375" 
                            loading="lazy" 
                            decoding="async" 
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            onerror="this.onerror=null; this.src='{{ asset('assets/TOOLKIT/mesin-rooter-ridgid-k50-spiral-baja.webp') }}';"
                        >
                        @endif
                    </div>

                    <div class="p-5">
                        <div class="flex items-center justify-between gap-2 mb-1.5 text-[11px]">
                            @if($equip->category)
                            <span class="font-bold uppercase tracking-wider text-sky-700">
                                {{ $equip->category }}
                            </span>
                            @endif
                            @if($equip->badge)
                            <span class="font-semibold text-slate-500">
                                {{ $equip->badge }}
                            </span>
                            @endif
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-snug mb-2">
                            @if($equip->slug)
                            <a href="{{ route('equipment.show', $equip->slug) }}" class="hover:text-sky-700 transition-colors">
                                {{ $equip->name }}
                            </a>
                            @else
                            {{ $equip->name }}
                            @endif
                        </h3>
                        @if($equip->short_description)
                        <p class="text-xs text-slate-600 leading-relaxed mb-4">
                            {{ $equip->short_description }}
                        </p>
                        @endif

                        @php
                            $specs = $equip->specs_list;
                        @endphp
                        @if(!empty($specs))
                        <div class="space-y-1.5 text-[11px] text-slate-700 border-t border-slate-100 pt-3">
                            @foreach(array_slice($specs, 0, 3) as $spec)
                            <div class="flex items-start gap-1.5 text-slate-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-sky-600 mt-1 shrink-0"></span>
                                <span class="line-clamp-1">{{ $spec }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>

                @if($equip->slug)
                <div class="px-5 pb-5 pt-0">
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

        <div class="flex md:hidden justify-center items-center flex-wrap gap-1 mt-4">
            @for($i = 0; $i < $equipCount; $i++)
                <button :aria-current="active === {{ $i }} ? 'true' : 'false'" type="button"
                        @click="goTo({{ $i }})"
                        class="carousel-dot min-w-7 min-h-7 p-2 inline-flex items-center justify-center cursor-pointer active:scale-90"
                        aria-label="Peralatan {{ $i + 1 }}">
                    <span class="h-2 rounded-full transition-all duration-300 block"
                          :class="active === {{ $i }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300 hover:bg-slate-400'"></span>
                </button>
            @endfor
        </div>
        @else
        <!-- Fallback if empty in DB -->
        <div class="p-8 text-center bg-slate-50 rounded-xl border border-slate-200">
            <p class="text-slate-500 text-sm">Peralatan armada sedang diperbarui di sistem CMS.</p>
        </div>
        @endif

    </div>
</section>
