<?php

namespace App\Commands;

use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
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
        if (! File::exists($_SERVER['HOME'].'/.perscom/database.sqlite')) {
            $this->confirm('The PERSCOM CLI will create a database on your local system to store some settings. Do you wish to continue?', true);

            $this->task('Provisioning database on local system', function () {
                File::makeDirectory($_SERVER['HOME'].'/.perscom');
                File::put($_SERVER['HOME'].'/.perscom/database.sqlite', '');
            });

            $this->task('Setting and migrating the database', function () {
                Artisan::call('migrate --force');

                return true;
            });
        }

        $found = Setting::query()->whereIn('key', ['perscom_id', 'api_key'])->whereNotNull('value')->exists();

        $continue = true;
        if ($found) {
            $continue = $this->confirm('We found your saved PERSCOM credentials. Do you wish to overwrite these credentials and continue?', true);
        }

        if (! $continue) {
            return Command::SUCCESS;
        }

        $perscomId = $this->ask('What is your PERSCOM ID');
        $apiKey = $this->ask('What is your PERSCOM API key');

        $this->task('Saving settings to the database', function () use ($perscomId, $apiKey) {
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
}
