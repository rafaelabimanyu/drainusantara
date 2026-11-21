<?php

declare(strict_types=1);

return [
    'channels' => [
        'whatsapp' => [
            'slug' => 'whatsapp',
            'admin_code' => 'wa',
            'name' => 'WhatsApp',
            'breadcrumb_label' => 'Customer Service WhatsApp',
            'handle' => '0856-0900-9009',
            'social_config_key' => 'whatsapp',
            'whatsapp_number' => env('WHATSAPP_NUMBER_WHATSAPP'),
            'summary' => 'Jalur dispatch darurat 24 jam untuk pengiriman teknisi ke rumah, ruko, dan dapur restoran.',
            'seo_title' => 'Customer Service WhatsApp 24 Jam & Dispatch Teknisi Pipa Mampet',
            'seo_description' => 'Hubungi customer service WhatsApp resmi Drainusantara (0856-0900-9009) siaga 24 jam. Pilih kota dan kecamatan Anda untuk memesan teknisi spiral rooter tanpa bongkar keramik.',
            'seo_keywords' => [
                'customer service whatsapp drainusantara',
                'nomor wa tukang pipa mampet',
                'dispatch teknisi saluran mampet 24 jam',
                'wa jasa rooter jakarta',
                'konsultasi pipa mampet whatsapp',
            ],
            'faqs' => [
                [
                    'question' => 'Apakah nomor WhatsApp 0856-0900-9009 melayani panggilan darurat malam hari dan hari libur?',
                    'answer' => 'Ya. Tim operator WhatsApp Drainusantara aktif 24 jam setiap Senin sampai Minggu, termasuk hari libur nasional, untuk menerima keluhan saluran meluap dan menjadwalkan posko armada terdekat.',
                ],
                [
                    'question' => 'Foto atau data apa yang sebaiknya dikirim di chat pertama WhatsApp?',
                    'answer' => 'Sertakan foto titik saluran yang tersumbat (wastafel, kloset, atau floor drain), video singkat saat air disiram, lokasi kecamatan, serta informasi apakah pipa pernah dituangi soda api sebelumnya.',
                ],
                [
                    'question' => 'Bagaimana aturan pembayaran jika teknisi sudah datang ke lokasi lewat WhatsApp?',
                    'answer' => 'Kami menerapkan kebijakan No Cure No Pay. Anda hanya membayar setelah aliran pipa terbukti kembali lancar diuji bersama teknisi di lokasi, disertai nota garansi tertulis 30 hari kalender.',
                ],
                [
                    'question' => 'Apakah konsultasi estimasi biaya via WhatsApp dikenakan tarif atau biaya survei?',
                    'answer' => 'Konsultasi awal dan perkiraan biaya melalui WhatsApp tidak dipungut biaya. Rincian tarif dasar mulai Rp 400.000 akan dikonfirmasi sebelum pengerjaan dimulai.',
                ],
            ],
        ],
        'instagram' => [
            'slug' => 'instagram',
            'admin_code' => 'ig',
            'name' => 'Instagram',
            'breadcrumb_label' => 'Customer Service Instagram',
            'handle' => '@drainusantara',
            'social_config_key' => 'instagram',
            'whatsapp_number' => env('WHATSAPP_NUMBER_INSTAGRAM'),
            'summary' => 'Meja layanan bagi pengunjung profil @drainusantara untuk konsultasi foto/video sumbatan dan dokumentasi before-after.',
            'seo_title' => 'Customer Service Resmi Instagram @drainusantara | Konsultasi Visual Pipa Mampet',
            'seo_description' => 'Tautan resmi bio Instagram @drainusantara. Pilih kota atau kecamatan Anda untuk langsung terhubung ke admin IG Drainusantara via WhatsApp beserta bukti hasil pengerjaan nyata.',
            'seo_keywords' => [
                'customer service instagram drainusantara',
                'admin ig drainusantara',
                'instagram jasa saluran mampet',
                'dm ig tukang pipa mampet',
                'dokumentasi before after drainusantara',
            ],
            'faqs' => [
                [
                    'question' => 'Mengapa tautan bio Instagram @drainusantara mengarahkan ke halaman ini sebelum masuk ke WhatsApp?',
                    'answer' => 'Melalui halaman ini Anda dapat memilih kota dan kecamatan lebih dulu sehingga pesan yang diterima admin IG langsung mencantumkan wilayah Anda, mempercepat pengecekan posko armada yang tersedia.',
                ],
                [
                    'question' => 'Bisakah saya mengirim foto atau video Reels/Story kondisi saluran lewat DM Instagram lalu lanjut ke WhatsApp?',
                    'answer' => 'Bisa. Namun untuk respons jadwal teknisi tercepat dan pengiriman pin lokasi Google Maps rumah Anda, sebaiknya lanjutkan pengiriman foto langsung ke chat WhatsApp admin IG melalui tombol di halaman ini.',
                ],
                [
                    'question' => 'Apakah hasil pengerjaan yang tampil di Instagram @drainusantara dikerjakan tanpa membongkar keramik?',
                    'answer' => 'Benar. Seluruh dokumentasi before-after kami memakai metode mekanis spiral baja rotary dan inspeksi kamera endoskopi sehingga lantai keramik dan nat tetap utuh.',
                ],
                [
                    'question' => 'Bagaimana cara memastikan akun Instagram yang saya hubungi benar milik PT Jawa Jaya Rooter?',
                    'answer' => 'Akun Instagram resmi kami hanya @drainusantara yang terhubung dengan nomor hotline tunggal 0856-0900-9009 dan situs resmi drainusantara.id.',
                ],
            ],
        ],
        'tiktok' => [
            'slug' => 'tiktok',
            'admin_code' => 'tiktok',
            'name' => 'TikTok',
            'breadcrumb_label' => 'Customer Service TikTok',
            'handle' => '@drainusantara',
            'social_config_key' => 'tiktok',
            'whatsapp_number' => env('WHATSAPP_NUMBER_TIKTOK'),
            'summary' => 'Triage cepat gejala pipa mampet dan fakta penanganan tanpa soda api bagi penonton TikTok @drainusantara.',
            'seo_title' => 'Customer Service Resmi TikTok @drainusantara | Cek Gejala & Panggil Teknisi',
            'seo_description' => 'Tautan resmi bio TikTok @drainusantara. Cek gejala saluran mampet di rumah Anda, hindari kerusakan pipa akibat soda api, dan hubungi admin TikTok Drainusantara sesuai kota Anda.',
            'seo_keywords' => [
                'customer service tiktok drainusantara',
                'admin tiktok drainusantara',
                'tiktok jasa saluran mampet',
                'bahaya soda api pipa pvc',
                'rooter spiral tiktok drainusantara',
            ],
            'faqs' => [
                [
                    'question' => 'Saya menonton video pengerjaan di TikTok @drainusantara, apakah alat spiral rooter tersebut bisa masuk ke pipa belokan L?',
                    'answer' => 'Ya. Kabel spiral baja karbon fleksibel dirancang melewati belokan leher angsa dan sambungan L (elbow) tanpa memotong pipa atau membongkar dinding keramik.',
                ],
                [
                    'question' => 'Apakah aman menghubungi admin TikTok Drainusantara jika saluran sudah telanjur dituangi soda api?',
                    'answer' => 'Aman, namun wajib beri tahu admin saat memilih keluhan agar teknisi membawa alat pelindung kerja (APD) dan menetralisir sisa endapan kimia yang mengeras di dalam pipa PVC.',
                ],
                [
                    'question' => 'Berapa lama rata-rata proses pelancaran setelah teknisi tiba seperti di video TikTok?',
                    'answer' => 'Untuk kasus residensial standar (wastafel, floor drain, atau kloset), pengerjaan umumnya selesai dalam 30 hingga 45 menit, sedangkan sumbatan lemak berat atau akar pohon memakan waktu 1 sampai 2 jam.',
                ],
                [
                    'question' => 'Wilayah mana saja yang bisa dilayani dari tautan bio TikTok ini?',
                    'answer' => 'Posko armada kami siaga di Jabodetabek (Jakarta, Bogor, Depok, Tangerang, Tangsel, Bekasi), Bandung Raya, Semarang, Demak, Bandar Lampung, dan Bali.',
                ],
            ],
        ],
        'facebook' => [
            'slug' => 'facebook',
            'admin_code' => 'fb',
            'name' => 'Facebook',
            'breadcrumb_label' => 'Customer Service Facebook',
            'handle' => 'Drainusantara',
            'social_config_key' => 'facebook',
            'whatsapp_number' => env('WHATSAPP_NUMBER_FACEBOOK'),
            'summary' => 'Layanan ramah keluarga dan pemilik hunian dari halaman Facebook Drainusantara, dilengkapi pencari posko kota.',
            'seo_title' => 'Customer Service Facebook Drainusantara | Cari Posko Terdekat & Hubungi Admin',
            'seo_description' => 'Tautan resmi halaman Facebook Drainusantara. Cek ketersediaan posko armada di kota dan kecamatan Anda, lihat ulasan pelanggan hunian, atau telepon langsung 0856-0900-9009.',
            'seo_keywords' => [
                'customer service facebook drainusantara',
                'admin fb drainusantara',
                'halaman facebook tukang pipa mampet',
                'posko drainusantara terdekat',
                'jasa saluran mampet rumahan terpercaya',
            ],
            'faqs' => [
                [
                    'question' => 'Jika saya atau orang tua kesulitan memakai chat otomatis, apakah bisa langsung menelepon?',
                    'answer' => 'Bisa. Anda dapat menekan tombol Telepon Langsung 0856-0900-9009 yang tersedia di halaman Facebook ini untuk berbicara langsung dengan operator posko kami.',
                ],
                [
                    'question' => 'Apakah teknisi Drainusantara menjaga kebersihan lantai rumah selama bekerja?',
                    'answer' => 'Ya. Sesuai standar SOP K3 kami, teknisi mengenakan seragam rapi, pelindung sepatu (cover shoes) saat masuk ruangan, sarung tangan kerja, serta membersihkan kembali area saluran setelah selesai.',
                ],
                [
                    'question' => 'Apakah ada garansi jika saluran di rumah mampet kembali dalam beberapa minggu?',
                    'answer' => 'Setiap pengerjaan mendapat nota garansi resmi berlaku 30 hari kalender. Jika titik yang sama tersumbat kembali dalam masa garansi, teknisi datang melakukan perbaikan ulang tanpa biaya tambahan.',
                ],
                [
                    'question' => 'Di mana alamat kantor pusat resmi PT Jawa Jaya Rooter (Drainusantara)?',
                    'answer' => 'Kantor pusat dan workshop kami berlokasi di Jl. Manunggal XVII No. 104, Lubang Buaya, Cipayung, Kota Jakarta Timur 13810, dengan jaringan posko siaga di kota-kota layanan.',
                ],
            ],
        ],
        'youtube' => [
            'slug' => 'youtube',
            'admin_code' => 'youtube',
            'name' => 'YouTube',
            'breadcrumb_label' => 'Customer Service YouTube',
            'handle' => '@drainusantara',
            'social_config_key' => 'youtube',
            'whatsapp_number' => env('WHATSAPP_NUMBER_YOUTUBE'),
            'summary' => 'Konsultasi teknis mesin spiral Ridgid dan inspeksi kamera endoskopi CCTV pipa IP68 bagi pemirsa YouTube.',
            'seo_title' => 'Customer Service & Konsultasi Teknis YouTube @drainusantara',
            'seo_description' => 'Tautan resmi channel YouTube @drainusantara. Pelajari spesifikasi mesin rooter Ridgid dan kamera CCTV pipa 30 meter, lalu jadwalkan diagnosa teknis sesuai wilayah Anda.',
            'seo_keywords' => [
                'customer service youtube drainusantara',
                'admin youtube drainusantara',
                'inspeksi kamera cctv pipa ip68',
                'mesin rooter ridgid k-50 drainusantara',
                'konsultasi teknis saluran pipa mampet',
            ],
            'faqs' => [
                [
                    'question' => 'Kapan saya cukup memesan mesin spiral rooter dan kapan perlu inspeksi kamera CCTV pipa?',
                    'answer' => 'Mesin spiral rooter cukup untuk sumbatan umum akibat lemak, rambut, atau tisu. Inspeksi kamera CCTV IP68 (jangkauan hingga 30 meter) disarankan jika pipa sering mampet berulang, dicurigai retak/amblas, atau jalur bak kontrol tertimbun lantai.',
                ],
                [
                    'question' => 'Apakah rekaman video dari kamera endoskopi pipa bisa saya terima sebagai dokumentasi?',
                    'answer' => 'Ya. Hasil visual kondisi dalam pipa sebelum dan sesudah tindakan ditampilkan langsung di monitor lapangan dan dapat dibagikan kepada pemilik bangunan atau manajemen gedung.',
                ],
                [
                    'question' => 'Berapa diameter pipa maksimal yang bisa ditangani unit mesin Drainusantara?',
                    'answer' => 'Armada kami membawa pilihan kabel spiral 16mm hingga 22mm untuk pipa rumah tangga 1,5 inci sampai 4 inci, serta dukungan hydro-jetting bertekanan 100 hingga 200 bar untuk jalur induk berdiameter lebih besar.',
                ],
                [
                    'question' => 'Apakah mesin spiral baja dapat menggores atau memecahkan pipa PVC standar?',
                    'answer' => 'Operator kami menyesuaikan mata bor (cutter head) dan torsi putaran dengan diameter serta kondisi material pipa agar kerak terkikis tanpa merusak dinding pipa sehat.',
                ],
            ],
        ],
        'linkedin' => [
            'slug' => 'linkedin',
            'admin_code' => 'linkedin',
            'name' => 'LinkedIn',
            'breadcrumb_label' => 'Customer Service Korporat LinkedIn',
            'handle' => 'PT Jawa Jaya Rooter (Drainusantara)',
            'social_config_key' => 'linkedin',
            'whatsapp_number' => env('WHATSAPP_NUMBER_LINKEDIN'),
            'summary' => 'Meja layanan B2B dan pengadaan korporat PT Jawa Jaya Rooter untuk restoran, hotel, perkantoran, dan pabrik.',
            'seo_title' => 'Customer Service Korporat & B2B LinkedIn | PT Jawa Jaya Rooter',
            'seo_description' => 'Layanan pelanggan B2B resmi PT Jawa Jaya Rooter dari LinkedIn. Dukungan pemeliharaan grease trap, pipa induk gedung, pengerjaan after-hours, kelengkapan SPK, BAPP, NPWP/SPPKP, dan e-Faktur PPN.',
            'seo_keywords' => [
                'customer service linkedin drainusantara',
                'admin linkedin pt jawa jaya rooter',
                'jasa pipa mampet b2b korporat',
                'maintenance grease trap restoran hotel',
                'kontraktor drainase faktur pajak spk',
            ],
            'faqs' => [
                [
                    'question' => 'Dokumen legalitas dan administrasi pengadaan apa yang tersedia untuk vendor korporat?',
                    'answer' => 'Di bawah badan hukum PT Jawa Jaya Rooter, kami menyediakan NIB OSS, NPWP dan SPPKP resmi, penerbitan e-Faktur PPN 11%, Surat Perintah Kerja (SPK), Berita Acara Penyelesaian Pekerjaan (BAPP), serta invoice berstempel.',
                ],
                [
                    'question' => 'Apakah pengerjaan pembersihan grease trap restoran atau pipa gedung bisa dijadwalkan di luar jam operasional?',
                    'answer' => 'Bisa. Tim komersial kami melayani pengerjaan malam hari (after-hours) setelah jam tutup restoran atau gedung perkantoran agar operasional bisnis dan kenyamanan tamu tidak terganggu.',
                ],
                [
                    'question' => 'Apakah tersedia kontrak perawatan berkala untuk jaringan outlet F&B atau manajemen properti?',
                    'answer' => 'Tersedia. Manajemen properti dan grup F&B dapat mengajukan jadwal preventive maintenance bulanan atau triwulanan melalui form penawaran B2B atau langsung ke admin LinkedIn via WhatsApp.',
                ],
                [
                    'question' => 'Bagaimana alur survei lokasi awal untuk gedung bertingkat, pabrik, atau kawasan industri?',
                    'answer' => 'Isi formulir permohonan B2B di halaman ini atau kirim pesan melalui tombol WhatsApp admin LinkedIn dengan menyebutkan wilayah proyek agar tim teknis kami menjadwalkan peninjauan jalur pipa induk dan bak kontrol.',
                ],
            ],
        ],
        'x' => [
            'slug' => 'x',
            'admin_code' => 'x',
            'name' => 'X (Twitter)',
            'breadcrumb_label' => 'Customer Service X (Twitter)',
            'handle' => '@drainusantara',
            'social_config_key' => 'x',
            'whatsapp_number' => env('WHATSAPP_NUMBER_X'),
            'summary' => 'Tanggapan cepat untuk mention, DM, dan pembaca utasan edukasi sanitasi di akun X (Twitter) @drainusantara.',
            'seo_title' => 'Customer Service Resmi X (Twitter) @drainusantara | Respon Cepat & Panduan Pipa',
            'seo_description' => 'Tautan resmi bio X (Twitter) @drainusantara. Pilih kota dan kecamatan Anda untuk terhubung ke admin X Drainusantara via WhatsApp, baca panduan teknis saluran mampet, dan pesan teknisi siaga 24 jam.',
            'seo_keywords' => [
                'customer service x drainusantara',
                'customer service twitter drainusantara',
                'admin x drainusantara',
                'twitter jasa saluran mampet',
                'utasan tips pipa mampet',
            ],
            'faqs' => [
                [
                    'question' => 'Apakah laporan saluran mampet lewat mention atau DM di X (Twitter) langsung ditindaklanjuti ke WhatsApp?',
                    'answer' => 'Ya. Untuk menjaga privasi alamat rumah dan pengiriman pin lokasi Google Maps, admin X akan mengarahkan detail laporan Anda ke WhatsApp posko terdekat melalui tombol di halaman ini.',
                ],
                [
                    'question' => 'Data apa saja yang perlu disiapkan setelah membaca utasan edukasi di X @drainusantara?',
                    'answer' => 'Cukup sebutkan kota serta kecamatan lokasi Anda, titik saluran yang tersumbat (wastafel, floor drain, kloset, atau grease trap), dan riwayat pemakaian soda api bila pernah dituang.',
                ],
                [
                    'question' => 'Apakah tarif dan garansi pengerjaan via kanal X (Twitter) sama dengan halaman utama?',
                    'answer' => 'Sama persis. Estimasi dasar mulai Rp 400.000 dengan sistem mekanis spiral baja rooter tanpa membongkar keramik, kebijakan No Cure No Pay, dan nota garansi resmi 30 hari kalender.',
                ],
                [
                    'question' => 'Apakah admin X Drainusantara melayani panggilan darurat pipa meluap pada malam hari?',
                    'answer' => 'Ya. Operator WhatsApp terhubung langsung dengan armada siaga 24 jam sehingga permintaan malam hari atau akhir pekan tetap dijadwalkan dari posko kota terdekat.',
                ],
            ],
        ],
    ],

    'hub_faqs' => [
        [
            'question' => 'Bagaimana cara memastikan link atau admin customer service Drainusantara yang saya hubungi adalah resmi?',
            'answer' => 'Seluruh halaman /customer-service/{media-sosial} berada di domain resmi drainusantara.id dan terhubung ke nomor layanan utama 0856-0900-9009 di bawah naungan PT Jawa Jaya Rooter.',
        ],
        [
            'question' => 'Apakah ada perbedaan tarif layanan antara memesan lewat WhatsApp, Instagram, TikTok, Facebook, YouTube, LinkedIn, atau X (Twitter)?',
            'answer' => 'Tidak ada perbedaan tarif. Seluruh kanal memakai standar estimasi yang sama mulai Rp 400.000 dengan kebijakan No Cure No Pay dan garansi tertulis 30 hari kalender.',
        ],
        [
            'question' => 'Kanal mana yang paling tepat untuk kebutuhan kantor, hotel, atau restoran yang membutuhkan faktur pajak?',
            'answer' => 'Anda dapat memilih meja Customer Service LinkedIn yang dilengkapi formulir pengadaan B2B (SPK, BAPP, e-Faktur PPN 11%) atau langsung menghubungi WhatsApp 24 jam dengan menyebut tipe bangunan komersial.',
        ],
        [
            'question' => 'Mengapa pesan WhatsApp otomatis meminta saya memilih daerah terlebih dahulu?',
            'answer' => 'Dengan menyertakan kota dan kecamatan di pesan pembuka, operator langsung mengetahui posko armada terdekat yang siaga sehingga estimasi waktu kedatangan teknisi dapat diberikan lebih akurat.',
        ],
    ],
];
