@extends('layouts.admin')

@section('title', 'Edit ' . $companyPage->title)
@section('page-title', 'Edit Halaman: ' . $companyPage->page_key)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="inline-flex items-center gap-1.5 text-xs text-sky-700 font-bold uppercase tracking-wider mb-1">
                <span>Manajemen Halaman</span>
                <span>&bull;</span>
                <span class="font-mono bg-sky-50 px-2 py-0.5 rounded border border-sky-200">{{ $companyPage->page_key }}</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Edit Konten & SEO Halaman</h1>
        </div>
        <a href="{{ route('admin.company-pages.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-100 px-3 py-2 rounded-lg border border-slate-300 transition-colors shadow-2xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <!-- Edit Form -->
    <form method="POST" action="{{ route('admin.company-pages.update', $companyPage) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Card 1: Informasi Konten Utama -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 sm:p-6 shadow-2xs space-y-5">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900 pb-3 border-b border-slate-100">
                1. Konten Utama & Hero Header
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Judul Utama Halaman (H1) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $companyPage->title) }}" required
                           class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                </div>

                <div class="md:col-span-2">
                    <label for="subtitle" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Sub-Judul / Ringkasan Header
                    </label>
                    <textarea name="subtitle" id="subtitle" rows="2"
                              class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent">{{ old('subtitle', $companyPage->subtitle) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <x-form.image-upload 
                        name="hero_image" 
                        label="Foto Banner / Hero Halaman" 
                        :current="$companyPage->hero_image"
                        :allowUrl="true"
                        urlName="hero_image_url"
                        :urlValue="old('hero_image_url', $companyPage->hero_image)"
                        aspect="video"
                        help="Format JPG, PNG, WEBP (Maks. 20MB). Otomatis dikompresi &amp; dikonversi ke WebP teroptimasi." />
                </div>

                <div class="flex items-center pt-2 md:col-span-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $companyPage->is_active) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                        <span class="ml-3 text-xs font-bold uppercase tracking-wider text-slate-700">Publikasikan Halaman (Aktif)</span>
                    </label>
                </div>

                <div class="md:col-span-2">
                    <label for="content" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Teks Deskripsi / Narasi Detail
                    </label>
                    <textarea name="content" id="content" rows="4"
                              class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent">{{ old('content', $companyPage->content) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Card 2: Metadata SEO & Social Graph -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 sm:p-6 shadow-2xs space-y-4">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900 pb-3 border-b border-slate-100">
                2. Metadata SEO (Google, OpenGraph, JSON-LD)
            </h2>

            <div>
                <label for="meta_title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Meta Title (Browser Tab & SERP)
                </label>
                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $companyPage->meta_title) }}"
                       class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent">
            </div>

            <div>
                <label for="meta_description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Meta Description
                </label>
                <textarea name="meta_description" id="meta_description" rows="2"
                          class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent">{{ old('meta_description', $companyPage->meta_description) }}</textarea>
            </div>
        </div>

        <!-- Card 3: Konfigurasi Sub-Section Data (JSON) -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 sm:p-6 shadow-2xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900">
                    3. Konfigurasi Item Khusus & Sub-Section (JSON Struktur)
                </h2>
                <span class="text-[11px] font-semibold text-slate-400">Poin data terstruktur</span>
            </div>

            <p class="text-xs text-slate-600">
                Sesuaikan daftar keunggulan, visi/misi, tahapan langkah, poin SOP K3, atau ketentuan garansi dalam format data terstruktur.
            </p>

            <div>
                <textarea name="sections_data_raw" id="sections_data_raw" rows="9"
                          class="w-full text-xs font-mono rounded-lg border border-slate-300 px-3.5 py-2.5 text-slate-800 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent">{{ old('sections_data_raw', json_encode($companyPage->sections_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)) }}</textarea>
            </div>
        </div>

        <!-- Submit Bar -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
            <a href="{{ route('admin.company-pages.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 px-4 py-2.5 rounded-lg border border-slate-300 hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 bg-sky-700 hover:bg-sky-800 text-white font-bold text-xs sm:text-sm px-5 py-2.5 rounded-lg shadow-2xs transition-colors cursor-pointer btn-press">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Simpan Perubahan & Segarkan Cache</span>
            </button>
        </div>
    </form>
</div>
@endsection

