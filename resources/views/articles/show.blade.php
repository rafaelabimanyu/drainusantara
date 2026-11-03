@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-6 sm:py-10 lg:py-12 border-b border-slate-200" x-data="blogImageViewer()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs Navigation -->
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-500 mb-6 overflow-x-auto no-scrollbar reveal-fade" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5 shrink-0">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Beranda</span>
            </a>
            <span class="text-slate-300">/</span>
            <a href="{{ route('articles.index') }}" class="hover:text-sky-700 transition-colors shrink-0">Blog</a>
            <span class="text-slate-300">/</span>
            <span class="text-slate-800 truncate font-semibold">{{ $article->title }}</span>
        </nav>

        <!-- Article Editorial Header Card -->
        <header class="bg-white rounded-xl border border-slate-200 p-6 sm:p-10 mb-8 shadow-xs reveal-soft">
            <div class="max-w-4xl mx-auto">
                <div class="flex flex-wrap items-center gap-2 mb-4 text-xs">
                    <span class="font-bold text-sky-800 tracking-wider uppercase">
                        {{ $article->category_label }}
                    </span>
                    <span class="text-slate-300">&bull;</span>
                    <span class="text-xs text-slate-500 font-medium">
                        Dipublikasikan {{ $article->published_at ? $article->published_at->format('d F Y') : $article->created_at->format('d F Y') }}
                    </span>
                    <span class="text-slate-300">&bull;</span>
                    <span class="text-xs text-slate-500 font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-sky-600 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ $article->reading_time }} Menit Baca</span>
                    </span>
                    <span class="text-slate-300">&bull;</span>
                    <span class="text-xs text-slate-500 font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-slate-400 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <span>{{ number_format($article->views_count) }}x Dilihat</span>
                    </span>
                </div>

                <h1 class="text-2xl sm:text-4xl md:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                    {{ $article->title }}
                </h1>

                <!-- Placement: Hero Image jika dipilih hero di CMS -->
                @if($article->thumbnail && $article->image_placement === 'hero')
                    @php
                        $heroResolved = filter_var($article->thumbnail, FILTER_VALIDATE_URL) ? $article->thumbnail : asset(ltrim($article->thumbnail, '/'));
                    @endphp
                    <figure class="mt-6 rounded-xl overflow-hidden border border-slate-200 bg-white shadow-2xs max-w-3xl mx-auto group">
                        <div class="relative cursor-zoom-in overflow-hidden group/img"
                             @click="open('{{ $heroResolved }}', '{{ addslashes($article->title) }}')"
                             title="Klik untuk melihat foto lebih besar">
                            <img src="{{ $heroResolved }}" 
                                 alt="{{ $article->title }}" 
                                 width="900" 
                                 height="450" 
                                 loading="eager" 
                                 decoding="async" 
                                 class="w-full max-h-[340px] object-cover group-hover/img:scale-[1.02] transition-transform duration-300">
                            <div class="absolute bottom-3 right-3 bg-slate-900/80 hover:bg-slate-900 backdrop-blur-xs text-white text-[11px] font-semibold px-3 py-1.5 rounded-lg border border-white/20 flex items-center gap-1.5 shadow-md transition-colors pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                                </svg>
                                <span>Lihat Gambar Penuh</span>
                            </div>
                        </div>
                        <figcaption class="px-4 py-2 bg-slate-50 border-t border-slate-100 text-[11px] text-slate-500 flex items-center justify-between">
                            <span>Dokumentasi Resmi Sanitasi &amp; Pemipaan Drainusantara</span>
                            <span class="font-medium text-slate-600">Standar Teknis Lapangan</span>
                        </figcaption>
                    </figure>
                @endif

                <!-- Author Bio Bar -->
                <div class="mt-6 sm:mt-8 pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-md bg-slate-900 text-sky-400 font-extrabold flex items-center justify-center text-xs border border-slate-800 shadow-2xs">
                            DN
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-900 flex items-center gap-1.5">
                                <span>{{ $article->author_name }}</span>
                                <svg class="w-4 h-4 text-sky-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="text-xs text-slate-500 font-medium">
                                {{ $article->author_role }} &bull; Verifikasi Standar Teknis
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <!-- Quick WhatsApp Share / Consultation -->
                        <a href="https://wa.me/{{ config('app.whatsapp_number', '6285609009009') }}?text={{ rawurlencode('Halo Admin Drainusantara, saya sedang membaca panduan ' . $article->title . ' dan ingin konsultasi saluran pipa.') }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="btn-press inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs border border-emerald-200 transition-colors">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>Konsultasi Topik Ini</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- 2-Column Editorial Grid: Content (Left) + Sticky Sidebar (Right) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            <!-- Main Content Column -->
            <main class="lg:col-span-8 bg-white rounded-xl border border-slate-200 p-6 sm:p-10 shadow-xs reveal-soft">
                
                <!-- Placement: Image di Konten (Tengah, Ukuran Kompak & Proporsional) -->
                @if($article->thumbnail && $article->image_placement !== 'hero')
                    @php
                        $contentResolved = filter_var($article->thumbnail, FILTER_VALIDATE_URL) ? $article->thumbnail : asset(ltrim($article->thumbnail, '/'));
                    @endphp
                    <figure class="mb-8 rounded-xl overflow-hidden border border-slate-200 bg-white shadow-2xs max-w-2xl mx-auto group">
                        <div class="relative cursor-zoom-in overflow-hidden group/img"
                             @click="open('{{ $contentResolved }}', '{{ addslashes($article->title) }}')"
                             title="Klik untuk melihat foto lebih besar">
                            <img src="{{ $contentResolved }}" 
                                 alt="{{ $article->title }}" 
                                 width="800" 
                                 height="450" 
                                 loading="eager" 
                                 decoding="async" 
                                 class="w-full max-h-[320px] object-cover group-hover/img:scale-[1.02] transition-transform duration-300">
                            <div class="absolute bottom-3 right-3 bg-slate-900/80 hover:bg-slate-900 backdrop-blur-xs text-white text-[11px] font-semibold px-3 py-1.5 rounded-lg border border-white/20 flex items-center gap-1.5 shadow-md transition-colors pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                                </svg>
                                <span>Lihat Gambar Penuh</span>
                            </div>
                        </div>
                        <figcaption class="px-4 py-2 bg-slate-50 border-t border-slate-100 text-[11px] text-slate-500 flex items-center justify-between">
                            <span>Dokumentasi Sanitasi &amp; Pemipaan Drainusantara</span>
                            <span class="font-medium text-slate-600">Standar Teknis Lapangan</span>
                        </figcaption>
                    </figure>
                @endif

                <!-- Excerpt Takeaway Box (Intisari Panduan) -->
                @if($article->excerpt)
                    <div class="mb-8 p-4 sm:p-5 rounded-xl bg-sky-50/70 border-l-4 border-sky-700 border-t border-r border-b border-sky-100 text-slate-800">
                        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-sky-800 mb-1.5">
                            <svg class="w-4 h-4 text-sky-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Intisari Panduan</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium">
                            {{ $article->excerpt }}
                        </p>
                    </div>
                @endif

                <!-- Table of Contents for Mobile View (Collapsible) -->
                @if(!empty($article->table_of_contents) && count($article->table_of_contents) > 0)
                    <div class="block lg:hidden mb-8 p-5 rounded-xl bg-slate-50 border border-slate-200" x-data="{ openToc: false }">
                        <button type="button" 
                                @click="openToc = !openToc" 
                                class="w-full flex items-center justify-between font-bold text-slate-900 text-sm">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                                <span>Daftar Isi Panduan</span>
                            </span>
                            <svg class="w-4 h-4 text-slate-500 transform transition-transform" :class="openToc ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <nav x-show="openToc" x-transition class="mt-4 pt-3 border-t border-slate-200 text-xs space-y-2">
                            @foreach($article->table_of_contents as $item)
                                <a href="#{{ $item['id'] }}" 
                                   @click="openToc = false"
                                   class="block text-slate-600 hover:text-sky-700 transition-colors {{ $item['level'] === 3 ? 'pl-4 text-slate-500' : 'font-semibold' }}">
                                    {{ $item['title'] }}
                                </a>
                            @endforeach
                        </nav>
                    </div>
                @endif

                <!-- Rendered Markdown & HTML Content with Rich Typography -->
                <div class="article-content">
                    {!! $article->rendered_content !!}
                </div>

                <!-- Tag Pendukung di Bawah Artikel -->
                @if(!empty($article->tags_list))
                    <div class="mt-10 pt-6 border-t border-slate-100">
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2.5">
                            Topik Terkait:
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            @foreach($article->tags_list as $tag)
                                <span class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
                                    #{{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                
            </main>

            <!-- Sticky Sidebar Column -->
            <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">
                
                <!-- Table of Contents Widget (Desktop View) -->
                @if(!empty($article->table_of_contents) && count($article->table_of_contents) > 0)
                    <div class="hidden lg:block bg-white rounded-xl border border-slate-200 p-6 shadow-xs">
                        <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                            <svg class="w-4 h-4 text-sky-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                            <h3 class="font-bold text-slate-900 text-sm tracking-tight">Daftar Isi Panduan</h3>
                        </div>
                        <nav class="space-y-2 text-xs">
                            @foreach($article->table_of_contents as $item)
                                <a href="#{{ $item['id'] }}" 
                                   class="block text-slate-600 hover:text-sky-700 transition-colors leading-snug {{ $item['level'] === 3 ? 'pl-4 text-slate-500 border-l border-slate-200' : 'font-semibold text-slate-800' }}">
                                    {{ $item['title'] }}
                                </a>
                            @endforeach
                        </nav>
                    </div>
                @endif

                <!-- 24-Hour Emergency Help Widget -->
                <div class="bg-slate-900 text-white rounded-xl p-6 border border-slate-800 shadow-xs space-y-4">
                    <h3 class="text-base font-extrabold leading-snug">
                        Armada Teknisi Siaga Meluncur ke Alamat Anda
                    </h3>

                    <p class="text-xs text-slate-400 leading-relaxed">
                        Layanan darurat pelancaran wastafel, kloset, talang, dan pipa pembuangan untuk Jabodetabek, Semarang, dan Lampung.
                    </p>

                    <div class="pt-2">
                        <a href="https://wa.me/{{ config('app.whatsapp_number', '6285609009009') }}?text={{ rawurlencode('Halo Admin Drainusantara, saya membutuhkan kedatangan teknisi pelancar saluran pipa ke alamat saya.') }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="btn-press w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-xs transition-colors min-h-[44px]">
                            <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>Panggil Teknisi Sekarang</span>
                        </a>
                    </div>
                </div>

                <!-- Related Guides Sidebar Widget -->
                @if(isset($recentArticles) && $recentArticles->isNotEmpty())
                    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs">
                        <div class="mb-4 pb-3 border-b border-slate-100">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-sky-800">
                                PANDUAN LAINNYA
                            </h3>
                        </div>
                        <div class="space-y-4">
                            @foreach($recentArticles->take(3) as $related)
                                <a href="{{ route('articles.show', $related->slug) }}" 
                                   class="group block border-b border-slate-100 pb-3 last:border-b-0 last:pb-0">
                                    <span class="text-[10px] font-bold text-sky-700 block mb-1">
                                        {{ $related->category ?? 'Tips' }}
                                    </span>
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-sky-700 transition-colors leading-snug line-clamp-2">
                                        {{ $related->title }}
                                    </h4>
                                    <div class="flex items-center gap-2 text-[11px] text-slate-400 mt-1">
                                        <span>{{ $related->reading_time }} mnt baca</span>
                                        <span>&bull;</span>
                                        <span>{{ number_format($related->views_count) }}x</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </aside>
        </div>

        <!-- Bottom Related Articles Section (Full Grid) -->
        @if(isset($relatedArticles) && $relatedArticles->isNotEmpty())
            <section class="mt-16 sm:mt-20 reveal-soft">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-1">
                            REKOMENDASI PANDUAN TERKAIT
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                            Artikel Edukasi Pilihan Lainnya
                        </h2>
                    </div>

                    <a href="{{ route('articles.index') }}" 
                       class="hidden sm:inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-sky-700 hover:text-sky-800 transition-colors">
                        <span>Lihat Semua di Blog</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-3.5 sm:gap-6">
                    @foreach($relatedArticles as $related)
                        <article class="bg-white rounded-xl border border-slate-200 shadow-2xs hover:border-sky-300 hover:shadow-md transition-all flex flex-col group card-lift overflow-hidden">
                            <a href="{{ route('articles.show', $related->slug) }}" class="block relative overflow-hidden aspect-16/10 bg-slate-100">
                                @if($related->thumbnail)
                                    <img src="{{ $related->thumbnail }}" 
                                         alt="{{ $related->title }}" 
                                         width="600" 
                                         height="375" 
                                         loading="lazy" 
                                         decoding="async" 
                                         class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400 text-xs font-semibold">
                                        Panduan Sanitasi
                                    </div>
                                @endif
                                <span class="absolute top-2 left-2 bg-slate-900/85 backdrop-blur-xs text-white text-[10px] font-bold px-2 py-0.5 rounded-md border border-white/20">
                                    {{ $related->category_label }}
                                </span>
                            </a>
                            <div class="p-3 sm:p-5 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-slate-400 mb-1.5 sm:mb-2 font-medium flex-wrap">
                                        <span>{{ $related->published_at ? $related->published_at->format('d M Y') : $related->created_at->format('d M Y') }}</span>
                                        <span>&bull;</span>
                                        <span>{{ $related->reading_time }} mnt</span>
                                        <span>&bull;</span>
                                        <span>{{ number_format($related->views_count) }}x</span>
                                    </div>
                                    <h3 class="text-xs sm:text-base font-bold text-slate-900 group-hover:text-sky-700 transition-colors leading-snug line-clamp-2">
                                        <a href="{{ route('articles.show', $related->slug) }}">
                                            {{ $related->title }}
                                        </a>
                                    </h3>
                                    <p class="mt-1.5 text-xs text-slate-600 line-clamp-2 leading-relaxed hidden sm:block">
                                        {{ $related->excerpt ?? Str::limit(strip_tags($related->content), 80) }}
                                    </p>
                                </div>
                                <div class="mt-3 pt-2 sm:mt-4 sm:pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] sm:text-xs">
                                    <span class="font-bold text-sky-700 group-hover:text-sky-800 inline-flex items-center gap-1 transition-colors">
                                        Baca Panduan &rarr;
                                    </span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

    </div>

    <!-- Modal Lightbox / Image Zoom Viewer -->
    <div x-show="isOpen" 
         x-cloak 
         @keydown.escape.window="close()" 
         class="fixed inset-0 z-[100] flex flex-col bg-slate-950/95 backdrop-blur-md"
         role="dialog" 
         aria-modal="true" 
         aria-label="Penampil Gambar Penuh">
        
        <!-- Top Navigation Bar / Controls -->
        <div class="flex items-center justify-between px-4 sm:px-6 py-3 bg-slate-900/90 border-b border-slate-800 text-white shrink-0">
            <div class="flex items-center gap-2 max-w-[50%] sm:max-w-md truncate">
                <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-xs sm:text-sm font-semibold truncate" x-text="activeAlt"></span>
            </div>

            <!-- Toolbar Controls -->
            <div class="flex items-center gap-1.5 sm:gap-2">
                <!-- Zoom Out -->
                <button type="button" 
                        @click="zoomOut()" 
                        :disabled="zoomLevel <= 1"
                        :class="zoomLevel <= 1 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-800 active:scale-95'"
                        class="min-h-[44px] min-w-[44px] flex items-center justify-center rounded-lg bg-slate-800/80 text-white transition-all border border-slate-700/60"
                        title="Perkecil (-)" aria-label="Perkecil Gambar">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                    </svg>
                </button>

                <!-- Zoom Level Display -->
                <span class="text-xs font-mono font-bold px-2.5 py-1 rounded-lg bg-slate-800 border border-slate-700 text-sky-300 min-w-[56px] text-center select-none"
                      x-text="Math.round(zoomLevel * 100) + '%'">
                </span>

                <!-- Zoom In -->
                <button type="button" 
                        @click="zoomIn()" 
                        :disabled="zoomLevel >= 3"
                        :class="zoomLevel >= 3 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-800 active:scale-95'"
                        class="min-h-[44px] min-w-[44px] flex items-center justify-center rounded-lg bg-slate-800/80 text-white transition-all border border-slate-700/60"
                        title="Perbesar (+)" aria-label="Perbesar Gambar">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </button>

                <!-- Reset Zoom -->
                <button type="button" 
                        @click="resetZoom()" 
                        class="hidden sm:inline-flex min-h-[44px] items-center justify-center px-3 rounded-lg bg-slate-800/80 hover:bg-slate-800 active:scale-95 text-white text-xs font-semibold transition-all border border-slate-700/60"
                        title="Kembalikan ke Ukuran Semula" aria-label="Reset Ukuran">
                    Reset
                </button>

                <!-- Open original in new tab -->
                <a :href="activeSrc" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="hidden sm:inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-lg bg-slate-800/80 hover:bg-slate-800 active:scale-95 text-slate-300 hover:text-white transition-all border border-slate-700/60"
                   title="Buka Gambar Asli di Tab Baru" aria-label="Buka di Tab Baru">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>

                <!-- Close Button -->
                <button type="button" 
                        @click="close()" 
                        class="min-h-[44px] min-w-[44px] flex items-center justify-center rounded-lg bg-rose-600/90 hover:bg-rose-600 active:scale-95 text-white transition-all border border-rose-500/60 ml-1"
                        title="Tutup (ESC)" aria-label="Tutup Penampil Gambar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Image Main Stage -->
        <div class="flex-1 overflow-auto p-4 sm:p-8 flex items-center justify-center cursor-zoom-out" 
             @click.self="close()">
            <div class="relative transition-transform duration-200 ease-out" 
                 :style="'transform: scale(' + zoomLevel + '); transform-origin: center center;'">
                <img :src="activeSrc" 
                     :alt="activeAlt" 
                     class="max-h-[80vh] max-w-[92vw] sm:max-w-[85vw] object-contain rounded-lg shadow-2xl border border-slate-700/40 select-none cursor-default"
                     @click.stop>
            </div>
        </div>

        <!-- Footer Hint -->
        <div class="py-2.5 px-4 bg-slate-900/80 text-center text-[11px] text-slate-400 border-t border-slate-800/80 shrink-0">
            <span>Gunakan tombol perbesar atau tekan <kbd class="px-1.5 py-0.5 rounded bg-slate-800 text-slate-300 border border-slate-700 font-mono text-[10px]">ESC</kbd> untuk menutup</span>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.blogImageViewer = function() {
        return {
            isOpen: false,
            activeSrc: '',
            activeAlt: '',
            zoomLevel: 1,

            init() {
                this.$nextTick(() => {
                    const contentImgs = document.querySelectorAll('.article-content img');
                    contentImgs.forEach(img => {
                        img.classList.add('cursor-zoom-in', 'hover:opacity-95', 'transition-opacity');
                        img.setAttribute('title', 'Klik untuk melihat foto lebih besar');
                        img.addEventListener('click', () => {
                            this.open(img.src, img.alt || 'Dokumentasi Artikel');
                        });
                    });
                });
            },

            open(src, alt) {
                this.activeSrc = src;
                this.activeAlt = alt || 'Dokumentasi Sanitasi & Pemipaan Drainusantara';
                this.zoomLevel = 1;
                this.isOpen = true;
                document.body.style.overflow = 'hidden';
            },

            close() {
                this.isOpen = false;
                document.body.style.overflow = '';
                this.zoomLevel = 1;
            },

            zoomIn() {
                if (this.zoomLevel < 3) {
                    this.zoomLevel = Math.round((this.zoomLevel + 0.5) * 10) / 10;
                }
            },

            zoomOut() {
                if (this.zoomLevel > 1) {
                    this.zoomLevel = Math.round((this.zoomLevel - 0.5) * 10) / 10;
                }
            },

            resetZoom() {
                this.zoomLevel = 1;
            }
        };
    };
</script>
@endpush
@endsection
