<?php

namespace App\Commands;

use function Laravel\Prompts\info;
use function Laravel\Prompts\text;

class InstallCommand extends Command
{
    protected $signature = 'install';

    protected $description = 'Installs and configures the PERSCOM CLI to connect and interact with your online dashboard.';

    public function handle()
    {
        $perscomId = text(
            label: 'Please enter your PERSCOM ID:',
            required: true,
            validate: fn (string $value) => match (true) {
                ! is_numeric($value) => 'The PERSCOM ID must be a number.',
                default => null
            },
            hint: 'You can find this located in the settings of your PERSCOM dashboard.'
        );

        $this->config->set('perscomId', $perscomId);

        $apiKey = text(
            label: 'Please enter your PERSCOM API key:',
            required: true,
            hint: 'You must have the "manage:api" permissions to create and view your API keys.'
        );

        $this->config->set('apiKey', $apiKey);

        info('<fg=green>==></> <options=bold>You have successfully setup the PERSCOM CLI.');

        return Command::SUCCESS;
    }
}
