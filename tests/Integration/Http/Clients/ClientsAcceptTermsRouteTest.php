<?php

namespace Tests\Integration\Http\Clients;

use App\Models\User;
use App\Models\Client;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Integration\AbstractIntegrationTestCase as TestCase;

final class ClientsAcceptTermsRouteTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;

    private function assertClientTermsAccepted(Client $client): void
    {
        $this->assertDatabaseHas('users', [
            'id' => $client->user_id,
            'has_accepted_terms' => true,
        ]);
    }

    public function testUnauthenticated(): void
    {
        $client = Client::factory()->hasAcceptedTerms(false)->create();

        $this
            ->json('POST', "clients/{$client->id}/acceptTerms")
            ->assertUnauthorized();
    }

    public function testClientAcceptsForeignClientTerms(): void
    {
        $client = Client::factory()->hasAcceptedTerms(false)->create();
        $otherClient = Client::factory()->hasAcceptedTerms(false)->create();

        $this
            ->actingAs($client->user)
            ->json('POST', "clients/{$otherClient->id}/acceptTerms")
            ->assertForbidden();
    }

    public function testClientAcceptsAlreadyAcceptedTerms(): void
    {
        $client = Client::factory()->create();

        $this
            ->actingAs($client->user)
            ->json('POST', "clients/{$client->id}/acceptTerms")
            ->assertForbidden();
    }

    public function testClientAcceptsTerms(): void
    {
        $client = Client::factory()->hasAcceptedTerms(false)->create();

        $this
            ->actingAs($client->user)
            ->json('POST', "clients/{$client->id}/acceptTerms")
            ->assertOk();

        $this->assertClientTermsAccepted($client);
    }

    public function testAdminAcceptsClientTerms(): void
    {
        $admin = User::factory()->admin()->create();
        $client = Client::factory()->hasAcceptedTerms(false)->create();

        $this
            ->actingAs($admin)
            ->json('POST', "clients/{$client->id}/acceptTerms")
            ->assertOk();

        $this->assertClientTermsAccepted($client);
    }
}
