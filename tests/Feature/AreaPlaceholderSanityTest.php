<?php

namespace Tests\Feature;

use App\Models\CoverageArea;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AreaPlaceholderSanityTest extends TestCase
{
    use RefreshDatabase;

    public function test_city_and_district_render_without_raw_placeholders_or_duplications(): void
    {
        // Create an article for Semarang and an article for Depok to verify smart article filtering
        Article::create([
            'title' => 'Panduan Perawatan Pipa Mampet Khusus Semarang',
            'slug' => 'panduan-perawatan-pipa-mampet-khusus-semarang',
            'content' => 'Edukasi saluran mampet Semarang kawasan pesisir.',
            'category' => 'Edukasi',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Article::create([
            'title' => 'Tips Mengatasi Wastafel Mampet di Kawasan Depok',
            'slug' => 'tips-mengatasi-wastafel-mampet-di-kawasan-depok',
            'content' => 'Edukasi saluran wastafel di area Margonda Depok.',
            'category' => 'Tips',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Article::create([
            'title' => 'Penyebab Utama Pipa Saluran Pembuangan Mampet',
            'slug' => 'penyebab-utama-pipa-saluran-pembuangan-mampet',
            'content' => 'Edukasi umum mengenai lemak dan sisa makanan yang membeku.',
            'category' => 'Edukasi',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $testUrls = [
            '/area/semarang',
            '/area/semarang/banyumanik',
            '/area/jakarta-selatan',
            '/area/jakarta-selatan/tebet',
        ];

        $forbiddenPatterns = [
            '[KOTA]',
            '[kota]',
            '{kota}',
            '[KECAMATAN]',
            '[kecamatan]',
            '{kecamatan}',
            '[PROVINSI]',
            '[provinsi]',
            '{provinsi}',
            'Pelancaran Pelancaran',
        ];

        foreach ($testUrls as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);

            $content = $response->getContent();

            foreach ($forbiddenPatterns as $pattern) {
                if (str_contains($content, $pattern)) {
                    $lines = explode("\n", $content);
                    foreach ($lines as $lineNum => $line) {
                        if (str_contains($line, $pattern)) {
                            fwrite(STDERR, "\nFound '{$pattern}' in {$url} at line {$lineNum}: " . trim($line) . "\n");
                        }
                    }
                }
                $this->assertStringNotContainsString(
                    $pattern,
                    $content,
                    "Failed: URL {$url} contains forbidden placeholder or duplication: {$pattern}"
                );
            }
        }

        // Specific test for /area/semarang
        $responseSemarang = $this->get('/area/semarang');
        $responseSemarang->assertStatus(200);
        $contentSemarang = $responseSemarang->getContent();

        // Must show Semarang article and neutral article, and NOT show Depok article
        $this->assertStringContainsString('panduan-perawatan-pipa-mampet-khusus-semarang', $contentSemarang);
        $this->assertStringContainsString('penyebab-utama-pipa-saluran-pembuangan-mampet', $contentSemarang);
        $this->assertStringNotContainsString('tips-mengatasi-wastafel-mampet-di-kawasan-depok', $contentSemarang);

        // Must contain new profile section with localized title
        $responseSemarang->assertSee('Profil Layanan, Titik Cakupan &amp; Solusi Pipa Mampet di Kota Semarang', false);
        $responseSemarang->assertSee('Hasil Pengerjaan Teknisi di Kota Semarang', false);
        $responseSemarang->assertSee('Daftar Area Layanan di Kota Semarang', false);

        // Specific test for /area/semarang/banyumanik
        $responseBanyumanik = $this->get('/area/semarang/banyumanik');
        $responseBanyumanik->assertStatus(200);
        $contentBanyumanik = $responseBanyumanik->getContent();

        $this->assertStringContainsString('panduan-perawatan-pipa-mampet-khusus-semarang', $contentBanyumanik);
        $this->assertStringNotContainsString('tips-mengatasi-wastafel-mampet-di-kawasan-depok', $contentBanyumanik);

        $responseBanyumanik->assertSee('Profil Layanan, Titik Cakupan &amp; Solusi Pipa Mampet di Banyumanik, Kota Semarang', false);
        $responseBanyumanik->assertSee('Standar Operasional Wilayah Banyumanik, Kota Semarang', false);
        $responseBanyumanik->assertSee('Solusi Pipa untuk Beragam Kategori Bangunan di Banyumanik, Kota Semarang', false);
        $responseBanyumanik->assertSee('Dokumentasi Pengerjaan di Lapangan Banyumanik, Kota Semarang', false);
        $responseBanyumanik->assertSee('Tukang Konvensional vs Standar Drainusantara di Banyumanik, Kota Semarang', false);
        $responseBanyumanik->assertSee('Pertanyaan Seputar Layanan di Banyumanik, Kota Semarang', false);
    }
}
