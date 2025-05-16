<?php

namespace Tests\Integration\Http\Clients;

use App\Models\User;
use App\Models\Client;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Integration\AbstractIntegrationTestCase as TestCase;

final class ClientsDeleteRouteTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;

    public function testUnauthenticated(): void
    {
        $client = Client::factory()->create();

        $this
            ->json('DELETE', "clients/{$client->id}")
            ->assertUnauthorized();
    }

    public function testSuperAdminRequestsClientDelete(): void
    {
        $user = User::factory()->superAdmin()->create();
        $client = Client::factory()->create();

        $this
            ->actingAs($user)
            ->json('DELETE', "clients/{$client->id}")
            ->assertOk();

        $this->assertDatabaseCount('clients', 0);
    }
}
