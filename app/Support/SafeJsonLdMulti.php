<?php

declare(strict_types=1);

namespace App\Support;

use Artesaos\SEOTools\JsonLd;
use Artesaos\SEOTools\JsonLdMulti;

final class SafeJsonLdMulti extends JsonLdMulti
{
    /**
     * Create a new JsonLd group.
     * When $clean is true (default for any subsequent schema after index 0),
     * initialize with an empty array so BreadcrumbList, Service, WebSite, etc.
     * do NOT inherit default title, description, image, and type.
     */
    public function newJsonLd($clean = true)
    {
        $this->index = count($this->list);
        $defaults = ($clean && count($this->list) > 0) ? [] : $this->defaultJsonLdData;
        $this->list[] = new JsonLd($defaults);

        return $this;
    }

    /**
     * Convenience method to explicitly create a clean schema block.
     */
    public function newCleanJsonLd()
    {
        return $this->newJsonLd(true);
    }

    /**
     * Generate HTML output with clean Schema.org specifications.
     */
    public function generate($minify = false)
    {
        $html = '';
        foreach ($this->list as $schema) {
            if (! $schema->isEmpty()) {
                $raw = $schema->convertToArray();

                // Clean BreadcrumbList from inherited defaults
                if (($raw['@type'] ?? '') === 'BreadcrumbList') {
                    unset($raw['name'], $raw['description'], $raw['image']);
                }

                $data = array_merge(['@context' => 'https://schema.org'], $raw);

                $html .= '<script type="application/ld+json">'.json_encode(
                    $data,
                    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR,
                ).'</script>'.PHP_EOL;
            }
        }

        return $html;
    }
}
