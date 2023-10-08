<?php

namespace App\Providers;

use App\Repositories\ConfigRepository;
use App\Repositories\PerscomRepository;
use Illuminate\Support\ServiceProvider;
use Perscom\PerscomConnection;

class PerscomServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PerscomRepository::class, function () {
            $config = resolve(ConfigRepository::class);
            $perscomId = $config->get('perscomId', $_SERVER['PERSCOM_ID'] ?? getenv('PERSCOM_ID') ?: '');
            $apiKey = $config->get('apiKey', $_SERVER['PERSCOM_API_KEY'] ?? getenv('PERSCOM_API_KEY') ?: '');

            $client = new PerscomConnection($apiKey, $perscomId);

            return new PerscomRepository($config, $client);
        });
    }
}
