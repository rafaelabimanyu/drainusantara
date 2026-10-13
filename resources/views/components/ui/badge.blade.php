@props([
    'variant' => 'sky',
    'size' => 'sm'
])

@php
    $variantClasses = match($variant) {
        'emerald', 'success' => 'bg-emerald-50 text-emerald-800 border-emerald-200/60',
        'indigo' => 'bg-indigo-50 text-indigo-800 border-indigo-200/60',
        'amber', 'warning' => 'bg-amber-50 text-amber-800 border-amber-200/60',
        'red', 'danger' => 'bg-red-50 text-red-800 border-red-200/60',
        'slate', 'secondary' => 'bg-slate-100 text-slate-700 border-slate-200',
        default => 'bg-sky-50 text-sky-800 border-sky-200',
    };

    $sizeClasses = match($size) {
        'xs' => 'text-[9px] px-1.5 py-0.5',
        'md' => 'text-xs px-2.5 py-1',
        default => 'text-[10px] px-2 py-0.5',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center font-bold rounded-md border {$variantClasses} {$sizeClasses}"]) }}>
    {{ $slot }}
</span>
