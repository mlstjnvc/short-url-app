<?php declare(strict_types=1);

namespace Tests\Feature\ShortUrl;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{

    public function testRouteCreateShortUrlExists(): void
    {
        $this->assertTrue(app()->router->getRoutes()->hasNamedRoute('api.v1.short-url.create'));
    }

    public function testRouteGetTokenExists(): void
    {
        $this->assertTrue(app()->router->getRoutes()->hasNamedRoute('api.v1.token.get'));
    }
}
