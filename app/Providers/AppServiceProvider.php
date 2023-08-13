<?php

namespace App\Providers;

use App\Contracts\PerscomApiServiceContract;
use App\Contracts\ResourceTransformerContract;
use App\Services\PerscomApiService;
use App\Transformers\ResourceTransformer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PerscomApiServiceContract::class, PerscomApiService::class);
        $this->app->bind(ResourceTransformerContract::class, ResourceTransformer::class);
    }
}
