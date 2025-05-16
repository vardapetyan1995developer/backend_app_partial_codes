<?php

namespace Modules\Client\Policies;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Auth\Access\Response;
use Modules\Client\Dto\QueryClientDto;
use Modules\Client\Dto\CreateClientDto;
use Modules\Client\Dto\UpdateClientDto;
use Modules\Client\Dto\UpdateClientPasswordDto;
use Infrastructure\Auth\Policies\AbstractPolicy;
use App\Policies\Checks\AdministrationPolicyCheck;
use App\Policies\Checks\HasNotAcceptedTermsPolicyCheck;
use Modules\Client\Policies\Checks\Scope\ClientViewPolicyCheck;
use Modules\Client\Policies\Checks\Scope\ClientAcceptTermsPolicyCheck;

final class ClientPolicy extends AbstractPolicy
{
    public function query(User $user, QueryClientDto $request): Response | bool
    {
        return $this->check(new AdministrationPolicyCheck($user));
    }

    public function view(User $user, int $clientId): Response | bool
    {
        if ($user->hasRole(UserRole::CLIENT)) {
            return $this->check(new ClientViewPolicyCheck($user->client, $clientId));
        }

        return $this->check(new AdministrationPolicyCheck($user));
    }

    public function create(User $user, CreateClientDto $request): Response | bool
    {
        return $this->check(new AdministrationPolicyCheck($user));
    }

    public function update(User $user, int $clientId, UpdateClientDto $request): Response | bool
    {
        return $this->check(new AdministrationPolicyCheck($user));
    }

    public function updatePassword(User $user, int $clientId, UpdateClientPasswordDto $request): Response | bool
    {
        return $this->check(new AdministrationPolicyCheck($user));
    }

    public function terms(User $user, int $clientId): Response | bool
    {
        if ($user->hasRole(UserRole::CLIENT)) {
            return $this->check(
                new ClientAcceptTermsPolicyCheck($user->client, $clientId),
                new HasNotAcceptedTermsPolicyCheck($user),
            );
        }

        return $this->check(new AdministrationPolicyCheck($user));
    }

    public function delete(User $user, int $clientId): Response | bool
    {
        return $this->check(new AdministrationPolicyCheck($user));
    }
}
