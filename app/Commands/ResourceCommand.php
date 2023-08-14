<?php

namespace App\Commands;

use App\Contracts\PerscomApiServiceContract;
use App\Contracts\ResourceCommandContract;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Phar;
use Symfony\Component\HttpFoundation\Request;
use function Termwind\render;

abstract class ResourceCommand extends Command implements ResourceCommandContract
{
    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (Phar::running() && ! File::exists($_SERVER['HOME'].'/.perscom/database/database.sqlite')) {
            $this->error('Unable to find the local database. Please run the install command to perform the PERSCOM CLI setup.');

            return Command::FAILURE;
        }

        if (! Setting::query()->whereIn('key', ['perscom_id', 'api_key'])->whereNotNull('value')->exists()) {
            $this->error('Unable to load saved PERSCOM credentials. Please run the install command to perform the PERSCOM CLI setup.');

            return Command::FAILURE;
        }

        $apiService = app()->make(PerscomApiServiceContract::class);

        $id = null;
        if ($this->hasArgument('id')) {
            $id = $this->argument('id');
        }

        $body = null;
        if ($this->hasOption('body')) {
            $body = json_decode($this->option('body'), true);

            if (is_null($body)) {
                $this->error('The body provided is not proper JSON. Please try again.');

                return Command::FAILURE;
            }
        }

        $response = $apiService->api(optional($id, function ($id) {
            return "$this->endpoint/$id";
        }) ?: $this->endpoint, $this->method, $body);

        if (! $response->successful()) {
            $this->error($response->json('error.message', 'There was an error with your last request. Please try again.'));

            return Command::FAILURE;
        }

        if ($this->method === Request::METHOD_POST) {
            $resource = Str::lower(Str::singular($this->endpoint));

            $this->info("The $resource has been successfully created.");
        }

        if ($this->method === Request::METHOD_PUT) {
            $resource = Str::lower(Str::singular($this->endpoint));

            $this->info("The $resource has been successfully updated.");
        }

        if ($this->method === Request::METHOD_DELETE) {
            $resource = Str::lower(Str::singular($this->endpoint));

            $this->info("The $resource has been successfully deleted.");

            return Command::SUCCESS;
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
