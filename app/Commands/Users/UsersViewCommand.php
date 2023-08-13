<?php

namespace App\Commands\Users;

use App\Commands\ResourceCommand;
use App\Transformers\UsersTransformer;

class UsersViewCommand extends ResourceCommand
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'users:view
                           {--id= : The ID of a user (optional)}
                           {--keys= : A comma-delimited list of additional attributes to include (optional)}
                           {--include= : A comma-delimited list of resource relationships to include (optional)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'View a list of users or a specific user';

    /**
     * The API endpoint
     *
     * @var string
     */
    protected $endpoint = 'users';

    /**
     * The transformer to use
     *
     * @var string
     */
    protected $transformer = UsersTransformer::class;
}
