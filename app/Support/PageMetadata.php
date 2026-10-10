<?php

namespace App\Support;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;

final class PageMetadata
{
    public static function cleanTitle(string $title): string
    {
        $brand = preg_quote(config('seotools.meta.defaults.title'), '/');

        return trim(preg_replace('/(?:\s*[-|]\s*'.$brand.'(?: Bergaransi)?)+\s*$/i', '', $title));
    }

    public static function title(string $title): void
    {
        SEOMeta::setTitle(self::cleanTitle($title));
        OpenGraph::setTitle(SEOMeta::getTitle());
        TwitterCard::setTitle(SEOMeta::getTitle());
    }
}
