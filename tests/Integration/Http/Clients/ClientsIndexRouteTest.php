<?php

namespace Tests\Integration\Http\Clients;

use App\Models\User;
use App\Models\Client;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Integration\AbstractIntegrationTestCase as TestCase;

final class ClientsIndexRouteTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;

    public function testUnauthenticated(): void
    {
        $this
            ->json('GET', 'clients')
            ->assertUnauthorized();
    }

    public function testClientRequestsClients(): void
    {
        $client = Client::factory()->create();

        $this
            ->actingAs($client->user)
            ->json('GET', 'clients')
            ->assertStatus(403);
    }

    public function testSuperAdminRequestsClients(): void
    {
        $clients = Client::factory()->times(3)->create();

        $user = User::factory()
            ->superAdmin()
            ->create();

        $this
            ->actingAs($user)
            ->json('GET', 'clients')
            ->assertOk()
            ->assertClientSchemaCollection($clients);
    }
}
