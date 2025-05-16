<?php

namespace Tests\Integration\Http\Admins;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\Integration\AbstractIntegrationTestCase as TestCase;

final class AdminsIndexSearchRouteTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;

    public function testSearchAdminsByEmail(): void
    {
        $user = User::factory()->superAdmin()->create();
        $admins = User::factory()->admin()->search()->count(5)->create();

        foreach ($admins as $admin) {
            $this
                ->actingAs($user)
                ->json('GET', "admins?q={$admin->email}")
                ->assertOk()
                ->assertAdminSchemaCollection(new Collection([$admin]));
        }
    }

    public function testSearchAdminsByUsername(): void
    {
        $user = User::factory()->superAdmin()->create();
        $admins = User::factory()->admin()->search()->count(5)->create();

        foreach ($admins as $admin) {
            $this
                ->actingAs($user)
                ->json('GET', "admins?q={$admin->username}")
                ->assertOk()
                ->assertAdminSchemaCollection(new Collection([$admin]));
        }
    }
}
