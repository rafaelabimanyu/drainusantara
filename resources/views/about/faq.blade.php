@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6285609009009';
    $faqWaText = urlencode("Halo Admin Drainusantara, saya ingin bertanya lebih lanjut mengenai penanganan saluran pipa dan estimasi biaya.");
    $faqWaUrl = "https://wa.me/{$whatsappNumber}?text={$faqWaText}";
@endphp

<x-about.subnav 
    active-title="FAQ"
    eyebrow="Pusat Bantuan & Konsultasi"
    heading="Tanya Jawab Seputar Layanan & Prosedur Pengerjaan"
    subheading="Keterbukaan informasi seputar metode mekanis tanpa bongkar, armada mesin Ridgid & Hydro-Jetting, estimasi biaya transparan, legalitas, serta jaminan garansi 30 hari."
    :bg-image="asset('assets/banner/Drainusantara-jasa-saluran-mampet-profesional-desktop.webp')"
/>

<section id="faq-page" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200" x-data="{ openFaq: {{ !empty($faqs) ? ($faqs[0]['id'] ?? 1) : 1 }}, activeCategory: 'all' }">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-12 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Informasi Transparan
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Jawaban Langsung dari Tim Teknis Drainusantara
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2 leading-relaxed">
                Kami menjunjung tinggi kejelasan metode, keamanan instalasi pipa properti, serta kepastian garansi sebelum teknisi diberangkatkan ke lokasi Anda.
            </p>
        </div>

        @php
            $activeCategories = array_unique(array_column($faqs, 'category'));
        @endphp

        <!-- Category Pills Filter -->
        <div class="flex items-center justify-center gap-2 flex-wrap mb-8 reveal-soft delay-100">
            <button type="button" 
                    @click="activeCategory = 'all'"
                    :class="activeCategory === 'all' ? 'bg-slate-900 text-white border-slate-900 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'"
                    class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition-colors cursor-pointer">
                Semua Tanya Jawab ({{ count($faqs) }})
            </button>
            @foreach($categories as $catKey => $catLabel)
                @if(in_array($catKey, $activeCategories))
                    <button type="button" 
                            @click="activeCategory = '{{ $catKey }}'"
                            :class="activeCategory === '{{ $catKey }}' ? 'bg-slate-900 text-white border-slate-900 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'"
                            class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition-colors cursor-pointer">
                        {{ $catLabel }}
                    </button>
                @endif
            @endforeach
        </div>

        <!-- FAQ Items Accordion -->
        <div class="space-y-3.5 mb-12">
            @forelse($faqs as $item)
                @php
                    $q = $item['question'] ?? ($item['q'] ?? '');
                    $a = $item['answer'] ?? ($item['a'] ?? '');
                    $itemId = $item['id'] ?? $loop->iteration;
                    $cat = $item['category'] ?? 'umum';
                @endphp
                <div x-show="activeCategory === 'all' || activeCategory === '{{ $cat }}'"
                     class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs transition-all card-lift reveal-soft stagger-{{ ($loop->iteration % 4) + 1 }}">
                    <button type="button" 
                            @click="openFaq = (openFaq === {{ $itemId }} ? null : {{ $itemId }})"
                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                            :aria-expanded="openFaq === {{ $itemId }}" aria-controls="faq-answer-{{ $itemId }}"
                            class="w-full flex items-center justify-between p-4 sm:p-5 text-left text-xs sm:text-sm font-bold text-slate-900 hover:text-sky-700 transition-colors cursor-pointer min-h-[48px]">
                        <span class="pr-4 leading-snug">{{ $q }}</span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 shrink-0" 
                             :class="{ 'rotate-180 text-sky-700': openFaq === {{ $itemId }} }" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="faq-answer-{{ $itemId }}" x-show="openFaq === {{ $itemId }}" x-cloak>
                        <div class="px-4 sm:px-5 pb-5 pt-1 border-t border-slate-100 text-xs sm:text-sm text-slate-600 leading-relaxed">
                            {{ $a }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center bg-white rounded-xl border border-slate-200 text-slate-500">
                    Belum ada pertanyaan FAQ yang dipublikasikan.
                </div>
            @endforelse
        </div>

        <div class="bg-white p-6 sm:p-8 rounded-xl border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-6 reveal-soft">
            <div class="text-center sm:text-left max-w-xl">
                <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-1">
                    Layanan Konsultasi Bebas Biaya
                </span>
                <h3 class="text-lg font-bold text-slate-900">Pertanyaan Anda Belum Terjawab di Sini?</h3>
                <p class="text-slate-600 text-xs sm:text-sm mt-1 leading-relaxed">
                    Sampaikan kendala saluran mampet Anda kepada tim teknis Drainusantara. Kami berikan diagnosa awal dan estimasi pengerjaan via WhatsApp.
                </p>
            </div>
            <a href="{{ $faqWaUrl }}" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="btn-press inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-xs shadow-xs transition-colors shrink-0 min-h-[44px]">
                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                <span>Tanya Teknisi via WhatsApp</span>
            </a>
        </div>

    </div>
</section>
@endsection
