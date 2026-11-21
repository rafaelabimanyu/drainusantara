@props([
    'label' => 'Item',
    'surface' => 'light',
    'hideAt' => 'md',
    'count' => null,
])

@if($count === null || (int) $count > 1)
    @php
        $isDark = $surface === 'dark';
        $hideClass = $hideAt === 'sm' ? 'sm:hidden' : 'md:hidden';
        $textMuted = $isDark ? 'text-slate-300' : 'text-slate-600';
        $textStrong = $isDark ? 'text-white' : 'text-slate-900';
        $btnClasses = $isDark
            ? 'bg-slate-900 border-slate-700 text-slate-100 hover:bg-slate-800 focus-visible:ring-sky-400'
            : 'bg-white border-slate-300 text-slate-800 hover:bg-slate-100 focus-visible:ring-sky-600';
    @endphp
    <div class="flex items-center justify-between gap-3 mt-3 {{ $hideClass }}">
        <div class="text-xs {{ $textMuted }} flex items-center gap-2 min-w-0">
            <span class="font-semibold">{{ $label }} <strong class="{{ $textStrong }}" x-text="active + 1">1</strong> / <span x-text="total">{{ $count ?? 1 }}</span></span>
            <span aria-hidden="true">&bull;</span>
            <span>Geser kartu</span>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <button type="button"
                    @click="goTo(Math.max(0, active - 1))"
                    :disabled="active === 0"
                    aria-label="{{ $label }} sebelumnya"
                    class="min-h-11 min-w-11 inline-flex items-center justify-center rounded-md border transition-colors cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed focus:outline-hidden focus-visible:ring-2 {{ $btnClasses }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button type="button"
                    @click="goTo(Math.min(total - 1, active + 1))"
                    :disabled="active >= total - 1"
                    aria-label="{{ $label }} berikutnya"
                    class="min-h-11 min-w-11 inline-flex items-center justify-center rounded-md border transition-colors cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed focus:outline-hidden focus-visible:ring-2 {{ $btnClasses }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>
@endif
