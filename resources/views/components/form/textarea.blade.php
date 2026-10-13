@props([
    'name',
    'id' => null,
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'rows' => 4,
    'help' => null,
])

@php
    $inputId = $id ?? $name;
@endphp

<div>
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-bold text-slate-700 mb-2">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif
    <textarea name="{{ $name }}" 
              id="{{ $inputId }}" 
              rows="{{ $rows }}"
              @if($placeholder) placeholder="{{ $placeholder }}" @endif
              @if($required) required @endif
              {{ $attributes->merge(['class' => 'w-full px-4 py-2.5 rounded-xl border ' . ($errors->has($name) ? 'border-red-400 focus:border-red-500 focus:ring-red-500/20' : 'border-slate-200 focus:border-sky-500 focus:ring-sky-500/20') . ' focus:ring-2 text-slate-800 text-sm outline-none transition bg-white']) }}>{{ old($name, $value) }}</textarea>
    @if($help)
        <p class="text-[11px] text-slate-400 mt-1">{{ $help }}</p>
    @endif
    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
