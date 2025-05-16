<?php

namespace App\Policies\Checks;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Auth\Access\Response;
use Infrastructure\Auth\Policies\AbstractPolicyCheck;

final class AdministrationPolicyCheck extends AbstractPolicyCheck
{
    public function __construct(
        private User $user,
    ) {
        //
    }

    public function execute(): Response | bool
    {
        return $this->role($this->user, UserRole::SUPER_ADMIN, UserRole::ADMIN);
    }
}
