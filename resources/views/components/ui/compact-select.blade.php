@props([
    'id' => '',
    'name' => null,
    'value' => '',
    'placeholder' => 'Pilih opsi',
    'placeholderExpr' => null,
    'groups' => [],
    'options' => [],
    'optionsExpr' => null,
    'disabledExpr' => null,
    'searchable' => false,
    'searchPlaceholder' => 'Cari...',
    'ringClass' => 'focus-visible:ring-sky-600',
    'allowClear' => true,
])

@php
    $normalizedGroups = [];
    $labelMap = [];

    foreach ($groups as $group) {
        $groupOptions = [];
        foreach (($group['options'] ?? []) as $opt) {
            $optValue = is_array($opt) ? (string) ($opt['value'] ?? $opt['label'] ?? '') : (string) $opt;
            $optLabel = is_array($opt) ? (string) ($opt['label'] ?? $optValue) : (string) $opt;
            if ($optValue !== '') {
                $groupOptions[] = ['value' => $optValue, 'label' => $optLabel];
                $labelMap[$optValue] = $optLabel;
            }
        }
        if (! empty($groupOptions)) {
            $normalizedGroups[] = [
                'label' => (string) ($group['label'] ?? ''),
                'options' => $groupOptions,
            ];
        }
    }

    $normalizedOptions = [];
    foreach ($options as $opt) {
        $optValue = is_array($opt) ? (string) ($opt['value'] ?? $opt['label'] ?? '') : (string) $opt;
        $optLabel = is_array($opt) ? (string) ($opt['label'] ?? $optValue) : (string) $opt;
        if ($optValue !== '') {
            $normalizedOptions[] = ['value' => $optValue, 'label' => $optLabel];
            $labelMap[$optValue] = $optLabel;
        }
    }

    $initialValue = (string) $value;
    $initialLabel = $initialValue !== '' ? ($labelMap[$initialValue] ?? $initialValue) : $placeholder;
    $disabledJs = $disabledExpr ?: 'false';
@endphp

<div {{ $attributes->merge(['class' => 'relative']) }}
     x-data="{
        open: false,
        query: '',
        selected: @js($initialValue),
        groups: @js($normalizedGroups),
        flatOptions: @js($normalizedOptions),
        labels: @js($labelMap),
        get displayLabel() {
            return this.selected ? (this.labels[this.selected] ?? this.selected) : '';
        },
        normalizeList(raw) {
            return (raw || []).map(item => typeof item === 'string'
                ? { value: item, label: item }
                : { value: String(item.value ?? item.label ?? ''), label: String(item.label ?? item.value ?? '') });
        },
        filterItems(items) {
            const q = this.query.trim().toLowerCase();
            if (!q) return items;
            return items.filter(item => item.label.toLowerCase().includes(q));
        },
        filteredDynamic(raw) {
            return this.filterItems(this.normalizeList(raw));
        },
        filteredFlat() {
            return this.filterItems(this.flatOptions);
        },
        filteredGroupOptions(group) {
            return this.filterItems(group.options || []);
        },
        hasNoMatches(rawDynamic) {
            if (rawDynamic !== null) {
                return this.filteredDynamic(rawDynamic).length === 0;
            }
            if (this.groups.length > 0) {
                return this.groups.every(g => this.filteredGroupOptions(g).length === 0);
            }
            return this.filteredFlat().length === 0;
        },
        choose(val) {
            this.selected = val;
            this.open = false;
            this.query = '';
        }
     }"
     x-modelable="selected"
     @click.outside="open = false; query = ''"
     @keydown.escape.window="open = false; query = ''">

    @if($name)
        <input type="hidden" name="{{ $name }}" :value="selected" value="{{ $initialValue }}">
    @endif

    <button @if($id !== '') id="{{ $id }}" @endif
            type="button"
            aria-haspopup="listbox"
            :aria-expanded="open ? 'true' : 'false'"
            :disabled="{{ $disabledJs }}"
            @click="if (!({{ $disabledJs }})) { open = !open; if (open) { $nextTick(() => $refs.searchInput?.focus()); } else { query = ''; } }"
            class="w-full h-10 px-3 py-1.5 rounded-md border border-slate-300 bg-white text-xs sm:text-sm text-left text-slate-900 flex items-center justify-between gap-2 transition-colors cursor-pointer disabled:bg-slate-100 disabled:text-slate-500 disabled:cursor-not-allowed focus:outline-hidden focus-visible:ring-2 {{ $ringClass }}">
        <span class="truncate"
              :class="selected ? 'text-slate-900 font-medium' : 'text-slate-500'"
              x-text="displayLabel || ({{ $placeholderExpr ?: \Illuminate\Support\Js::from($placeholder) }})">{{ $initialLabel }}</span>
        <svg class="w-4 h-4 text-slate-500 shrink-0 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="open"
         x-cloak
         class="absolute z-40 left-0 right-0 mt-1 rounded-md border border-slate-300 bg-white shadow-md overflow-hidden">
        @if($searchable)
            <div class="p-1.5 border-b border-slate-200 bg-slate-50">
                <input x-ref="searchInput"
                       type="search"
                       x-model="query"
                       placeholder="{{ $searchPlaceholder }}"
                       aria-label="{{ $searchPlaceholder }}"
                       class="w-full h-8 px-2.5 py-1 text-xs rounded-sm border border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:outline-hidden focus:ring-1 focus:ring-sky-500">
            </div>
        @endif

        <div role="listbox" class="max-h-44 overflow-y-auto py-1">
            @if($allowClear)
                <button type="button"
                        role="option"
                        :aria-selected="selected === '' ? 'true' : 'false'"
                        @click="choose('')"
                        :class="selected === '' ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-600'"
                        class="w-full text-left px-3 py-1.5 text-xs flex items-center justify-between gap-2 cursor-pointer transition-colors hover:bg-slate-100">
                    <span x-text="{{ $placeholderExpr ?: \Illuminate\Support\Js::from($placeholder) }}">{{ $placeholder }}</span>
                </button>
            @endif

            @if($optionsExpr)
                <template x-for="opt in filteredDynamic({{ $optionsExpr }})" :key="opt.value">
                    <button type="button"
                            role="option"
                            :aria-selected="selected === opt.value ? 'true' : 'false'"
                            @click="choose(opt.value)"
                            :class="selected === opt.value ? 'bg-sky-50 text-sky-800 font-bold' : 'text-slate-800'"
                            class="w-full text-left px-3 py-1.5 text-xs flex items-center justify-between gap-2 cursor-pointer transition-colors hover:bg-sky-50/70">
                        <span class="truncate" x-text="opt.label"></span>
                        <span x-show="selected === opt.value" class="text-sky-700 text-[11px] font-bold shrink-0">Dipilih</span>
                    </button>
                </template>
            @elseif(!empty($normalizedGroups))
                <template x-for="group in groups" :key="group.label">
                    <div x-show="filteredGroupOptions(group).length > 0">
                        <div class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-500 bg-slate-50 border-y border-slate-100"
                             x-text="group.label"></div>
                        <template x-for="opt in filteredGroupOptions(group)" :key="opt.value">
                            <button type="button"
                                    role="option"
                                    :aria-selected="selected === opt.value ? 'true' : 'false'"
                                    @click="choose(opt.value)"
                                    :class="selected === opt.value ? 'bg-sky-50 text-sky-800 font-bold' : 'text-slate-800'"
                                    class="w-full text-left px-3 py-1.5 text-xs flex items-center justify-between gap-2 cursor-pointer transition-colors hover:bg-sky-50/70">
                                <span class="truncate" x-text="opt.label"></span>
                                <span x-show="selected === opt.value" class="text-sky-700 text-[11px] font-bold shrink-0">Dipilih</span>
                            </button>
                        </template>
                    </div>
                </template>
            @else
                <template x-for="opt in filteredFlat()" :key="opt.value">
                    <button type="button"
                            role="option"
                            :aria-selected="selected === opt.value ? 'true' : 'false'"
                            @click="choose(opt.value)"
                            :class="selected === opt.value ? 'bg-sky-50 text-sky-800 font-bold' : 'text-slate-800'"
                            class="w-full text-left px-3 py-1.5 text-xs flex items-center justify-between gap-2 cursor-pointer transition-colors hover:bg-sky-50/70">
                        <span class="truncate" x-text="opt.label"></span>
                        <span x-show="selected === opt.value" class="text-sky-700 text-[11px] font-bold shrink-0">Dipilih</span>
                    </button>
                </template>
            @endif

            <div x-show="query.trim() !== '' && hasNoMatches({{ $optionsExpr ?: 'null' }})"
                 class="px-3 py-2 text-xs text-slate-500 text-center">
                Tidak ditemukan
            </div>
        </div>
    </div>
</div>
