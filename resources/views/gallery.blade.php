@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number', '6281234567890');
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
            <div class="flex flex-wrap items-center justify-center gap-2 mb-10 reveal-soft delay-150">
                <button type="button" @click="activeFilter = 'all'"
                        :class="activeFilter === 'all' ? 'bg-sky-700 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold'"
                        class="px-5 py-2.5 rounded-lg text-xs transition-colors cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-[44px]">
                    Semua Sektor ({{ count($galleries) }})
                </button>
                <button type="button" @click="activeFilter = 'rumahan'"
                        :class="activeFilter === 'rumahan' ? 'bg-sky-700 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold'"
                        class="px-5 py-2.5 rounded-lg text-xs transition-colors cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-[44px]">
                    Rumahan / Residensial ({{ $galleries->where('category', 'rumahan')->count() }})
                </button>
                <button type="button" @click="activeFilter = 'b2b'"
                        :class="activeFilter === 'b2b' ? 'bg-sky-700 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold'"
                        class="px-5 py-2.5 rounded-lg text-xs transition-colors cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-[44px]">
                    B2B / Komersial ({{ $galleries->where('category', 'b2b')->count() }})
                </button>
            </div>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-2 gap-3 sm:gap-6 lg:gap-8">
                @forelse($galleries as $item)
                    @php
                        $photoUrl = $item->image ?: ($item->after_image ?: $item->before_image);
                        $isB2b = ($item->category ?? 'rumahan') === 'b2b';
                    @endphp
                    <div x-show="activeFilter === 'all' || activeFilter === '{{ $item->category ?? 'rumahan' }}'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-98"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="bg-white rounded-xl border border-slate-200 shadow-2xs hover:shadow-md hover:border-sky-300 transition-all flex flex-col group card-lift reveal-soft stagger-{{ ($loop->iteration % 4) + 1 }}">
                        
                        <div class="relative aspect-[16/10] bg-slate-950 overflow-hidden border-b border-slate-100 group/img">
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

                            <!-- Sector Badge -->
                            @if($isB2b)
                                <div class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-slate-950/85 backdrop-blur-xs border border-amber-500/40 text-amber-300 text-[10px] sm:text-[11px] font-bold px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-md shadow-xs flex items-center gap-1 sm:gap-1.5">
                                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 fill-current shrink-0" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm3 1h6v2H7V5zm6 4H7v2h6V9zm-6 4h6v2H7v-2z"/>
                                    </svg>
                                    <span class="hidden sm:inline">B2B Komersial</span>
                                    <span class="sm:hidden">B2B</span>
                                </div>
                            @else
                                <div class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-slate-950/85 backdrop-blur-xs border border-sky-500/40 text-sky-300 text-[10px] sm:text-[11px] font-bold px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-md shadow-xs flex items-center gap-1 sm:gap-1.5">
                                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 fill-current shrink-0" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                    </svg>
                                    <span class="hidden sm:inline">Rumahan Residensial</span>
                                    <span class="sm:hidden">Rumahan</span>
                                </div>
                            @endif
                        </div>

                        <!-- Content Details -->
                        <div class="p-3 sm:p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex flex-wrap items-center justify-between gap-1.5 mb-2 sm:mb-3">
                                    <span class="px-2 py-0.5 text-[10px] sm:text-xs font-bold bg-sky-50 text-sky-800 border border-sky-200 rounded-md truncate max-w-full">
                                        {{ $item->service ? $item->service->name : 'Plumbing Spesialis' }}
                                    </span>
                                    <span class="hidden sm:flex text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-md items-center gap-1">
                                        ✓ 100% Tanpa Bongkar
                                    </span>
                                </div>

                                <h3 class="text-xs sm:text-lg md:text-xl font-bold text-slate-900 group-hover:text-sky-700 transition-colors leading-snug tracking-tight line-clamp-2">
                                    {{ $item->title }}
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
                                <span class="hidden md:inline-flex text-xs text-amber-800 bg-amber-50 px-2.5 py-1 rounded-md border border-amber-200/80 font-bold">
                                    Garansi 30 Hari
                                </span>
                                <a href="{{ $waUrl }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer" 
                                   class="btn-press w-full md:w-auto inline-flex items-center justify-center gap-1.5 px-2.5 sm:px-3.5 py-2 sm:py-2.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-xs shadow-2xs transition-colors min-h-[38px] sm:min-h-[44px]">
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

    <section class="py-14 lg:py-20 bg-slate-900 text-white border-t border-slate-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal-soft">
            <span class="text-xs font-bold uppercase tracking-widest text-sky-400 block mb-2">
                Konsultasi Bebas Biaya
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                Saluran Pipa Rumah Anda Sedang Mampet?
            </h2>
            <p class="mt-3 text-slate-400 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                Hindari risiko menuang soda api yang dapat merusak dan melengkungkan pipa PVC. Hubungi teknisi siaga Drainusantara untuk penanganan mekanis bebas bongkar.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ $generalWaUrl }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="btn-press inline-flex items-center gap-2 px-6 sm:px-8 py-3.5 sm:py-4 rounded-xl bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-sm shadow-md transition-colors min-h-[48px]">
                    <svg class="w-5 h-5 fill-current shrink-0" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Hubungi Teknisi via WhatsApp (Konsultasi Gratis)</span>
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
