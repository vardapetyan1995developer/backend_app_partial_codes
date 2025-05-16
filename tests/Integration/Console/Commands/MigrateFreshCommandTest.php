<?php

namespace Tests\Integration\Console\Commands;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Integration\AbstractIntegrationTestCase as TestCase;

final class MigrateFreshCommandTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testMigrateFresh(): void
    {
        $this
            ->artisan('migrate:fresh')
            ->assertSuccessful();
    }
}
