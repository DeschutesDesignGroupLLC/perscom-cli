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
                           {--id= : The ID of a specific user (optional)}
                           {--keys= : A comma-delimited list of additional attributes to include (optional)}
                           {--include= : A comma-delimited list of resource relationships to include (optional)}
                           {--output=table : The intended output of the command (options: table, json, html)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'View a list of users';

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
