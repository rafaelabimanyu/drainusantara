<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BreadcrumbSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_static_public_pages_emit_breadcrumb_schema_matching_navigation(): void
    {
        $pages = [
            'area.index' => [['Beranda', url('/')], ['Area Layanan', route('area.index')]],
            'gallery' => [['Beranda', url('/')], ['Galeri', route('gallery')]],
            'articles.index' => [['Beranda', url('/')], ['Pengetahuan & Edukasi', route('articles.index')]],
            'about.profile' => [['Beranda', url('/')], ['Tentang Kami', route('about')], ['Profil Perusahaan', route('about.profile')]],
            'about.holding' => [['Beranda', url('/')], ['Tentang Kami', route('about')], ['Struktur Holding', route('about.holding')]],
            'about.k3' => [['Beranda', url('/')], ['Tentang Kami', route('about')], ['SOP K3', route('about.k3')]],
            'about.equipment' => [['Beranda', url('/')], ['Tentang Kami', route('about')], ['Peralatan & Teknologi', route('about.equipment')]],
            'about.portfolio' => [['Beranda', url('/')], ['Tentang Kami', route('about')], ['Klien & Portofolio', route('about.portfolio')]],
            'about.warranty' => [['Beranda', url('/')], ['Tentang Kami', route('about')], ['Ketentuan Garansi', route('about.warranty')]],
            'about.faq' => [['Beranda', url('/')], ['Tentang Kami', route('about')], ['FAQ', route('about.faq')]],
        ];

        foreach ($pages as $route => $expected) {
            app()->forgetInstance('seotools.json-ld-multi');
            \Illuminate\Support\Facades\Facade::clearResolvedInstance('seotools.json-ld-multi');
            $response = $this->get(route($route));
            $response->assertOk();
            preg_match_all('~<script type="application/ld\\+json"[^>]*>(.*?)</script>~s', $response->getContent(), $scripts);
            $schemas = array_merge(...array_map(static function (string $script): array {
                $schema = json_decode($script, true, 512, JSON_THROW_ON_ERROR);
                return isset($schema['@graph']) ? $schema['@graph'] : (array_is_list($schema) ? $schema : [$schema]);
            }, $scripts[1]));
            $breadcrumbs = array_values(array_filter($schemas, static fn (array $schema): bool => ($schema['@type'] ?? null) === 'BreadcrumbList'));
            $this->assertCount(1, $breadcrumbs, $route);
            $this->assertSame(array_map(static fn (array $entry, int $index): array => [
                '@type' => 'ListItem', 'position' => $index + 1, 'name' => $entry[0], 'item' => $entry[1],
            ], $expected, array_keys($expected)), $breadcrumbs[0]['itemListElement'], $route);
        }
    }
}
