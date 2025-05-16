<?php

namespace Modules\Client;

use Modules\Client\Policies\ClientPolicy;
use Infrastructure\Auth\Traits\DefineGates;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
{
    use DefineGates;

    protected $gates = [
        'client' => ClientPolicy::class,
    ];

    public function boot(): void
    {
        $this->defineGates();
        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
    }
}
