<?php

namespace Tests\Integration\Http\Admins;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Integration\AbstractIntegrationTestCase as TestCase;

final class AdminsDeleteRouteTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;

    public function testUnauthenticated(): void
    {
        $admin = User::factory()->admin()->create();

        $this
            ->json('DELETE', "admins/{$admin->id}")
            ->assertUnauthorized();
    }

    public function testSuperAdminRequestsWorkerDelete(): void
    {
        $user = User::factory()->superAdmin()->create();
        $admin = User::factory()->admin()->create();

        $this
            ->actingAs($user)
            ->json('DELETE', "admins/{$admin->id}")
            ->assertOk();

        $this->assertDatabaseCount('users', 1);
    }
}
