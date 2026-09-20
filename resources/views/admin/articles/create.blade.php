@extends('layouts.admin')

@section('title', 'Tulis Artikel Baru')
@section('page-title', 'Tulis Artikel & Tips Edukasi')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.articles.index') }}" class="text-sm font-semibold text-slate-500 hover:text-sky-600 transition flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Artikel
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Judul Artikel <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           placeholder="Misal: Bahaya Menuang Soda Api pada Saluran Pipa Wastafel"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-slate-800 text-sm outline-none transition">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category" class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
                    <input type="text" name="category" id="category" value="{{ old('category', 'Tips & Edukasi') }}"
                           placeholder="Tips & Edukasi, Plumbing..."
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-slate-800 text-sm outline-none transition">
                    @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Upload Gambar Thumbnail -->
            <div x-data="{ preview: null }">
                <label class="block text-sm font-bold text-slate-700 mb-2">Upload Gambar Thumbnail Artikel</label>
                <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center p-4 bg-slate-50 rounded-2xl border border-slate-200/80">
                    <div class="w-32 h-20 rounded-xl border-2 border-dashed border-slate-300 bg-white flex items-center justify-center overflow-hidden shrink-0 shadow-2xs">
                        <template x-if="preview">
                            <img :src="preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!preview">
                            <div class="text-center p-2 text-slate-400">
                                <svg class="w-6 h-6 mx-auto mb-1 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-[10px]">Thumbnail</span>
                            </div>
                        </template>
                    </div>
                    <div class="flex-1 w-full space-y-1.5">
                        <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                               @change="const f = $event.target.files[0]; if (f) { preview = URL.createObjectURL(f); }"
                               class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                        <p class="text-[11px] text-slate-400">Pilih file gambar resolusi tinggi (16:9 disarankan, maks 5MB). Jika dikosongkan, gambar otomatis dibuat.</p>
                        @error('thumbnail') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div>
                <label for="excerpt" class="block text-sm font-bold text-slate-700 mb-2">Ringkasan Singkat (Excerpt)</label>
                <textarea name="excerpt" id="excerpt" rows="2"
                          placeholder="Ringkasan 1-2 kalimat pengantar artikel untuk kartu tampilan..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-slate-800 text-sm outline-none transition">{{ old('excerpt') }}</textarea>
                @error('excerpt') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="content" class="block text-sm font-bold text-slate-700 mb-2">Isi Konten Artikel <span class="text-red-500">*</span></label>
                <textarea name="content" id="content" rows="10" required
                          placeholder="Tuliskan konten artikel lengkap di sini (mendukung format paragraf atau Markdown)..."
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-slate-800 text-sm outline-none transition font-sans">{{ old('content') }}</textarea>
                @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- SEO Settings -->
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200/80 space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Konfigurasi SEO (Opsional)</h3>
                <div>
                    <label for="meta_title" class="block text-xs font-semibold text-slate-700 mb-1">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                           placeholder="Otomatis dari judul jika dikosongkan"
                           class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-sky-500 text-xs outline-none bg-white">
                </div>
                <div>
                    <label for="meta_description" class="block text-xs font-semibold text-slate-700 mb-1">Meta Description</label>
                    <input type="text" name="meta_description" id="meta_description" value="{{ old('meta_description') }}"
                           placeholder="Otomatis dari ringkasan jika dikosongkan"
                           class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-sky-500 text-xs outline-none bg-white">
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}
                       class="w-4 h-4 text-sky-600 rounded border-slate-300 focus:ring-sky-500">
                <label for="is_published" class="text-sm font-semibold text-slate-700">Publikasikan Langsung ke Website</label>
            </div>

            <div class="pt-4 flex items-center gap-3">
                <button type="submit" 
                        class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm rounded-xl transition shadow-sm">
                    Terbitkan Artikel
                </button>
                <a href="{{ route('admin.articles.index') }}" 
                   class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm rounded-xl transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
