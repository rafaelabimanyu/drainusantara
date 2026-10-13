@extends('layouts.admin')

@section('title', 'Edit Area Jangkauan')
@section('page-title', 'Edit Area')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Edit Area: {{ $coverageArea->district }}</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Perbarui judul meta SEO lokal dan detail wilayah.</p>
        </div>
        <a href="{{ route('admin.coverage-areas.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.coverage-areas.update', $coverageArea) }}" method="POST" class="bg-white rounded-xl border border-slate-200 p-5 sm:p-7 space-y-5 shadow-2xs">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Kota / Wilayah -->
            <div>
                <label for="city" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kota / Wilayah *</label>
                <input type="text" name="city" id="city" required value="{{ old('city', $coverageArea->city) }}" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                @error('city') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Nama Area -->
            <div>
                <label for="district" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Area *</label>
                <input type="text" name="district" id="district" required value="{{ old('district', $coverageArea->district) }}" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                @error('district') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Kode Pos -->
            <div class="sm:col-span-2">
                <label for="postal_code" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kode Pos (Opsional)</label>
                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $coverageArea->postal_code) }}" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
            </div>

            <!-- Custom SEO Title -->
            <div class="sm:col-span-2">
                <label for="meta_title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Custom SEO Meta Title</label>
                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $coverageArea->meta_title) }}" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
            </div>

            <!-- Custom SEO Meta Description -->
            <div class="sm:col-span-2">
                <label for="meta_description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">SEO Meta Description</label>
                <textarea name="meta_description" id="meta_description" rows="2" class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('meta_description', $coverageArea->meta_description) }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label for="content" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Konten Lokal (Teks Biasa)</label>
                <textarea name="content" id="content" rows="6" class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('content', $coverageArea->content) }}</textarea>
                <p class="text-[11px] text-slate-500 mt-1">Isi informasi layanan khusus area ini. HTML ditampilkan sebagai teks, bukan markup.</p>
                @error('content') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Status Aktif Checkbox -->
            <div class="sm:col-span-2 flex items-center gap-2.5 pt-1">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $coverageArea->is_active) ? 'checked' : '' }} class="w-4 h-4 text-sky-700 rounded-sm border-slate-300 focus:ring-sky-700">
                <label for="is_active" class="text-xs sm:text-sm font-medium text-slate-700 cursor-pointer">Publikasikan halaman SEO area ini</label>
            </div>
        </div>

        <div class="pt-5 border-t border-slate-200 flex items-center justify-end gap-2.5">
            <a href="{{ route('admin.coverage-areas.index') }}" class="px-4 py-2 rounded-lg border border-slate-300 text-xs sm:text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-5 py-2 rounded-lg bg-sky-700 hover:bg-sky-800 text-white text-xs sm:text-sm font-semibold shadow-2xs transition-colors cursor-pointer">
                Perbarui Area
            </button>
        </div>
    </form>
</div>
@endsection
