@extends('layouts.admin')

@section('title', 'Tambah FAQ Baru')
@section('page-title', 'Tambah FAQ Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Pertanyaan &amp; Jawaban (FAQ)</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Buat FAQ baru untuk mengedukasi konsumen mengenai teknis saluran, SOP, biaya, atau garansi.</p>
        </div>
        <a href="{{ route('admin.faqs.index') }}" class="self-start sm:self-auto inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <form method="POST" action="{{ route('admin.faqs.store') }}" class="bg-white rounded-xl border border-slate-200 p-4 sm:p-6 lg:p-7 shadow-2xs space-y-6">
        @csrf

        <!-- Pertanyaan -->
        <div>
            <label for="question" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                Pertanyaan (Question) <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="question" id="question" value="{{ old('question') }}" required
                   placeholder="Contoh: Mengapa pemakaian soda api sangat dilarang untuk pipa PVC?" 
                   class="w-full px-3.5 py-2.5 text-sm rounded-lg border @error('question') border-rose-500 @else border-slate-300 @enderror focus:outline-hidden focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
            @error('question')
                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Jawaban -->
        <div>
            <label for="answer" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                Jawaban Lengkap (Answer) <span class="text-rose-500">*</span>
            </label>
            <textarea name="answer" id="answer" rows="5" required
                      placeholder="Jelaskan secara teknis, jelas, dan meyakinkan tanpa istilah rancu..." 
                      class="w-full px-3.5 py-2.5 text-sm rounded-lg border @error('answer') border-rose-500 @else border-slate-300 @enderror focus:outline-hidden focus:ring-2 focus:ring-sky-500 focus:border-sky-500">{{ old('answer') }}</textarea>
            @error('answer')
                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- 2 Kolom: Kategori & Urutan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Kategori <span class="text-rose-500">*</span>
                </label>
                <select name="category" id="category" required
                        class="w-full px-3.5 py-2.5 text-sm rounded-lg border @error('category') border-rose-500 @else border-slate-300 @enderror focus:outline-hidden focus:ring-2 focus:ring-sky-500 focus:border-sky-500 bg-white">
                    @foreach($categories as $catKey => $catLabel)
                        <option value="{{ $catKey }}" {{ old('category') === $catKey ? 'selected' : '' }}>
                            {{ $catLabel }} ({{ $catKey }})
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="order" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Urutan Tampil (Order)
                </label>
                <input type="number" name="order" id="order" value="{{ old('order', $nextOrder) }}" min="0"
                       class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:outline-hidden focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                <p class="text-[11px] text-slate-400 mt-1">Angka lebih kecil tampil lebih awal di atas.</p>
            </div>
        </div>

        <!-- Opsi Status & Featured -->
        <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-start sm:items-center gap-6">
            <label class="inline-flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                       class="w-4 h-4 text-sky-600 rounded border-slate-300 focus:ring-sky-500">
                <span class="text-xs sm:text-sm font-semibold text-slate-800">Publikasikan FAQ ini (Status Aktif)</span>
            </label>

            <label class="inline-flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', false) ? 'checked' : '' }}
                       class="w-4 h-4 text-amber-600 rounded border-slate-300 focus:ring-amber-500">
                <span class="text-xs sm:text-sm font-semibold text-slate-800">Tampilkan juga di Homepage (Featured)</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2.5">
            <a href="{{ route('admin.faqs.index') }}" class="w-full sm:w-auto text-center px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 text-xs sm:text-sm font-semibold hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="w-full sm:w-auto text-center px-6 py-2.5 rounded-lg bg-sky-700 hover:bg-sky-800 text-white text-xs sm:text-sm font-semibold shadow-xs transition-colors cursor-pointer">
                Simpan FAQ Baru
            </button>
        </div>
    </form>
</div>
@endsection

