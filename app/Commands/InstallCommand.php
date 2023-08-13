<?php

namespace App\Commands;

use App\Models\Setting;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class InstallCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Installs and configures the PERSCOM CLI to connect and interact with your online dashboard.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $found = Setting::query()->whereIn('key', ['perscom_id', 'api_key'])->exists();

        $continue = true;
        if ($found) {
            $continue = $this->confirm('We found your saved PERSCOM credentials. Do you wish to overwrite these credentials and continue?', true);
        }

        if (! $continue) {
            return Command::SUCCESS;
        }

        $perscomId = $this->ask('What is your PERSCOM ID');
        $apiKey = $this->ask('What is your PERSCOM API key');

        $this->task('Configuring and setting up the PERSCOM CLI', function () use ($perscomId, $apiKey) {
            Setting::updateOrCreate([
                'key' => 'perscom_id',
            ], ['value' => $perscomId]);

            Setting::updateOrCreate([
                'key' => 'api_key',
            ], ['value' => $apiKey]);

            return true;
        });

        $this->info('The PERSCOM CLI has been successfully configured.');

        return Command::SUCCESS;
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
