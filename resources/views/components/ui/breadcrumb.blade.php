@props([
    'items' => [],
    'showHome' => true,
])

<nav class="hidden sm:flex items-center gap-2 text-xs text-slate-500 mb-6 font-medium flex-wrap reveal-fade" aria-label="Breadcrumb">
    @if($showHome)
        <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Beranda</span>
        </a>
    @endif

    @foreach($items as $item)
        @if($showHome || !$loop->first)
            <span class="text-slate-300">/</span>
        @endif
        @if(!empty($item['url']) && !$loop->last)
            <a href="{{ $item['url'] }}" class="hover:text-sky-700 transition-colors">
                {{ $item['label'] }}
            </a>
        @else
            <span class="text-sky-700 font-bold">
                {{ $item['label'] }}
            </span>
        @endif
    @endforeach
</nav>
