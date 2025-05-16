<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

final class EnsureUserHasRole
{
    private function getAuthorizationErrorMessage(array $roles): string
    {
        return trans('messages.http.middleware.ensure_user_has_role', [
            'roles' => implode(', ', $roles),
        ]);
    }

    private function rolesToEnums(array $roles): array
    {
        return array_map(static fn ($r) => UserRole::from($r), $roles);
    }

    public function handle(Request $request, Closure $next, string ...$roles)
    {
        /** @var null|User $user */
        $user = Auth::user();

        if (!$user || !$user->hasRole(...$this->rolesToEnums($roles))) {
            throw new AuthorizationException($this->getAuthorizationErrorMessage($roles));
        }

        return $next($request);
    }
}
