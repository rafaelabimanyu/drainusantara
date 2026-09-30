@props([
    'name' => 'image',
    'id' => null,
    'label' => 'Upload Gambar',
    'current' => null,
    'help' => 'Pilih file gambar resolusi tinggi (16:9 disarankan, maks 5MB).',
    'required' => false,
])

@php
    $resolvedCurrent = null;
    if ($current) {
        $resolvedCurrent = filter_var($current, FILTER_VALIDATE_URL) ? $current : asset($current);
    }
    $inputId = $id ?? $name;
@endphp

<div x-data="{ preview: '{{ $resolvedCurrent }}' }">
    <label for="{{ $inputId }}" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
        {{ $label }}
        @if($required) <span class="text-rose-600">*</span> @endif
    </label>
    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center p-4 bg-slate-50/75 rounded-lg border border-slate-200">
        <div class="w-28 h-20 rounded-md border border-slate-300 bg-white flex items-center justify-center overflow-hidden shrink-0 shadow-2xs">
            <template x-if="preview">
                <img :src="preview" class="w-full h-full object-cover">
            </template>
            <template x-if="!preview">
                <div class="text-center p-2 text-slate-400">
                    <svg class="w-5 h-5 mx-auto mb-1 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-[10px]">Belum ada foto</span>
                </div>
            </template>
        </div>
        <div class="flex-1 w-full space-y-1">
            <input type="file" name="{{ $name }}" id="{{ $inputId }}" accept="image/*"
                   {{ $required && !$current ? 'required' : '' }}
                   @change="const f = $event.target.files[0]; if (f) { preview = URL.createObjectURL(f); }"
                   class="block w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
            @if($help)
                <p class="text-[11px] text-slate-500">{{ $help }}</p>
            @endif
            @error($name) <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>
</div>
