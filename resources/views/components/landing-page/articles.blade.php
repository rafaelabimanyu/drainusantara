@props([
    'articles' => [],
])

<section id="edukasi" class="py-16 lg:py-24 bg-white border-b border-slate-200 content-auto" x-data="mobileCarousel({{ max(1, count($articles)) }}, 4500)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-10 md:mb-14 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Panduan Teknis &amp; Sanitasi
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Edukasi &amp; Tips Perawatan Saluran Pipa
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Pelajari langkah pencegahan pipa mampet, bahaya bahan kimia korosif, dan standar pemeliharaan sanitasi hunian Anda.
            </p>
            <div class="flex lg:hidden items-center justify-center gap-1.5 text-xs text-sky-700 font-medium mt-3" aria-hidden="true">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
                <span>Geser artikel &bull; Auto-scroll aktif</span>
            </div>
        </div>

        <div x-ref="slider"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex lg:grid lg:grid-cols-3 overflow-x-auto lg:overflow-visible snap-x snap-mandatory no-scrollbar gap-5 lg:gap-8 pb-4 pt-1 px-4 -mx-4 sm:mx-0 sm:px-0">
            @forelse($articles as $article)
                <article class="w-[85vw] sm:w-[350px] lg:w-auto shrink-0 snap-center bg-white rounded-xl border border-slate-200/90 overflow-hidden hover:border-sky-300 hover:shadow-md transition-all flex flex-col justify-between group card-lift reveal-soft stagger-{{ ($loop->iteration % 3) + 1 }}">
                    <div>
                        <div class="relative aspect-[16/10] bg-slate-100 overflow-hidden border-b border-slate-100">
                            <img 
                                src="{{ $article->thumbnail ?: 'https://placehold.co/800x500/0284c7/ffffff?text=' . urlencode($article->title) }}" 
                                alt="{{ $article->title }}" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                width="600"
                                height="375"
                                loading="lazy"
                                decoding="async"
                            >
                            <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs text-sky-800 text-[11px] font-bold px-2.5 py-1 rounded-md shadow-2xs border border-slate-200/80">
                                {{ $article->category ?? 'Tips & Edukasi' }}
                            </span>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center gap-2 text-xs text-slate-400 mb-2.5">
                                <span>{{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
                                <span>&bull;</span>
                                <span class="text-slate-500 font-medium">4 Menit Baca</span>
                            </div>

                            <h3 class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-sky-700 transition-colors line-clamp-2 leading-snug">
                                <a href="{{ route('articles.show', $article->slug) }}">
                                    {{ $article->title }}
                                </a>
                            </h3>

                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mt-2.5 line-clamp-3">
                                {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}
                            </p>
                        </div>
                    </div>

                    <div class="p-6 pt-0 border-t border-slate-100 mt-4 flex items-center justify-between text-xs">
                        <a href="{{ route('articles.show', $article->slug) }}" class="font-bold text-sky-700 group-hover:text-sky-800 inline-flex items-center transition-colors">
                            <span>Baca Selengkapnya</span>
                        </a>
                        <span class="text-slate-400 text-[11px]">Tim Ahli Drainusantara</span>
                    </div>
                </article>
            @empty
                <div class="w-full col-span-3 text-center py-12 bg-slate-50 rounded-xl border border-slate-200 p-8">
                    <p class="text-slate-500 text-sm">Belum ada artikel yang diterbitkan.</p>
                </div>
            @endforelse
        </div>

        @if(count($articles) > 1)
        <div class="flex lg:hidden justify-center items-center gap-1 mt-5">
            @for($i = 0; $i < count($articles); $i++)
                <button type="button" 
                        @click="goTo({{ $i }})"
                        class="min-w-[28px] min-h-[28px] p-2 inline-flex items-center justify-center cursor-pointer active:scale-90"
                        aria-label="Artikel {{ $i + 1 }}">
                    <span class="h-2 rounded-full transition-all duration-300 block"
                          :class="active === {{ $i }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300'"></span>
                </button>
            @endfor
        </div>
        @endif

        <div class="mt-10 sm:mt-12 text-center reveal-soft">
            <a href="{{ route('articles.index') }}" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white hover:bg-slate-50 text-slate-800 hover:text-sky-700 font-bold text-xs sm:text-sm rounded-xl border border-slate-200 shadow-2xs hover:shadow-xs transition-all btn-press">
                <span>Lihat Semua Artikel &amp; Panduan Edukasi Sanitasi</span>
                <svg class="w-4 h-4 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>

    </div>
</section>
