@extends('layouts.admin')

@section('title', 'Detail Permohonan: ' . $contact->name)
@section('page-title', 'Detail Permohonan Layanan #' . $contact->id)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Permohonan #{{ $contact->id }}</span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs text-slate-500">{{ $contact->created_at->format('d M Y, H:i') }} WIB</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">{{ $contact->name }}</h1>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-100 px-3 py-2 rounded-lg border border-slate-300 transition-colors shadow-2xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Daftar</span>
            </a>
            <a href="{{ $contact->whats_app_reply_url }}" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm px-4 py-2 rounded-lg shadow-2xs transition-colors btn-press">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                <span>Balas via WhatsApp</span>
            </a>
        </div>
    </div>

    <!-- Main Detail Card -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-2xs space-y-6">
        
        <!-- Info Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 pb-6 border-b border-slate-100">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Nomor WhatsApp</span>
                <a href="tel:{{ $contact->phone }}" class="text-sm font-bold text-sky-700 hover:underline">
                    {{ $contact->phone }}
                </a>
            </div>

            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Wilayah / Area</span>
                <span class="text-sm font-bold text-slate-900 block">
                    {{ $contact->city ?: 'Kota Tidak Dipilih' }}
                </span>
                <span class="text-xs text-slate-500">{{ $contact->district }}</span>
            </div>

            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Kategori Bangunan</span>
                <span class="text-sm font-bold text-slate-900 block">
                    {{ $contact->property_type ?: 'Residensial' }}
                </span>
            </div>

            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Jenis Layanan / Titik Pipa</span>
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-sky-50 text-sky-800 border border-sky-200">
                    {{ $contact->service_type ?: 'Saluran Pipa Mampet' }}
                </span>
            </div>

            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Status Penanganan</span>
                @if($contact->status === 'new')
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-black bg-amber-100 text-amber-800 border border-amber-300">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                        <span>Baru</span>
                    </span>
                @elseif($contact->status === 'in_progress')
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-800 border border-sky-300">
                        <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                        <span>Sedang Diproses</span>
                    </span>
                @elseif($contact->status === 'completed')
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <span>Tuntas &amp; Selesai</span>
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                        Dibatalkan
                    </span>
                @endif
            </div>

            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">IP &amp; Browser</span>
                <span class="text-xs text-slate-500 font-mono block">{{ $contact->ip_address ?: '-' }}</span>
            </div>
        </div>

        <!-- Deskripsi Keluhan Pelanggan -->
        <div>
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-900 mb-2">
                Deskripsi Masalah &amp; Alamat Pelanggan
            </h2>
            <div class="bg-slate-50 rounded-xl border border-slate-200 p-4 sm:p-5 text-sm text-slate-800 leading-relaxed whitespace-pre-line">
                {{ $contact->message }}
            </div>
        </div>

        <!-- Form Update Status & Catatan Dispatcher -->
        <form method="POST" action="{{ route('admin.contacts.update', $contact) }}" class="pt-6 border-t border-slate-100 space-y-4">
            @csrf
            @method('PUT')

            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-900">
                Pembaruan Status &amp; Catatan Dispatcher Posko
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Ubah Status
                    </label>
                    <select name="status" id="status"
                            class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2 text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <option value="new" {{ old('status', $contact->status) === 'new' ? 'selected' : '' }}>Baru (Belum Ditindaklanjuti)</option>
                        <option value="in_progress" {{ old('status', $contact->status) === 'in_progress' ? 'selected' : '' }}>Diproses (Teknisi Ditugaskan / Sedang Komunikasi)</option>
                        <option value="completed" {{ old('status', $contact->status) === 'completed' ? 'selected' : '' }}>Selesai (Pengerjaan Tuntas &amp; Bergaransi)</option>
                        <option value="cancelled" {{ old('status', $contact->status) === 'cancelled' ? 'selected' : '' }}>Batal (Dibatalkan oleh Pelanggan)</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="admin_notes" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Catatan Internal Dispatcher (Nama teknisi yang ditugaskan, jadwal kunjungan, no nota garansi)
                </label>
                <textarea name="admin_notes" id="admin_notes" rows="3"
                          placeholder="Contoh: Ditugaskan ke Teknisi Mas Budi armada Bandung. Jadwal kunjungan pk 14.00 WIB. Saluran lancar tanpa kendala."
                          class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2 text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500">{{ old('admin_notes', $contact->admin_notes) }}</textarea>
            </div>

            <div class="flex items-center justify-between pt-2">
                <button type="submit" class="inline-flex items-center gap-2 bg-sky-700 hover:bg-sky-800 text-white font-bold text-xs sm:text-sm px-5 py-2.5 rounded-lg shadow-2xs transition-colors cursor-pointer btn-press">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Status &amp; Catatan</span>
                </button>
            </div>
        </form>

    </div>

    <!-- Delete Action Bar -->
    <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50 border border-slate-200">
        <span class="text-xs text-slate-500">Hapus permohonan ini jika berupa spam atau data uji coba:</span>
        <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-xs font-semibold text-rose-700 hover:text-rose-800 hover:underline cursor-pointer">
                Hapus Permohonan
            </button>
        </form>
    </div>
</div>
@endsection

