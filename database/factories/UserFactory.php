<?php

namespace Database\Factories;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;

final class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'role' => $this->faker->randomElement(UserRole::cases()),
            'email' => $this->faker->unique()->safeEmail(),
            'username' => $this->faker->userName(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'has_accepted_terms' => true,
        ];
    }

    public function role(UserRole $role): static
    {
        return $this->state(['role' => $role]);
    }

    public function admin(): static
    {
        return $this->role(UserRole::ADMIN);
    }

    public function superAdmin(): static
    {
        return $this->role(UserRole::SUPER_ADMIN);
    }

    public function search(): static
    {
        return $this->state(fn () => [
            'email' => $this->faker->unique()->uuid(),
            'username' => $this->faker->unique()->uuid(),
        ]);
    }

    public function escaped(): static
    {
        return $this->state(fn () => [
            'email' => $this->faker->unique()->slug(),
            'username' => $this->faker->slug(),
        ]);
    }

    public function withoutPassword(): static
    {
        return $this->state([
            'password' => null,
        ]);
    }

    public function hasAcceptedTerms(bool $status = true): static
    {
        return $this->state(['has_accepted_terms' => $status]);
    }
}
