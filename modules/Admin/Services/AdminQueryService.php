<?php

namespace Modules\Admin\Services;

use App\Models\User;
use App\Enums\UserRole;
use Modules\Admin\Dto\QueryAdminDto;
use Illuminate\Contracts\Pagination\CursorPaginator;

final class AdminQueryService
{
    public function query(QueryAdminDto $query): CursorPaginator
    {
        $builder = User::query()
            ->role(UserRole::ADMIN)
            ->orderBy('id');

        if ($queryString = $query->queryString) {
            $builder->searchable($queryString);
        }

        return $builder
            ->orderBy('users.id')
            ->cursorPaginate();
    }

    public function sole(int $adminId): User
    {
        return User::query()
            ->role(UserRole::ADMIN)
            ->findOrFail($adminId);
    }
}
