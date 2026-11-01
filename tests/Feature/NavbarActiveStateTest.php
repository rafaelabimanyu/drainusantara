<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NavbarActiveStateTest extends TestCase
{
    use RefreshDatabase;
    public function test_desktop_navbar_renders_beranda_active_on_home_by_default(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        // Check Beranda active class rendered server-side
        $response->assertSee('text-sky-400 font-bold bg-slate-800/90 border-slate-700/80', false);
        $response->assertSee('activeSection === \'home\'', false);
        $response->assertSee('activeSection === \'layanan\'', false);
        $response->assertSee('activeSection === \'area\'', false);
    }

    public function test_desktop_navbar_renders_area_active_on_area_pages(): void
    {
        $response = $this->get(route('area.city', ['city' => 'bogor']));
        $response->assertOk();

        // On area page, Area Jangkauan button should be active via SSR
        $content = $response->getContent();
        $this->assertStringContainsString('Area Jangkauan', $content);
        $this->assertMatchesRegularExpression(
            '/<button[^>]*class="[^"]*text-sky-400 font-bold bg-slate-800\/90[^"]*"[^>]*>[\s\S]*?Area Jangkauan/m',
            $content
        );
    }

    public function test_desktop_navbar_renders_tentang_kami_active_on_tentang_kami_pages(): void
    {
        $response = $this->get(route('about.profile'));
        $response->assertOk();

        $content = $response->getContent();
        $this->assertMatchesRegularExpression(
            '/<button[^>]*class="[^"]*text-sky-400 font-bold bg-slate-800\/90[^"]*"[^>]*>[\s\S]*?Tentang kami/m',
            $content
        );
    }

    public function test_desktop_navbar_renders_tentang_kami_active_on_cara_kerja_page(): void
    {
        $response = $this->get(route('how-it-works'));
        $response->assertOk();

        $content = $response->getContent();
        $this->assertMatchesRegularExpression(
            '/<button[^>]*class="[^"]*text-sky-400 font-bold bg-slate-800\/90[^"]*"[^>]*>[\s\S]*?Tentang kami/m',
            $content
        );
    }

    public function test_desktop_navbar_renders_hasil_kerja_active_on_gallery_page(): void
    {
        $response = $this->get(route('gallery'));
        $response->assertOk();

        $content = $response->getContent();
        $this->assertMatchesRegularExpression(
            '/<a[^>]*class="[^"]*text-sky-400 font-bold bg-slate-800\/90[^"]*"[^>]*>[\s\S]*?Hasil Kerja/m',
            $content
        );
    }

    public function test_desktop_navbar_renders_blog_active_on_articles_page(): void
    {
        $response = $this->get(route('articles.index'));
        $response->assertOk();

        $content = $response->getContent();
        $this->assertMatchesRegularExpression(
            '/<a[^>]*class="[^"]*text-sky-400 font-bold bg-slate-800\/90[^"]*"[^>]*>[\s\S]*?Blog/m',
            $content
        );
    }

    public function test_mobile_dock_has_active_state_bindings_for_layanan_and_area(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        $content = $response->getContent();
        $this->assertStringContainsString('activeSection === \'layanan\'', $content);
        $this->assertStringContainsString('activeSection === \'area\'', $content);
    }
}
