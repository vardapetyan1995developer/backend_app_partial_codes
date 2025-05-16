<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\SuperAdminSeed;

/**
 * @codeCoverageIgnore
 */
final class AppInstallCommand extends Command
{
    protected $signature = 'app:install';

    protected $description = 'Project initial setup command.';

    public function handle(): int
    {
        $this->call('config:clear');
        $this->call('cache:clear');
        $this->call('route:clear');
        $this->call('key:generate', ['--force' => true]);
        $this->call('storage:link');
        $this->call('migrate:fresh', ['--force' => true, '--seed' => true]);
        $this->call('db:seed', ['--class' => SuperAdminSeed::class]);
        $this->call('passport:client', ['--password' => true, '--no-interaction' => true]);
        $this->call('l5-swagger:generate');

        return 0;
    }
}
