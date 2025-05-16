<?php

namespace Modules\Admin\Services;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Modules\Admin\Dto\CreateAdminDto;
use Modules\Admin\Dto\UpdateAdminDto;
use Modules\Admin\Dto\UpdateAdminPasswordDto;

final class AdminCommandService
{
    public function create(CreateAdminDto $request): int
    {
        return DB::transaction(static function () use ($request): int {
            $user = User::create([
                'role' => UserRole::ADMIN,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'has_accepted_terms' => false,
            ]);

            Event::dispatch('admin.created', $user->id);

            return $user->id;
        });
    }

    public function update(int $adminId, UpdateAdminDto $request): void
    {
        DB::transaction(static function () use ($adminId, $request): void {
            User::query()
                ->role(UserRole::ADMIN)
                ->findOrFail($adminId)
                ->update([
                    'username' => $request->username,
                ]);

            Event::dispatch('admin.updated', $adminId);
        });
    }

    public function delete(int $adminId): void
    {
        DB::transaction(static function () use ($adminId): void {
            User::role(UserRole::ADMIN)->findOrFail($adminId)->delete();

            Event::dispatch('admin.deleted', $adminId);
        });
    }
}
