<?php

namespace Tests\Integration\Http\Admins;

use App\Models\User;
use App\Enums\UserRole;
use App\Rules\PasswordRule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Integration\AbstractIntegrationTestCase as TestCase;

final class AdminsUpdatePasswordRouteTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;

    private function assertAdminPasswordUpdated(int $adminId, array $request): void
    {
        $this->assertTrue(Hash::check($request['password'], User::findOrFail($adminId)->password));
    }

    private function generateRequest(array $base = []): array
    {
        return array_merge([
            'password' => $password = $this->faker->regexify(PasswordRule::PATTERN),
            'password_confirmation' => $password,
        ], $base);
    }

    public function testUnauthenticated(): void
    {
        $admin = User::factory()->admin()->create();

        $this
            ->json('POST', "admins/{$admin->id}/updatePassword", $this->generateRequest())
            ->assertUnauthorized();
    }

    public function testNonSuperUserUpdatesAdminPassword(): void
    {
        $user = User::factory()->role(UserRole::CLIENT)->create();
        $admin = User::factory()->admin()->create();

        $this
            ->actingAs($user)
            ->json('POST', "admins/{$admin->id}/updatePassword", $this->generateRequest())
            ->assertStatus(403);
    }

    public function testSuperAdminUpdatesAdminPassword(): void
    {
        $user = User::factory()->superAdmin()->create();
        $admin = User::factory()->admin()->create();

        $this
            ->actingAs($user)
            ->json('POST', "admins/{$admin->id}/updatePassword", $request = $this->generateRequest())
            ->assertOk();

        $this->assertAdminPasswordUpdated($admin->id, $request);
    }
}
