@extends('layouts.app')

@section('content')
<main class="flex-grow">
    <!-- Hero Banner -->
    <section class="bg-gradient-to-b from-sky-900 via-sky-800 to-slate-900 text-white py-16 sm:py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center fade-up">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-500/20 text-sky-200 border border-sky-400/30 text-xs font-bold uppercase tracking-wider mb-4">
                <svg class="w-4 h-4 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Portofolio & Dokumentasi Nyata
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight max-w-3xl mx-auto leading-tight">
                Galeri Hasil Pengerjaan <span class="text-sky-400">Drainusantara</span>
            </h1>
            <p class="mt-4 text-base sm:text-lg text-sky-100/90 max-w-2xl mx-auto leading-relaxed">
                Bukti dokumentasi foto sebelum & sesudah tim teknisi kami melancarkan saluran mampet menggunakan mesin rooter spiral baja dan endoscopic camera 30 meter.
            </p>
        </div>
    </section>

    <!-- Gallery Grid Section -->
    <section class="py-16 sm:py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-10">
                @forelse($galleries as $item)
                <div class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group fade-up delay-{{ min($loop->iteration * 100, 300) }}">
                    <!-- Before / After Photos -->
                    <div class="relative bg-slate-900 overflow-hidden">
                        @if($item->before_image && $item->after_image)
                            <div class="grid grid-cols-2 gap-1 p-2 bg-slate-950">
                                <div class="relative group/img overflow-hidden rounded-xl">
                                    <img src="{{ $item->before_image }}" alt="Sebelum - {{ $item->title }}" class="w-full h-48 sm:h-56 object-cover transform group-hover/img:scale-105 transition duration-300">
                                    <span class="absolute top-2 left-2 bg-red-600/90 backdrop-blur-xs text-white text-[11px] font-extrabold px-2.5 py-1 rounded-md shadow">
                                        SEBELUM (MAMPET)
                                    </span>
                                </div>
                                <div class="relative group/img overflow-hidden rounded-xl">
                                    <img src="{{ $item->after_image }}" alt="Sesudah - {{ $item->title }}" class="w-full h-48 sm:h-56 object-cover transform group-hover/img:scale-105 transition duration-300">
                                    <span class="absolute top-2 right-2 bg-sky-600/90 backdrop-blur-xs text-white text-[11px] font-extrabold px-2.5 py-1 rounded-md shadow">
                                        SESUDAH (LANCAR)
                                    </span>
                                </div>
                            </div>
                        @elseif($item->image)
                            <img src="{{ $item->image }}" alt="{{ $item->title }}" class="w-full h-64 object-cover transform group-hover:scale-105 transition duration-300">
                        @else
                            <div class="w-full h-56 bg-slate-100 flex items-center justify-center text-slate-400">
                                Dokumentasi Lapangan
                            </div>
                        @endif
                    </div>

                    <!-- Content Details -->
                    <div class="p-6 sm:p-7 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                    {{ $item->service ? $item->service->name : 'Plumbing Spesialis' }}
                                </span>
                                <span class="text-xs font-semibold text-emerald-600 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    100% Tanpa Bongkar
                                </span>
                            </div>

                            <h3 class="text-xl font-bold text-slate-900 group-hover:text-sky-600 transition-colors leading-snug">
                                {{ $item->title }}
                            </h3>

                            <p class="mt-3 text-slate-600 text-sm leading-relaxed">
                                {{ $item->description }}
                            </p>
                        </div>

                        <!-- CTA WhatsApp Action -->
                        @php
                            $waMessage = urlencode("Halo Teknisi Drainusantara, saya tertarik dengan pengerjaan '{$item->title}'. Saluran pipa saya juga mengalami masalah serupa, mohon info estimasi biaya dan jadwal kunjungan.");
                            $waUrl = "https://wa.me/" . config('app.whatsapp_number', '6281234567890') . "?text={$waMessage}";
                        @endphp
                        <div class="mt-6 pt-5 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs font-medium text-slate-400">Garansi 30 Hari Kerja</span>
                            <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" 
                               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs shadow-md shadow-orange-600/20 transition-all transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                </svg>
                                Pesan Layanan Serupa
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-2 py-16 text-center text-slate-400">
                    Dokumentasi galeri sedang dipersiapkan.
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Emergency Consultation CTA Section -->
    <section class="bg-white border-t border-slate-200 py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 text-center fade-up">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Saluran Pipa Rumah Anda Sedang Mampet?</h2>
            <p class="mt-3 text-slate-600 text-sm sm:text-base max-w-2xl mx-auto">
                Jangan ambil risiko menuang soda api yang bisa merusak pipa PVC. Hubungi teknisi profesional Drainusantara sekarang juga!
            </p>
            <div class="mt-6">
                <a href="https://wa.me/{{ config('app.whatsapp_number', '6281234567890') }}?text={{ urlencode('Halo Drainusantara, saya ingin konsultasi pengerjaan saluran mampet.') }}" 
                   target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-3 px-8 py-3.5 rounded-full bg-orange-600 hover:bg-orange-700 text-white font-extrabold text-base shadow-lg shadow-orange-600/30 transition-all transform hover:-translate-y-0.5">
                    Hubungi Teknisi Sekarang (Gratis Konsultasi) &rarr;
                </a>
            </div>
        </div>
    </section>
</main>
@endsection
