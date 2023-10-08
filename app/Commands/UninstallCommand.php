<?php

namespace App\Commands;

use function Laravel\Prompts\info;

class UninstallCommand extends Command
{
    protected $signature = 'uninstall';

    protected $description = 'Uninstalls the PERSCOM CLI and removes all stored credentials.';

    public function handle()
    {
        $this->config->flush();

        info('<fg=green>==></> <options=bold>The PERSCOM CLI has been successfully uninstalled.');

        return Command::SUCCESS;
    }
}
