<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\CoverageArea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegionalAreasCmsLandingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        CoverageArea::syncFromMaster();
    }

    public function test_province_landing_page_renders_enhancements(): void
    {
        // Update province record via CMS data
        $province = CoverageArea::where('slug', 'dki-jakarta')->first();
        $this->assertNotNull($province);

        $province->update([
            'cta_headline' => 'Kustom Hotline Provinsi DKI Jakarta',
            'faqs' => [
                [
                    'question' => 'Apakah Drainusantara melayani seluruh penjuru DKI Jakarta?',
                    'answer' => 'Ya, armada kami tersebar di 5 wilayah kota administratif Jakarta.',
                ],
            ],
        ]);

        $response = $this->get('/area/provinsi/dki-jakarta');
        $response->assertStatus(200);

        // 1. Hotline phone in hero section
        $response->assertSee('0856-0900-9009');
        $response->assertSee('tel:085609009009');

        // 2. 1-Row Services Carousel
        $response->assertSee('id="layanan-provinsi"', false);
        $response->assertSee('w-[84vw]', false);

        // 3. 1-Row Equipment Carousel
        $response->assertSee('id="peralatan-armada"', false);
        $response->assertSee('Mesin Spiral Rotary Ridgid K-6200');

        // 4. Regional Coverage Directory
        $response->assertSee('id="cakupan-daerah-operasional"', false);
        $response->assertSee('Jabodetabek');
        $response->assertSee('Semarang');
        $response->assertSee('Lampung');

        // 5. SOP Teknis 5 Pilar
        $response->assertSee('Standar Operasional Wilayah Provinsi DKI Jakarta');
        $response->assertSee('Standar Terverifikasi');

        // 6. Dynamic FAQ from CMS
        $response->assertSee('Apakah Drainusantara melayani seluruh penjuru DKI Jakarta?');
        $response->assertSee('Ya, armada kami tersebar di 5 wilayah kota administratif Jakarta.');

        // 7. Verify no "Estimasi Tiba" in regional coverage cards
        $response->assertDontSee('Estimasi Tiba:');

        // 8. Verify exact 12-section sequence on Province Page
        $content = $response->getContent();
        $posPresence = strpos($content, 'id="kehadiran-lokal-provinsi"');
        $posLayanan = strpos($content, 'id="layanan"');
        $posPeralatan = strpos($content, 'id="peralatan-armada"');
        $posSOP = strpos($content, 'id="standar-operasional-provinsi"');
        $posSektor = strpos($content, 'id="sektor-layanan-provinsi"');
        $posGaleri = strpos($content, 'id="dokumentasi"');
        $posKomparasi = strpos($content, 'id="perbandingan-provinsi"');
        $posArtikel = strpos($content, 'id="artikel-provinsi"');
        $posCakupan = strpos($content, 'id="cakupan-daerah-operasional"');
        $posWilayah = strpos($content, 'id="wilayah-layanan"');
        $posFaq = strpos($content, 'id="faq-provinsi"');

        $this->assertNotFalse($posPresence);
        $this->assertNotFalse($posLayanan);
        $this->assertNotFalse($posPeralatan);
        $this->assertNotFalse($posSOP);
        $this->assertNotFalse($posSektor);
        $this->assertNotFalse($posGaleri);
        $this->assertNotFalse($posKomparasi);
        $this->assertNotFalse($posArtikel);
        $this->assertNotFalse($posCakupan);
        $this->assertNotFalse($posWilayah);
        $this->assertNotFalse($posFaq);

        $this->assertTrue($posPresence < $posLayanan, 'Presence must precede Layanan');
        $this->assertTrue($posLayanan < $posPeralatan, 'Layanan must precede Peralatan');
        $this->assertTrue($posPeralatan < $posSOP, 'Peralatan must precede SOP');
        $this->assertTrue($posSOP < $posSektor, 'SOP must precede Sektor');
        $this->assertTrue($posSektor < $posGaleri, 'Sektor must precede Galeri');
        $this->assertTrue($posGaleri < $posKomparasi, 'Galeri must precede Komparasi');
        $this->assertTrue($posKomparasi < $posArtikel, 'Komparasi must precede Artikel');
        $this->assertTrue($posArtikel < $posCakupan, 'Artikel must precede Cakupan Daerah');
        $this->assertTrue($posCakupan < $posWilayah, 'Cakupan Daerah must precede Wilayah Layanan');
        $this->assertTrue($posWilayah < $posFaq, 'Wilayah Layanan must precede FAQ');
    }

    public function test_city_landing_page_renders_presence_and_enhancements(): void
    {
        // Update city record via CMS data
        $city = CoverageArea::where('slug', 'jakarta-selatan')->first();
        $this->assertNotNull($city);

        $city->update([
            'presence_description' => 'Drainusantara hadir secara resmi di Jakarta Selatan dengan posko siaga armada reaksi cepat.',
            'faqs' => [
                [
                    'question' => 'Berapa lama armada siaga tiba di Jakarta Selatan?',
                    'answer' => 'Sekitar 30 sampai 45 menit tergantung titik kelurahan Anda.',
                ],
            ],
        ]);

        $response = $this->get('/area/jakarta-selatan');
        $response->assertStatus(200);

        // 1. Hotline phone in hero section
        $response->assertSee('0856-0900-9009');
        $response->assertSee('tel:085609009009');

        // 2. Section "Drainusantara Hadir di [Kota]"
        $response->assertSee('id="kehadiran-lokal-kota"', false);
        $response->assertSee('Drainusantara Hadir di');
        $response->assertSee('Drainusantara hadir secara resmi di Jakarta Selatan dengan posko siaga armada reaksi cepat.');

        // 3. 1-Row Services Carousel
        $response->assertSee('id="layanan-kota"', false);
        $response->assertSee('w-[84vw]', false);

        // 4. 1-Row Equipment Carousel
        $response->assertSee('id="peralatan-kota"', false);
        $response->assertSee('Mesin Spiral Rotary Ridgid K-6200');

        // 5. Regional Coverage Directory
        $response->assertSee('id="cakupan-daerah-operasional"', false);
        $response->assertSee('Jabodetabek');

        // 6. SOP Teknis 5 Pilar
        $response->assertSee('Standar Operasional Wilayah Jakarta Selatan');
        $response->assertSee('Standar Terverifikasi');

        // 7. Dynamic FAQ from CMS
        $response->assertSee('Berapa lama armada siaga tiba di Jakarta Selatan?');
        $response->assertSee('Sekitar 30 sampai 45 menit tergantung titik kelurahan Anda.');

        // 8. Verify no "Estimasi Tiba" in regional coverage cards
        $response->assertDontSee('Estimasi Tiba:');

        // 9. Verify exact 12-section sequence on City Page
        $content = $response->getContent();
        $posPresence = strpos($content, 'id="kehadiran-lokal-kota"');
        $posLayanan = strpos($content, 'id="layanan-kota"');
        $posPeralatan = strpos($content, 'id="peralatan-kota"');
        $posSOP = strpos($content, 'id="keunggulan-kota"');
        $posSektor = strpos($content, 'id="sektor-layanan-kota"');
        $posGaleri = strpos($content, 'id="galeri-kota"');
        $posKomparasi = strpos($content, 'id="perbandingan-kota"');
        $posArtikel = strpos($content, 'id="artikel-kota"');
        $posCakupan = strpos($content, 'id="cakupan-daerah-operasional"');
        $posKecamatan = strpos($content, 'id="daftar-kecamatan"');
        $posFaq = strpos($content, 'id="faq-kota"');

        $this->assertNotFalse($posPresence);
        $this->assertNotFalse($posLayanan);
        $this->assertNotFalse($posPeralatan);
        $this->assertNotFalse($posSOP);
        $this->assertNotFalse($posSektor);
        $this->assertNotFalse($posGaleri);
        $this->assertNotFalse($posKomparasi);
        $this->assertNotFalse($posArtikel);
        $this->assertNotFalse($posCakupan);
        $this->assertNotFalse($posKecamatan);
        $this->assertNotFalse($posFaq);

        $this->assertTrue($posPresence < $posLayanan, 'Presence must precede Layanan');
        $this->assertTrue($posLayanan < $posPeralatan, 'Layanan must precede Peralatan');
        $this->assertTrue($posPeralatan < $posSOP, 'Peralatan must precede SOP');
        $this->assertTrue($posSOP < $posSektor, 'SOP must precede Sektor');
        $this->assertTrue($posSektor < $posGaleri, 'Sektor must precede Galeri');
        $this->assertTrue($posGaleri < $posKomparasi, 'Galeri must precede Komparasi');
        $this->assertTrue($posKomparasi < $posArtikel, 'Komparasi must precede Artikel');
        $this->assertTrue($posArtikel < $posCakupan, 'Artikel must precede Cakupan Daerah');
        $this->assertTrue($posCakupan < $posKecamatan, 'Cakupan Daerah must precede Daftar Kecamatan');
        $this->assertTrue($posKecamatan < $posFaq, 'Daftar Kecamatan must precede FAQ');
    }

    public function test_district_landing_page_renders_enhancements(): void
    {
        $response = $this->get('/area/jakarta-selatan/tebet');
        $response->assertStatus(200);

        // 1. Hotline phone in hero section
        $response->assertSee('0856-0900-9009');
        $response->assertSee('tel:085609009009');

        // 2. Section "Drainusantara Hadir di Kecamatan"
        $response->assertSee('id="kehadiran-lokal-kecamatan"', false);
        $response->assertSee('Drainusantara Hadir di');

        // 3. 1-Row Services Carousel
        $response->assertSee('id="layanan-kecamatan"', false);
        $response->assertSee('id="layanan-area"', false);
        $response->assertSee('w-[84vw]', false);

        // 4. 1-Row Equipment Carousel
        $response->assertSee('id="peralatan-kecamatan"', false);
        $response->assertSee('Mesin Spiral Rotary Ridgid K-6200');

        // 5. SOP Teknis 5 Pilar
        $response->assertSee('Standar Operasional Wilayah Tebet');
        $response->assertSee('Standar Terverifikasi');

        // 6. Section Sektor Bangunan
        $response->assertSee('id="sektor-layanan"', false);

        // 7. Section Galeri Dokumentasi Lapangan
        $response->assertSee('id="galeri-kecamatan"', false);
        $response->assertSee('id="dokumentasi"', false);
        $response->assertSee('Hasil Pengerjaan Teknisi di Lapangan');

        // 8. Section Komparasi & Artikel
        $response->assertSee('id="perbandingan-area"', false);
        $response->assertSee('id="artikel-kecamatan"', false);

        // 9. Regional Coverage Directory (no "Estimasi Tiba")
        $response->assertSee('id="cakupan-daerah-operasional"', false);
        $response->assertDontSee('Estimasi Tiba:');

        // 10. Posko Armada & Wilayah Sekitar
        $response->assertSee('id="posko-armada"', false);

        // 11. FAQ Dinamis
        $response->assertSee('id="faq-kecamatan"', false);

        // Verify exact 12-section sequence on District Page matching Province & City
        $content = $response->getContent();
        $posPresence = strpos($content, 'id="kehadiran-lokal-kecamatan"');
        $posLayanan = strpos($content, 'id="layanan-kecamatan"');
        $posPeralatan = strpos($content, 'id="peralatan-kecamatan"');
        $posSOP = strpos($content, 'id="keunggulan-area"');
        $posSektor = strpos($content, 'id="sektor-layanan"');
        $posGaleri = strpos($content, 'id="galeri-kecamatan"');
        $posKomparasi = strpos($content, 'id="perbandingan-area"');
        $posArtikel = strpos($content, 'id="artikel-kecamatan"');
        $posCakupan = strpos($content, 'id="cakupan-daerah-operasional"');
        $posPosko = strpos($content, 'id="posko-armada"');
        $posFaq = strpos($content, 'id="faq-kecamatan"');

        $this->assertNotFalse($posPresence);
        $this->assertNotFalse($posLayanan);
        $this->assertNotFalse($posPeralatan);
        $this->assertNotFalse($posSOP);
        $this->assertNotFalse($posSektor);
        $this->assertNotFalse($posGaleri);
        $this->assertNotFalse($posKomparasi);
        $this->assertNotFalse($posArtikel);
        $this->assertNotFalse($posCakupan);
        $this->assertNotFalse($posPosko);
        $this->assertNotFalse($posFaq);

        $this->assertTrue($posPresence < $posLayanan, 'Presence must precede Layanan');
        $this->assertTrue($posLayanan < $posPeralatan, 'Layanan must precede Peralatan');
        $this->assertTrue($posPeralatan < $posSOP, 'Peralatan must precede SOP');
        $this->assertTrue($posSOP < $posSektor, 'SOP must precede Sektor');
        $this->assertTrue($posSektor < $posGaleri, 'Sektor must precede Galeri');
        $this->assertTrue($posGaleri < $posKomparasi, 'Galeri must precede Komparasi');
        $this->assertTrue($posKomparasi < $posArtikel, 'Komparasi must precede Artikel');
        $this->assertTrue($posArtikel < $posCakupan, 'Artikel must precede Cakupan Daerah');
        $this->assertTrue($posCakupan < $posPosko, 'Cakupan Daerah must precede Posko & Area Sekitar');
        $this->assertTrue($posPosko < $posFaq, 'Posko must precede FAQ');
    }

    public function test_admin_cms_can_select_galleries_and_landing_pages_display_chosen_galleries(): void
    {
        $admin = User::factory()->create();

        // Create 3 specific galleries in DB
        $galleryA = \App\Models\Gallery::create([
            'title' => 'Pembersihan Kerak Lemak Dapur Resto Tebet',
            'slug' => 'pembersihan-kerak-lemak-dapur-resto-tebet',
            'location' => 'Tebet Raya',
            'category' => 'fnb',
            'image' => 'images/dokumentasi/resto-tebet.webp',
            'is_active' => true,
            'order' => 10,
        ]);

        $galleryB = \App\Models\Gallery::create([
            'title' => 'Pelancaran Toilet Duduk Mampet Tebet Barat',
            'slug' => 'pelancaran-toilet-duduk-mampet-tebet-barat',
            'location' => 'Tebet Barat',
            'category' => 'rumahan',
            'image' => 'images/dokumentasi/toilet-tebet-barat.webp',
            'is_active' => true,
            'order' => 20,
        ]);

        $galleryC = \App\Models\Gallery::create([
            'title' => 'Inspeksi Kamera CCTV Pipa Industri Cikarang',
            'slug' => 'inspeksi-kamera-cctv-pipa-industri-cikarang',
            'location' => 'Kawasan Industri Cikarang',
            'category' => 'pabrik',
            'image' => 'images/dokumentasi/pabrik-cikarang.webp',
            'is_active' => true,
            'order' => 30,
        ]);

        $districtArea = CoverageArea::where('city', 'Jakarta Selatan')
            ->where('district', 'Tebet')
            ->first();

        $this->assertNotNull($districtArea);

        // Admin selects Gallery A and Gallery B via CMS
        $response = $this->actingAs($admin)->put(route('admin.coverage-areas.update', $districtArea), [
            'type' => 'district',
            'city' => 'Jakarta Selatan',
            'district' => 'Tebet',
            'gallery_ids' => [$galleryA->id, $galleryB->id],
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.coverage-areas.index'));

        $districtArea->refresh();
        $this->assertEquals([$galleryA->id, $galleryB->id], $districtArea->gallery_ids);

        // Visit district landing page and verify the chosen galleries are rendered
        $pageResponse = $this->get('/area/jakarta-selatan/tebet');
        $pageResponse->assertStatus(200);
        $pageResponse->assertSee('Pembersihan Kerak Lemak Dapur Resto Tebet');
        $pageResponse->assertSee('Pelancaran Toilet Duduk Mampet Tebet Barat');

        // Test with Province as well
        $provinceArea = CoverageArea::where('slug', 'dki-jakarta')->first();
        $this->actingAs($admin)->put(route('admin.coverage-areas.update', $provinceArea), [
            'type' => 'province',
            'city' => 'DKI Jakarta',
            'province_name' => 'DKI Jakarta',
            'gallery_ids' => [$galleryA->id],
            'is_active' => '1',
        ]);

        $provinceResponse = $this->get('/area/provinsi/dki-jakarta');
        $provinceResponse->assertStatus(200);
        $provinceResponse->assertSee('Pembersihan Kerak Lemak Dapur Resto Tebet');
    }

    public function test_admin_cms_can_edit_city_and_province(): void
    {
        $admin = User::factory()->create();

        $city = CoverageArea::where('slug', 'jakarta-selatan')->first();
        $this->assertNotNull($city);

        // Admin updates city via PUT request
        $response = $this->actingAs($admin)->put(route('admin.coverage-areas.update', $city), [
            'type' => 'city',
            'city' => 'Jakarta Selatan',
            'province_name' => 'DKI Jakarta',
            'presence_description' => 'Posko pusat armada Jakarta Selatan siap siaga 24 jam.',
            'cta_headline' => 'Layanan Pipa Mampet Jakarta Selatan',
            'faqs' => [
                [
                    'question' => 'Apakah melayani area perkantoran Jakarta Selatan?',
                    'answer' => 'Ya, kami melayani SCBD, Mega Kuningan, TB Simatupang, dan sekitarnya.',
                ],
            ],
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.coverage-areas.index'));

        $city->refresh();
        $this->assertEquals('Posko pusat armada Jakarta Selatan siap siaga 24 jam.', $city->presence_description);
        $this->assertCount(1, $city->faqs);
        $this->assertEquals('Apakah melayani area perkantoran Jakarta Selatan?', $city->faqs[0]['question']);
    }
}
