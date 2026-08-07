<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Cache;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Tests must not depend on a built Vite manifest.
        $this->withoutVite();

        // Isola o cache entre testes (SiteSetting usa rememberForever).
        Cache::flush();
    }
}
