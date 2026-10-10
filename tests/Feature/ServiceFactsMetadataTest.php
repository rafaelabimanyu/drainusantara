<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Facade;
use Tests\TestCase;

class ServiceFactsMetadataTest extends TestCase
{
    use RefreshDatabase;

    public function test_duration_answer_matches_home_faq_and_decoded_schema(): void
    {
        $faq = $this->page('/tentang-kami/faq');
        $answer = $this->durationAnswer($faq, 'faq-page');
        $this->assertStringContainsString('30 hingga 45 menit', $answer);
        $this->assertStringContainsString('1 hingga 2 jam', $answer);
        $this->assertSame($answer, $this->durationAnswer($this->page('/'), 'faq'));

        $schemas = [];
        foreach ($faq->query('//script[@type="application/ld+json"]') as $script) {
            $schema = json_decode($script->textContent, true, 512, JSON_THROW_ON_ERROR);
            array_push($schemas, ...($schema['@graph'] ?? (array_is_list($schema) ? $schema : [$schema])));
        }
        $faqs = array_values(array_filter($schemas, fn ($schema) => $schema['@type'] === 'FAQPage'));
        $this->assertCount(1, $faqs);
        $durations = array_values(array_filter($faqs[0]['mainEntity'], fn ($item) => str_contains($item['name'], 'Berapa lama')));
        $this->assertCount(1, $durations);
        $this->assertSame('Question', $durations[0]['@type']);
        $this->assertSame('Answer', $durations[0]['acceptedAnswer']['@type']);
        $this->assertSame($answer, $durations[0]['acceptedAnswer']['text']);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('pageTitles')]
    public function test_page_and_social_titles_share_one_brand_suffix(string $path, string $title): void
    {
        $page = $this->page($path);
        $expected = $title.' | Drainusantara';
        $titles = $page->query('//head/title | //meta[@property="og:title"] | //meta[@name="twitter:title"]');
        $this->assertCount(3, $titles);
        foreach ($titles as $node) {
            $this->assertSame($expected, $node->nodeName === 'title' ? $node->textContent : $node->getAttribute('content'), $path);
        }
    }

    public static function pageTitles(): array
    {
        return [
            ['/', 'Jasa Saluran Pipa Mampet Tanpa Bongkar'],
            ['/tentang-kami/holding', 'Struktur Ekosistem Holding J&J Group'],
            ['/tentang-kami/profil', 'Profil Perusahaan: Spesialis Pipa Tanpa Bongkar'],
            ['/tentang-kami/sop-k3', 'Standar SOP K3 & Higienitas Teknisi'],
            ['/tentang-kami/peralatan', 'Peralatan & Teknologi Mesin Pipa Modern'],
            ['/tentang-kami/portofolio', 'Klien & Portofolio Proyek B2B'],
            ['/tentang-kami/garansi', 'Ketentuan Resmi Garansi 30 Hari Kalender'],
            ['/tentang-kami/faq', 'Tanya Jawab (FAQ) Pelancaran Pipa'],
            ['/area', 'Wilayah Jangkauan Teknisi Pipa Mampet'],
            ['/area/provinsi/banten', 'Jasa Saluran Mampet Banten'],
            ['/area/tangerang-selatan', 'Jasa Pipa Mampet Tangerang Selatan'],
            ['/area/tangerang-selatan/serpong', 'Jasa Saluran Mampet Serpong, Tangerang Selatan'],
            ['/galeri', 'Dokumentasi Hasil Pengerjaan Pipa Mampet'],
            ['/pengetahuan', 'Panduan & Edukasi Perawatan Saluran Pipa'],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('legacyTitles')]
    public function test_cms_titles_strip_only_legacy_brand_suffixes(string $rawTitle, string $expected): void
    {
        \App\Models\Article::create([
            'title' => 'Panduan', 'slug' => 'panduan', 'meta_title' => $rawTitle,
            'content' => 'Pipa', 'is_published' => true,
        ]);
        \App\Models\CoverageArea::create([
            'city' => 'Tangerang Selatan', 'district' => 'Serpong', 'slug' => 'serpong',
            'meta_title' => $rawTitle, 'is_active' => true,
        ]);
        foreach (['/artikel/panduan', '/area/tangerang-selatan/serpong'] as $path) {
            $page = $this->page($path);
            $titles = $page->query('//head/title | //meta[@property="og:title"] | //meta[@name="twitter:title"]');
            $this->assertCount(3, $titles);
            foreach ($titles as $node) {
                $this->assertSame($expected.' | Drainusantara', $node->nodeName === 'title' ? $node->textContent : $node->getAttribute('content'), $path);
            }
        }
    }

    public static function legacyTitles(): array
    {
        return [
            ['Panduan - Drainusantara', 'Panduan'],
            ['Panduan | Drainusantara', 'Panduan'],
            ['Panduan - Drainusantara Bergaransi', 'Panduan'],
            ['Panduan - Drainusantara | Drainusantara', 'Panduan'],
            ['Panduan - Drainusantara untuk Rumah', 'Panduan - Drainusantara untuk Rumah'],
        ];
    }

    private function page(string $path): \DOMXPath
    {
        foreach (['seotools.json-ld-multi', 'seotools.metatags', 'seotools.opengraph', 'seotools.twitter'] as $service) {
            app()->forgetInstance($service);
            Facade::clearResolvedInstance($service);
        }
        $dom = new \DOMDocument;
        @$dom->loadHTML($this->get($path)->assertOk()->getContent());

        return new \DOMXPath($dom);
    }

    private function durationAnswer(\DOMXPath $page, string $section): string
    {
        $answers = $page->query('//section[@id="'.$section.'"]//button[contains(., "Berapa lama")]/following-sibling::div[1]');
        $this->assertCount(1, $answers);

        return preg_replace('/\s+/u', ' ', trim($answers->item(0)->textContent));
    }
}
