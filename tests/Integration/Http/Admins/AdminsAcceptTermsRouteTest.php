<?php

namespace Tests\Integration\Http\Admins;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Integration\AbstractIntegrationTestCase as TestCase;

final class AdminsAcceptTermsRouteTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;

    private function assertAdminTermsAccepted(User $admin): void
    {
        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'has_accepted_terms' => true,
        ]);
    }

    public function testUnauthenticated(): void
    {
        $admin = User::factory()->admin()->hasAcceptedTerms(false)->create();

        $this
            ->json('POST', "admins/{$admin->id}/acceptTerms")
            ->assertUnauthorized();
    }

    public function testAdminAcceptsForeignAdminTerms(): void
    {
        $admin = User::factory()->admin()->hasAcceptedTerms(false)->create();
        $otherAdmin = User::factory()->admin()->hasAcceptedTerms(false)->create();

        $this
            ->actingAs($admin)
            ->json('POST', "admins/{$otherAdmin->id}/acceptTerms")
            ->assertForbidden();
    }

    public function testAdminAcceptsAlreadyAcceptedTerms(): void
    {
        $admin = User::factory()->admin()->create();

        $this
            ->actingAs($admin)
            ->json('POST', "admins/{$admin->id}/acceptTerms")
            ->assertForbidden();
    }

    public function testAdminAcceptsTerms(): void
    {
        $admin = User::factory()->admin()->hasAcceptedTerms(false)->create();

        $this
            ->actingAs($admin)
            ->json('POST', "admins/{$admin->id}/acceptTerms")
            ->assertOk();

        $this->assertAdminTermsAccepted($admin);
    }

    public function testSuperAdminAcceptsAdminTerms(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();
        $admin = User::factory()->admin()->hasAcceptedTerms(false)->create();

        $this
            ->actingAs($superAdmin)
            ->json('POST', "admins/{$admin->id}/acceptTerms")
            ->assertOk();

        $this->assertAdminTermsAccepted($admin);
    }
}
