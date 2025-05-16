<?php

namespace App\Policies\Checks;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Infrastructure\Auth\Policies\AbstractPolicyCheck;

final class HasAcceptedTermsPolicyCheck extends AbstractPolicyCheck
{
    public function __construct(
        private User $user,
    ) {
        //
    }

    public function execute(): Response | bool
    {
        return $this->user->has_accepted_terms;
    }
}
