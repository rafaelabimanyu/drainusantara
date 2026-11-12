@props([
    'locationName',
    'locationTitle',
    'analysis',
    'whatsappUrl',
])

<section id="profil-layanan-lokal" class="py-14 lg:py-20 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Seksi -->
        <div class="text-center max-w-3xl mx-auto mb-10 md:mb-14">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold uppercase tracking-wider mb-2.5">
                <svg class="w-4 h-4 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>PROFIL LAYANAN &amp; CAKUPAN AREA LOKAL</span>
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Profil Layanan, Titik Cakupan &amp; Solusi Pipa Mampet di {{ $locationTitle }}
            </h2>
            <p class="text-xs sm:text-sm md:text-base text-slate-600 mt-2.5 leading-relaxed">
                Pemetaan karakteristik topografi perpipaan, estimasi mobilitas armada siaga, serta metode pelancaran mekanis modern tanpa bongkar keramik lantai khusus untuk warga {{ $locationTitle }}.
            </p>
        </div>

        <!-- 3 Kartu Analisis Karakteristik Lokal -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 lg:gap-6 mb-10">
            @foreach($analysis['analysis_cards'] ?? [] as $card)
                <div class="bg-slate-50 rounded-lg border border-slate-200 p-5 sm:p-6 flex flex-col justify-between shadow-2xs hover:border-sky-300 transition-colors group">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-bold tracking-wider uppercase bg-white border border-slate-200 text-sky-800 shadow-2xs">
                                {{ $card['badge'] }}
                            </span>
                            <span class="text-[11px] font-mono font-bold text-slate-400">0{{ $loop->iteration }}</span>
                        </div>

                        <h3 class="text-base font-bold text-slate-900 tracking-tight leading-snug group-hover:text-sky-800 transition-colors">
                            {{ $card['title'] }}
                        </h3>

                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            {{ $card['description'] }}
                        </p>

                        <div class="p-3 bg-white rounded-md border border-slate-200 text-xs text-slate-700 leading-relaxed">
                            <strong class="text-slate-900 block font-semibold text-[11px] mb-1">Catatan Teknis Lapangan:</strong>
                            {{ $card['detail'] }}
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-200/80 mt-4">
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" 
                           class="text-xs font-bold text-sky-700 hover:text-sky-900 inline-flex items-center gap-1.5 transition-colors">
                            <span>Konsultasikan Masalah Ini</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Tabel / Ringkasan Standar Layanan Lokal -->
        <div class="bg-white rounded-lg border border-slate-200 overflow-hidden shadow-2xs mb-8">
            <div class="bg-slate-900 text-white p-4 sm:px-6 flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-800">
                <div>
                    <h3 class="text-sm sm:text-base font-extrabold text-white tracking-tight">
                        Ringkasan Standar Layanan Teknisi di {{ $locationTitle }}
                    </h3>
                    <p class="text-[11px] text-slate-300">Komitmen SLA operasional resmi Drainusantara (PT Jawa Jaya Rooter)</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Posko Armada Siaga
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-slate-200">
                @foreach($analysis['service_specs'] ?? [] as $spec)
                    <div class="p-4 sm:p-5 space-y-2 hover:bg-slate-50 transition-colors">
                        <div class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            {{ $spec['label'] }}
                        </div>
                        <div class="text-xs sm:text-sm font-bold text-slate-900 leading-snug">
                            {{ $spec['value'] }}
                        </div>
                        @if(!empty($spec['badge']))
                            <div class="pt-1">
                                <span class="inline-block text-[10px] font-semibold text-sky-800 bg-sky-50 px-2 py-0.5 rounded border border-sky-200">
                                    {{ $spec['badge'] }}
                                </span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Titik Landmark & Kawasan Layanan Terkait -->
        @if(!empty($analysis['landmarks']))
            <div class="p-4 sm:p-5 rounded-lg bg-slate-50 border border-slate-200 space-y-2.5">
                <div class="flex items-center gap-2 text-sky-800 font-bold uppercase tracking-wider text-xs">
                    <svg class="w-4 h-4 text-sky-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Titik Kawasan, Jalan Utama &amp; Sentra Pemukiman di {{ $locationTitle }}:</span>
                </div>
                <div class="flex flex-wrap gap-1.5">
                    @foreach($analysis['landmarks'] as $landmark)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-white border border-slate-200 text-xs font-medium text-slate-700 shadow-2xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500 mr-1.5"></span>
                            {{ $landmark }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</section>

