<?php

namespace FikriMastor\LaravelAuditLogin\Commands;

use Illuminate\Console\Command;

class LaravelAuditLoginCommand extends Command
{
    public $signature = 'laravel-audit-login';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
