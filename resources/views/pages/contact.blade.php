@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number', '6285609009009');
@endphp

<!-- Header Banner -->
<section class="py-12 sm:py-16 bg-slate-900 text-white border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-800 border border-slate-700 text-sky-400 text-xs font-bold uppercase tracking-wider mb-4">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Pusat Koordinasi Armada Siaga 24 Jam</span>
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white">
                Hubungi Posko Teknisi Drainusantara
            </h1>
            <p class="mt-4 text-slate-300 text-sm sm:text-base leading-relaxed">
                Saluran pipa air Anda mampet, meluap, atau bau got menyengat? Hubungi call center siaga kami atau isi formulir permohonan kunjungan teknisi bergaransi 30 hari tanpa bongkar keramik.
            </p>
        </div>
    </div>
</section>

<!-- Content Grid -->
<section class="py-12 sm:py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Flash Alert -->
        @if(session('success'))
            <div class="mb-8 rounded-xl bg-emerald-50 border border-emerald-300 p-5 shadow-2xs">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-bold text-emerald-900">Permohonan Berhasil Terkirim!</h3>
                        <p class="text-xs sm:text-sm text-emerald-800 mt-1 leading-relaxed">{{ session('success') }}</p>
                        
                        @if(session('direct_wa_url'))
                            <div class="mt-4">
                                <a href="{{ session('direct_wa_url') }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-2 bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white text-xs sm:text-sm font-bold px-4 py-2.5 rounded-lg transition-colors shadow-2xs btn-press">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                    <span>Lanjut Konfirmasi via WhatsApp Dispatcher &rarr;</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Kolom Kiri: Info Hotline & Posko -->
            <div class="lg:col-span-5 space-y-6">
                
                <!-- Quick Contact Card -->
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-2xs space-y-6">
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900 tracking-tight">Kanal Komunikasi Siaga</h2>
                        <p class="text-xs text-slate-600 mt-1">Dukungan respon cepat dari operator teknis dan dispatcher posko terdekat.</p>
                    </div>

                    <div class="space-y-4">
                        <!-- Telepon -->
                        <div class="flex items-start gap-3.5 p-3.5 rounded-lg bg-slate-50 border border-slate-200/80">
                            <div class="w-10 h-10 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">Hotline Telepon Darurat</span>
                                <a href="tel:085609009009" class="text-sm sm:text-base font-extrabold text-slate-900 hover:text-sky-700 transition-colors">
                                    0856-0900-9009
                                </a>
                                <span class="text-[11px] text-slate-500 block mt-0.5">Panggilan darurat langsung ke posko armada</span>
                            </div>
                        </div>

                        <!-- WhatsApp -->
                        <div class="flex items-start gap-3.5 p-3.5 rounded-lg bg-emerald-50/60 border border-emerald-200">
                            <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-800 block">WhatsApp Chat 24 Jam</span>
                                <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode('Halo Admin Drainusantara, saya ingin permohonan kunjungan teknisi pipa mampet.') }}" 
                                   target="_blank" rel="noopener noreferrer"
                                   class="text-sm sm:text-base font-extrabold text-emerald-900 hover:text-emerald-700 transition-colors">
                                    +62 856-0900-9009
                                </a>
                                <span class="text-[11px] text-emerald-700 block mt-0.5">Kirim foto/video sumbatan untuk estimasi instan</span>
                            </div>
                        </div>

                        <!-- Email Resmi -->
                        <div class="flex items-start gap-3.5 p-3.5 rounded-lg bg-slate-50 border border-slate-200/80">
                            <div class="w-10 h-10 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">Email Kantor Resmi</span>
                                <a href="mailto:{{ config('services.company.email', 'drainusantara@gmail.com') }}" class="text-sm sm:text-base font-extrabold text-slate-900 hover:text-sky-700 transition-colors">
                                    {{ config('services.company.email', 'drainusantara@gmail.com') }}
                                </a>
                                <span class="text-[11px] text-slate-500 block mt-0.5">Korespondensi resmi, penawaran B2B &amp; administrasi</span>
                            </div>
                        </div>

                        <!-- Alamat Kantor Pusat & Workshop -->
                        <div class="flex items-start gap-3.5 p-3.5 rounded-lg bg-slate-50 border border-slate-200/80">
                            <div class="w-10 h-10 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">Kantor Pusat &amp; Workshop (HQ)</span>
                                <p class="text-xs sm:text-sm font-bold text-slate-900 leading-snug">
                                    PT JAWA JAYA ROOTER &bull; Drainusantara
                                </p>
                                <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                                    {{ config('services.company.address.full', 'Jl. Manunggal XVII No. 104, RT.5/RW.11, Lubang Buaya, Kec. Cipayung, Kota Jakarta Timur, DKI Jakarta 13810') }}
                                </p>
                                @if(config('services.company.google_maps_url'))
                                <a href="{{ config('services.company.google_maps_url') }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-1 text-[11px] font-bold text-sky-700 hover:text-sky-800 mt-1.5">
                                    <span>Buka di Google Maps &rarr;</span>
                                </a>
                                @endif
                            </div>
                        </div>

                        <!-- Jam Operasional -->
                        <div class="flex items-start gap-3.5 p-3.5 rounded-lg bg-slate-50 border border-slate-200/80">
                            <div class="w-10 h-10 rounded-lg bg-amber-50 border border-amber-200 text-amber-700 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">Waktu Layanan</span>
                                <span class="text-sm font-bold text-slate-900 block">24 Jam / 7 Hari Non-Stop</span>
                                <span class="text-[11px] text-slate-500 block mt-0.5">Termasuk hari Minggu dan hari libur nasional</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Posko Wilayah Card -->
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-2xs space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 pb-2 border-b border-slate-100">
                        Pusat Posko Armada Tersebar:
                    </h3>
                    <ul class="space-y-2.5 text-xs text-slate-600">
                        <li class="flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500 mt-1.5 shrink-0"></span>
                            <span><strong>Jabodetabek & Banten:</strong> Jakarta Selatan, Jakarta Barat, Jakarta Timur, Jakarta Utara, Jakarta Pusat, Depok, Tangerang Kota, Tangsel, Bekasi & Cikarang.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mt-1.5 shrink-0"></span>
                            <span><strong>Jawa Barat & Bandung Raya:</strong> Kota Bandung, Kabupaten Bandung, Kota Cimahi, Bogor, Cibinong.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 mt-1.5 shrink-0"></span>
                            <span><strong>Jawa Tengah & Pantura:</strong> Kota Semarang, Kabupaten Semarang (Ungaran/Ambarawa), Kabupaten Demak.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mt-1.5 shrink-0"></span>
                            <span><strong>Sumatera / Lampung:</strong> Bandar Lampung, Tanjung Karang, Kedaton & sekitarnya.</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Kolom Kanan: Form Pemesanan / Permohonan -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-xl border border-slate-200 p-6 sm:p-8 shadow-2xs">
                    <div class="mb-6 pb-4 border-b border-slate-100">
                        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Form Permohonan Layanan & Kunjungan Teknisi</h2>
                        <p class="text-xs sm:text-sm text-slate-600 mt-1">Isi formulir di bawah ini, dispatcher kami akan segera merespons via WhatsApp atau telepon dalam 5-15 menit.</p>
                    </div>

                    <form method="POST" action="{{ route('contact.submit') }}" class="space-y-4 sm:space-y-5">
                        @csrf

                        <!-- Honeypot -->
                        <div class="hidden">
                            <label for="website_url">Website URL (leave blank)</label>
                            <input type="text" name="website_url" id="website_url" autocomplete="off" tabindex="-1">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Nama -->
                            <div>
                                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                    Nama Lengkap <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                       placeholder="Contoh: Bpk. Hendra"
                                       class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                                @error('name')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- No WhatsApp -->
                            <div>
                                <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                    No. WhatsApp Aktif <span class="text-rose-500">*</span>
                                </label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                       placeholder="Contoh: 081234567890"
                                       class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                                @error('phone')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Kota / Wilayah -->
                            <div>
                                <label for="city" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                    Kota / Kabupaten
                                </label>
                                <select name="city" id="city"
                                        class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                                    <option value="">-- Pilih Kota Terdekat --</option>
                                    @foreach($provinces as $prov)
                                        <optgroup label="{{ $prov['name'] }}">
                                            @foreach($prov['cities'] as $city)
                                                <option value="{{ $city['name'] }}" {{ old('city') === $city['name'] ? 'selected' : '' }}>
                                                    {{ $city['name'] }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Area / Kecamatan -->
                            <div>
                                <label for="district" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                    Kecamatan / Area Spesifik
                                </label>
                                <input type="text" name="district" id="district" value="{{ old('district') }}"
                                       placeholder="Contoh: Tebet / Coblong / Ungaran"
                                       class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Jenis Titik Masalah -->
                            <div>
                                <label for="service_type" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                    Titik Saluran Tersumbat
                                </label>
                                <select name="service_type" id="service_type"
                                        class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                                    <option value="Wastafel & Cuci Piring">Wastafel & Cuci Piring (Sink Lemak)</option>
                                    <option value="Kloset & WC Meluap">Kloset & WC Duduk / Jongkok</option>
                                    <option value="Floor Drain Kamar Mandi">Floor Drain Saluran Lantai Kamar Mandi</option>
                                    <option value="Talang Rooftop & Pipa Atap">Talang Air Rooftop / Pipa Curah Hujan</option>
                                    <option value="Kuras Grease Trap Resto">Pembersihan Grease Trap & Bak Lemak Resto</option>
                                    <option value="Pipa Utama & Bak Kontrol">Pipa Utama Gedung & Bak Kontrol Luar</option>
                                    <option value="Inspeksi CCTV Pipa">Inspeksi Kamera Endoskopi CCTV Pipa</option>
                                    <option value="Lainnya">Titik Masalah Lainnya</option>
                                </select>
                            </div>

                            <!-- Kategori Properti / Bangunan -->
                            <div>
                                <label for="property_type" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                    Kategori Bangunan
                                </label>
                                <select name="property_type" id="property_type"
                                        class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                                    <option value="Rumah Tinggal">Rumah Tinggal / Residensial</option>
                                    <option value="Restoran Kafe FNB">Restoran, Kafe & F&B</option>
                                    <option value="Apartemen Kondominium">Apartemen & Kondominium</option>
                                    <option value="Ruko Bisnis & Rukan">Ruko Bisnis & Rukan</option>
                                    <option value="Gedung Perkantoran / Hotel">Gedung Perkantoran & Hotel</option>
                                    <option value="Pabrik & Industri">Pabrik & Kawasan Industri</option>
                                    <option value="Lainnya">Kategori Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <!-- Pesan / Catatan -->
                        <div>
                            <label for="message" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Deskripsi Masalah & Alamat Lokasi <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="message" id="message" rows="4" required
                                      placeholder="Jelaskan kondisi sumbatan (misal: air cuci piring meluap sejak kemarin, sudah coba disiram air panas tapi tidak lancar) dan alamat lengkap patokan..."
                                      class="w-full text-sm rounded-lg border border-slate-300 px-3.5 py-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" 
                                    class="w-full inline-flex items-center justify-center gap-2 bg-sky-700 hover:bg-sky-800 text-white font-extrabold text-sm sm:text-base px-6 py-3.5 rounded-lg shadow-2xs transition-colors cursor-pointer btn-press">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                <span>Kirim Permohonan Layanan Sekarang</span>
                            </button>
                            <p class="text-[11px] text-slate-500 text-center mt-2">
                                Dilindungi prinsip No Cure No Pay &amp; Garansi 30 Hari Tanpa Biaya Tambahan.
                            </p>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</section>
@endsection

