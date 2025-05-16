<?php

namespace Modules\Admin\Policies;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Auth\Access\Response;
use Infrastructure\Auth\Policies\AbstractPolicy;
use App\Policies\Checks\AdministrationPolicyCheck;
use App\Policies\Checks\HasNotAcceptedTermsPolicyCheck;
use Modules\Admin\Policies\Checks\Scope\AdminAcceptTermsPolicyCheck;

final class AdminPolicy extends AbstractPolicy
{
    public function terms(User $user, int $adminId): Response | bool
    {
        if ($user->hasRole(UserRole::ADMIN)) {
            return $this->check(
                new AdminAcceptTermsPolicyCheck($user, $adminId),
                new HasNotAcceptedTermsPolicyCheck($user),
            );
        }

        return $this->check(new AdministrationPolicyCheck($user));
    }
}
