<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * @codeCoverageIgnore
 */
final class AppCiCommand extends Command
{
    protected $signature = 'app:ci {--p|production}';

    protected $description = 'Continuous integration command';

    public function handle(): int
    {
        $this->call('cache:clear');
        $this->call('migrate', ['--force' => true, '--seed' => true]);

        if ($this->option('production')) {
            $this->call('config:cache');
            $this->call('optimize');
            $this->call('route:cache');
            $this->call('view:cache');
        } else {
            $this->call('optimize:clear');
            $this->call('route:clear');
            $this->call('view:clear');
        }

        $this->call('l5-swagger:generate');

        return 0;
    }
}
