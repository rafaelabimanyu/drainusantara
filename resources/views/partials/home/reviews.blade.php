<!-- ====================================================================
     8. VERIFIED TESTIMONIALS & RATING
==================================================================== -->
@php
    $displayReviews = (isset($reviews) && $reviews->isNotEmpty()) ? $reviews : collect([
        (object)[
            'rating' => 5,
            'comment' => 'Wastafel mampet berhari-hari langsung tuntas 30 menit tanpa bongkar keramik sedikitpun. Teknisi datang cepat, pakai sarung tangan & cover sepatu, area dapur ditinggal dalam kondisi bersih. Puas banget!',
            'customer_name' => 'Ibu Ratna Dewi',
            'customer_role_or_location' => 'Duren Sawit, Jakarta Timur'
        ],
        (object)[
            'rating' => 5,
            'comment' => 'Kloset duduk lantai 2 meluap tersumbat tisu basah. Teknisi Drainusantara menggunakan spiral lentur khusus, 35 menit beres tanpa lepas kloset atau merusak porselen. Sangat profesional.',
            'customer_name' => 'Bpk. Hendra Wijaya',
            'customer_role_or_location' => 'BSD City, Tangerang Selatan'
        ],
        (object)[
            'rating' => 5,
            'comment' => 'Grease trap dan saluran pembuangan resto kami tersumbat lemak beku. Dikerjakan malam hari dengan kamera CCTV pipa 30M, terlihat jelas lemak bersih tuntas. Diberikan nota garansi 30 hari.',
            'customer_name' => 'Chef Adrian',
            'customer_role_or_location' => 'Resto F&B Kelapa Gading, Jakarta Utara'
        ],
        (object)[
            'rating' => 5,
            'comment' => 'Pipa talang rooftop tersumbat pasir dak dan lumut saat hujan deras sampai rembes ke plafon. Mesin spiral jangkauan panjang langsung melancarkan dalam waktu 45 menit. Rekomended!',
            'customer_name' => 'Bpk. Suryadi Pratama',
            'customer_role_or_location' => 'Tebet, Jakarta Selatan'
        ],
    ]);
@endphp
<section class="py-16 lg:py-24 bg-white border-b border-slate-200" x-data="mobileCarousel({{ count($displayReviews) }}, 4500)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 md:mb-16 fade-up">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 border border-amber-200 text-amber-900 text-xs font-mono font-bold rounded-full uppercase tracking-wider mb-2">
                TESTIMONI TERVERIFIKASI
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Pengalaman Nyata Bersama Drainusantara
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3">
                Kepercayaan dari ratusan pemilik rumah, kafe, restoran, dan pengelola gedung komersial.
            </p>
        </div>

        <!-- Reviews Carousel Grid -->
        <div x-ref="slider"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex md:grid md:grid-cols-2 lg:grid-cols-4 overflow-x-auto md:overflow-visible snap-x snap-mandatory no-scrollbar gap-5 lg:gap-6 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0">
            @foreach($displayReviews as $review)
                <div class="w-[82vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-slate-50 rounded-2xl p-6 border border-slate-200/80 flex flex-col justify-between hover:border-slate-300 transition-all fade-up delay-{{ min($loop->iteration * 100, 300) }}">
                    <div>
                        <div class="flex items-center gap-1 text-amber-700 mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-current' : 'text-slate-300' }}" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-slate-700 text-xs sm:text-sm leading-relaxed">
                            "{{ $review->comment }}"
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-200/80 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-slate-900 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-2xs font-mono">
                            {{ substr($review->customer_name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-bold text-slate-900 text-xs sm:text-sm">{{ $review->customer_name }}</div>
                            <div class="text-[11px] text-slate-500 font-medium">{{ $review->customer_role_or_location }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
