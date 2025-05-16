<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

final class SuperAdminSeed extends Seeder
{
    public function run(): void
    {
        DB::transaction(static function (): void {
            User::create([
                'role' => UserRole::SUPER_ADMIN,
                'email' => env('SUPER_ADMIN_INITIAL_EMAIL'),
                'password' => Hash::make(env('SUPER_ADMIN_INITIAL_PASSWORD')),
                'has_accepted_terms' => true,
            ]);
        });
    }
}
