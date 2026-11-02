@extends('layouts.admin')

@section('title', 'Edit FAQ')
@section('page-title', 'Edit FAQ')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Edit Pertanyaan &amp; Jawaban (FAQ)</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Perbarui teks pertanyaan, jawaban teknis, kategori, atau urutan tampil.</p>
        </div>
        <a href="{{ route('admin.faqs.index') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">
            &larr; Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('admin.faqs.update', $faq) }}" class="bg-white rounded-xl border border-slate-200 p-6 sm:p-8 shadow-2xs space-y-6">
        @csrf
        @method('PUT')

        <!-- Pertanyaan -->
        <div>
            <label for="question" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                Pertanyaan (Question) <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="question" id="question" value="{{ old('question', $faq->question) }}" required
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
                      class="w-full px-3.5 py-2.5 text-sm rounded-lg border @error('answer') border-rose-500 @else border-slate-300 @enderror focus:outline-hidden focus:ring-2 focus:ring-sky-500 focus:border-sky-500">{{ old('answer', $faq->answer) }}</textarea>
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
                        <option value="{{ $catKey }}" {{ old('category', $faq->category) === $catKey ? 'selected' : '' }}>
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
                <input type="number" name="order" id="order" value="{{ old('order', $faq->order) }}" min="0"
                       class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:outline-hidden focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                <p class="text-[11px] text-slate-400 mt-1">Angka lebih kecil tampil lebih awal di atas.</p>
            </div>
        </div>

        <!-- Opsi Status & Featured -->
        <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-start sm:items-center gap-6">
            <label class="inline-flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 text-sky-600 rounded border-slate-300 focus:ring-sky-500">
                <span class="text-xs sm:text-sm font-semibold text-slate-800">Publikasikan FAQ ini (Status Aktif)</span>
            </label>

            <label class="inline-flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $faq->is_featured) ? 'checked' : '' }}
                       class="w-4 h-4 text-amber-600 rounded border-slate-300 focus:ring-amber-500">
                <span class="text-xs sm:text-sm font-semibold text-slate-800">Tampilkan juga di Homepage (Featured)</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.faqs.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 text-xs sm:text-sm font-semibold hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-lg bg-sky-700 hover:bg-sky-800 text-white text-xs sm:text-sm font-semibold shadow-xs transition-colors cursor-pointer">
                Perbarui FAQ
            </button>
        </div>
    </form>
</div>
@endsection

