<?php

declare(strict_types=1);

namespace App\Http\Controllers\Traits;

use Artesaos\SEOTools\Facades\JsonLdMulti;

trait HasPageSeo
{
    /**
     * Add standard About Us breadcrumbs to JSON-LD BreadcrumbList.
     */
    protected function addAboutBreadcrumb(string $name, string $route): void
    {
        $this->addBreadcrumb(['Tentang Kami', route('about')], [$name, route($route)]);
    }

    /**
     * Build and attach a JSON-LD BreadcrumbList schema.
     */
    protected function addBreadcrumb(array ...$entries): void
    {
        $items = [['Beranda', url('/')], ...$entries];
        $breadcrumb = JsonLdMulti::newJsonLd();
        $breadcrumb->setType('BreadcrumbList');
        $breadcrumb->addValues([
            'itemListElement' => array_map(
                static fn (array $entry, int $index): array => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $entry[0],
                    'item' => $entry[1],
                ],
                $items,
                array_keys($items)
            ),
        ]);
    }

    /**
     * Format official hotline phone into E.164 international format for Schema JSON-LD.
     */
    protected function formatInternationalPhone(): string
    {
        $raw = (string) config('app.whatsapp_number', '6285609009009');
        $digits = preg_replace('/[^0-9]/', '', $raw);

        return '+'.($digits !== '' ? $digits : '6285609009009');
    }
}

