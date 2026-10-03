@props([
    'reviews' => null,
])

@php
    $displayStories = collect([
        (object)[
            'comment' => 'Awalnya panik wastafel dapur meluap pas lagi siap-siap masak. Takut banget kalau harus bobok keramik kitchen set. Mas teknisi datang cepat bawa mesin spiral, sekitar 35 menit leher angsa bersih, air langsung lancar dan dapur ditinggal dalam kondisi rapi.',
            'customer_name' => 'Ibu Ratna Dewi',
            'customer_role_or_location' => 'Duren Sawit, Jakarta Timur',
            'initial' => 'R',
            'rating' => 5,
        ],
        (object)[
            'comment' => 'Kloset duduk lantai atas mampet airnya meluap hampir ke kamar. Sempat mikir bakal dicopot klosetnya, ternyata dikerjakan lewat pipa pakai spiral khusus tanpa dibongkar sama sekali. Masalah beres, langsung dikasih nota garansi tertulis 30 hari.',
            'customer_name' => 'Bpk. Hendra Wijaya',
            'customer_role_or_location' => 'BSD City, Tangerang Selatan',
            'initial' => 'H',
            'rating' => 5,
        ],
        (object)[
            'comment' => 'Saluran grease trap resto kami di Kelapa Gading mampet oleh lemak jenuh pas jam sibuk. Drainusantara datang malam hari, kerak lemaknya dibersihkan tuntas sampai ke bak kontrol tanpa bau mengganggu pelanggan besok paginya.',
            'customer_name' => 'Chef Adrian',
            'customer_role_or_location' => 'Resto F&B Kelapa Gading, Jakarta Utara',
            'initial' => 'A',
            'rating' => 5,
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
                <div class="w-[85vw] sm:w-[350px] md:w-auto shrink-0 snap-center bg-slate-50/70 hover:bg-white rounded-xl p-6 sm:p-7 border border-slate-200/90 hover:border-slate-300 transition-all flex flex-col justify-between shadow-2xs card-lift reveal-soft stagger-{{ ($loop->iteration % 3) + 1 }}">
                    <div>
                        <div role="img" class="flex items-center gap-1 mb-4 text-amber-400" aria-label="Rating {{ $story->rating ?? 5 }} Bintang">
                            @for($s = 1; $s <= 5; $s++)
                                <svg class="w-4 h-4 {{ $s <= ($story->rating ?? 5) ? 'fill-current' : 'text-slate-200 fill-current' }}" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
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

        <div class="flex md:hidden justify-center items-center gap-1 mt-4">
            @for($i = 0; $i < count($displayStories); $i++)
                <button type="button" 
                        @click="goTo({{ $i }})"
                        class="min-w-[28px] min-h-[28px] p-2 inline-flex items-center justify-center cursor-pointer"
                        aria-label="Cerita {{ $i + 1 }}">
                    <span class="h-2 rounded-full transition-all duration-300 block"
                          :class="active === {{ $i }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300'"></span>
                </button>
            @endfor
        </div>

    </div>
</section>
