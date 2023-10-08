<?php

namespace App\Commands;

use App\Contracts\ResourceCommandContract;
use Saloon\Exceptions\Request\RequestException;

use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\table;

abstract class ResourceCommand extends Command implements ResourceCommandContract
{
    public function handle()
    {
        try {
            $response = spin(
                fn () => $this->performApiCall(),
                'Performing operation...'
            );

            $transformer = app()->make($this->transformer);
            [$keys, $data] = $transformer->transform($response);

            info('<fg=green>==></> <options=bold>The operation has successfully been performed.');

            table($keys, $data);

            return Command::SUCCESS;
        } catch (\Exception $exception) {
            $message = match (true) {
                $exception instanceof RequestException => $exception->getResponse()->json('error.message') ?? null,
                $exception->getMessage() !== '' => $exception->getMessage(),
                default => 'There was an error with the last operation.'
            };

            error($message);

            return Command::FAILURE;
        }
    }
}
