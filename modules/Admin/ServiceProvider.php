<?php

namespace Modules\Admin;

use Modules\Admin\Policies\AdminPolicy;
use Infrastructure\Auth\Traits\DefineGates;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
{
    use DefineGates;

    protected $gates = [
        'admin' => AdminPolicy::class,
    ];

    public function boot(): void
    {
        $this->defineGates();
        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
    }
}
