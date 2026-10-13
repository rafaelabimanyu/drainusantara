<?php

namespace Tests\Feature;

use App\Models\CoverageArea;
use App\Models\User;
use App\Services\RegionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Facade;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RegionContentRegressionTest extends TestCase
{
    use RefreshDatabase;

    public function test_cms_local_content_round_trips_as_plain_text_without_changing_status_or_url(): void
    {
        $this->actingAs(User::factory()->create());
        $create = $this->get(route('admin.coverage-areas.create'))->assertOk();
        $create->assertSee('name="content"', false);
        $create->assertSeeText('Nama Area');
        $content = "Catatan akses pengujian.\n<script>alert('cms')</script> & <b>teks biasa</b>";
        $payload = ['city' => 'Tangerang Selatan', 'district' => 'BSD City', 'content' => $content, 'postal_code' => '00000', 'is_active' => '1'];
        $this->post(route('admin.coverage-areas.store'), $payload)->assertRedirect();
        $area = CoverageArea::where('district', 'BSD City')->firstOrFail();
        $slug = $area->slug;
        $url = route('area.detail', ['city' => 'tangerang-selatan', 'district' => 'bsd-city']);
        $this->assertSame($url, $area->publicUrl());
        $edit = $this->get(route('admin.coverage-areas.edit', $area))->assertOk();
        $dom = new \DOMDocument;
        @$dom->loadHTML($edit->getContent());
        $xpath = new \DOMXPath($dom);
        $textarea = $xpath->query('//textarea[@name="content"]')->item(0);
        $this->assertNotNull($textarea);
        $this->assertSame($content, $textarea->textContent);
        $this->assertSame(1, $xpath->query('//input[@name="is_active"][@checked]')->length);

        $this->get($url)->assertOk()->assertSee($content)->assertSeeText('Kode Pos: 00000')
            ->assertDontSee('<script>alert', false)->assertDontSee('<b>teks biasa</b>', false);
        $payload['content'] = 'Catatan akses diperbarui.';
        $this->put(route('admin.coverage-areas.update', $area), $payload)->assertRedirect();
        $area->refresh();
        $this->assertSame($slug, $area->slug);
        $this->assertSame($url, $area->publicUrl());
        $this->get($url)->assertOk()->assertSeeText($payload['content'])->assertDontSeeText('Catatan akses pengujian.');

        unset($payload['is_active']);
        $this->put(route('admin.coverage-areas.update', $area), $payload)->assertRedirect();
        $this->assertFalse((bool) $area->fresh()->is_active);
        $this->assertNull($area->fresh()->publicUrl());
        $this->get($url)->assertNotFound();
    }

    public function test_mixed_region_directories_and_cms_use_inclusive_labels(): void
    {
        foreach ([
            '/area' => 'Lihat Area',
            '/area/provinsi/banten' => 'PILIH AREA DI',
            '/' => 'Lihat Area Layanan',
        ] as $url => $label) {
            app()->forgetInstance('seotools.json-ld-multi');
            Facade::clearResolvedInstance('seotools.json-ld-multi');
            $response = $this->get($url)->assertOk()->assertSeeText($label);
            $response->assertDontSeeText('Lihat 44 Kecamatan')->assertDontSeeText('PILIH KECAMATAN DI')->assertDontSeeText('KECAMATAN SIAGA:');
            $response->assertSee('Ketik nama kota atau area', false);
            $dom = new \DOMDocument;
            @$dom->loadHTML($response->getContent());
            $data = json_decode($dom->getElementById('drainusantara-areas-data')->textContent, true, 512, JSON_THROW_ON_ERROR);
            $this->assertSame('Kawasan', collect($data)->firstWhere('name', 'BSD City')['type']);
            $bogor = collect($data)->firstWhere('url', route('area.city', ['city' => 'bogor']));
            $this->assertSame('Kota & Kabupaten', $bogor['type']);
            $this->assertStringNotContainsString('Kecamatan Siaga', $bogor['subtitle']);
        }
        $this->actingAs(User::factory()->create());
        $this->get(route('admin.coverage-areas.index'))->assertOk()->assertSeeText('Nama Area')->assertDontSeeText('Kecamatan');
        $this->get(route('admin.coverage-areas.create'))->assertOk()->assertDontSeeText('kecamatan')->assertDontSeeText('{Kecamatan}');
        $this->get('/admin')->assertOk()->assertSeeText('Area / Kota')->assertDontSeeText('landing page SEO kecamatan');
        $this->get('/llms.txt')->assertOk()->assertSee('daftar provinsi, kota, dan area layanan');
    }

    public function test_only_matching_local_content_is_rendered_and_optional_fields_stay_optional(): void
    {
        $area = CoverageArea::create([
            'city' => 'Tangerang Selatan', 'district' => 'BSD City', 'slug' => 'tangerang-selatan-bsd-city',
            'content' => 'Catatan khusus BSD untuk pengujian.', 'postal_code' => '<b>0</b>', 'is_active' => true,
        ]);
        $this->get('/area/tangerang-selatan/bsd-city')->assertOk()->assertSeeText($area->content)
            ->assertSee('Kode Pos: &lt;b&gt;0&lt;/b&gt;', false)->assertDontSee('Kode Pos: <b>0</b>', false);
        $this->get('/area/semarang/simpang-lima')->assertOk()->assertDontSeeText($area->content)->assertDontSeeText('Kode Pos:');
        $area->update(['content' => null, 'postal_code' => null]);
        $this->get('/area/tangerang-selatan/bsd-city')->assertOk()->assertDontSee('id="konten-lokal"', false);
        $this->assertSame('Area', RegionService::districtType([], 'Unknown Test Area'));
    }

    public static function regionTypes(): array
    {
        return [
            ['tangerang-selatan', 'BSD City', 'Kawasan'],
            ['semarang', 'Simpang Lima', 'Kawasan'],
            ['jakarta-timur', 'Rawamangun', 'Kelurahan'],
            ['jakarta-utara', 'Pluit', 'Kelurahan'],
            ['bandung', 'Dago', 'Kelurahan'],
            ['bogor', 'Kota Bogor', 'Kota'],
            ['bogor', 'Sentul City', 'Kawasan'],
            ['jakarta-barat', 'Puri Kembangan', 'Kawasan'],
            ['jakarta-utara', 'Pantai Indah Kapuk', 'Kawasan'],
            ['jakarta-utara', 'Sunter', 'Kawasan'],
            ['depok-cinere', 'Margonda', 'Kawasan'],
            ['bekasi-cikarang', 'Harapan Indah', 'Kawasan'],
            ['tangerang-selatan', 'Bintaro', 'Kawasan'],
            ['bandar-lampung', 'Teluk Betung', 'Kawasan'],
            ['jakarta-selatan', 'Tebet', 'Kecamatan'],
        ];
    }

    #[DataProvider('regionTypes')]
    public function test_region_type_reaches_detail_listing_and_search_without_changing_urls(string $city, string $name, string $type): void
    {
        $cityData = RegionService::findCity($city);
        $this->assertContains($name, $cityData['districts']);
        $url = route('area.detail', ['city' => $city, 'district' => \Illuminate\Support\Str::slug($name)]);
        $response = $this->get($url)->assertOk();
        $label = str_starts_with($name, $type.' ') ? $name : $type.' '.$name;
        $response->assertSeeText('Wilayah Layanan: '.$label.', '.$cityData['name'])->assertDontSeeText('KECAMATAN SEKITAR');
        $this->assertDatabaseCount('coverage_areas', 0);

        app()->forgetInstance('seotools.json-ld-multi');
        Facade::clearResolvedInstance('seotools.json-ld-multi');
        $listing = $this->get(route('area.city', ['city' => $city]))->assertOk();
        $dom = new \DOMDocument;
        @$dom->loadHTML($listing->getContent());
        $xpath = new \DOMXPath($dom);
        $card = $xpath->query('//h3/a[@href="'.$url.'"]/../..')->item(0);
        $this->assertNotNull($card);
        $this->assertSame($type, trim($xpath->query('./span', $card)->item(0)->textContent));
        $listing->assertSeeText('Area yang Dilayani di '.$cityData['name']);

        $item = collect(RegionService::getSearchableItems())->firstWhere('url', $url);
        $this->assertSame($type, $item['type']);
        $this->assertSame(strtoupper($type), $item['badge']);
        $this->assertSame($name, $item['name']);
        $area = new CoverageArea(['city' => $cityData['name'], 'district' => $name, 'is_active' => true]);
        $this->assertSame($url, $area->publicUrl());
    }
}
