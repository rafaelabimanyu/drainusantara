@extends('layouts.admin')

@section('title', 'Edit Artikel')
@section('page-title', 'Edit Artikel & Edukasi')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Edit Artikel</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Perbarui judul, ringkasan, atau isi konten artikel edukasi.</p>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-5 sm:p-7 shadow-2xs">
        <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="md:col-span-2">
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Judul Artikel *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" required
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                    @error('title') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kategori</label>
                    <input type="text" name="category" id="category" value="{{ old('category', $article->category) }}"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                    @error('category') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <x-form.image-upload 
                name="thumbnail" 
                label="Gambar Thumbnail Artikel"
                :current="$article->thumbnail"
                help="Pilih file baru jika ingin mengganti gambar thumbnail artikel saat ini."
            />

            <div>
                <label for="excerpt" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Ringkasan Singkat (Excerpt)</label>
                <textarea name="excerpt" id="excerpt" rows="2"
                          class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">{{ old('excerpt', $article->excerpt) }}</textarea>
                @error('excerpt') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="content" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Isi Konten Artikel *</label>
                <textarea name="content" id="content" rows="10" required
                          class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs font-sans">{{ old('content', $article->content) }}</textarea>
                @error('content') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- SEO Settings -->
            <div class="p-4 bg-slate-50/75 rounded-lg border border-slate-200 space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Konfigurasi SEO (Opsional)</h3>
                <div>
                    <label for="meta_title" class="block text-xs font-semibold text-slate-700 mb-1">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $article->meta_title) }}"
                           class="w-full px-3 py-1.5 rounded-lg border border-slate-300 focus:border-sky-700 text-xs outline-hidden bg-white">
                </div>
                <div>
                    <label for="meta_description" class="block text-xs font-semibold text-slate-700 mb-1">Meta Description</label>
                    <input type="text" name="meta_description" id="meta_description" value="{{ old('meta_description', $article->meta_description) }}"
                           class="w-full px-3 py-1.5 rounded-lg border border-slate-300 focus:border-sky-700 text-xs outline-hidden bg-white">
                </div>
            </div>

            <div class="flex items-center gap-2.5 pt-1">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', session()->hasOldInput() ? false : $article->is_published) ? 'checked' : '' }}
                       class="w-4 h-4 text-sky-700 rounded-sm border-slate-300 focus:ring-sky-700">
                <label for="is_published" class="text-xs sm:text-sm font-medium text-slate-700 cursor-pointer">Publikasikan Langsung ke Website</label>
            </div>

            <div class="pt-5 border-t border-slate-200 flex items-center justify-end gap-2.5">
                <a href="{{ route('admin.articles.index') }}" 
                   class="px-4 py-2 bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 font-semibold text-xs sm:text-sm rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-5 py-2 bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs sm:text-sm rounded-lg shadow-2xs transition-colors cursor-pointer">
                    Perbarui Artikel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
