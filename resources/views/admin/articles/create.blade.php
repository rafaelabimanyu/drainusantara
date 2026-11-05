@extends('layouts.admin')

@section('title', 'Tulis Artikel Baru')
@section('page-title', 'Tulis Artikel & Tips Edukasi')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Tulis Artikel Baru</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Tulis artikel tips drainase, solusi pipa mampet, dan edukasi perawatan saluran.</p>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="self-start sm:self-auto inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-4 sm:p-6 lg:p-7 shadow-2xs">
        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            @php
                $subCategoriesMap = \App\Models\Article::SUB_CATEGORIES;
            @endphp
            <div x-data="{
                category: '{{ old('category', 'Edukasi') }}',
                subCategory: '{{ old('sub_category', '') }}',
                subMap: {{ json_encode($subCategoriesMap) }},
                get availableSub() {
                    return this.subMap[this.category] || [];
                }
            }" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="md:col-span-1">
                        <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Judul Artikel *</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                               placeholder="Misal: Bahaya Menuang Soda Api pada Saluran Pipa Wastafel"
                               class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                        @error('title') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kategori Utama *</label>
                        <select name="category" id="category" x-model="category" required
                                class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs bg-white">
                            @foreach(\App\Models\Article::CATEGORIES as $catOption)
                                <option value="{{ $catOption }}" {{ old('category', 'Edukasi') === $catOption ? 'selected' : '' }}>
                                    {{ $catOption }}
                                </option>
                            @endforeach
                        </select>
                        @error('category') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="sub_category" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Sub Kategori</label>
                        <select name="sub_category" id="sub_category" x-model="subCategory"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs bg-white">
                            <option value="">-- Pilih Sub Kategori (Opsional) --</option>
                            <template x-for="sub in availableSub" :key="sub">
                                <option :value="sub" x-text="sub" :selected="sub === subCategory"></option>
                            </template>
                        </select>
                        @error('sub_category') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="published_at" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tanggal Publikasi / Upload</label>
                    <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs bg-white">
                    <p class="text-[11px] text-slate-500 mt-1">Tanggal upload resmi yang tampil di kartu dan detail artikel.</p>
                    @error('published_at') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="image_placement" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Posisi Gambar di Halaman Detail</label>
                    <select name="image_placement" id="image_placement"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs bg-white">
                        <option value="content" {{ old('image_placement', 'content') === 'content' ? 'selected' : '' }}>Di Tengah Konten (Kompak &amp; Rapi)</option>
                        <option value="hero" {{ old('image_placement') === 'hero' ? 'selected' : '' }}>Di Hero Section (Header Atas)</option>
                    </select>
                    <p class="text-[11px] text-slate-500 mt-1">Pilih apakah gambar tampil di header atas atau di dalam badan artikel.</p>
                    @error('image_placement') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <x-form.image-upload 
                name="thumbnail" 
                label="Gambar Thumbnail Artikel"
                help="Pilih file gambar resolusi tinggi (16:9 disarankan, maks 20MB)."
            />

            <!-- Foto Tambahan di Tengah Berita (Maksimal 3 Foto, Opsional) -->
            <div class="p-4 sm:p-5 bg-slate-50 rounded-xl border border-slate-200 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Foto Konten Tambahan (Maksimal 3 Foto, Opsional)</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Dapat disematkan otomatis di sela paragraf atau gunakan penanda manual: <code class="px-1.5 py-0.5 bg-slate-200 text-slate-800 rounded font-mono text-[11px]">[foto-1]</code>, <code class="px-1.5 py-0.5 bg-slate-200 text-slate-800 rounded font-mono text-[11px]">[foto-2]</code>, <code class="px-1.5 py-0.5 bg-slate-200 text-slate-800 rounded font-mono text-[11px]">[foto-3]</code> di dalam teks.</p>
                    </div>
                    <span class="text-[11px] font-bold text-sky-800 bg-sky-50 border border-sky-200 px-2.5 py-1 rounded-md shrink-0">Auto-WebP</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @for($i = 1; $i <= 3; $i++)
                    <div class="p-3 bg-white rounded-lg border border-slate-200 space-y-3">
                        <x-form.image-upload 
                            name="content_image_{{ $i }}" 
                            label="Foto Tengah #{{ $i }}" 
                            aspect="video"
                            help="Maks. 20MB. Otomatis dikonversi ke WebP." />

                        <div>
                            <label for="content_caption_{{ $i }}" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Keterangan Foto #{{ $i }}
                            </label>
                            <input type="text" name="content_caption_{{ $i }}" id="content_caption_{{ $i }}"
                                   value="{{ old('content_caption_' . $i) }}"
                                   placeholder="Contoh: Proses pengikisan kerak pipa"
                                   class="w-full px-3 py-1.5 text-xs rounded-md border border-slate-300 focus:border-sky-700 focus:ring-1 focus:ring-sky-700/20 text-slate-900">
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            <div>
                <label for="tags" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tag Pendukung</label>
                <input type="text" name="tags" id="tags" value="{{ old('tags') }}"
                       placeholder="Misal: Pipa PVC, Wastafel Dapur, Soda Api, CCTV Drainase (pisahkan dengan tanda koma)"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                <p class="text-[11px] text-slate-500 mt-1">Tag topik pendukung yang muncul di bagian akhir artikel detail.</p>
                @error('tags') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="excerpt" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Ringkasan Singkat (Excerpt)</label>
                <textarea name="excerpt" id="excerpt" rows="2"
                          placeholder="Ringkasan 1-2 kalimat pengantar artikel untuk kartu tampilan..."
                          class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">{{ old('excerpt') }}</textarea>
                @error('excerpt') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="content" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Isi Konten Artikel *</label>
                    <span class="text-[11px] text-sky-700 font-medium">Mendukung Markdown &amp; Tag HTML Lengkap</span>
                </div>
                <textarea name="content" id="content" rows="12" required
                          placeholder="Tuliskan konten artikel lengkap di sini (mendukung format paragraf, Markdown, dan tag HTML seperti &lt;b&gt;, &lt;ul&gt;, &lt;table&gt;, &lt;iframe&gt;)..."
                          class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs font-sans">{{ old('content') }}</textarea>
                <p class="text-[11px] text-slate-500 mt-1">Anda dapat menyisipkan tag HTML langsung (misal: embed iframe YouTube, tabel spesifikasi pipa, atau callout info) maupun sintaks Markdown biasa.</p>
                @error('content') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- SEO Settings -->
            <div class="p-4 bg-slate-50/75 rounded-lg border border-slate-200 space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Konfigurasi SEO (Opsional)</h3>
                <div>
                    <label for="meta_title" class="block text-xs font-semibold text-slate-700 mb-1">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                           placeholder="Otomatis dari judul jika dikosongkan"
                           class="w-full px-3 py-1.5 rounded-lg border border-slate-300 focus:border-sky-700 text-xs outline-hidden bg-white">
                </div>
                <div>
                    <label for="meta_description" class="block text-xs font-semibold text-slate-700 mb-1">Meta Description</label>
                    <input type="text" name="meta_description" id="meta_description" value="{{ old('meta_description') }}"
                           placeholder="Otomatis dari ringkasan jika dikosongkan"
                           class="w-full px-3 py-1.5 rounded-lg border border-slate-300 focus:border-sky-700 text-xs outline-hidden bg-white">
                </div>
            </div>

            <div class="flex items-center gap-2.5 pt-1">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', session()->hasOldInput() ? false : true) ? 'checked' : '' }}
                       class="w-4 h-4 text-sky-700 rounded-sm border-slate-300 focus:ring-sky-700">
                <label for="is_published" class="text-xs sm:text-sm font-medium text-slate-700 cursor-pointer">Publikasikan Langsung ke Website</label>
            </div>

            <div class="pt-5 border-t border-slate-200 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2.5">
                <a href="{{ route('admin.articles.index') }}" 
                   class="w-full sm:w-auto text-center px-4 py-2.5 bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 font-semibold text-xs sm:text-sm rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="w-full sm:w-auto text-center px-5 py-2.5 bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs sm:text-sm rounded-lg shadow-2xs transition-colors cursor-pointer btn-press">
                    Terbitkan Artikel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
