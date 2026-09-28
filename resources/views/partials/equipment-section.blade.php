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
@endphp

<section id="peralatan-armada" class="py-16 lg:py-20 {{ $bgColor }} border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row items-start lg:items-end justify-between gap-6 mb-10 md:mb-12 reveal-soft">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold rounded-md uppercase tracking-wider mb-3">
                    <svg class="w-3.5 h-3.5 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ $eyebrow }}</span>
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    {{ $resolvedTitle }}
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-2.5 leading-relaxed">
                    {{ $resolvedDesc }}
                </p>
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
        <!-- Grid Dynamic Equipment from CMS Database -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($dbEquipments as $index => $equip)
            <div class="bg-white rounded-xl border border-slate-200 shadow-2xs overflow-hidden flex flex-col justify-between card-lift reveal-soft delay-{{ min(($index + 1) * 75, 300) }}">
                <div>
                    <!-- Container Gambar Peralatan -->
                    <div class="relative aspect-[16/10] bg-slate-900 overflow-hidden border-b border-slate-200 group">
                        <img 
                            src="{{ $equip->image ?: asset('assets/TOOLKIT/mesin-spiral-rotary.svg') }}" 
                            alt="{{ $equip->name }}" 
                            width="600" 
                            height="375" 
                            loading="lazy" 
                            decoding="async" 
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            onerror="this.onerror=null; this.src='{{ asset('assets/TOOLKIT/mesin-spiral-rotary.svg') }}';"
                        >
                        @if($equip->badge)
                        <div class="absolute top-2.5 left-2.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-slate-900/85 backdrop-blur-xs text-[11px] font-bold text-white border border-slate-700">
                                {{ $equip->badge }}
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="p-5">
                        @if($equip->category)
                        <span class="text-[11px] font-bold uppercase tracking-wider text-sky-700 block mb-1">
                            {{ $equip->category }}
                        </span>
                        @endif
                        <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-snug mb-2">
                            {{ $equip->name }}
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
            </div>
            @endforeach
        </div>
        @else
        <!-- Fallback if empty in DB -->
        <div class="p-8 text-center bg-slate-50 rounded-xl border border-slate-200">
            <p class="text-slate-500 text-sm">Peralatan armada sedang diperbarui di sistem CMS.</p>
        </div>
        @endif

    </div>
</section>
