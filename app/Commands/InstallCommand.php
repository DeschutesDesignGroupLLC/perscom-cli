<?php

namespace App\Commands;

use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Sleep;
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
        if (! File::exists($_SERVER['HOME'].'/.perscom/framework/views') ||
            ! File::exists($_SERVER['HOME'].'/.perscom/app') ||
            ! File::exists($_SERVER['HOME'].'/.perscom/logs')) {
            $this->task('Setting up the proper file structure', function () {
                if (! File::exists($_SERVER['HOME'].'/.perscom/framework/views')) {
                    File::makeDirectory($_SERVER['HOME'].'/.perscom/framework/views', 0755, true);
                }

                if (! File::exists($_SERVER['HOME'].'/.perscom/app')) {
                    File::makeDirectory($_SERVER['HOME'].'/.perscom/app', 0755, true);
                }

                if (! File::exists($_SERVER['HOME'].'/.perscom/logs')) {
                    File::makeDirectory($_SERVER['HOME'].'/.perscom/logs', 0755, true);
                }

                Sleep::for(1)->seconds();

                return true;
            });
        }

        if (! File::exists($_SERVER['HOME'].'/.perscom/database/database.sqlite')) {
            $this->task('Provisioning a database on the local system', function () {
                if (! File::exists($_SERVER['HOME'].'/.perscom/database')) {
                    File::makeDirectory($_SERVER['HOME'].'/.perscom/database', 0755, true);
                }
                File::put($_SERVER['HOME'].'/.perscom/database/database.sqlite', '');

                Sleep::for(1)->seconds();

                return true;
            });

            $this->task('Setting up and migrating the database', function () {
                Artisan::call('migrate --force');

                Sleep::for(1)->seconds();

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

            Sleep::for(1)->seconds();

            return true;
        });

        $this->info('The PERSCOM CLI has been successfully configured.');

        return Command::SUCCESS;
    }
}
