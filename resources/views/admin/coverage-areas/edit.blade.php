@extends('layouts.admin')

@section('title', 'Edit Area Jangkauan')
@section('page-title', 'Edit Area')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Edit Area: {{ $coverageArea->district }}</h1>
            <p class="text-sm text-slate-500 mt-1">Perbarui judul meta SEO lokal dan detail wilayah.</p>
        </div>
        <a href="{{ route('admin.coverage-areas.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">
            &larr; Kembali
        </a>
    </div>

    <form action="{{ route('admin.coverage-areas.update', $coverageArea) }}" method="POST" class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 space-y-6 shadow-2xs">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Kota / Wilayah -->
            <div>
                <label for="city" class="block text-sm font-bold text-slate-700 mb-1">Kota / Wilayah *</label>
                <input type="text" name="city" id="city" required value="{{ old('city', $coverageArea->city) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-hidden">
            </div>

            <!-- Nama Kecamatan -->
            <div>
                <label for="district" class="block text-sm font-bold text-slate-700 mb-1">Nama Kecamatan *</label>
                <input type="text" name="district" id="district" required value="{{ old('district', $coverageArea->district) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-hidden">
            </div>

            <!-- Kode Pos -->
            <div class="sm:col-span-2">
                <label for="postal_code" class="block text-sm font-bold text-slate-700 mb-1">Kode Pos (Opsional)</label>
                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $coverageArea->postal_code) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-hidden">
            </div>

            <!-- Custom SEO Title -->
            <div class="sm:col-span-2">
                <label for="meta_title" class="block text-sm font-bold text-slate-700 mb-1">Custom SEO Meta Title</label>
                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $coverageArea->meta_title) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-hidden">
            </div>

            <!-- Custom SEO Meta Description -->
            <div class="sm:col-span-2">
                <label for="meta_description" class="block text-sm font-bold text-slate-700 mb-1">SEO Meta Description</label>
                <textarea name="meta_description" id="meta_description" rows="2" class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-hidden">{{ old('meta_description', $coverageArea->meta_description) }}</textarea>
            </div>

            <!-- Status Aktif Checkbox -->
            <div class="sm:col-span-2 flex items-center gap-3 pt-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $coverageArea->is_active) ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded-sm border-slate-300 focus:ring-emerald-500">
                <label for="is_active" class="text-sm font-semibold text-slate-700">Publikasikan halaman SEO kecamatan ini</label>
            </div>
        </div>

        <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.coverage-areas.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold shadow-md shadow-emerald-600/20 transition-colors">
                Perbarui Area
            </button>
        </div>
    </form>
</div>
@endsection
