<?php

namespace App\Support;

use Artesaos\SEOTools\JsonLdMulti;

final class SafeJsonLdMulti extends JsonLdMulti
{
    public function generate($minify = false)
    {
        $html = '';
        foreach ($this->list as $schema) {
            if (! $schema->isEmpty()) {
                $data = array_merge(['@context' => 'https://schema.org'], $schema->convertToArray());
                $html .= '<script type="application/ld+json">'.json_encode(
                    $data,
                    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR,
                ).'</script>';
            }
        }

        return $html;
    }
}
