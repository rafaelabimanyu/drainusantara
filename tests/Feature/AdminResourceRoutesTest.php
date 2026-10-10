<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminResourceRoutesTest extends TestCase
{
    public static function resources(): array
    {
        return array_map(fn ($resource) => [$resource], [
            'services', 'coverage-areas', 'galleries', 'portfolios',
            'staff', 'equipments', 'articles', 'reviews',
        ]);
    }

    #[DataProvider('resources')]
    public function test_resources_only_register_existing_actions(string $resource): void
    {
        $this->assertFalse(Route::has("admin.{$resource}.show"));

        foreach (['index', 'create', 'store', 'edit', 'update', 'destroy'] as $action) {
            $route = Route::getRoutes()->getByName("admin.{$resource}.{$action}");
            $this->assertNotNull($route);
            $this->assertTrue(method_exists($route->getControllerClass(), $route->getActionMethod()));
        }
    }
}
