<?php

namespace Tests\Integration\Http\Clients;

use App\Models\User;
use App\Models\Client;
use App\Enums\UserRole;
use App\Rules\PasswordRule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Integration\AbstractIntegrationTestCase as TestCase;

final class ClientsCreateRouteTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;

    private function assertClientCreated(array $request, TestResponse $response): void
    {
        $this->assertDatabaseHas('clients', [
            'id' => $response['id'],
            'company_name' => $request['companyName'],
            'phone_number' => $request['phoneNumber'],
            'kvk_number' => $request['kvkNumber'],
            'btw_number' => $request['btwNumber'],
            'btw_percent' => $request['btwPercent'],
            'invoice_email' => $request['invoiceEmail'],
            'invoice_for_attention' => $request['invoiceForAttention'],
            'details' => $request['details'],
            'billing_street' => $request['billing']['street'],
            'billing_house_number' => $request['billing']['houseNumber'],
            'billing_addition' => $request['billing']['addition'],
            'billing_postcode' => $request['billing']['postcode'],
            'billing_city' => $request['billing']['city'],
            'billing_country' => $request['billing']['country'],
        ]);

        $client = Client::findOrFail($response['id']);

        $this->assertDatabaseHas('users', [
            'id' => $client->user_id,
            'email' => $request['email'],
            'has_accepted_terms' => false,
        ]);

        $this->assertTrue(Hash::check($request['password'], $client->user->password));
    }

    private function generateRequest(array $base = []): array
    {
        return array_merge([
            'companyName' => $this->faker->company(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $password = $this->faker->regexify(PasswordRule::PATTERN),
            'password_confirmation' => $password,
            'phoneNumber' => $this->faker->validPhoneNumber(),
            'kvkNumber' => (string) $this->faker->randomDigitNotNull(),
            'btwNumber' => (string) $this->faker->randomDigitNotNull(),
            'btwPercent' => $this->faker->numberBetween(10, 50),
            'invoiceEmail' => $this->faker->email(),
            'invoiceForAttention' => $this->faker->text(),
            'details' => $this->faker->text(),
            'billing' => [
                'street' => $this->faker->streetAddress(),
                'houseNumber' => $this->faker->address(),
                'addition' => $this->faker->text(),
                'postcode' => $this->faker->postcode(),
                'city' => $this->faker->city(),
                'country' => $this->faker->country(),
            ],
        ], $base);
    }

    public function testUnauthenticated(): void
    {
        $this
            ->json('POST', 'clients', $this->generateRequest())
            ->assertUnauthorized();
    }

    public function testNonSuperAdminCreatesClient(): void
    {
        $user = User::factory()->role(UserRole::CLIENT)->create();

        $this
            ->actingAs($user)
            ->json('POST', 'clients', $this->generateRequest())
            ->assertStatus(403);

        $this->assertDatabaseCount('clients', 0);
    }

    public function testSuperAdminCreatesClient(): void
    {
        $user = User::factory()->superAdmin()->create();

        $response = $this
            ->actingAs($user)
            ->json('POST', 'clients', $request = $this->generateRequest())
            ->assertCreated();

        $this->assertDatabaseCount('clients', 1);
        $this->assertClientCreated($request, $response);
    }
}
