<?php

namespace Tests\Integration\Http\Admins;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Integration\AbstractIntegrationTestCase as TestCase;

final class AdminsIndexRouteTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;

    public function testUnauthenticated(): void
    {
        $this
            ->json('GET', 'admins')
            ->assertUnauthorized();
    }

    public function testNonAdminRequestsAdmins(): void
    {
        $admin = User::factory()->role(UserRole::CLIENT)->create();

        $this
            ->actingAs($admin)
            ->json('GET', 'admins')
            ->assertStatus(403);
    }

    public function testSuperAdminRequestsAdmins(): void
    {
        $user = User::factory()->superAdmin()->create();
        $admins = User::factory()->admin()->count(3)->create();

        $this
            ->actingAs($user)
            ->json('GET', 'admins')
            ->assertOk()
            ->assertAdminSchemaCollection($admins);
    }
}
