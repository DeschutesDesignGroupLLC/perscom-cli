<?php

namespace App\Commands\Users;

use App\Commands\ResourceCommand;
use App\Transformers\UsersTransformer;

class UsersCreateCommand extends ResourceCommand
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'users:create
                           {--body= : The JSON payload containing the new user data}
                           {--keys= : A comma-delimited list of additional attributes to include (optional)}
                           {--include= : A comma-delimited list of resource relationships to include (optional)}
                           {--output=table : The intended output of the command (options: table, json, html)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create a new user';

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

    /**
     * @var string
     */
    protected $method = 'POST';
}
