@extends('layouts.admin')

@section('title', 'Edit Testimoni')
@section('page-title', 'Edit Testimoni')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Edit Testimoni Pelanggan</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Perbarui ulasan atau status publikasi ulasan pelanggan.</p>
        </div>
        <a href="{{ route('admin.reviews.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.reviews.update', $review) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border border-slate-200 p-5 sm:p-7 space-y-5 shadow-2xs">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Nama Pelanggan -->
            <div>
                <label for="customer_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Pelanggan *</label>
                <input type="text" name="customer_name" id="customer_name" required value="{{ old('customer_name', $review->customer_name) }}" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                @error('customer_name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Peran / Lokasi -->
            <div>
                <label for="customer_role_or_location" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Lokasi / Keterangan</label>
                <input type="text" name="customer_role_or_location" id="customer_role_or_location" value="{{ old('customer_role_or_location', $review->customer_role_or_location) }}" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                @error('customer_role_or_location') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Rating Bintang -->
            <div>
                <label for="rating" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Rating Bintang *</label>
                <select name="rating" id="rating" required class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden bg-white transition shadow-2xs">
                    <option value="5" {{ old('rating', $review->rating) == 5 ? 'selected' : '' }}>★★★★★ (5 Bintang - Sangat Puas)</option>
                    <option value="4" {{ old('rating', $review->rating) == 4 ? 'selected' : '' }}>★★★★☆ (4 Bintang - Puas)</option>
                    <option value="3" {{ old('rating', $review->rating) == 3 ? 'selected' : '' }}>★★★☆☆ (3 Bintang - Cukup)</option>
                    <option value="2" {{ old('rating', $review->rating) == 2 ? 'selected' : '' }}>★★☆☆☆ (2 Bintang - Kurang)</option>
                    <option value="1" {{ old('rating', $review->rating) == 1 ? 'selected' : '' }}>★☆☆☆☆ (1 Bintang - Buruk)</option>
                </select>
                @error('rating') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Terkait Layanan -->
            <div>
                <label for="service_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Terkait Layanan</label>
                <select name="service_id" id="service_id" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden bg-white transition shadow-2xs">
                    <option value="">-- Umum / Semua Layanan --</option>
                    @foreach($services as $svc)
                        <option value="{{ $svc->id }}" {{ old('service_id', $review->service_id) == $svc->id ? 'selected' : '' }}>
                            {{ $svc->name }}
                        </option>
                    @endforeach
                </select>
                @error('service_id') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Isi Ulasan / Komentar -->
            <div class="sm:col-span-2">
                <label for="comment" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Ulasan / Komentar Pelanggan *</label>
                <textarea name="comment" id="comment" rows="3" required class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs leading-relaxed">{{ old('comment', $review->comment) }}</textarea>
                @error('comment') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Status Aktif Switch -->
            <div class="sm:col-span-2 pt-1">
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $review->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded-sm text-sky-700 focus:ring-sky-700 border-slate-300">
                    <span class="text-xs sm:text-sm font-medium text-slate-700">Tampilkan Testimoni Ini di Website (Status Aktif)</span>
                </label>
            </div>
        </div>

        <div class="pt-5 border-t border-slate-200 flex items-center justify-end gap-2.5">
            <a href="{{ route('admin.reviews.index') }}" class="px-4 py-2 rounded-lg border border-slate-300 text-xs sm:text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-5 py-2 rounded-lg bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs sm:text-sm shadow-2xs transition-colors cursor-pointer">
                Perbarui Testimoni
            </button>
        </div>
    </form>
</div>
@endsection
