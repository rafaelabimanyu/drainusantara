<?php

namespace Tests\Feature;

use Tests\TestCase;

class CarouselStyleTest extends TestCase
{
    public function test_narrow_carousels_snap_to_reachable_inset(): void
    {
        $css = file_get_contents(resource_path('css/app.css'));
        $this->assertStringContainsString('@media (max-width: 359px)', $css);
        $this->assertStringContainsString('scroll-snap-align: start', $css);
        $this->assertStringContainsString('scroll-padding-inline: 1rem', $css);
        $this->assertStringContainsString('scroll-padding-inline: 0.25rem', $css);

        foreach (glob(resource_path('views/{about,areas,components}'), GLOB_BRACE) as $directory) {
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));
            foreach ($files as $file) {
                if (! str_ends_with($file->getFilename(), '.blade.php')) continue;
                preg_match_all('/class="([^"]*\bsnap-x\b[^"]*)"/', file_get_contents($file->getPathname()), $matches);
                foreach ($matches[1] as $classes) {
                    $this->assertMatchesRegularExpression('/(?:^| )px-(?:1|4)(?: |$)/', $classes, $file->getPathname());
                }
            }
        }
    }

    public function test_footer_panels_use_compact_radius(): void
    {
        $footer = file_get_contents(resource_path('views/components/layout/footer.blade.php'));
        $this->assertStringNotContainsString('rounded-xl', $footer);
        $this->assertStringNotContainsString('rounded-xl', file_get_contents(resource_path('views/auth/login.blade.php')));
    }
}
