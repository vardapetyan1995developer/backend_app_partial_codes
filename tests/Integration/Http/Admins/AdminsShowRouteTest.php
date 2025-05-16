<?php

namespace Tests\Integration\Http\Admins;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Integration\AbstractIntegrationTestCase as TestCase;

final class AdminsShowRouteTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;

    public function testUnauthenticated(): void
    {
        $admin = User::factory()->admin()->create();

        $this
            ->json('GET', "admins/{$admin->id}")
            ->assertUnauthorized();
    }

    public function testNonSuperAdminRequestsAdmin(): void
    {
        $admin = User::factory()->admin()->create();

        $this
            ->actingAs($admin)
            ->json('GET', "admins/{$admin->id}")
            ->assertStatus(403);
    }

    public function testSuperAdminNotFound(): void
    {
        $user = User::factory()->superAdmin()->create();

        $this
            ->actingAs($user)
            ->json('GET', 'admins/' . ($user->id + 1))
            ->assertNotFound();
    }

    public function testSuperAdminRequestsAdmin(): void
    {
        $user = User::factory()->superAdmin()->create();
        $admin = User::factory()->admin()->create();

        $this
            ->actingAs($user)
            ->json('GET', "admins/{$admin->id}")
            ->assertOk()
            ->assertAdminSchema($admin);
    }
}
