@props([
    'name' => 'image',
    'id' => null,
    'label' => 'Upload Gambar',
    'current' => null,
    'help' => 'Format JPG, PNG, atau WEBP (Maks. 20MB). Gambar otomatis dikompresi & dikonversi ke WebP.',
    'required' => false,
    'aspect' => 'video', // 'video', 'square', 'auto'
    'allowUrl' => false,
    'urlName' => null,
    'urlValue' => null,
    'removeName' => null,
    'removeLabel' => 'Hapus gambar saat ini',
])

@php
    $resolvedCurrent = null;
    if ($current) {
        $resolvedCurrent = filter_var($current, FILTER_VALIDATE_URL) ? $current : asset(ltrim($current, '/'));
    }
    $inputId = $id ?? $name;
    $computedUrlName = $urlName ?? ($name . '_url');
    $computedUrlValue = $urlValue ?? old($computedUrlName);

    $aspectClasses = match($aspect) {
        'square' => 'w-24 h-24 sm:w-28 sm:h-28 aspect-square',
        'auto' => 'max-h-48 w-auto',
        default => 'w-36 sm:w-44 aspect-16/10',
    };
@endphp

<div x-data="{
    isDragging: false,
    dragCounter: 0,
    preview: {{ Illuminate\Support\Js::from($resolvedCurrent) }},
    initialPreview: {{ Illuminate\Support\Js::from($resolvedCurrent) }},
    fileName: '',
    fileSize: '',
    isNewUpload: false,
    showUrlInput: {{ ($allowUrl && !empty($computedUrlValue)) ? 'true' : 'false' }},
    urlText: {{ Illuminate\Support\Js::from($computedUrlValue ?? '') }},

    handleDragEnter(e) {
        this.dragCounter++;
        this.isDragging = true;
    },
    handleDragLeave(e) {
        this.dragCounter--;
        if (this.dragCounter <= 0) {
            this.isDragging = false;
            this.dragCounter = 0;
        }
    },
    handleDrop(e) {
        this.isDragging = false;
        this.dragCounter = 0;
        const files = e.dataTransfer?.files;
        if (files && files.length > 0) {
            const file = files[0];
            if (!file.type.match(/^image\/(jpeg|png|webp)$/i)) {
                alert('Format berkas tidak didukung. Harap unggah gambar bertipe JPG, PNG, atau WEBP.');
                return;
            }
            this.$refs.fileInput.files = e.dataTransfer.files;
            this.setFile(file);
        }
    },
    handleFileChange(e) {
        const file = e.target.files?.[0];
        if (file) {
            this.setFile(file);
        }
    },
    setFile(file) {
        const maxBytes = 20 * 1024 * 1024; // 20 MB
        if (file.size > maxBytes) {
            alert('Ukuran berkas terlalu besar (' + this.formatBytes(file.size) + '). Maksimal ukuran yang diizinkan adalah 20 MB.');
            this.resetFile();
            return;
        }
        this.preview = URL.createObjectURL(file);
        this.fileName = file.name;
        this.fileSize = this.formatBytes(file.size);
        this.isNewUpload = true;
        this.showUrlInput = false;
    },
    resetFile() {
        this.preview = this.initialPreview;
        this.fileName = '';
        this.fileSize = '';
        this.isNewUpload = false;
        if (this.$refs.fileInput) {
            this.$refs.fileInput.value = '';
        }
    },
    formatBytes(bytes) {
        if (!bytes || bytes === 0) return '0 B';
        const k = 1024;
        const sizes = ['B', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    }
}" class="space-y-1.5">

    <div class="flex items-center justify-between">
        <label for="{{ $inputId }}" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
            {{ $label }}
            @if($required) <span class="text-rose-600">*</span> @endif
        </label>
        @if($allowUrl)
            <button type="button" 
                    @click="showUrlInput = !showUrlInput" 
                    class="text-[11px] font-semibold text-sky-700 hover:text-sky-900 transition-colors focus:outline-hidden">
                <span x-text="showUrlInput ? '← Unggah Berkas Gambar' : '+ Gunakan Link URL Luar'"></span>
            </button>
        @endif
    </div>

    {{-- Fallback External URL Input (Jika allowUrl aktif dan dipilih) --}}
    @if($allowUrl)
        <div x-show="showUrlInput" x-cloak class="p-3 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
            <label class="block text-xs font-semibold text-slate-700">Tautan Gambar Luar (URL)</label>
            <div class="flex items-center gap-2">
                <input type="url" 
                       name="{{ $computedUrlName }}" 
                       x-model="urlText"
                       @input="if (urlText) { preview = urlText; isNewUpload = false; }"
                       placeholder="https://domain.com/path-ke-gambar.webp" 
                       class="w-full text-xs rounded-lg border border-slate-300 px-3 py-2 text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-sky-500 bg-white">
                <button type="button" @click="showUrlInput = false" class="text-xs px-3 py-2 rounded-lg bg-slate-200 text-slate-700 font-semibold hover:bg-slate-300 shrink-0">
                    Batal
                </button>
            </div>
            <p class="text-[11px] text-slate-500">Gunakan tautan langsung jika gambar sudah dihosting secara eksternal.</p>
        </div>
    @endif

    {{-- Dropzone Utama --}}
    <div x-show="!showUrlInput"
         @dragenter.prevent="handleDragEnter($event)"
         @dragleave.prevent="handleDragLeave($event)"
         @dragover.prevent
         @drop.prevent="handleDrop($event)"
         @click="$refs.fileInput.click()"
         :class="isDragging ? 'border-sky-500 bg-sky-50/80 ring-4 ring-sky-500/20 scale-[1.005]' : 'border-slate-300 hover:border-sky-500 bg-white hover:bg-slate-50/70'"
         class="relative rounded-xl border-2 border-dashed p-4 sm:p-5 transition-all duration-200 cursor-pointer shadow-2xs group focus-within:ring-2 focus-within:ring-sky-500/20 focus-within:border-sky-500">

        {{-- Hidden Native File Input --}}
        <input type="file" 
               x-ref="fileInput" 
               name="{{ $name }}" 
               id="{{ $inputId }}" 
               accept="image/jpeg,image/png,image/webp"
               @change="handleFileChange($event)"
               {{ $required && !$current ? 'required' : '' }}
               class="sr-only">

        {{-- Layout Ketika Ada Gambar (Preview Terisi) --}}
        <template x-if="preview">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4" @click.stop>
                <div class="{{ $aspectClasses }} rounded-lg overflow-hidden border border-slate-200 bg-slate-100 shrink-0 shadow-2xs relative flex items-center justify-center">
                    <img :src="preview" alt="Pratinjau" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-slate-900/40 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center text-white text-[11px] font-semibold cursor-pointer"
                         @click="$refs.fileInput.click()">
                        Klik Ganti
                    </div>
                </div>

                <div class="flex-1 min-w-0 text-center sm:text-left space-y-2">
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                        <template x-if="isNewUpload">
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Berkas Baru Terpilih
                            </span>
                        </template>
                        <template x-if="!isNewUpload">
                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 border border-slate-200">
                                Berkas Saat Ini
                            </span>
                        </template>
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-sky-100 text-sky-800">
                            ✨ Auto WebP
                        </span>
                    </div>

                    <div class="space-y-0.5">
                        <template x-if="fileName">
                            <p class="text-xs font-bold text-slate-900 truncate" x-text="fileName"></p>
                        </template>
                        <template x-if="fileSize">
                            <p class="text-[11px] text-slate-500" x-text="'Ukuran: ' + fileSize"></p>
                        </template>
                        <template x-if="!fileName">
                            <p class="text-xs text-slate-500">Tarik gambar baru ke sini untuk mengganti foto ini.</p>
                        </template>
                    </div>

                    <div class="pt-1 flex items-center justify-center sm:justify-start gap-2">
                        <button type="button" 
                                @click="$refs.fileInput.click()" 
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-700 font-bold text-xs border border-sky-200 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            <span>Ganti Gambar</span>
                        </button>

                        <template x-if="isNewUpload && initialPreview">
                            <button type="button" 
                                    @click="resetFile()" 
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                                <span>Reset Awal</span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </template>

        {{-- Layout Ketika Belum Ada Gambar (Zona Drop Kosong) --}}
        <template x-if="!preview">
            <div class="text-center py-3 sm:py-4 space-y-2 pointer-events-none">
                <div class="w-12 h-12 mx-auto rounded-full bg-sky-50 text-sky-700 flex items-center justify-center group-hover:scale-105 transition-transform duration-200 border border-sky-100 shadow-2xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                </div>
                
                <div class="space-y-1">
                    <p class="text-xs sm:text-sm font-bold text-slate-800">
                        <span class="text-sky-700 underline underline-offset-2">Klik untuk memilih berkas</span> atau tarik &amp; lepas gambar ke sini
                    </p>
                    <p class="text-[11px] text-slate-500 max-w-sm mx-auto leading-relaxed">
                        Mendukung JPG, PNG, WEBP (Maks. 20MB). Gambar otomatis dikompresi &amp; dikonversi ke WebP.
                    </p>
                </div>

                <div class="pt-1">
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200">
                        <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Otomatis Dikonversi ke WebP Teroptimasi
                    </span>
                </div>
            </div>
        </template>
    </div>

    @if($removeName && $current)
        <div class="pt-1">
            <label class="inline-flex items-center gap-1.5 text-xs text-rose-700 font-medium cursor-pointer">
                <input type="checkbox" name="{{ $removeName }}" value="1" @change="if($event.target.checked) { preview = null; } else { preview = initialPreview; }" class="w-3.5 h-3.5 rounded text-rose-600 border-slate-300 focus:ring-rose-500">
                <span>{{ $removeLabel }}</span>
            </label>
        </div>
    @endif

    @if($help)
        <p class="text-[11px] text-slate-500">{{ $help }}</p>
    @endif
    @error($name) 
        <p class="text-xs text-rose-600 font-semibold mt-1">{{ $message }}</p> 
    @enderror
    @if($allowUrl)
        @error($computedUrlName) 
            <p class="text-xs text-rose-600 font-semibold mt-1">{{ $message }}</p> 
        @enderror
    @endif
</div>
