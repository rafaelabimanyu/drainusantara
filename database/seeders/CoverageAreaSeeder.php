<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CoverageArea;
use Illuminate\Database\Seeder;

class CoverageAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coverageAreas = [
            // 1. Jakarta Selatan
            [
                'city' => 'Jakarta Selatan',
                'district' => 'Tebet',
                'slug' => 'jakarta-selatan-tebet',
                'postal_code' => '12810',
                'meta_title' => 'Jasa Saluran Mampet di Tebet, Jakarta Selatan - Drainusantara Bergaransi',
                'meta_description' => 'Jasa pelancaran pipa wastafel, toilet, dan floor drain mampet di Tebet, Jakarta Selatan. 100% tanpa bongkar keramik, garansi 30 hari. Teknisi siap meluncur!',
                'content' => 'Layanan darurat penanganan saluran pipa mampet untuk perumahan, apartemen, kafe, dan kantor di area Tebet, Jakarta Selatan dan sekitarnya.',
                'is_active' => true,
            ],
            // 2. Jakarta Timur
            [
                'city' => 'Jakarta Timur',
                'district' => 'Duren Sawit',
                'slug' => 'jakarta-timur-duren-sawit',
                'postal_code' => '13440',
                'meta_title' => 'Jasa Saluran Mampet di Duren Sawit, Jakarta Timur - Drainusantara Bergaransi',
                'meta_description' => 'Solusi saluran pipa mampet di Duren Sawit & Jakarta Timur. Tanpa bongkar lantai, bersih higienis, dan bergaransi resmi 30 hari.',
                'content' => 'Melayani perumahan dan ruko di kawasan Duren Sawit, Jakarta Timur dengan mesin rooter spiral elektrik.',
                'is_active' => true,
            ],
            // 3. Jakarta Utara
            [
                'city' => 'Jakarta Utara',
                'district' => 'Kelapa Gading',
                'slug' => 'jakarta-utara-kelapa-gading',
                'postal_code' => '14240',
                'meta_title' => 'Jasa Saluran Mampet di Kelapa Gading, Jakarta Utara - Drainusantara Bergaransi',
                'meta_description' => 'Spesialis saluran wastafel resto & kloset mampet di Kelapa Gading, Jakarta Utara. Menggunakan mesin spiral & CCTV pipa 30 meter.',
                'content' => 'Layanan cepat untuk perumahan elit dan kawasan kuliner di Kelapa Gading, Jakarta Utara.',
                'is_active' => true,
            ],
            // 4. Jakarta Pusat
            [
                'city' => 'Jakarta Pusat',
                'district' => 'Kemayoran',
                'slug' => 'jakarta-pusat-kemayoran',
                'postal_code' => '10620',
                'meta_title' => 'Jasa Saluran Mampet di Kemayoran, Jakarta Pusat - Drainusantara Bergaransi',
                'meta_description' => 'Jasa saluran pipa tersumbat di Kemayoran & Jakarta Pusat. Tanpa bongkar keramik, teknisi ber-APD, garansi 30 hari.',
                'content' => 'Penanganan pipa apartemen, gedung perkantoran, dan perumahan di kawasan Kemayoran, Jakarta Pusat.',
                'is_active' => true,
            ],
            // 5. Jakarta Barat
            [
                'city' => 'Jakarta Barat',
                'district' => 'Kebon Jeruk',
                'slug' => 'jakarta-barat-kebon-jeruk',
                'postal_code' => '11530',
                'meta_title' => 'Jasa Saluran Mampet di Kebon Jeruk, Jakarta Barat - Drainusantara Bergaransi',
                'meta_description' => 'Pelancaran saluran pipa kitchen sink, kloset, dan floor drain di Kebon Jeruk, Jakarta Barat. Tuntas bergaransi 30 hari.',
                'content' => 'Armada teknisi siaga di area Kebon Jeruk, Puri Kembangan, dan Jakarta Barat.',
                'is_active' => true,
            ],
            // 6. Bogor
            [
                'city' => 'Bogor',
                'district' => 'Cibinong',
                'slug' => 'bogor-cibinong',
                'postal_code' => '16911',
                'meta_title' => 'Jasa Saluran Mampet di Cibinong, Bogor - Drainusantara Bergaransi',
                'meta_description' => 'Jasa pipa mampet profesional di Cibinong & Kota/Kabupaten Bogor. 100% tanpa bongkar keramik, garansi 30 hari.',
                'content' => 'Melayani wilayah Cibinong, Sentul, dan seluruh area Bogor dengan respon cepat.',
                'is_active' => true,
            ],
            // 7. Depok & Cinere
            [
                'city' => 'Depok & Cinere',
                'district' => 'Cinere',
                'slug' => 'depok-cinere-cinere',
                'postal_code' => '16514',
                'meta_title' => 'Jasa Saluran Mampet di Cinere, Depok & Cinere - Drainusantara Bergaransi',
                'meta_description' => 'Solusi ahli pipa wastafel & kloset tersumbat di kawasan Cinere, Margonda, dan seluruh Depok. Bergaransi 30 hari.',
                'content' => 'Penanganan saluran pipa mampet untuk perumahan di Cinere dan Depok.',
                'is_active' => true,
            ],
            // 8. Tangerang Kota
            [
                'city' => 'Tangerang Kota',
                'district' => 'Cipondoh',
                'slug' => 'tangerang-kota-cipondoh',
                'postal_code' => '15148',
                'meta_title' => 'Jasa Saluran Mampet di Cipondoh, Tangerang Kota - Drainusantara Bergaransi',
                'meta_description' => 'Teknisi rooter pipa mampet di Cipondoh, Karawaci, Ciledug, Tangerang Kota. Tanpa bongkar, garansi 30 hari.',
                'content' => 'Layanan pelancaran saluran air kotor dan pembuangan di wilayah Tangerang Kota.',
                'is_active' => true,
            ],
            // 9. Tangerang Selatan
            [
                'city' => 'Tangerang Selatan',
                'district' => 'Serpong',
                'slug' => 'tangerang-selatan-serpong',
                'postal_code' => '15310',
                'meta_title' => 'Jasa Saluran Mampet di Serpong, Tangerang Selatan - Drainusantara Bergaransi',
                'meta_description' => 'Teknisi ahli saluran pipa mampet di Serpong, BSD City, Bintaro, Tangerang Selatan. Tanpa bongkar lantai, bergaransi resmi 30 hari.',
                'content' => 'Layanan pelancaran pipa got, wastafel, dan WC di perumahan Serpong, BSD City, dan Tangerang Selatan.',
                'is_active' => true,
            ],
            // 10. Bekasi & Cikarang
            [
                'city' => 'Bekasi & Cikarang',
                'district' => 'Cikarang Selatan',
                'slug' => 'bekasi-cikarang-cikarang-selatan',
                'postal_code' => '17530',
                'meta_title' => 'Jasa Saluran Mampet di Cikarang Selatan, Bekasi & Cikarang - Drainusantara Bergaransi',
                'meta_description' => 'Jasa pelancaran pipa saluran mampet perumahan dan kawasan industri di Cikarang & Bekasi. Garansi 30 hari.',
                'content' => 'Armada teknisi siaga di Bekasi Barat, Tambun, dan Cikarang.',
                'is_active' => true,
            ],
            // 11. Kota Semarang
            [
                'city' => 'Kota Semarang',
                'district' => 'Candisari',
                'slug' => 'kota-semarang-candisari',
                'postal_code' => '50257',
                'meta_title' => 'Jasa Saluran Mampet di Candisari, Kota Semarang - Drainusantara Bergaransi',
                'meta_description' => 'Jasa pipa mampet profesional di Candisari, Kota Semarang. Tanpa soda api, tanpa bongkar keramik, garansi 30 hari.',
                'content' => 'Armada teknisi siaga di area Candisari, Banyumanik, dan seluruh Kota Semarang.',
                'is_active' => true,
            ],
            // 12. Bandar Lampung
            [
                'city' => 'Bandar Lampung',
                'district' => 'Kedaton',
                'slug' => 'bandar-lampung-kedaton',
                'postal_code' => '35141',
                'meta_title' => 'Jasa Saluran Mampet di Kedaton, Bandar Lampung - Drainusantara Bergaransi',
                'meta_description' => 'Spesialis saluran wastafel dan WC mampet di Kedaton, Bandar Lampung. Pengerjaan mekanis spiral bergaransi 30 hari.',
                'content' => 'Solusi tuntas pipa mampet untuk perumahan, ruko, dan tempat usaha di kawasan Kedaton dan Kota Bandar Lampung.',
                'is_active' => true,
            ],
            // 13. Tingkat Kota: Semarang (Hub Jawa Tengah)
            [
                'type' => 'city',
                'province_name' => 'Jawa Tengah',
                'city' => 'Kota Semarang',
                'district' => '[KOTA]',
                'slug' => 'semarang',
                'meta_title' => 'Jasa Saluran & Pipa Mampet Semarang - Garansi 30 Hari Tanpa Bongkar',
                'meta_description' => 'Jasa saluran pipa mampet di Semarang: wastafel dapur, kloset toilet, talang air, & floor drain tanpa bongkar keramik. Mesin spiral baja Ridgid, siaga 24 jam & garansi 30 hari.',
                'content' => 'Layanan pelancaran saluran pipa mampet profesional di Kota Semarang dan sekitarnya. Menangani tantangan instalasi drainase dataran rendah dan kawasan Pantura Semarang dari sedimentasi lumpur, pasir halus, hingga timbunan kerak lemak mengeras di pipa pembuangan rumah tangga, resto, ruko, serta penginapan. Tanpa bongkar keramik lantai dan tanpa bahan kimia korosif.',
                'posko_name' => 'Posko Armada Siaga Kota Semarang',
                'posko_address' => 'Posko Armada Siaga Kota Semarang (Area Candisari, Simpang Lima & Sekitarnya)',
                'posko_coverage_radius' => 'Radius Jangkauan 20 KM • Melayani Semarang Tengah, Banyumanik, Tembalang, Genuk, Pedurungan',
                'cta_headline' => 'Saluran Pipa di Semarang Mampet Hari Ini?',
                'cta_button_text' => 'Panggil Teknisi Semarang via WhatsApp',
                'cta_whatsapp_text' => 'Halo teknisi Drainusantara Semarang, saya membutuhkan layanan darurat pipa mampet di area Semarang. Mohon info teknisi terdekat.',
                'is_active' => true,
            ],
            // 14. Tingkat Kota: Depok & Cinere
            [
                'type' => 'city',
                'province_name' => 'Jawa Barat',
                'city' => 'Depok & Cinere',
                'district' => '[KOTA]',
                'slug' => 'depok-cinere',
                'meta_title' => 'Jasa Saluran & Pipa Mampet Depok - Garansi 30 Hari Tanpa Bongkar',
                'meta_description' => 'Jasa saluran pipa mampet di Depok & Cinere: wastafel cuci piring, kloset WC, & floor drain tersumbat tanpa bongkar keramik. Teknisi siaga 24 jam & garansi resmi 30 hari.',
                'content' => 'Spesialis pelancaran pipa saluran mampet untuk perumahan, kafe, restoran, dan ruko komersial di kawasan Depok dan Cinere. Melayani penanganan sumbatan kerak lemak membatu di leher angsa sifon dapur, gumpalan rambut di floor drain kamar mandi, hingga penetrasi akar pohon di pipa pembuangan luar tanah. Dikerjakan dengan mesin spiral rotary baja tanpa merusak paralon PVC.',
                'posko_name' => 'Posko Armada Siaga Depok & Cinere',
                'posko_address' => 'Posko Armada Siaga Depok & Cinere (Area Margonda, Cinere & Sekitarnya)',
                'posko_coverage_radius' => 'Radius Jangkauan 15 KM • Melayani Cinere, Margonda, Sawangan, Beji, Sukmajaya, Cimanggis',
                'cta_headline' => 'Wastafel atau Kloset di Depok Tersumbat?',
                'cta_button_text' => 'Panggil Teknisi Depok via WhatsApp',
                'cta_whatsapp_text' => 'Halo teknisi Drainusantara Depok, saya membutuhkan layanan pelancaran saluran mampet di area Depok/Cinere. Mohon info kedatangan teknisi.',
                'is_active' => true,
            ],
            // 15. Tingkat Kota: Jakarta Timur
            [
                'type' => 'city',
                'province_name' => 'DKI Jakarta',
                'city' => 'Jakarta Timur',
                'district' => '[KOTA]',
                'slug' => 'jakarta-timur',
                'meta_title' => 'Jasa Saluran & Pipa Mampet Jakarta Timur - Posko Siaga 24 Jam',
                'meta_description' => 'Jasa pelancaran saluran pipa mampet di Jakarta Timur (Duren Sawit, Ciracas, Cakung, Kramat Jati). 100% tanpa bongkar keramik, mesin rotary baja & garansi resmi 30 hari.',
                'content' => 'Layanan darurat penanganan saluran pipa mampet terpercaya di seluruh wilayah Jakarta Timur. Didukung oleh posko armada pusat dengan respon teknisi cepat ke perumahan, apartemen, rumah sakit, dan sentra kuliner. Pembersihan menyeluruh pipa wastafel, bak kontrol, talang dak beton, serta kloset tersumbat.',
                'posko_name' => 'Posko Armada Siaga Jakarta Timur',
                'posko_address' => 'Posko Armada Siaga Jakarta Timur (Area Duren Sawit & Sekitarnya)',
                'posko_coverage_radius' => 'Radius Jangkauan Seluruh Jakarta Timur • Respon Cepat Siaga 24 Jam',
                'cta_headline' => 'Pipa Mampet di Jakarta Timur Butuh Tindakan Cepat?',
                'cta_button_text' => 'Hubungi Teknisi Jakarta Timur via WhatsApp',
                'cta_whatsapp_text' => 'Halo teknisi Drainusantara Jakarta Timur, saya butuh bantuan pelancaran pipa mampet. Mohon dikirimkan teknisi terdekat.',
                'is_active' => true,
            ],
            // 16. Tingkat Kota: Jakarta Barat
            [
                'type' => 'city',
                'province_name' => 'DKI Jakarta',
                'city' => 'Jakarta Barat',
                'district' => '[KOTA]',
                'slug' => 'jakarta-barat',
                'meta_title' => 'Jasa Saluran & Pipa Mampet Jakarta Barat - Garansi 30 Hari Tanpa Bongkar',
                'meta_description' => 'Jasa saluran pipa mampet di Jakarta Barat (Kebon Jeruk, Puri Kembangan, Grogol, Cengkareng). Tanpa bongkar keramik, mesin rotary Ridgid, siaga 24 jam & garansi 30 hari.',
                'content' => 'Spesialis pelancaran pipa wastafel, floor drain, dan kloset mampet di wilayah Jakarta Barat. Melayani kompleks perumahan, ruko perkantoran, restoran, dan pergudangan di Kebon Jeruk, Puri Indah, Grogol, Cengkareng, dan Palmerah dengan teknologi spiral fleksibel dan kamera endoskopi pipa.',
                'posko_name' => 'Posko Armada Siaga Jakarta Barat',
                'posko_address' => 'Posko Armada Siaga Jakarta Barat (Area Kebon Jeruk & Sekitarnya)',
                'posko_coverage_radius' => 'Radius Jangkauan Seluruh Jakarta Barat • Siaga 24 Jam',
                'cta_headline' => 'Saluran Air di Jakarta Barat Meluap?',
                'cta_button_text' => 'Panggil Teknisi Jakarta Barat via WhatsApp',
                'cta_whatsapp_text' => 'Halo teknisi Drainusantara Jakarta Barat, saya membutuhkan penanganan pipa mampet di Jakarta Barat. Mohon info teknisi terdekat.',
                'is_active' => true,
            ],
        ];

        foreach ($coverageAreas as $area) {
            CoverageArea::updateOrCreate(['slug' => $area['slug']], $area);
        }

        // Synchronize any remaining districts from the RegionService master directory
        CoverageArea::syncFromMaster();
    }
}
