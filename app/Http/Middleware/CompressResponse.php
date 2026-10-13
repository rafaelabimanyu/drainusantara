<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Symfony\Component\HttpFoundation\Response;

class CompressResponse
{
    /**
     * Handle an incoming request and compress response with Gzip if supported.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (!extension_loaded('zlib') || !($response instanceof \Illuminate\Http\Response)) {
            return $response;
        }

        // Avoid re-compressing or compressing binary/streamed responses
        if ($response->headers->has('Content-Encoding')) {
            return $response;
        }

        $contentType = $response->headers->get('Content-Type', '');
        $compressibleTypes = [
            'text/html',
            'text/css',
            'text/plain',
            'text/xml',
            'application/javascript',
            'application/json',
            'application/xml',
            'image/svg+xml',
        ];

        $shouldCompress = false;
        foreach ($compressibleTypes as $type) {
            if (str_starts_with($contentType, $type)) {
                $shouldCompress = true;
                break;
            }
        }

        if (!$shouldCompress) {
            return $response;
        }

        $content = $response->getContent();
        if ($content === false || strlen($content) < 1024) {
            return $response;
        }

        $response->setVary('Accept-Encoding', false);
        $encodings = AcceptHeader::fromString(strtolower((string) $request->header('Accept-Encoding')));
        $gzipQuality = $encodings->get('gzip')?->getQuality() ?? 0;
        $identityQuality = $encodings->has('identity') ? $encodings->get('identity')->getQuality() : 0;
        if ($gzipQuality <= 0 || $identityQuality > $gzipQuality) {
            return $response;
        }

        $compressed = gzencode($content, 5);
        if ($compressed !== false && strlen($compressed) < strlen($content)) {
            $response->setContent($compressed);
            $response->headers->set('Content-Encoding', 'gzip');
            $response->headers->set('Content-Length', (string) strlen($compressed));
        }

        return $response;
    }
}
