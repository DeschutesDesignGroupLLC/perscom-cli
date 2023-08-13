<?php

namespace App\Commands;

use App\Contracts\PerscomApiServiceContract;
use App\Contracts\ResourceCommandContract;
use Illuminate\Console\Command;
use function Termwind\render;

abstract class ResourceCommand extends Command implements ResourceCommandContract
{
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $apiService = app()->make(PerscomApiServiceContract::class);

        $response = $apiService->api(optional($this->option('id'), function ($id) {
            return "$this->endpoint/$id";
        }) ?: $this->endpoint);

        if (! $response->successful()) {
            $this->error($response->json('error.message', 'There was an error with your last request. Please try again.'));

            return Command::FAILURE;
        }

        $transformer = app()->make($this->transformer);

        if ($keys = $this->option('keys')) {
            $keys = explode(',', $this->option('keys'));
        }

        render(view('api.view', [
            'transformer' => $transformer->transform($response->json('data'), $keys),
        ]));

        return Command::SUCCESS;
    }
}
