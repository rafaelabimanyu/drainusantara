<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_key',
        'title',
        'subtitle',
        'meta_title',
        'meta_description',
        'hero_image',
        'content',
        'sections_data',
        'is_active',
    ];

    protected $casts = [
        'sections_data' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get or create a company page with default fallback values.
     */
    public static function getByKey(string $key): self
    {
        return self::firstOrCreate(
            ['page_key' => $key],
            self::defaultData($key)
        );
    }

    /**
     * Default seeded data for each company page.
     */
    public static function defaultData(string $key): array
    {
        $defaults = [
            'profil' => [
                'page_key' => 'profil',
                'title' => 'Profil Perusahaan: Spesialis Pipa Mampet Tanpa Bongkar',
                'subtitle' => 'Membangun standar baru penanganan sanitasi dan drainase pipa di Indonesia dengan teknologi mekanis presisi, integritas operasional, dan garansi resmi.',
                'meta_title' => 'Profil Perusahaan: Spesialis Pipa Tanpa Bongkar',
                'meta_description' => 'Profil resmi Drainusantara: spesialis pelancaran pipa mampet tanpa bongkar keramik berstandar mutu tinggi, integritas teknis, dan jaminan garansi 30 hari.',
                'hero_image' => 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp',
                'content' => 'Drainusantara didirikan atas kebutuhan mendesak masyarakat Indonesia akan solusi pipa tersumbat yang tidak merusak lantai keramik dan tidak menggunakan bahan kimia soda api yang merusak instalasi. Dengan tim teknisi terlatih dan peralatan spiral rotary modern berstandar internasional, kami hadir memberikan jaminan mutu no cure no pay.',
                'sections_data' => [
                    'vision' => 'Menjadi penyedia solusi drainase mekanis nomor satu dan paling terpercaya di seluruh kepulauan Nusantara.',
                    'mission' => [
                        'Memberikan layanan pelancaran pipa mampet non-destruktif tanpa bongkar keramik.',
                        'Menghilangkan ketergantungan masyarakat pada bahan kimia berbahaya seperti soda api.',
                        'Memberikan garansi purna jual nyata 30 hari kalender dengan respons cepat.',
                    ],
                    'core_values' => [
                        ['title' => 'Integritas Teknis', 'desc' => 'Pemeriksaan transparan dengan kamera CCTV tanpa trik biaya tersembunyi.'],
                        ['title' => 'No Cure No Pay', 'desc' => 'Saluran tidak lancar? Anda tidak perlu membayar biaya jasa.'],
                        ['title' => 'Higienitas Total', 'desc' => 'Cover sepatu steril dan pembersihan area pasca pengerjaan.'],
                    ],
                ],
                'is_active' => true,
            ],
            'cara-kerja' => [
                'page_key' => 'cara-kerja',
                'title' => 'Cara Kerja & Standar Proses Non-Destruktif',
                'subtitle' => 'Alur pengerjaan 5 tahap teknisi Drainusantara yang terukur, aman untuk pipa PVC, dan terbukti efektif menuntaskan sumbatan tanpa merusak bangunan.',
                'meta_title' => 'Cara Kerja & Standar Proses Non-Destruktif',
                'meta_description' => 'Pelajari 5 tahap proses kerja mekanis Drainusantara: deteksi CCTV endoskopi, penetrasi spiral baja Ridgid, pengikisan kerak pipa, uji alir debit air, dan garansi 30 hari.',
                'hero_image' => 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp',
                'content' => 'Proses pelancaran pipa di Drainusantara mengedepankan metode non-destruktif berstandar internasional. Tanpa sedikit pun membongkar ubin, dinding, atau merusak lem sambungan pipa PVC.',
                'sections_data' => [
                    'steps' => [
                        ['num' => '01', 'title' => 'Inspeksi & Diagnosis Awal', 'desc' => 'Menggunakan kamera endoskopi drain CCTV IP68 untuk memetakan titik sumbatan dan kondisi pipa.'],
                        ['num' => '02', 'title' => 'Penetrasi Spiral Rotary Fleksibel', 'desc' => 'Kabel spiral baja elastis berputar masuk melintasi leher angsa dan belokan pipa (knee elbow) 90 derajat.'],
                        ['num' => '03', 'title' => 'Pencacahan Lemak & Penarikan Benda', 'desc' => 'Mata pisau khusus mencacah endapan lemak membatu dan mengait rambut atau sampah keluar.'],
                        ['num' => '04', 'title' => 'Flushing & Uji Alir Debit Penuh', 'desc' => 'Penggelontoran air debit maksimal untuk memastikan aliran benar-benar lancar tanpa genangan.'],
                        ['num' => '05', 'title' => 'Penerbitan Nota Garansi 30 Hari', 'desc' => 'Pemberian nota digital bergaransi resmi 30 hari kalender dengan jaminan No Cure No Pay.'],
                    ],
                ],
                'is_active' => true,
            ],
            'holding' => [
                'page_key' => 'holding',
                'title' => 'Struktur Entitas Induk PT Jawa Jaya Rooter',
                'subtitle' => 'Drainusantara beroperasi dengan dukungan penuh entitas induk PT Jawa Jaya Rooter, menghadirkan kekuatan rantai pasok mesin mekanik dan standarisasi layanan di seluruh Nusantara.',
                'meta_title' => 'Struktur Entitas Induk PT Jawa Jaya Rooter',
                'meta_description' => 'Drainusantara bernaung di bawah entitas induk PT Jawa Jaya Rooter. Sinergi rantai pasok mesin mekanik, kendali mutu, dan standarisasi operasional terpadu.',
                'hero_image' => 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp',
                'content' => 'Sebagai bagian dari entitas bisnis terintegrasi PT Jawa Jaya Rooter, Drainusantara memiliki akses langsung ke inovasi teknologi sanitasi modern, ketersediaan suku cadang mesin, serta pelatihan sertifikasi teknisi berkelanjutan.',
                'sections_data' => [
                    'holding_name' => 'PT Jawa Jaya Rooter',
                    'synergies' => [
                        ['title' => 'Rantai Pasok Teknologi', 'desc' => 'Pengadaan langsung unit mesin drain cleaner Ridgid dan modul spiral baja high-torque original.'],
                        ['title' => 'Pusat Diklat Teknisi', 'desc' => 'Pelatihan berkala bagi seluruh teknisi mengenai keselamatan K3, plumbing code, dan etika pelayanan hunian.'],
                        ['title' => 'Manajemen Logistik Armada', 'desc' => 'Sistem monitoring posko siaga armada terpusat untuk menjamin response time cepat di setiap kota.'],
                    ],
                ],
                'is_active' => true,
            ],
            'sop-k3' => [
                'page_key' => 'sop-k3',
                'title' => 'Standar SOP K3 & Higienitas Teknisi',
                'subtitle' => 'Keselamatan kerja, sterilisasi area konsumen, dan kepatuhan prosedur kelistrikan GFCI pada setiap kunjungan teknisi Drainusantara.',
                'meta_title' => 'Standar SOP K3 & Higienitas Teknisi',
                'meta_description' => 'Protokol K3 resmi teknisi Drainusantara: pemakaian APD steril, cover sepatu saat masuk hunian, keamanan kelistrikan GFCI, dan uji alir sanitasi.',
                'hero_image' => 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp',
                'content' => 'Setiap armada teknisi Drainusantara wajib mematuhi standar higienitas ketat untuk menjaga keamanan, kenyamanan, dan kebersihan rumah maupun unit usaha konsumen.',
                'sections_data' => [
                    'checkpoints' => [
                        ['title' => 'Pemakaian Shoe Cover Steril', 'desc' => 'Wajib memakai penutup sepatu steril sebelum menginjak lantai hunian konsumen.'],
                        ['title' => 'Alas Kerja Anti Bocor & Terpal Sanitasi', 'desc' => 'Area kerja dilapisi pelindung agar cipratan air kotor tidak mengotori lantai keramik sekitarnya.'],
                        ['title' => 'Keamanan Listrik Ground Fault (GFCI)', 'desc' => 'Mesin rotary dilengkapi proteksi pemutus arus kebocoran tanah untuk mencegah sengatan listrik.'],
                        ['title' => 'Desinfeksi Akhir Area Kerja', 'desc' => 'Pembersihan dan sterilisasi area kerja pasca tindakan hingga bersih seperti semula.'],
                    ],
                ],
                'is_active' => true,
            ],
            'peralatan' => [
                'page_key' => 'peralatan',
                'title' => 'Peralatan & Teknologi Mesin Pipa Modern',
                'subtitle' => 'Investasi armada mekanis canggih: mesin spiral rotary Ridgid, kamera endoskopi drain CCTV IP68, dan unit hydro jetting tekanan terukur.',
                'meta_title' => 'Peralatan & Teknologi Mesin Pipa Modern',
                'meta_description' => 'Spesifikasi mesin drain rooter Ridgid spiral baja rotary, kamera inspeksi visual CCTV IP68 jangkauan 30 meter, dan water jetting pembersih grease trap.',
                'hero_image' => 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp',
                'content' => 'Kami menolak penggunaan metode konvensional seperti menusuk dengan kawat bambu atau menuang bahan kimia soda api. Seluruh armada Drainusantara dipersenjatai mesin standar plumbing internasional.',
                'sections_data' => [
                    'tech_pillars' => [
                        ['title' => 'Rotary Spiral Ridgid K-50 & K-60', 'spec' => 'Spiral Baja 16mm & 22mm', 'desc' => 'Menghancurkan endapan lemak, akar pohon, dan sampah padat tanpa menggores dinding pipa PVC.'],
                        ['title' => 'Kamera Pipa Endoskopi IP68', 'spec' => 'Kabel semi-rigid 30 Meter & LED Super Bright', 'desc' => 'Visualisasi real-time kondisi bagian dalam pipa dan memastikan kebersihan saluran 100%.'],
                        ['title' => 'Hydro Jetting High-Flow', 'spec' => 'Nozzle Putar Spesialis Grease Trap', 'desc' => 'Menyapu bersih sisa lemak cair dan minyak pada saluran dapur restoran berkapasitas besar.'],
                    ],
                ],
                'is_active' => true,
            ],
            'kemitraan' => [
                'page_key' => 'kemitraan',
                'title' => 'Kemitraan B2B & Portofolio Rekam Jejak',
                'subtitle' => 'Solusi kontrak pemeliharaan drainase rutin (SLA) untuk restoran, kafe, hotel, pengelola gedung perkantoran, dan kawasan pabrik industri.',
                'meta_title' => 'Klien & Portofolio Proyek B2B',
                'meta_description' => 'Daftar portofolio klien komersial B2B dan hunian residensial Drainusantara: restoran F&B, hotel bintang, food court, ruko, dan gedung perkantoran.',
                'hero_image' => 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp',
                'content' => 'Drainusantara dipercaya oleh puluhan brand kuliner, hotel berbintang, dan pengelola properti untuk penanganan darurat 24 jam serta pemeliharaan berkala grease trap pencegah overflow.',
                'sections_data' => [
                    'benefits' => [
                        ['title' => 'Service Level Agreement (SLA) 24 Jam', 'desc' => 'Prioritas dispatch armada teknisi dalam waktu 30-45 menit untuk panggilan darurat bisnis F&B.'],
                        ['title' => 'Faktur Pajak & Dokumen Resmi Lengkap', 'desc' => 'Kemudahan administrasi perusahaan dengan penagihan resmi, invoice, dan laporan berita acara foto pengerjaan.'],
                        ['title' => 'Paket Maintenance Rutin Grease Trap', 'desc' => 'Pencegahan pipa mampet berkala terjadwal di luar jam operasional resto sehingga tidak mengganggu pengunjung.'],
                    ],
                ],
                'is_active' => true,
            ],
            'garansi' => [
                'page_key' => 'garansi',
                'title' => 'Ketentuan Resmi Garansi 30 Hari Kalender',
                'subtitle' => 'Komitmen perlindungan purna jual tanpa biaya tambahan dengan prinsip transparansi No Cure No Pay yang mengikat secara resmi.',
                'meta_title' => 'Ketentuan Resmi Garansi 30 Hari Kalender',
                'meta_description' => 'Syarat dan ketentuan resmi jaminan garansi 30 hari kalender Drainusantara, komitmen No Cure No Pay, serta alur klaim kunjungan ulang bebas biaya.',
                'hero_image' => 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp',
                'content' => 'Setiap pengerjaan pelancaran pipa oleh teknisi Drainusantara dilindungi masa garansi 30 hari kalender. Jika saluran air kembali mampet dalam masa garansi, kami datang kembali melancarkan sampai tuntas tanpa biaya tambahan.',
                'sections_data' => [
                    'rules' => [
                        ['title' => 'Masa Berlaku Garansi', 'desc' => 'Garansi berlaku selama 30 hari kalender terhitung sejak tanggal pengerjaan yang tercantum pada nota digital resmi.'],
                        ['title' => 'Cakupan Penanganan Ulang', 'desc' => 'Mencakup titik saluran yang sama yang dikerjakan oleh teknisi kami tanpa biaya kunjungan maupun biaya pengerjaan ulang.'],
                        ['title' => 'Komitmen No Cure No Pay', 'desc' => 'Jika saluran air tetap tidak berhasil dialirkan lancar oleh tim teknisi kami, pelanggan tidak dikenakan biaya jasa.'],
                        ['title' => 'Klaim 1-Klik via WhatsApp', 'desc' => 'Cukup kirim foto nota digital atau nomor telepon pemesan ke WhatsApp customer care kami, armada langsung dijadwalkan ulang.'],
                    ],
                ],
                'is_active' => true,
            ],
        ];

        return $defaults[$key] ?? [
            'page_key' => $key,
            'title' => ucfirst($key),
            'subtitle' => '',
            'meta_title' => ucfirst($key) . ' - Drainusantara',
            'meta_description' => '',
            'content' => '',
            'sections_data' => [],
            'is_active' => true,
        ];
    }
}
