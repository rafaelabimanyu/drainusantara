<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\CoverageArea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewRegionsExpansionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        CoverageArea::syncFromMaster();
    }

    public function test_bandung_raya_cities_and_districts_render_properly(): void
    {
        // 1. Kota Bandung
        $responseBandung = $this->get('/area/bandung');
        $responseBandung->assertOk();
        $responseBandung->assertSee('Kota Bandung');
        $responseBandung->assertSee('ID-JB');
        $responseBandung->assertSee('0856-0900-9009');

        // 2. Kabupaten Bandung
        $responseKabBandung = $this->get('/area/kabupaten-bandung');
        $responseKabBandung->assertOk();
        $responseKabBandung->assertSee('Kabupaten Bandung');
        $responseKabBandung->assertSee('Soreang');
        $responseKabBandung->assertSee('Baleendah');
        $responseKabBandung->assertSee('ID-JB');

        // 3. District Soreang in Kabupaten Bandung
        $responseSoreang = $this->get('/area/kabupaten-bandung/soreang');
        $responseSoreang->assertOk();
        $responseSoreang->assertSee('Soreang');
        $responseSoreang->assertSee('Kabupaten Bandung');
        $responseSoreang->assertSee('Plumber');

        // 4. Kota Cimahi
        $responseCimahi = $this->get('/area/kota-cimahi');
        $responseCimahi->assertOk();
        $responseCimahi->assertSee('Kota Cimahi');
        $responseCimahi->assertSee('Cimahi Tengah');
        $responseCimahi->assertSee('ID-JB');

        // 5. District Cimahi Tengah
        $responseCimahiTengah = $this->get('/area/kota-cimahi/cimahi-tengah');
        $responseCimahiTengah->assertOk();
        $responseCimahiTengah->assertSee('Cimahi Tengah');
    }

    public function test_semarang_and_demak_cities_and_districts_render_properly(): void
    {
        // 1. Kota Semarang
        $responseSemarang = $this->get('/area/semarang');
        $responseSemarang->assertOk();
        $responseSemarang->assertSee('Kota Semarang');
        $responseSemarang->assertSee('ID-JT');

        // 2. Kabupaten Semarang
        $responseKabSemarang = $this->get('/area/kabupaten-semarang');
        $responseKabSemarang->assertOk();
        $responseKabSemarang->assertSee('Kabupaten Semarang');
        $responseKabSemarang->assertSee('Ungaran Barat');
        $responseKabSemarang->assertSee('Ambarawa');
        $responseKabSemarang->assertSee('ID-JT');

        // 3. District Ungaran Barat
        $responseUngaran = $this->get('/area/kabupaten-semarang/ungaran-barat');
        $responseUngaran->assertOk();
        $responseUngaran->assertSee('Ungaran Barat');
        $responseUngaran->assertSee('Kabupaten Semarang');

        // 4. Kabupaten Demak
        $responseDemak = $this->get('/area/demak');
        $responseDemak->assertOk();
        $responseDemak->assertSee('Kabupaten Demak');
        $responseDemak->assertSee('Bonang');
        $responseDemak->assertSee('Mranggen');
        $responseDemak->assertSee('Sayung');
        $responseDemak->assertSee('ID-JT');

        // 5. District Mranggen in Demak
        $responseMranggen = $this->get('/area/demak/mranggen');
        $responseMranggen->assertOk();
        $responseMranggen->assertSee('Mranggen');
        $responseMranggen->assertSee('Kabupaten Demak');

        // 6. District Sayung in Demak
        $responseSayung = $this->get('/area/demak/sayung');
        $responseSayung->assertOk();
        $responseSayung->assertSee('Sayung');
        $responseSayung->assertSee('Kabupaten Demak');
    }

    public function test_regional_coverage_component_shows_adaptive_clusters(): void
    {
        $response = $this->get('/area/bandung');
        $response->assertOk();
        $response->assertSee('Jawa Barat &amp; Bandung Raya', false);
        $response->assertSee('Kota Bandung');
        $response->assertSee('Kab. Bandung');
        $response->assertSee('Kota Cimahi');
        $response->assertSee('Bandung Utara');
        $response->assertSee('Jawa Tengah &amp; Pantura', false);
        $response->assertSee('Kota Semarang');
        $response->assertSee('Kab. Semarang');
        $response->assertSee('Kab. Demak');
        $response->assertSee('Mranggen');
        $response->assertSee('Sayung');
    }
}
