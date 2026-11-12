@extends('layouts.admin')

@section('title', 'Edit Artikel')
@section('page-title', 'Digital Content Studio - Edit Artikel')

@section('content')
@php
    $existingContentImages = is_array($article->content_images) ? array_values($article->content_images) : [];
    
    // Resolve initial category ID
    $initialCatId = old('category_id', $article->category_id);
    if (!$initialCatId && $article->category) {
        $foundCat = $categories->first(fn ($c) => $c->name === $article->category || $c->slug === $article->category_slug);
        if ($foundCat) {
            $initialCatId = $foundCat->id;
        }
    }
    if (!$initialCatId) {
        $initialCatId = $categories->first()?->id ?? '';
    }

    // Resolve initial subcategory ID
    $initialSubId = old('subcategory_id', $article->subcategory_id);
    if (!$initialSubId && $article->sub_category && $initialCatId) {
        $catModel = $categories->firstWhere('id', $initialCatId);
        if ($catModel) {
            $foundSub = $catModel->subcategories->first(fn ($s) => $s->name === $article->sub_category || $s->slug === \Illuminate\Support\Str::slug($article->sub_category));
            if ($foundSub) {
                $initialSubId = $foundSub->id;
            }
        }
    }

    $studioConfig = [
        'title' => old('title', $article->title),
        'content' => old('content', $article->content),
        'metaTitle' => old('meta_title', $article->meta_title ?? ''),
        'metaDescription' => old('meta_description', $article->meta_description ?? ''),
        'focusKeyword' => '',
        'selectedCategoryId' => $initialCatId,
        'selectedSubcategoryId' => $initialSubId ?? '',
        'selectedCategoryName' => old('category', $article->category_label),
        'selectedSubcategoryName' => old('sub_category', $article->sub_category ?? ''),
        'selectedService' => old('service_id', $article->service_id ?? ''),
        'selectedCity' => old('city', $article->city ?? ''),
        'uploadUrl' => route('admin.articles.upload-image'),
        'csrfToken' => csrf_token(),
        'categories' => $categories->map(function ($cat) {
            return [
                'id' => (int) $cat->id,
                'name' => (string) $cat->name,
                'slug' => (string) $cat->slug,
                'subcategories' => $cat->subcategories->map(fn ($s) => [
                    'id' => (int) $s->id,
                    'name' => (string) $s->name,
                    'slug' => (string) $s->slug,
                ])->values(),
            ];
        })->values(),
    ];
@endphp

<script type="application/json" id="article-studio-config">
    {!! json_encode($studioConfig, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!}
</script>

<div class="max-w-5xl mx-auto space-y-6" x-data="articleStudio()">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[11px] font-bold bg-sky-50 border border-sky-200 text-sky-800 mb-1">
                <span>DIGITAL CONTENT STUDIO</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Edit Artikel &amp; Panduan</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Perbarui konten edukasi, optimasi struktur URL Silo, dan kelola media visual berstandar WebP.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.article-categories.index') }}" target="_blank"
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 hover:text-slate-900 px-3 py-2 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors shadow-2xs">
                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                <span>Kelola Kategori</span>
            </a>
            <a href="{{ route('articles.show', $article->slug) }}" target="_blank" 
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-sky-700 hover:text-sky-800 px-3 py-2 rounded-lg border border-sky-200 bg-sky-50 hover:bg-sky-100 transition-colors shadow-2xs">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                <span>Lihat di Web</span>
            </a>
            <a href="{{ route('admin.articles.index') }}" 
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3.5 py-2 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors shadow-2xs">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Main Form Container -->
    <div class="bg-white rounded-xl border border-slate-200 p-4 sm:p-6 lg:p-7 shadow-2xs">
        <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- 1. Metadata Utama: Judul & Kategori Dinamis -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="md:col-span-1">
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Judul Artikel <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="title" x-model="title" required
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                    @error('title') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Kategori Utama <span class="text-rose-500">*</span></label>
                        <a href="{{ route('admin.article-categories.index') }}" target="_blank" class="text-[11px] text-sky-700 hover:underline font-semibold">+ Kategori</a>
                    </div>
                    <select name="category" id="category" x-model="selectedCategoryName" @change="onCategoryNameChange($event.target.value)" required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs bg-white">
                        <option value="">-- Pilih Kategori Utama --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}" data-id="{{ $cat->id }}" {{ old('category', $article->category_label) === $cat->name ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="category_id" :value="selectedCategoryId">
                    @error('category') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    @error('category_id') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="sub_category" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Sub Kategori</label>
                        <span class="text-[11px] text-slate-400 font-normal">Auto-Filter</span>
                    </div>
                    <select name="sub_category" id="sub_category" x-model="selectedSubcategoryName" @change="onSubcategoryNameChange($event.target.value)"
                            :disabled="availableSubcategories.length === 0"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs bg-white disabled:bg-slate-100 disabled:text-slate-400">
                        <option value="">-- Pilih Sub Kategori (Opsional) --</option>
                        <template x-for="sub in availableSubcategories" :key="sub.id">
                            <option :value="sub.name" x-text="sub.name" :selected="sub.name === selectedSubcategoryName"></option>
                        </template>
                    </select>
                    <input type="hidden" name="subcategory_id" :value="selectedSubcategoryId">
                    @error('sub_category') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    @error('subcategory_id') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- 2. Internal Linking Topic Silo (Layanan & Wilayah) -->
            <div class="p-4 sm:p-5 bg-slate-50 rounded-xl border border-slate-200 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Interkoneksi Internal Link (Topic Cluster &amp; Silo)</h3>
                        <p class="text-[11px] text-slate-500 mt-0.5">Kaitkan artikel dengan halaman Layanan dan Wilayah terkait untuk memperkuat ranking Google.</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-sky-100 text-sky-800 border border-sky-200">SEO Silo</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="service_id" class="block text-xs font-semibold text-slate-700 mb-1">Layanan Spesialis Terkait</label>
                        <select name="service_id" id="service_id" x-model="selectedService" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:border-sky-700 text-xs bg-white">
                            <option value="">-- Tidak Terkait Layanan Tertentu --</option>
                            @foreach($services ?? [] as $svc)
                                <option value="{{ $svc->id }}" {{ old('service_id', $article->service_id) == $svc->id ? 'selected' : '' }}>{{ $svc->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" @click="insertInternalLink('service')" :disabled="!selectedService"
                                class="mt-1.5 text-[11px] font-bold text-sky-700 hover:text-sky-900 disabled:opacity-40 disabled:cursor-not-allowed flex items-center gap-1 cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>+ Sisipkan Link Layanan ke Teks</span>
                        </button>
                    </div>

                    <div>
                        <label for="city" class="block text-xs font-semibold text-slate-700 mb-1">Wilayah / Kota Target Terkait</label>
                        <select name="city" id="city" x-model="selectedCity" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:border-sky-700 text-xs bg-white">
                            <option value="">-- Seluruh Indonesia / Nasional --</option>
                            @foreach($cities ?? [] as $c)
                                <option value="{{ $c['name'] }}" {{ old('city', $article->city) == $c['name'] ? 'selected' : '' }}>{{ $c['name'] }} ({{ $c['province_name'] }})</option>
                            @endforeach
                        </select>
                        <button type="button" @click="insertInternalLink('city')" :disabled="!selectedCity"
                                class="mt-1.5 text-[11px] font-bold text-sky-700 hover:text-sky-900 disabled:opacity-40 disabled:cursor-not-allowed flex items-center gap-1 cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>+ Sisipkan Link Wilayah ke Teks</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- 3. Jadwal Publikasi & Posisi Gambar -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="published_at" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tanggal Publikasi / Upload</label>
                    <input type="datetime-local" name="published_at" id="published_at" 
                           value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs bg-white">
                    <p class="text-[11px] text-slate-500 mt-1">Tanggal upload resmi yang tampil di kartu dan detail artikel.</p>
                    @error('published_at') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="image_placement" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Posisi Gambar di Halaman Detail</label>
                    <select name="image_placement" id="image_placement"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs bg-white">
                        <option value="content" {{ old('image_placement', $article->image_placement ?? 'content') === 'content' ? 'selected' : '' }}>Di Tengah Konten (Kompak &amp; Rapi)</option>
                        <option value="hero" {{ old('image_placement', $article->image_placement) === 'hero' ? 'selected' : '' }}>Di Hero Section (Header Atas)</option>
                    </select>
                    <p class="text-[11px] text-slate-500 mt-1">Pilih apakah gambar tampil di header atas atau di dalam badan artikel.</p>
                    @error('image_placement') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <x-form.image-upload 
                name="thumbnail" 
                label="Gambar Thumbnail Artikel"
                :current="$article->thumbnail"
                help="Pilih file baru jika ingin mengganti gambar thumbnail artikel saat ini (otomatis WebP)."
            />

            <!-- Foto Tambahan di Tengah Berita (Maksimal 3 Foto, Opsional) -->
            <div class="p-4 sm:p-5 bg-slate-50 rounded-xl border border-slate-200 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Foto Konten Tambahan (Maksimal 3 Foto, Opsional)</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Dapat disematkan otomatis di sela paragraf atau gunakan penanda manual: <code class="px-1.5 py-0.5 bg-slate-200 text-slate-800 rounded font-mono text-[11px]">[foto-1]</code>, <code class="px-1.5 py-0.5 bg-slate-200 text-slate-800 rounded font-mono text-[11px]">[foto-2]</code>, <code class="px-1.5 py-0.5 bg-slate-200 text-slate-800 rounded font-mono text-[11px]">[foto-3]</code> di dalam teks.</p>
                    </div>
                    <span class="text-[11px] font-bold text-sky-800 bg-sky-50 border border-sky-200 px-2.5 py-1 rounded-md shrink-0">Auto-WebP</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @for($i = 1; $i <= 3; $i++)
                    @php
                        $curSlot = $existingContentImages[$i - 1] ?? null;
                        $curPath = is_array($curSlot) ? ($curSlot['path'] ?? null) : (is_string($curSlot) ? $curSlot : null);
                        $curCaption = is_array($curSlot) ? ($curSlot['caption'] ?? '') : '';
                    @endphp
                    <div class="p-3 bg-white rounded-lg border border-slate-200 space-y-3">
                        <x-form.image-upload 
                            name="content_image_{{ $i }}" 
                            label="Foto Tengah #{{ $i }}" 
                            :current="$curPath"
                            aspect="video"
                            help="Maks. 20MB. Otomatis dikonversi ke WebP." />

                        <div>
                            <label for="content_caption_{{ $i }}" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Keterangan Foto #{{ $i }}
                            </label>
                            <input type="text" name="content_caption_{{ $i }}" id="content_caption_{{ $i }}"
                                   value="{{ old('content_caption_' . $i, $curCaption) }}"
                                   placeholder="Contoh: Proses pengikisan kerak pipa"
                                   class="w-full px-3 py-1.5 text-xs rounded-md border border-slate-300 focus:border-sky-700 focus:ring-1 focus:ring-sky-700/20 text-slate-900">
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- 4. Ringkasan & Tag -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="excerpt" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Ringkasan Singkat (Excerpt)</label>
                    <textarea name="excerpt" id="excerpt" rows="3"
                              placeholder="Ringkasan 1-2 kalimat pengantar artikel untuk kartu indeks..."
                              class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">{{ old('excerpt', $article->excerpt) }}</textarea>
                    @error('excerpt') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="tags" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tag Pendukung</label>
                    <textarea name="tags" id="tags" rows="3"
                              placeholder="Misal: Pipa PVC, Wastafel Dapur, Soda Api, CCTV Drainase (pisahkan dengan koma)"
                              class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">{{ old('tags', $article->tags) }}</textarea>
                    @error('tags') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- 5. Modern Text Editor Studio: WYSIWYG TinyMCE + Code + Live Preview -->
            <div class="rounded-xl border border-slate-200 overflow-hidden shadow-2xs bg-white">
                <!-- Toolbar Header & Tabs -->
                <div class="bg-slate-50 border-b border-slate-200 p-2.5 sm:p-3 flex flex-wrap items-center justify-between gap-2.5">
                    <!-- Tab Buttons -->
                    <div class="inline-flex p-0.5 rounded-lg bg-slate-200/80 border border-slate-300 text-xs font-bold">
                        <button type="button" @click="switchTab('visual')"
                                :class="activeTab === 'visual' ? 'bg-white text-sky-800 shadow-2xs' : 'text-slate-600 hover:text-slate-900'"
                                class="px-3 py-1.5 rounded-md transition-colors flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            <span>Editor Visual (Rich Text)</span>
                        </button>
                        <button type="button" @click="switchTab('code')"
                                :class="activeTab === 'code' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-600 hover:text-slate-900'"
                                class="px-3 py-1.5 rounded-md transition-colors flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                            <span>Kode Markdown / HTML</span>
                        </button>
                        <button type="button" @click="switchTab('preview')"
                                :class="activeTab === 'preview' ? 'bg-white text-emerald-800 shadow-2xs' : 'text-slate-600 hover:text-slate-900'"
                                class="px-3 py-1.5 rounded-md transition-colors flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <span>Live Preview</span>
                        </button>
                    </div>

                    <!-- Live Content Stats -->
                    <div class="flex items-center gap-3 text-xs text-slate-500 font-medium">
                        <span class="inline-flex items-center gap-1">
                            <strong class="font-bold text-slate-800" x-text="wordCount">0</strong> kata
                        </span>
                        <span>&bull;</span>
                        <span class="inline-flex items-center gap-1">
                            <strong class="font-bold text-slate-800" x-text="readingTime">1</strong> mnt baca
                        </span>
                        <span>&bull;</span>
                        <span class="text-[11px] text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded font-semibold border border-emerald-200">
                            Auto-WebP Drag &amp; Drop
                        </span>
                    </div>
                </div>

                <!-- Quick Shortcode Actions Toolbar -->
                <div class="bg-slate-50/50 border-b border-slate-200 p-2 sm:p-2.5 flex flex-wrap items-center gap-1.5 text-xs text-slate-700">
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mr-1">Sisipkan Cepat:</span>
                    
                    <!-- Callout Boxes -->
                    <button type="button" @click="insertBlock('[Info Penting]\nTuliskan catatan penting teknis atau informasi wajib di sini.\n[/Info Penting]')"
                            class="px-2 py-1 rounded bg-sky-50 hover:bg-sky-100 text-sky-800 font-semibold border border-sky-200 cursor-pointer">
                        + Box Info
                    </button>
                    <button type="button" @click="insertBlock('[Peringatan Bahaya]\nJangan pernah mencampur soda api dengan cairan kimia asam keras di pipa PVC!\n[/Peringatan Bahaya]')"
                            class="px-2 py-1 rounded bg-rose-50 hover:bg-rose-100 text-rose-800 font-semibold border border-rose-200 cursor-pointer">
                        + Peringatan Bahaya
                    </button>
                    <button type="button" @click="insertBlock('[Tips Hemat]\nSiram leher angsa wastafel dengan air panas secara rutin seminggu sekali untuk mencegah penumpukan minyak jenuh.\n[/Tips Hemat]')"
                            class="px-2 py-1 rounded bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-semibold border border-emerald-200 cursor-pointer">
                        + Tips Hemat
                    </button>

                    <span class="text-slate-300">|</span>

                    <!-- CTAs -->
                    <button type="button" @click="insertBlock('[cta-konsultasi]')"
                            class="px-2 py-1 rounded bg-slate-900 hover:bg-slate-800 text-white font-semibold shadow-2xs cursor-pointer">
                        + CTA WhatsApp
                    </button>
                    <button type="button" @click="insertBlock('[cta-kalkulator]')"
                            class="px-2 py-1 rounded bg-sky-700 hover:bg-sky-800 text-white font-semibold shadow-2xs cursor-pointer">
                        + CTA Kalkulator
                    </button>

                    <span class="text-slate-300">|</span>

                    <!-- Media Tags -->
                    <button type="button" @click="insertVideoBlock()" class="px-2 py-1 rounded bg-indigo-50 hover:bg-indigo-100 text-indigo-800 font-semibold border border-indigo-200 cursor-pointer">+ Video YouTube</button>
                    <button type="button" @click="insertText('[foto-1]', '')" class="px-2 py-1 rounded bg-slate-100 hover:bg-slate-200 font-mono text-[11px] border border-slate-300 cursor-pointer">+ [foto-1]</button>
                    <button type="button" @click="insertText('[foto-2]', '')" class="px-2 py-1 rounded bg-slate-100 hover:bg-slate-200 font-mono text-[11px] border border-slate-300 cursor-pointer">+ [foto-2]</button>
                </div>

                <!-- Textarea Editor (Primary Form Input) -->
                <div x-show="activeTab === 'visual' || activeTab === 'code'" class="p-2 sm:p-3">
                    <textarea name="content" id="content-textarea" x-model="content" rows="18" required
                              placeholder="Tuliskan isi artikel lengkap di sini (mendukung drag-and-drop gambar langsung, format heading, tabel, dan shortcode)..."
                              class="w-full p-4 text-slate-900 text-sm outline-hidden font-mono border border-slate-200 rounded-lg focus:border-sky-700 leading-relaxed resize-y"></textarea>
                    @error('content') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Live Preview Tab -->
                <div x-show="activeTab === 'preview'" class="p-6 bg-white min-h-[420px] max-h-[650px] overflow-y-auto">
                    <div class="border-b border-slate-200 pb-4 mb-4">
                        <div class="text-[11px] font-bold text-sky-700 uppercase tracking-wider mb-1" x-text="selectedCategoryName || 'Edukasi'"></div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight" x-text="title || 'Judul Artikel Belum Diisi'"></h1>
                        <div class="flex items-center gap-2 text-xs text-slate-500 mt-2">
                            <span>Ditulis oleh Tim Ahli Teknis Drainusantara</span>
                            <span>&bull;</span>
                            <span x-text="readingTime + ' menit baca'"></span>
                            <span>&bull;</span>
                            <span class="font-mono text-slate-400" x-text="'/edukasi/' + selectedCategorySlug + '/' + selectedSubcategorySlug + '/' + serpSlug"></span>
                        </div>
                    </div>
                    <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed" x-html="parsedPreviewHtml"></div>
                </div>
            </div>

            <!-- 6. Real-Time SEO Analyzer & Google Mobile SERP Preview (URL Silo) -->
            <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200 pb-3">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Real-Time SEO Analyzer &amp; Google SERP Preview (Silo Structure)</h3>
                        <p class="text-[11px] text-slate-500 mt-0.5">Analisis skor keterbacaan, distribusi focus keyword, dan simulasi tampilan URL Silo di Google Search.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <label for="focus_kw" class="text-xs font-bold text-slate-700">Focus Keyword:</label>
                        <input type="text" id="focus_kw" x-model="focusKeyword" placeholder="Misal: soda api pipa mampet"
                               class="px-2.5 py-1.5 rounded-md border border-slate-300 text-xs text-slate-900 bg-white focus:border-sky-700 outline-hidden">
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                    <!-- Checklist SEO -->
                    <div class="lg:col-span-5 space-y-2 text-xs">
                        <div class="font-bold text-slate-700 mb-1">Checklist Optimasi Konten:</div>
                        
                        <div class="flex items-center gap-2 p-2 rounded-md bg-white border border-slate-200">
                            <span :class="hasKeywordInTitle ? 'text-emerald-600' : 'text-slate-300'">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            </span>
                            <span :class="hasKeywordInTitle ? 'text-slate-800 font-semibold' : 'text-slate-500'">Keyword ada di Judul Artikel</span>
                        </div>

                        <div class="flex items-center gap-2 p-2 rounded-md bg-white border border-slate-200">
                            <span :class="hasKeywordInFirstParagraph ? 'text-emerald-600' : 'text-slate-300'">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            </span>
                            <span :class="hasKeywordInFirstParagraph ? 'text-slate-800 font-semibold' : 'text-slate-500'">Keyword ada di Paragraf Pertama</span>
                        </div>

                        <div class="flex items-center gap-2 p-2 rounded-md bg-white border border-slate-200">
                            <span :class="hasKeywordInHeadings ? 'text-emerald-600' : 'text-slate-300'">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            </span>
                            <span :class="hasKeywordInHeadings ? 'text-slate-800 font-semibold' : 'text-slate-500'">Keyword ada di Sub-heading (H2 / H3)</span>
                        </div>

                        <div class="flex items-center gap-2 p-2 rounded-md bg-white border border-slate-200">
                            <span :class="wordCount >= 300 ? 'text-emerald-600' : 'text-amber-500'">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            </span>
                            <span :class="wordCount >= 300 ? 'text-slate-800 font-semibold' : 'text-slate-500'">
                                Panjang Konten (Minimal 300 kata, saat ini: <strong x-text="wordCount"></strong>)
                            </span>
                        </div>
                    </div>

                    <!-- Google Mobile SERP Card Preview with Silo Structure -->
                    <div class="lg:col-span-7">
                        <div class="text-xs font-bold text-slate-700 mb-1.5">Simulasi Google SERP Snippet (Silo):</div>
                        <div class="p-4 rounded-lg bg-white border border-slate-200 shadow-2xs space-y-1">
                            <div class="flex items-center gap-2 text-xs text-slate-600">
                                <div class="w-4 h-4 rounded-full bg-sky-600 text-white text-[9px] font-black flex items-center justify-center">D</div>
                                <span class="font-medium text-slate-800">Drainusantara</span>
                                <span class="text-slate-400">&bull;</span>
                                <span class="text-slate-500 font-mono text-[11px] truncate">
                                    https://drainusantara.id/edukasi/<span class="text-sky-700 font-bold" x-text="selectedCategorySlug"></span>/<span class="text-emerald-700 font-bold" x-text="selectedSubcategorySlug"></span>/<span class="text-slate-900" x-text="serpSlug"></span>
                                </span>
                            </div>
                            <div class="text-base font-medium text-sky-800 hover:underline cursor-pointer leading-snug line-clamp-2" x-text="serpTitle"></div>
                            <div class="text-xs text-slate-600 leading-relaxed line-clamp-2" x-text="serpDesc"></div>
                        </div>

                        <!-- Manual SEO Inputs -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3">
                            <div>
                                <label for="meta_title" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Custom Meta Title</label>
                                <input type="text" name="meta_title" id="meta_title" x-model="metaTitle"
                                       placeholder="Otomatis dari judul jika kosong"
                                       class="w-full px-3 py-1.5 rounded-md border border-slate-300 text-xs bg-white focus:border-sky-700 outline-hidden">
                            </div>
                            <div>
                                <label for="meta_description" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Custom Meta Description</label>
                                <input type="text" name="meta_description" id="meta_description" x-model="metaDescription"
                                       placeholder="Otomatis dari excerpt jika kosong"
                                       class="w-full px-3 py-1.5 rounded-md border border-slate-300 text-xs bg-white focus:border-sky-700 outline-hidden">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Publikasi & Submit -->
            <div class="flex items-center gap-2.5 pt-1">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', session()->hasOldInput() ? false : $article->is_published) ? 'checked' : '' }}
                       class="w-4 h-4 text-sky-700 rounded-sm border-slate-300 focus:ring-sky-700">
                <label for="is_published" class="text-xs sm:text-sm font-medium text-slate-700 cursor-pointer">Publikasikan Langsung ke Website</label>
            </div>

            <div class="pt-5 border-t border-slate-200 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2.5">
                <a href="{{ route('admin.articles.index') }}" 
                   class="w-full sm:w-auto text-center px-4 py-2.5 bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 font-semibold text-xs sm:text-sm rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="w-full sm:w-auto text-center px-5 py-2.5 bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs sm:text-sm rounded-lg shadow-2xs transition-colors cursor-pointer btn-press">
                    Simpan Perubahan Artikel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@7.6.1/tinymce.min.js" referrerpolicy="origin"></script>
<script>
function articleStudio() {
    const configEl = document.getElementById('article-studio-config');
    const cfg = configEl ? JSON.parse(configEl.textContent) : {};

    return {
        title: cfg.title || '',
        content: cfg.content || '',
        metaTitle: cfg.metaTitle || '',
        metaDescription: cfg.metaDescription || '',
        focusKeyword: cfg.focusKeyword || '',
        selectedCategoryId: cfg.selectedCategoryId || '',
        selectedSubcategoryId: cfg.selectedSubcategoryId || '',
        selectedCategoryName: cfg.selectedCategoryName || '',
        selectedSubcategoryName: cfg.selectedSubcategoryName || '',
        selectedService: cfg.selectedService || '',
        selectedCity: cfg.selectedCity || '',
        activeTab: 'visual',
        categories: cfg.categories || [],
        availableSubcategories: [],

        init() {
            if (this.selectedCategoryName && !this.selectedCategoryId) {
                const found = this.categories.find(c => c.name === this.selectedCategoryName || c.slug === this.selectedCategoryName);
                if (found) {
                    this.selectedCategoryId = found.id;
                    this.selectedCategoryName = found.name;
                }
            } else if (this.selectedCategoryId && !this.selectedCategoryName) {
                const found = this.categories.find(c => c.id == this.selectedCategoryId);
                if (found) {
                    this.selectedCategoryName = found.name;
                }
            }
            this.updateSubcategories(this.selectedCategoryId);
            this.$nextTick(() => {
                this.initTinyMCE();
            });
        },

        onCategoryNameChange(name) {
            this.selectedCategoryName = name;
            const cat = this.categories.find(c => c.name === name || c.id == name);
            if (cat) {
                this.selectedCategoryId = cat.id;
                this.selectedCategoryName = cat.name;
                this.updateSubcategories(cat.id);
            } else {
                this.selectedCategoryId = '';
                this.availableSubcategories = [];
            }
            this.selectedSubcategoryId = '';
            this.selectedSubcategoryName = '';
        },

        onCategoryChange(catId) {
            this.selectedCategoryId = catId;
            const cat = this.categories.find(c => c.id == catId);
            this.selectedCategoryName = cat ? cat.name : '';
            this.selectedSubcategoryId = '';
            this.selectedSubcategoryName = '';
            this.updateSubcategories(catId);
        },

        onSubcategoryNameChange(name) {
            this.selectedSubcategoryName = name;
            const sub = this.availableSubcategories.find(s => s.name === name);
            this.selectedSubcategoryId = sub ? sub.id : '';
        },

        onSubcategoryChange(subId) {
            this.selectedSubcategoryId = subId;
            const sub = this.availableSubcategories.find(s => s.id == subId);
            this.selectedSubcategoryName = sub ? sub.name : '';
        },

        updateSubcategories(catId) {
            const cat = this.categories.find(c => c.id == catId);
            this.availableSubcategories = cat ? (cat.subcategories || []) : [];
            if (this.selectedSubcategoryName && !this.availableSubcategories.some(s => s.name === this.selectedSubcategoryName)) {
                this.selectedSubcategoryId = '';
                this.selectedSubcategoryName = '';
            }
        },

        get selectedCategorySlug() {
            const cat = this.categories.find(c => c.id == this.selectedCategoryId);
            return cat ? cat.slug : 'edukasi';
        },

        get selectedSubcategorySlug() {
            const sub = this.availableSubcategories.find(s => s.id == this.selectedSubcategoryId);
            return sub ? sub.slug : 'umum';
        },

        get wordCount() {
            const clean = (this.content || '').replace(/<[^>]*>/g, ' ').trim();
            return clean ? (clean.match(/\S+/g) || []).length : 0;
        },

        get readingTime() {
            return Math.max(1, Math.ceil(this.wordCount / 200));
        },

        get hasKeywordInTitle() {
            if (!this.focusKeyword.trim()) return false;
            return (this.title || '').toLowerCase().includes(this.focusKeyword.trim().toLowerCase());
        },

        get hasKeywordInFirstParagraph() {
            if (!this.focusKeyword.trim()) return false;
            const clean = (this.content || '').replace(/<[^>]*>/g, '\n').trim();
            const firstP = (clean.split(/\n\s*\n/)[0] || '').toLowerCase();
            return firstP.includes(this.focusKeyword.trim().toLowerCase());
        },

        get hasKeywordInHeadings() {
            if (!this.focusKeyword.trim()) return false;
            const kw = this.focusKeyword.trim().toLowerCase();
            const mdHeadings = (this.content || '').match(/^#{2,3}\s+.*$/gm) || [];
            const htmlHeadings = (this.content || '').match(/<(h[23])(?:\s+[^>]*)?>(.*?)<\/\1>/gi) || [];
            return mdHeadings.some(h => h.toLowerCase().includes(kw)) || htmlHeadings.some(h => h.toLowerCase().includes(kw));
        },

        get serpTitle() {
            const raw = (this.metaTitle || '').trim() || ((this.title || '').trim() ? ((this.title || '').trim() + ' - Drainusantara') : 'Judul Artikel - Drainusantara');
            return raw.length > 60 ? raw.substring(0, 57) + '...' : raw;
        },

        get serpDesc() {
            const raw = (this.metaDescription || '').trim() || (this.content || '').replace(/<[^>]*>/g, '').trim().substring(0, 155);
            return raw.length > 155 ? raw.substring(0, 152) + '...' : (raw || 'Deskripsi ringkasan artikel edukasi dan tips saluran pembuangan Drainusantara.');
        },

        get serpSlug() {
            const s = (this.title || '').toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            return s ? s : '{{ $article->slug }}';
        },

        insertText(before, after = '') {
            const ed = typeof tinymce !== 'undefined' ? tinymce.get('content-textarea') : null;
            if (ed && !ed.isHidden()) {
                const sel = ed.selection.getContent({ format: 'text' }) || 'teks';
                ed.insertContent(before + sel + after);
                this.content = ed.getContent();
            } else {
                const el = document.getElementById('content-textarea');
                if (!el) return;
                const start = el.selectionStart;
                const end = el.selectionEnd;
                const selected = el.value.substring(start, end);
                const replacement = before + (selected || 'teks') + after;
                el.value = el.value.substring(0, start) + replacement + el.value.substring(end);
                this.content = el.value;
                el.focus();
                el.selectionStart = start + before.length;
                el.selectionEnd = start + before.length + (selected ? selected.length : 4);
            }
        },

        insertBlock(template) {
            const ed = typeof tinymce !== 'undefined' ? tinymce.get('content-textarea') : null;
            if (ed && !ed.isHidden()) {
                ed.insertContent('<p>' + template + '</p>');
                this.content = ed.getContent();
            } else {
                const el = document.getElementById('content-textarea');
                if (!el) return;
                const start = el.selectionStart;
                const end = el.selectionEnd;
                const prefix = el.value.substring(0, start);
                const suffix = el.value.substring(end);
                const sep = (prefix && !prefix.endsWith('\n\n')) ? (prefix.endsWith('\n') ? '\n' : '\n\n') : '';
                el.value = prefix + sep + template + '\n\n' + suffix;
                this.content = el.value;
                el.focus();
            }
        },

        insertVideoBlock() {
            const url = prompt('Masukkan URL Video YouTube (contoh: https://www.youtube.com/watch?v=...):');
            if (url && url.trim()) {
                this.insertBlock(`[video: ${url.trim()}]`);
            }
        },

        insertInternalLink(type) {
            if (type === 'service' && this.selectedService) {
                const selectEl = document.getElementById('service_id');
                const serviceName = selectEl ? selectEl.options[selectEl.selectedIndex].text : 'Layanan Pipa';
                this.insertBlock(`[Jasa ${serviceName} Bergaransi Resmi 30 Hari](https://drainusantara.id/layanan)`);
            } else if (type === 'city' && this.selectedCity) {
                const slug = this.selectedCity.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
                this.insertBlock(`[Jasa Saluran Pipa Mampet ${this.selectedCity} (Siaga 24 Jam)](https://drainusantara.id/area/${slug})`);
            }
        },

        switchTab(tab) {
            this.activeTab = tab;
            const ed = typeof tinymce !== 'undefined' ? tinymce.get('content-textarea') : null;
            if (ed) {
                if (tab === 'visual') {
                    ed.show();
                    ed.setContent(this.content || '');
                } else {
                    this.content = ed.getContent();
                    ed.hide();
                }
            }
        },

        initTinyMCE() {
            if (typeof tinymce === 'undefined') return;

            const self = this;
            tinymce.init({
                selector: '#content-textarea',
                height: 520,
                menubar: 'file edit view insert format tools table',
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'wordcount'
                ],
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table link image media | cta_wa cta_calc embed_youtube callout_box | fullscreen code',
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Plus Jakarta Sans", "Segoe UI", Roboto, sans-serif; font-size: 15px; line-height: 1.7; color: #1e293b; max-width: 100%; padding: 1.25rem; } img { max-width: 100%; height: auto; border-radius: 0.5rem; margin: 1rem 0; } table { width: 100%; border-collapse: collapse; margin: 1rem 0; } th, td { border: 1px solid #cbd5e1; padding: 0.5rem 0.75rem; } th { background-color: #f8fafc; font-weight: 700; } blockquote { border-left: 4px solid #0284c7; padding-left: 1rem; color: #475569; font-style: italic; margin: 1rem 0; }',
                images_upload_url: cfg.uploadUrl,
                automatic_uploads: true,
                images_reuse_filename: false,
                images_upload_handler: function (blobInfo, progress) {
                    return new Promise((resolve, reject) => {
                        const formData = new FormData();
                        formData.append('file', blobInfo.blob(), blobInfo.filename());
                        formData.append('_token', cfg.csrfToken);

                        fetch(cfg.uploadUrl, {
                            method: 'POST',
                            body: formData,
                            headers: { 'Accept': 'application/json' }
                        })
                        .then(res => {
                            if (!res.ok) {
                                return res.json().then(e => { throw new Error(e.error || 'Upload gagal'); });
                            }
                            return res.json();
                        })
                        .then(json => {
                            if (json && json.location) {
                                resolve(json.location);
                            } else {
                                reject('Gagal memperoleh URL gambar.');
                            }
                        })
                        .catch(err => {
                            reject(err.message || 'Upload gagal.');
                        });
                    });
                },
                setup: function (editor) {
                    editor.ui.registry.addButton('cta_wa', {
                        text: 'CTA WA',
                        tooltip: 'Sisipkan Tombol WhatsApp Teknisi',
                        icon: 'comment',
                        onAction: function () {
                            editor.insertContent('[cta-konsultasi]');
                        }
                    });

                    editor.ui.registry.addButton('cta_calc', {
                        text: 'Kalkulator',
                        tooltip: 'Sisipkan Kotak Estimasi Biaya',
                        icon: 'table',
                        onAction: function () {
                            editor.insertContent('[cta-kalkulator]');
                        }
                    });

                    editor.ui.registry.addButton('embed_youtube', {
                        text: 'YouTube',
                        tooltip: 'Sematkan Video YouTube',
                        icon: 'embed',
                        onAction: function () {
                            const url = prompt('Masukkan URL Video YouTube (contoh: https://www.youtube.com/watch?v=...):');
                            if (url && url.trim()) {
                                editor.insertContent('[video: ' + url.trim() + ']');
                            }
                        }
                    });

                    editor.ui.registry.addMenuButton('callout_box', {
                        text: 'Box Catatan',
                        tooltip: 'Sisipkan Kotak Callout Khusus',
                        fetch: function (callback) {
                            callback([
                                {
                                    type: 'menuitem',
                                    text: 'Catatan Penting (Info)',
                                    onAction: function () {
                                        editor.insertContent('[Info Penting]Tuliskan catatan teknis atau SOP penting di sini...[/Info Penting]');
                                    }
                                },
                                {
                                    type: 'menuitem',
                                    text: 'Peringatan Bahaya (Warning)',
                                    onAction: function () {
                                        editor.insertContent('[Peringatan Bahaya]Tuliskan peringatan bahaya kimiawi atau pipa pecah di sini...[/Peringatan Bahaya]');
                                    }
                                },
                                {
                                    type: 'menuitem',
                                    text: 'Tips Hemat & Perawatan',
                                    onAction: function () {
                                        editor.insertContent('[Tips Hemat]Tuliskan tips hemat pemeliharaan pipa di sini...[/Tips Hemat]');
                                    }
                                }
                            ]);
                        }
                    });

                    editor.on('change keyup NodeChange input', function () {
                        self.content = editor.getContent();
                        const el = document.getElementById('content-textarea');
                        if (el) {
                            el.value = self.content;
                        }
                    });

                    editor.on('init', function () {
                        if (self.content) {
                            editor.setContent(self.content);
                        }
                    });
                }
            });
        },

        get parsedPreviewHtml() {
            let text = this.content || '';
            if (!text.trim()) {
                return '<p class="text-sm text-slate-400 italic py-8 text-center">Konten artikel masih kosong. Tulis teks pada tab Editor Konten untuk melihat live preview.</p>';
            }

            // Shortcodes replacement for live preview
            text = text.replace(/\[(?:Info Penting|info)\]([\s\S]*?)\[\/(?:Info Penting|info)\]/gi, '<div class="my-4 p-4 rounded-lg bg-sky-50 border-l-4 border-sky-600 text-sky-950 border border-slate-200"><strong class="block text-xs uppercase font-bold text-sky-800 mb-1">Catatan Penting:</strong>$1</div>');
            text = text.replace(/\[(?:Peringatan Bahaya|danger|warning)\]([\s\S]*?)\[\/(?:Peringatan Bahaya|danger|warning)\]/gi, '<div class="my-4 p-4 rounded-lg bg-rose-50 border-l-4 border-rose-600 text-rose-950 border border-slate-200"><strong class="block text-xs uppercase font-bold text-rose-800 mb-1">Peringatan Bahaya:</strong>$1</div>');
            text = text.replace(/\[(?:Tips Hemat|tips|tip)\]([\s\S]*?)\[\/(?:Tips Hemat|tips|tip)\]/gi, '<div class="my-4 p-4 rounded-lg bg-emerald-50 border-l-4 border-emerald-600 text-emerald-950 border border-slate-200"><strong class="block text-xs uppercase font-bold text-emerald-800 mb-1">Tips Hemat:</strong>$1</div>');
            text = text.replace(/\[cta-konsultasi\]/gi, '<div class="my-5 p-4 rounded-lg bg-slate-900 text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3"><div><div class="text-xs font-bold text-emerald-400 uppercase tracking-wider mb-0.5">Siaga 24 Jam Nonstop</div><h4 class="font-bold text-sm text-white">Saluran Pipa Mengalami Kendala Serupa?</h4><p class="text-xs text-slate-300">Konsultasi bebas biaya, teknisi siap meluncur ke lokasi.</p></div><span class="px-3.5 py-2 rounded-lg bg-emerald-600 text-white text-xs font-bold shrink-0">Chat Teknisi via WA</span></div>');
            text = text.replace(/\[cta-kalkulator\]/gi, '<div class="my-5 p-4 rounded-lg bg-sky-50 border border-sky-200 text-slate-900 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3"><div><div class="text-xs font-bold text-sky-800 uppercase tracking-wider mb-0.5">Estimasi Biaya Transparan</div><h4 class="font-bold text-sm text-slate-900">Cek Estimasi Biaya Pelancaran Saluran</h4><p class="text-xs text-slate-600">Hitung perkiraan biaya tanpa biaya tersembunyi.</p></div><span class="px-3.5 py-2 rounded-lg bg-sky-700 text-white text-xs font-bold shrink-0">Lihat Estimasi Biaya</span></div>');
            text = text.replace(/\[foto-([1-3])\]/gi, '<div class="my-4 p-4 rounded-lg border-2 border-dashed border-sky-300 bg-sky-50/60 text-center text-xs font-bold text-sky-800">[Foto Tengah #$1 Ditampilkan di Sini]</div>');
            text = text.replace(/\[video:\s*(.*?)\]/gi, '<div class="my-4 p-4 rounded-lg border-2 border-dashed border-indigo-300 bg-indigo-50/60 text-center text-xs font-bold text-indigo-800">[Preview Video YouTube: $1]</div>');

            return text;
        }
    };
}
</script>
@endpush
