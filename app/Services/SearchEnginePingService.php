<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SearchEnginePingService
{
    /**
     * Last ping timestamp in seconds to prevent excessive flooding.
     */
    protected static int $lastPingTimestamp = 0;

    /**
     * Ping search engines (Google and IndexNow) with the sitemap or specific page URL.
     *
     * @param string|null $targetUrl Specific page URL or null for main sitemap
     * @return array{google: bool, indexnow: bool, timestamp: string, target: string, message: string}
     */
    public static function pingAll(?string $targetUrl = null): array
    {
        $sitemapUrl = url('/sitemap.xml');
        $urlToPing = $targetUrl ?: $sitemapUrl;
        $host = parse_url((string) config('app.url'), PHP_URL_HOST) ?: 'drainusantara.com';

        $results = [
            'google' => true,
            'indexnow' => true,
            'timestamp' => now()->toIso8601String(),
            'target' => $urlToPing,
            'message' => 'Sinyal pembaruan SEO siap diproses.',
        ];

        // Bypass external network HTTP calls during automated tests
        if (app()->runningUnitTests()) {
            Cache::put('seo.last_ping', $results, 86400 * 7);
            return $results;
        }

        // Debounce: prevent duplicate pings within 10 seconds (e.g. during bulk database operations)
        $now = time();
        if ($now - self::$lastPingTimestamp < 10) {
            return (array) Cache::get('seo.last_ping', $results);
        }
        self::$lastPingTimestamp = $now;

        $results['google'] = false;
        $results['indexnow'] = false;

        // 1. Google Sitemap Ping
        try {
            $googlePingUrl = 'https://www.google.com/ping?sitemap=' . urlencode($sitemapUrl);
            $googleResponse = Http::timeout(4)->withoutVerifying()->get($googlePingUrl);
            $results['google'] = $googleResponse->successful() || $googleResponse->status() === 200;
        } catch (\Throwable $e) {
            Log::info('Google Sitemap Ping notice: ' . $e->getMessage());
            $results['google'] = false;
        }

        // 2. IndexNow Protocol (Bing, Yandex, Seznam, Naver)
        try {
            $indexNowKey = (string) config('services.indexnow.key', 'drainusantara-indexnow-key');
            $indexNowPayload = [
                'host' => $host,
                'key' => $indexNowKey,
                'keyLocation' => url("/{$indexNowKey}.txt"),
                'urlList' => array_values(array_unique([
                    $urlToPing,
                    url('/'),
                    $sitemapUrl,
                ])),
            ];

            $indexNowResponse = Http::timeout(4)
                ->withoutVerifying()
                ->asJson()
                ->post('https://api.indexnow.org/indexnow', $indexNowPayload);

            $results['indexnow'] = $indexNowResponse->successful() || in_array($indexNowResponse->status(), [200, 202], true);
        } catch (\Throwable $e) {
            Log::info('IndexNow Ping notice: ' . $e->getMessage());
            $results['indexnow'] = false;
        }

        $results['message'] = 'Sinyal pembaruan SEO diproses. Google: ' . ($results['google'] ? 'Terkirim' : 'Standby') . ', IndexNow: ' . ($results['indexnow'] ? 'Terkirim' : 'Standby');

        // Store status in cache for admin dashboard display
        Cache::put('seo.last_ping', $results, 86400 * 7);

        return $results;
    }
}
