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
        ];

        foreach ($coverageAreas as $area) {
            CoverageArea::updateOrCreate(['slug' => $area['slug']], $area);
        }
    }
}
