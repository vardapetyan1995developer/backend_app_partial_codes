<?php

namespace Tests\Integration\Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Database\Seeders\SuperAdminSeed;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Integration\AbstractIntegrationTestCase as TestCase;

final class SuperAdminSeedTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testSeedSuperAdmin(): void
    {
        $this->seed(SuperAdminSeed::class);

        $this->assertDatabaseCount('users', 1);

        $this->assertDatabaseHas('users', [
            'role' => UserRole::SUPER_ADMIN->value,
            'email' => env('SUPER_ADMIN_INITIAL_EMAIL'),
            'has_accepted_terms' => true,
        ]);

        $this->assertTrue(Hash::check(env('SUPER_ADMIN_INITIAL_PASSWORD'), User::first()->password));
    }
}
