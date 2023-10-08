<?php

namespace App\Commands\Users;

use App\Commands\ResourceCommand;
use App\Transformers\UsersTransformer;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class UsersUpdateCommand extends ResourceCommand implements PromptsForMissingInput
{
    protected $signature = 'users:update
                           {id : The ID of the user being updated}
                           {--body= : The JSON payload containing the updated user data}
                           {--keys= : A comma-delimited list of additional attributes to include (optional)}
                           {--include= : A comma-delimited list of resource relationships to include (optional)}';

    protected $description = 'Update an existing user';

    protected string $transformer = UsersTransformer::class;

    public function performApiCall(): array
    {
        $body = json_decode($this->option('body'), true);
        if ($this->hasOption('body') && is_null($body)) {
            throw new \Exception('Please make sure the body option is properly formatted JSON.');
        }

        return $this->perscom->users()->update($this->argument('id'), $body ?? [])->json('data');
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'id' => 'Which user ID should be updated?',
        ];
    }
}
