<?php

namespace Tests\Feature;

use App\Http\Middleware\CompressResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CompressResponseTest extends TestCase
{
    public static function encodings(): array
    {
        return [
            'refused' => ['gzip;q=0', false],
            'refused with wildcard' => ['gzip;q=0, *;q=1', false],
            'allowed' => ['gzip', true],
            'weighted' => ['br, gzip;q=0.5', true],
            'case insensitive' => ['GZip;Q=0.5', true],
            'wildcard' => ['*;q=0.5', true],
            'wildcard refused' => ['*;q=0', false],
            'identity preferred' => ['gzip;q=0.5, identity;q=1', false],
            'unrelated token' => ['notgzip', false],
            'missing' => [null, false],
            'empty' => ['', false],
        ];
    }

    #[DataProvider('encodings')]
    public function test_encoding_negotiation_and_cache_variants(?string $encoding, bool $compressed): void
    {
        $request = Request::create('/');
        if ($encoding !== null) {
            $request->headers->set('Accept-Encoding', $encoding);
        }
        $body = str_repeat('Drainusantara ', 200);
        $response = (new CompressResponse)->handle($request, fn () => new Response($body, 200, [
            'Content-Type' => 'text/html', 'Vary' => 'Origin',
        ]));

        $this->assertSame($compressed ? 'gzip' : null, $response->headers->get('Content-Encoding'));
        $this->assertSame($body, $compressed ? gzdecode($response->getContent()) : $response->getContent());
        $this->assertContains('Accept-Encoding', $response->getVary());
        $this->assertContains('Origin', $response->getVary());
        if ($compressed) {
            $this->assertSame((string) strlen($response->getContent()), $response->headers->get('Content-Length'));
        }
    }

    public function test_does_not_recompress_encoded_responses(): void
    {
        $request = Request::create('/');
        $request->headers->set('Accept-Encoding', 'gzip');
        $body = str_repeat('existing encoded body', 200);
        $response = (new CompressResponse)->handle($request, fn () => new Response($body, 200, [
            'Content-Type' => 'text/html', 'Content-Encoding' => 'br',
        ]));
        $this->assertSame('br', $response->headers->get('Content-Encoding'));
        $this->assertSame($body, $response->getContent());
    }
}
