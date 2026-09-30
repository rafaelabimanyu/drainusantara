@props([
    'reviews' => null,
])

@php
    $displayStories = collect([
        (object)[
            'case_badge' => 'Wastafel Dapur',
            'status' => 'Bebas Bongkar',
            'comment' => 'Awalnya panik wastafel dapur meluap pas lagi siap-siap masak. Takut banget kalau harus bobok keramik kitchen set. Mas teknisi datang cepat bawa mesin spiral, sekitar 35 menit leher angsa bersih, air langsung lancar dan dapur ditinggal dalam kondisi rapi.',
            'customer_name' => 'Ibu Ratna Dewi',
            'customer_role_or_location' => 'Duren Sawit, Jakarta Timur',
            'initial' => 'R'
        ],
        (object)[
            'case_badge' => 'Kloset Lantai 2',
            'status' => 'Bebas Bongkar',
            'comment' => 'Kloset duduk lantai atas mampet airnya meluap hampir ke kamar. Sempat mikir bakal dicopot klosetnya, ternyata dikerjakan lewat pipa pakai spiral khusus tanpa dibongkar sama sekali. Masalah beres, langsung dikasih nota garansi tertulis 30 hari.',
            'customer_name' => 'Bpk. Hendra Wijaya',
            'customer_role_or_location' => 'BSD City, Tangerang Selatan',
            'initial' => 'H'
        ],
        (object)[
            'case_badge' => 'Grease Trap Resto',
            'status' => 'Bebas Bongkar',
            'comment' => 'Saluran grease trap resto kami di Kelapa Gading mampet oleh lemak jenuh pas jam sibuk. Drainusantara datang malam hari, kerak lemaknya dibersihkan tuntas sampai ke bak kontrol tanpa bau mengganggu pelanggan besok paginya.',
            'customer_name' => 'Chef Adrian',
            'customer_role_or_location' => 'Resto F&B Kelapa Gading, Jakarta Utara',
            'initial' => 'A'
        ],
    ]);
@endphp

<section id="pengalaman" class="py-16 lg:py-24 bg-white border-b border-slate-200" x-data="mobileCarousel({{ count($displayStories) }}, 4500)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-10 md:mb-14 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Catatan Lapangan &amp; Pengalaman Pelanggan
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Pengalaman Nyata Bersama Drainusantara
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2.5 leading-relaxed">
                Cerita dari pemilik rumah dan pelaku usaha saat mengatasi saluran air mampet tanpa repot membongkar keramik.
            </p>
        </div>

        <div x-ref="slider"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex md:grid md:grid-cols-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-5 lg:gap-6 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0 items-stretch">
            @foreach($displayStories as $story)
                <div class="w-[85vw] sm:w-[350px] md:w-auto shrink-0 snap-center bg-slate-50/70 hover:bg-white rounded-xl p-6 sm:p-7 border border-slate-200/90 hover:border-slate-300 transition-all flex flex-col justify-between shadow-2xs card-lift reveal-soft delay-{{ min($loop->iteration * 100, 300) }}">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <span class="inline-flex items-center px-2.5 py-1 bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-md shadow-2xs">
                                {{ $story->case_badge }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                <svg class="w-3.5 h-3.5 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ $story->status }}</span>
                            </span>
                        </div>

                        <p class="text-slate-700 text-sm leading-relaxed font-normal">
                            &ldquo;{{ $story->comment }}&rdquo;
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-200/80 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-white border border-slate-200 text-slate-700 flex items-center justify-center font-bold text-xs shrink-0 shadow-2xs">
                            {{ $story->initial }}
                        </div>
                        <div>
                            <div class="font-bold text-slate-900 text-sm leading-snug">{{ $story->customer_name }}</div>
                            <div class="text-[11px] text-slate-500 font-medium">{{ $story->customer_role_or_location }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex md:hidden justify-center items-center gap-1.5 mt-4">
            @for($i = 0; $i < count($displayStories); $i++)
                <button type="button" 
                        @click="goTo({{ $i }})"
                        class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                        :class="active === {{ $i }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300'"
                        aria-label="Cerita {{ $i + 1 }}">
                </button>
            @endfor
        </div>

    </div>
</section>
