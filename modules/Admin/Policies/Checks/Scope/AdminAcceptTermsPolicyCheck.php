<?php

namespace Modules\Admin\Policies\Checks\Scope;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Infrastructure\Auth\Policies\AbstractPolicyCheck;

final class AdminAcceptTermsPolicyCheck extends AbstractPolicyCheck
{
    public function __construct(
        private User $admin,
        private int $adminId,
    ) {
        //
    }

    public function execute(): Response | bool
    {
        return $this->scope($this->admin->id === $this->adminId);
    }
}
