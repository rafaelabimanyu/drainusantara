@extends('layouts.app')

@section('content')
@include('about.partials.nav', [
    'activeTitle' => 'FAQ',
    'eyebrow' => 'Pusat Bantuan & Pertanyaan',
    'heading' => 'Tanya Jawab Seputar Layanan & Prosedur Pengerjaan',
    'subheading' => 'Pertanyaan yang paling sering diajukan konsumen seputar metode tanpa bongkar, biaya, durasi pengerjaan, dan garansi.'
])

<!-- Main FAQ Content with Alpine Accordion -->
<section id="faq-page" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200" x-data="{ openFaq: 1 }">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Informasi Transparan
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Jawaban Langsung dari Tim Teknis
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2 leading-relaxed">
                Kami menjunjung tinggi keterbukaan informasi agar Anda merasa aman dan nyaman sebelum memanggil armada teknisi kami.
            </p>
        </div>

        @php
            $faqs = [
                [
                    'id' => 1,
                    'q' => 'Apakah benar proses pengerjaan 100% tanpa membongkar keramik lantai?',
                    'a' => 'Benar 100%. Kami memasukkan kabel spiral baja lentur berkecepatan putar terukur langsung melalui lubang afur wastafel, floor drain, atau lubang kontrol pipa yang ada. Ubin keramik, marmer, maupun dinding semen Anda tetap utuh tanpa retak atau bongkaran.'
                ],
                [
                    'id' => 2,
                    'q' => 'Mengapa pemakaian soda api sangat dilarang untuk pipa pembuangan?',
                    'a' => 'Soda api (NaOH) memicu reaksi kimia eksotermik panas ekstrem hingga di atas 90 derajat Celcius saat bereaksi dengan air. Suhu ini melunakkan pipa PVC, merusak sambungan lem elbow, dan jika gagal melarutkan lemak, justru membentuk gumpalan sabun keras seperti kapur semen di dasar pipa.'
                ],
                [
                    'id' => 3,
                    'q' => 'Berapa lama rata-rata durasi penanganan saluran tersumbat?',
                    'a' => 'Sebagian besar pengerjaan standar rumah tangga (wastafel, floor drain, toilet) selesai dalam waktu 30 hingga 45 menit. Untuk sumbatan berat lemak restoran komersial sepanjang belasan meter atau pemotongan akar pohon, pengerjaan dapat memakan waktu 1 hingga 2 jam.'
                ],
                [
                    'id' => 4,
                    'q' => 'Berapa kisaran estimasi biaya jasa di Drainusantara?',
                    'a' => 'Biaya pengerjaan dimulai dari Rp 400.000 tergantung pada jenis titik saluran, tingkat kerumitan, serta panjang jangkauan meteran pipa. Kami selalu mengonfirmasikan estimasi biaya secara transparan di awal sebelum teknisi memulai tindakan.'
                ],
                [
                    'id' => 5,
                    'q' => 'Bagaimana prosedur dan ketentuan klaim garansi 30 hari?',
                    'a' => 'Klaim garansi sangat mudah: cukup hubungi WhatsApp admin kami dengan menyertakan foto nota digital pengerjaan. Jika titik saluran yang sama tersumbat kembali dalam 30 hari kalender, teknisi kami dijadwalkan ulang tanpa pungutan biaya jasa pelancaran.'
                ],
                [
                    'id' => 6,
                    'q' => 'Apakah Drainusantara melayani pengerjaan malam hari (after-hours) untuk restoran/kafe?',
                    'a' => 'Ya, kami menyediakan tim khusus after-hours untuk mitra komersial seperti restoran mall, kafe, dan hotel, sehingga pengerjaan pembersihan grease trap atau pipa dapur dapat dilakukan setelah jam tutup tanpa mengganggu pelanggan Anda.'
                ],
                [
                    'id' => 7,
                    'q' => 'Wilayah kota mana saja yang dapat dijangkau teknisi siaga?',
                    'a' => 'Saat ini kami memiliki posko siaga armada di seluruh DKI Jakarta (Pusat, Selatan, Timur, Barat, Utara), Bodetabek (Bogor, Depok, Tangerang, Tangerang Selatan, Bekasi), Kota Semarang, dan Bandar Lampung.'
                ],
            ];
        @endphp

        <!-- Accordion Item List -->
        <div class="space-y-3.5 mb-12">
            @foreach($faqs as $item)
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs transition-all">
                    <button type="button" 
                            @click="openFaq = (openFaq === {{ $item['id'] }} ? null : {{ $item['id'] }})"
                            class="w-full flex items-center justify-between p-4 sm:p-5 text-left text-xs sm:text-sm font-bold text-slate-900 hover:text-sky-700 transition-colors cursor-pointer min-h-[48px]">
                        <span class="pr-4 leading-snug">{{ $item['q'] }}</span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 shrink-0" 
                             :class="{ 'rotate-180 text-sky-700': openFaq === {{ $item['id'] }} }" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="openFaq === {{ $item['id'] }}" x-collapse>
                        <div class="px-4 sm:px-5 pb-5 pt-1 border-t border-slate-100 text-xs sm:text-sm text-slate-600 leading-relaxed">
                            {{ $item['a'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Still have questions CTA -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 text-center">
            <h3 class="text-lg font-bold text-slate-900">Pertanyaan Anda Belum Terjawab di Sini?</h3>
            <p class="text-slate-600 text-xs sm:text-sm mt-1 max-w-xl mx-auto">
                Konsultasikan langsung kendala saluran pipa Anda dengan staf teknisi Drainusantara secara gratis melalui WhatsApp.
            </p>
            <div class="mt-6">
                <a href="https://wa.me/{{ config('app.whatsapp_number') ?: '6281234567890' }}?text={{ urlencode('Halo Admin Drainusantara, saya ingin bertanya lebih lanjut mengenai layanan pipa mampet.') }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="btn-press inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs shadow-xs transition-colors min-h-[44px]">
                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Tanya Teknisi via WhatsApp</span>
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
