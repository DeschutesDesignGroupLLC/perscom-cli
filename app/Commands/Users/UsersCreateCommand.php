<?php

namespace App\Commands\Users;

use App\Commands\ResourceCommand;
use App\Transformers\UsersTransformer;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class UsersCreateCommand extends ResourceCommand implements PromptsForMissingInput
{
    protected $signature = 'users:create
                           {name : The name of the user being updated}
                           {email : The email of the user being updated}
                           {--body= : The JSON payload containing the new user data}
                           {--keys= : A comma-delimited list of additional attributes to include (optional)}
                           {--include= : A comma-delimited list of resource relationships to include (optional)}';

    protected $description = 'Create a new user';

    protected string $transformer = UsersTransformer::class;

    public function performApiCall(): array
    {
        return $this->perscom->users()->create([
            'name' => $this->option('name'),
            'email' => $this->option('email'),
        ])->json('data');
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => 'What is the user\'s name?',
            'email' => 'Which is the user\'s email?',
        ];
    }
}
