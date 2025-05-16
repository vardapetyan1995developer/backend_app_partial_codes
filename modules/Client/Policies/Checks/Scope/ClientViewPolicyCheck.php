<?php

namespace Modules\Client\Policies\Checks\Scope;

use App\Models\Client;
use Illuminate\Auth\Access\Response;
use Infrastructure\Auth\Policies\AbstractPolicyCheck;

final class ClientViewPolicyCheck extends AbstractPolicyCheck
{
    public function __construct(
        private Client $client,
        private int $clientId,
    ) {
        //
    }

    public function execute(): Response | bool
    {
        return $this->scope($this->client->id === $this->clientId);
    }
}
