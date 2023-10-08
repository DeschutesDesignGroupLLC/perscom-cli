<?php

namespace App\Commands\Users;

use App\Commands\ResourceCommand;
use App\Transformers\UsersTransformer;

class UsersViewCommand extends ResourceCommand
{
    protected $signature = 'users:view
                           {id? : The ID of a specific user to view (optional)}
                           {--keys= : A comma-delimited list of additional attributes to include (optional)}
                           {--include= : A comma-delimited list of resource relationships to include (optional)}';

    protected $description = 'View a list of users';

    protected string $transformer = UsersTransformer::class;

    public function performApiCall(): array
    {
        if ($this->hasArgument('id') && ! is_null($this->argument('id'))) {
            return $this->perscom->users()->get($this->argument('id'))->json('data');
        }

        return $this->perscom->users()->all()->json('data');
    }
}
