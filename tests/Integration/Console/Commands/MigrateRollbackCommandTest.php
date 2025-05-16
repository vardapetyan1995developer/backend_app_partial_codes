<?php

namespace Tests\Integration\Console\Commands;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Integration\AbstractIntegrationTestCase as TestCase;

final class MigrateRollbackCommandTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testRollbackAndMigrate(): void
    {
        $this
            ->artisan('migrate:rollback')
            ->assertSuccessful();

        $this
            ->artisan('migrate')
            ->assertSuccessful();
    }
}
