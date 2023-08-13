<?php

namespace App\Commands;

use App\Contracts\PerscomApiServiceContract;
use App\Contracts\ResourceCommandContract;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
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
        if (! File::exists($_SERVER['HOME'].'/.perscom/database.sqlite')) {
            $this->error('Unable to find the local database. Please run the install command to perform the PERSCOM CLI setup.');

            return Command::FAILURE;
        }

        if (! Setting::query()->whereIn('key', ['perscom_id', 'api_key'])->whereNotNull('value')->exists()) {
            $this->error('Unable to load saved PERSCOM credentials. Please run the install command to perform the PERSCOM CLI setup.');

            return Command::FAILURE;
        }

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

        switch ($this->option('output')) {
            case 'json':
                $this->line($response);
                break;

            case 'html':
                $this->line(view('api.view', [
                    'transformer' => $transformer->transform($response->json('data'), $keys),
                ])->render());
                break;

            default:
                render(view('api.view', [
                    'transformer' => $transformer->transform($response->json('data'), $keys),
                ]));
                break;
        }

        return Command::SUCCESS;
    }
}
