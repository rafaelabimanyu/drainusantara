@props([
    'faqs' => [],
    'otherChannels' => [],
    'heading' => 'Tanya Jawab Layanan',
    'subheading' => 'Informasi prosedural seputar pemesanan, area jangkauan, dan jaminan pengerjaan.',
    'channelSlug' => 'cs',
    'variant' => 'split',
])

@if(!empty($faqs))
    @if($variant === 'dark')
        <section class="py-9 sm:py-16 bg-slate-900 text-slate-100 border-t border-slate-800" x-data="{ openItem: 0 }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <div class="lg:col-span-4 space-y-3">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                        {{ $heading }}
                    </h2>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        {{ $subheading }}
                    </p>
                </div>

                <div class="lg:col-span-8 divide-y divide-slate-800 border-y border-slate-800">
                    @foreach($faqs as $idx => $faq)
                        @php $panelId = "cs-faq-{$channelSlug}-{$idx}"; @endphp
                        <div>
                            <button type="button"
                                    @click="openItem = (openItem === {{ $idx }} ? null : {{ $idx }})"
                                    aria-expanded="{{ $idx === 0 ? 'true' : 'false' }}"
                                    :aria-expanded="openItem === {{ $idx }} ? 'true' : 'false'"
                                    aria-controls="{{ $panelId }}"
                                    class="w-full min-h-12 flex items-center justify-between gap-4 py-4 text-left text-sm sm:text-base font-bold text-white hover:text-sky-300 transition-colors cursor-pointer focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-400">
                                <span class="leading-snug">{{ $faq['question'] }}</span>
                                <svg class="w-5 h-5 text-slate-400 shrink-0 transition-transform duration-200"
                                     :class="{ 'rotate-180 text-sky-400': openItem === {{ $idx }} }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="{{ $panelId }}" x-show="openItem === {{ $idx }}" @if($idx !== 0) x-cloak @endif>
                                <div class="pb-5 text-sm text-slate-300 leading-relaxed">
                                    {{ $faq['answer'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @elseif($variant === 'compact')
        <section class="py-9 sm:py-16 bg-slate-50 border-t border-slate-200" x-data="{ openItem: 0 }">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
                <div class="space-y-2">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        {{ $heading }}
                    </h2>
                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                        {{ $subheading }}
                    </p>
                </div>

                <div class="bg-white border border-slate-200 rounded-lg divide-y divide-slate-200">
                    @foreach($faqs as $idx => $faq)
                        @php $panelId = "cs-faq-{$channelSlug}-{$idx}"; @endphp
                        <div>
                            <button type="button"
                                    @click="openItem = (openItem === {{ $idx }} ? null : {{ $idx }})"
                                    aria-expanded="{{ $idx === 0 ? 'true' : 'false' }}"
                                    :aria-expanded="openItem === {{ $idx }} ? 'true' : 'false'"
                                    aria-controls="{{ $panelId }}"
                                    class="w-full min-h-13 flex items-center justify-between gap-4 px-4 sm:px-5 py-4 text-left text-sm sm:text-base font-bold text-slate-900 hover:text-sky-700 transition-colors cursor-pointer focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 focus-visible:ring-inset">
                                <span class="leading-snug">{{ $faq['question'] }}</span>
                                <svg class="w-5 h-5 text-slate-500 shrink-0 transition-transform duration-200"
                                     :class="{ 'rotate-180 text-sky-700': openItem === {{ $idx }} }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="{{ $panelId }}" x-show="openItem === {{ $idx }}" @if($idx !== 0) x-cloak @endif>
                                <div class="px-4 sm:px-5 pb-5 pt-1 text-sm text-slate-700 leading-relaxed">
                                    {{ $faq['answer'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @else
        <section class="py-9 sm:py-16 bg-slate-50 border-t border-slate-200" x-data="{ openItem: 0 }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <div class="lg:col-span-4 space-y-3 lg:sticky lg:top-24">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        {{ $heading }}
                    </h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        {{ $subheading }}
                    </p>
                    <p class="text-xs text-slate-600 border-t border-slate-200 pt-3">
                        Hotline Resmi: <a href="tel:085609009009" class="font-bold text-sky-700 hover:underline">0856-0900-9009</a> (PT Jawa Jaya Rooter).
                    </p>
                </div>

                <div class="lg:col-span-8 divide-y divide-slate-200 border-y border-slate-200 bg-white px-4 sm:px-5 rounded-lg border-x">
                    @foreach($faqs as $idx => $faq)
                        @php $panelId = "cs-faq-{$channelSlug}-{$idx}"; @endphp
                        <div>
                            <button type="button"
                                    @click="openItem = (openItem === {{ $idx }} ? null : {{ $idx }})"
                                    aria-expanded="{{ $idx === 0 ? 'true' : 'false' }}"
                                    :aria-expanded="openItem === {{ $idx }} ? 'true' : 'false'"
                                    aria-controls="{{ $panelId }}"
                                    class="w-full min-h-12 flex items-center justify-between gap-4 py-4 text-left text-sm sm:text-base font-bold text-slate-900 hover:text-sky-700 transition-colors cursor-pointer focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                                <span class="leading-snug">{{ $faq['question'] }}</span>
                                <svg class="w-5 h-5 text-slate-500 shrink-0 transition-transform duration-200"
                                     :class="{ 'rotate-180 text-sky-700': openItem === {{ $idx }} }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="{{ $panelId }}" x-show="openItem === {{ $idx }}" @if($idx !== 0) x-cloak @endif>
                                <div class="pb-5 text-sm text-slate-700 leading-relaxed">
                                    {{ $faq['answer'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endif

@if(!empty($otherChannels))
<section class="py-9 sm:py-12 bg-white border-t border-slate-200 overflow-x-clip">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">
                    Meja Customer Service Kanal Lainnya
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-0.5">
                    Pilih platform lain yang Anda gunakan atau akses formulir pemesanan utama.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('customer-service.index') }}" class="min-h-11 inline-flex items-center px-3.5 py-2 rounded-md border border-slate-300 bg-slate-50 hover:bg-slate-100 text-xs sm:text-sm font-bold text-slate-800 transition-colors focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                    Semua Kanal CS
                </a>
                <a href="{{ route('contact') }}" class="min-h-11 inline-flex items-center px-3.5 py-2 rounded-md border border-sky-700 bg-sky-700 hover:bg-sky-800 text-xs sm:text-sm font-bold text-white transition-colors focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                    Form Kontak Utama
                </a>
            </div>
        </div>

        <div x-data="mobileCarousel({{ count($otherChannels) }}, 5500)" x-init="stopped = true">
            <div x-ref="slider"
                 tabindex="0"
                 role="region"
                 aria-label="Meja customer service kanal lainnya"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
                 @touchcancel="resume()"
                 class="flex overflow-x-auto snap-x snap-mandatory scroll-px-4 no-scrollbar gap-3 -mx-4 px-4 pb-2 sm:mx-0 sm:px-0 sm:grid sm:grid-cols-2 lg:grid-cols-5 sm:overflow-visible sm:pb-0">
                @foreach($otherChannels as $item)
                    <a href="{{ route('customer-service.show', ['socialMedia' => $item['slug']]) }}"
                       class="w-[74vw] max-w-[250px] sm:w-auto sm:max-w-none shrink-0 snap-start min-h-14 p-3.5 sm:p-4 rounded-lg border border-slate-200 bg-slate-50 hover:bg-white hover:border-sky-600 transition-colors card-lift flex items-start gap-3 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                        <span class="w-8 h-8 rounded-md bg-white border border-slate-200 text-slate-700 flex items-center justify-center shrink-0 mt-0.5">
                            <x-customer-service.channel-icon :channel="$item['slug']" class="w-4 h-4" />
                        </span>
                        <div class="min-w-0">
                            <span class="text-xs font-bold text-sky-700 block truncate">{{ $item['handle'] }}</span>
                            <span class="text-sm font-extrabold text-slate-900 block">CS {{ $item['name'] }}</span>
                        </div>
                    </a>
                @endforeach
            </div>

            <x-customer-service.carousel-controls label="Kanal" surface="light" hide-at="sm" :count="count($otherChannels)" />
        </div>
    </div>
</section>
@endif
