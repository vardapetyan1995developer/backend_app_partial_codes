<?php

namespace Tests\Integration\Http\Admins;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Integration\AbstractIntegrationTestCase as TestCase;

final class AdminsUpdateRouteTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;

    private function assertAdminUpdated(int $adminId, array $request): void
    {
        $this->assertDatabaseHas('users', [
            'id' => $adminId,
            'username' => $request['username'],
        ]);
    }

    private function generateRequest(array $base = []): array
    {
        return array_merge([
            'username' => $this->faker->userName(),
        ], $base);
    }

    public function testUnauthenticated(): void
    {
        $admin = User::factory()->admin()->create();

        $this
            ->json('PUT', "admins/{$admin->id}", $this->generateRequest())
            ->assertUnauthorized();
    }

    public function testNonSuperAdminCreatesAdmin(): void
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->role(UserRole::CLIENT)->create();

        $this
            ->actingAs($user)
            ->json('PUT', "admins/{$admin->id}", $this->generateRequest())
            ->assertStatus(403);
    }

    public function testSuperAdminUpdatesAdmin(): void
    {
        $user = User::factory()->superAdmin()->create();
        $admin = User::factory()->admin()->create();

        $this
            ->actingAs($user)
            ->json('PUT', "admins/{$admin->id}", $request = $this->generateRequest())
            ->assertOk();

        $this->assertDatabaseCount('users', 2);
        $this->assertAdminUpdated($admin->id, $request);
    }
}
