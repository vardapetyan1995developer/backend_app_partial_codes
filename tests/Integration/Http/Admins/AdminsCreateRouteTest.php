<?php

namespace Tests\Integration\Http\Admins;

use App\Models\User;
use App\Rules\PasswordRule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Integration\AbstractIntegrationTestCase as TestCase;

final class AdminsCreateRouteTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;

    private function assertAdminCreated(array $request, TestResponse $response): void
    {
        $this->assertDatabaseHas('users', [
            'id' => $response['id'],
            'email' => $request['email'],
            'username' => $request['username'],
            'has_accepted_terms' => false,
        ]);

        $this->assertTrue(Hash::check($request['password'], User::findOrFail($response['id'])->password));
    }

    private function generateRequest(array $base = []): array
    {
        return array_merge([
            'email' => $this->faker->unique()->safeEmail(),
            'username' => $this->faker->userName(),
            'password' => $password = $this->faker->regexify(PasswordRule::PATTERN),
            'password_confirmation' => $password,
        ], $base);
    }

    public function testUnauthenticated(): void
    {
        $this
            ->json('POST', 'admins', $this->generateRequest())
            ->assertUnauthorized();
    }

    public function testAdminCreatesAdmin(): void
    {
        $user = User::factory()->admin()->create();

        $this
            ->actingAs($user)
            ->json('POST', 'admins', $this->generateRequest())
            ->assertStatus(403);

        $this->assertDatabaseCount('users', 1);
    }

    public function testSuperAdminCreatesAdmin(): void
    {
        $admin = User::factory()->superAdmin()->create();

        $response = $this
            ->actingAs($admin)
            ->json('POST', 'admins', $request = $this->generateRequest())
            ->assertCreated();

        $this->assertDatabaseCount('users', 2);
        $this->assertAdminCreated($request, $response);
    }
}
