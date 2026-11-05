@extends('layouts.admin')

@section('title', 'Tambah Staff & Teknisi')
@section('page-title', 'Tambah Profil Staff')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Staff &amp; Teknisi Lapangan</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Tambahkan data tenaga kerja profesional yang akan tampil pada kartu profil di halaman Tentang Kami.</p>
        </div>
        <a href="{{ route('admin.staff.index') }}" class="self-start sm:self-auto inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border border-slate-200 p-4 sm:p-6 lg:p-7 space-y-5 shadow-2xs">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Nama Lengkap Staff -->
            <div class="sm:col-span-2">
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Nama Lengkap Staff / Teknisi *
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       placeholder="Misal: Agus Santoso, Bambang Wijaya"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                @error('name') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Peran / Spesialisasi -->
            <div>
                <label for="role" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Peran / Posisi / Spesialisasi
                </label>
                <input type="text" name="role" id="role" value="{{ old('role', 'Teknisi Lapangan Siaga') }}"
                       placeholder="Misal: Teknisi Senior Rooter Spiral"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                @error('role') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Inisial (Opsional) -->
            <div>
                <label for="initials" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Inisial Avatar (Opsional)
                </label>
                <input type="text" name="initials" id="initials" value="{{ old('initials') }}" maxlength="5"
                       placeholder="Misal: AS (Otomatis dibuat jika dikosongkan)"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm uppercase outline-hidden transition shadow-2xs">
                @error('initials') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Upload Foto Profil Staf -->
        <div class="space-y-2">
            <x-form.image-upload 
                name="photo" 
                label="Foto Profil Staff / Teknisi (Opsional)" 
                :allowUrl="true"
                urlName="photo_url"
                :urlValue="old('photo_url')"
                aspect="square"
                help="Format JPG, PNG, WEBP. Jika tidak diunggah, profil otomatis menampilkan avatar inisial nama." />
        </div>

        <!-- Pengaturan Urutan & Status -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-1">
            <div>
                <label for="order" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Urutan Tampilan (Angka Kecil Tampil Lebih Dulu)
                </label>
                <input type="number" name="order" id="order" value="{{ old('order', $nextOrder) }}" min="1"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                <p class="text-[11px] text-slate-500 mt-1">Otomatis mengisi slot urutan berikutnya (#{{ $nextOrder }}). Dapat diubah manual jika perlu.</p>
                @error('order') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center sm:pt-6">
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                           class="w-4 h-4 text-sky-700 rounded-sm border-slate-300 focus:ring-sky-700">
                    <span class="text-xs sm:text-sm font-medium text-slate-700">Tampilkan di Halaman Profil (Siaga Aktif)</span>
                </label>
            </div>
        </div>

        <div class="pt-5 border-t border-slate-200 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2.5">
            <a href="{{ route('admin.staff.index') }}" 
               class="w-full sm:w-auto text-center px-4 py-2.5 sm:py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 font-semibold text-xs sm:text-sm transition-colors">
                Batal
            </a>
            <button type="submit" 
                    class="w-full sm:w-auto text-center px-5 py-2.5 sm:py-2 bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs sm:text-sm rounded-lg shadow-2xs transition-colors cursor-pointer">
                Simpan Staff
            </button>
        </div>
    </form>
</div>
@endsection
