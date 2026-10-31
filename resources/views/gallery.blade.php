@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number', '6285609009009');
    $generalWaUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode("Halo Drainusantara, saya ingin konsultasi penanganan saluran pipa mampet.");
@endphp

<div>
    <section class="relative bg-slate-50 border-b border-slate-200 pt-8 pb-12 lg:pt-12 lg:pb-16 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <nav class="flex items-center justify-center gap-2 text-xs text-slate-500 mb-4 font-medium reveal-fade" aria-label="Breadcrumb">
                <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Beranda</span>
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-sky-700 font-bold">Galeri Dokumentasi</span>
            </nav>

            <span class="text-xs font-bold uppercase tracking-widest text-sky-700 block mb-2 reveal-fade">
                Dokumentasi Teknis Lapangan
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight max-w-3xl mx-auto leading-tight reveal-soft">
                Galeri Hasil Pengerjaan <span class="text-sky-700">Drainusantara</span>
            </h1>
            <p class="mt-3 text-slate-600 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed reveal-soft delay-100">
                Dokumentasi foto teknis pengerjaan pelancaran pipa tersumbat sektor residensial (rumahan) dan komersial (B2B) oleh tim teknisi Drainusantara menggunakan mesin spiral baja rotary dan kamera inspeksi digital IP68.
            </p>
        </div>
    </section>

    <section class="py-12 sm:py-16 bg-white border-b border-slate-200" x-data="{ activeFilter: 'all' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(count($galleries) > 0)
            <div class="flex justify-center mb-10 reveal-soft delay-150">
                <div class="inline-flex p-1 bg-slate-100 rounded-lg border border-slate-200/80 max-w-full overflow-x-auto no-scrollbar shadow-2xs">
                    <button type="button" @click="activeFilter = 'all'"
                            :class="activeFilter === 'all' ? 'bg-white text-sky-700 font-bold shadow-xs border border-slate-200' : 'text-slate-600 hover:text-slate-900 font-medium'"
                            class="px-4 py-2 rounded-md text-xs transition-all cursor-pointer whitespace-nowrap min-h-[40px] focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                        Semua Sektor ({{ count($galleries) }})
                    </button>
                    <button type="button" @click="activeFilter = 'rumahan'"
                            :class="activeFilter === 'rumahan' ? 'bg-white text-sky-700 font-bold shadow-xs border border-slate-200' : 'text-slate-600 hover:text-slate-900 font-medium'"
                            class="px-4 py-2 rounded-md text-xs transition-all cursor-pointer whitespace-nowrap min-h-[40px] focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                        Rumahan / Residensial ({{ $galleries->where('category', 'rumahan')->count() }})
                    </button>
                    <button type="button" @click="activeFilter = 'b2b'"
                            :class="activeFilter === 'b2b' ? 'bg-white text-sky-700 font-bold shadow-xs border border-slate-200' : 'text-slate-600 hover:text-slate-900 font-medium'"
                            class="px-4 py-2 rounded-md text-xs transition-all cursor-pointer whitespace-nowrap min-h-[40px] focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                        B2B / Komersial ({{ $galleries->where('category', 'b2b')->count() }})
                    </button>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-2 gap-3 sm:gap-6 lg:gap-8">
                @forelse($galleries as $item)
                    @php
                        $photoUrl = $item->image ?: ($item->after_image ?: $item->before_image);
                        $isB2b = ($item->category ?? 'rumahan') === 'b2b';
                        $detailUrl = !empty($item->slug) ? route('case-study.show', $item->slug) : null;
                    @endphp
                    <div x-show="activeFilter === 'all' || activeFilter === '{{ $item->category ?? 'rumahan' }}'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-98"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="bg-white rounded-xl border border-slate-200 shadow-2xs hover:shadow-md hover:border-sky-300 transition-all flex flex-col group card-lift reveal-soft stagger-{{ ($loop->iteration % 4) + 1 }}">
                        
                        <div class="relative aspect-[16/10] bg-slate-950 overflow-hidden border-b border-slate-100 group/img">
                            @if($detailUrl)
                                <a href="{{ $detailUrl }}" class="block w-full h-full focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600" title="Lihat detail studi kasus: {{ $item->title }}">
                            @endif
                            @if($photoUrl)
                                <img src="{{ $photoUrl }}" 
                                     alt="{{ $item->title }}" 
                                     width="800" 
                                     height="500" 
                                     loading="lazy" 
                                     decoding="async" 
                                     class="w-full h-full object-cover transform group-hover/img:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-slate-100 flex flex-col items-center justify-center text-slate-400 gap-2 p-4 text-center">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-xs font-semibold">Foto Dokumentasi Lapangan Drainusantara</span>
                                </div>
                            @endif
                            @if($detailUrl)
                                </a>
                            @endif

                            <!-- Sector Label -->
                            @if($isB2b)
                                <span class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-slate-900/90 text-amber-300 text-[10px] sm:text-xs font-semibold px-2 py-0.5 rounded-sm">
                                    B2B Komersial
                                </span>
                            @else
                                <span class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-slate-900/90 text-sky-300 text-[10px] sm:text-xs font-semibold px-2 py-0.5 rounded-sm">
                                    Rumahan Residensial
                                </span>
                            @endif
                        </div>

                        <!-- Content Details -->
                        <div class="p-3 sm:p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <p class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-sky-800 mb-1.5 truncate">
                                    {{ $item->service ? $item->service->name : 'Plumbing Spesialis' }}
                                </p>

                                <h3 class="text-xs sm:text-lg md:text-xl font-bold text-slate-900 group-hover:text-sky-700 transition-colors leading-snug tracking-tight line-clamp-2">
                                    @if($detailUrl)
                                        <a href="{{ $detailUrl }}" class="hover:underline">
                                            {{ $item->title }}
                                        </a>
                                    @else
                                        {{ $item->title }}
                                    @endif
                                </h3>

                                <p class="mt-1 sm:mt-2.5 text-slate-600 text-[11px] sm:text-sm leading-relaxed line-clamp-2 sm:line-clamp-3">
                                    {{ $item->description }}
                                </p>
                            </div>

                            <!-- Action & Guarantee Footer -->
                            @php
                                $waMessage = urlencode("Halo Tim Drainusantara, saya tertarik dengan pengerjaan '{$item->title}'. Saluran pipa saya mengalami kendala serupa, mohon info estimasi biaya dan teknisi terdekat.");
                                $waUrl = "https://wa.me/{$whatsappNumber}?text={$waMessage}";
                            @endphp
                            <div class="mt-3 sm:mt-6 pt-2.5 sm:pt-4 border-t border-slate-100 flex items-center justify-between gap-2 sm:gap-3">
                                @if($detailUrl)
                                    <a href="{{ $detailUrl }}" 
                                       class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-sky-700 hover:text-sky-800 transition-colors py-2">
                                        <span>Lihat Detail</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </a>
                                @endif
                                <a href="{{ $waUrl }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer" 
                                   class="btn-press {{ $detailUrl ? '' : 'w-full md:w-auto' }} inline-flex items-center justify-center gap-1.5 px-2.5 sm:px-3.5 py-2 sm:py-2.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-xs shadow-2xs transition-colors min-h-[38px] sm:min-h-[44px]">
                                    <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24">
                                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                    </svg>
                                    <span class="hidden sm:inline">Pesan Layanan Serupa</span>
                                    <span class="sm:hidden">Konsultasi</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 px-4 text-center bg-white rounded-xl border border-slate-200 text-slate-500 reveal-soft">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-800 mb-1">Dokumentasi Belum Tersedia</h3>
                        <p class="text-xs text-slate-500 max-w-md mx-auto">Saat ini belum ada dokumentasi foto yang dipublikasikan. Foto pengerjaan akan tampil di sini setelah ditambahkan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- EDUKASI SANITASI AMAN (BAHAYA SODA API) -->
    <section class="py-14 lg:py-20 bg-slate-50 border-t border-slate-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border border-slate-200 p-6 sm:p-10 shadow-2xs">
                <div class="max-w-3xl mx-auto text-center mb-8">
                    <p class="text-xs font-bold uppercase tracking-wider text-amber-800 mb-2">
                        Peringatan Sanitasi Saluran
                    </p>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Mengapa Harus Menghindari Penggunaan Soda Api?
                    </h2>
                    <p class="mt-2 text-slate-600 text-xs sm:text-sm leading-relaxed">
                        Cairan atau bubuk kimia korosif seperti soda api sering kali memperparah kerusakan instalasi saluran pipa rumah tangga dan bisnis Anda.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 text-xs space-y-1.5">
                        <span class="font-bold text-slate-900 block text-sm">1. Merusak &amp; Melelehkan Pipa PVC</span>
                        <p class="text-slate-600 leading-relaxed">Reaksi soda api dengan air menghasilkan suhu panas ekstrem yang dapat melunakkan dan membengkokkan dinding pipa PVC.</p>
                    </div>

                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 text-xs space-y-1.5">
                        <span class="font-bold text-slate-900 block text-sm">2. Melarutkan Lem Sambungan</span>
                        <p class="text-slate-600 leading-relaxed">Panas tinggi melemahkan lem pada sambungan elbow pipa, memicu kebocoran tersembunyi di dalam dinding atau bawah lantai.</p>
                    </div>

                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 text-xs space-y-1.5">
                        <span class="font-bold text-slate-900 block text-sm">3. Mengkristal Jadi Semen Batu</span>
                        <p class="text-slate-600 leading-relaxed">Jika sumbatan tidak tembus, sisa soda api akan mengeras seperti semen batu yang menutup saluran secara permanen.</p>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-center sm:text-left">
                        <h3 class="text-sm font-bold text-slate-900">Solusi Aman Mekanis Drainusantara</h3>
                        <p class="text-xs text-slate-600 mt-0.5">Penanganan dengan mesin spiral rotary tanpa merusak pipa, bergaransi nota resmi 30 hari.</p>
                    </div>
                    <a href="{{ $generalWaUrl }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="btn-press shrink-0 inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-xs sm:text-sm shadow-2xs transition-colors min-h-[46px]">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Konsultasi Penanganan Tanpa Kimia</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
