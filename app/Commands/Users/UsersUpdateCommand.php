<?php

namespace App\Commands\Users;

use App\Commands\ResourceCommand;
use App\Transformers\UsersTransformer;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class UsersUpdateCommand extends ResourceCommand implements PromptsForMissingInput
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'users:update
                           {id : The ID of the user being updated}
                           {--body= : The JSON payload containing the updated user data}
                           {--keys= : A comma-delimited list of additional attributes to include (optional)}
                           {--include= : A comma-delimited list of resource relationships to include (optional)}
                           {--output=table : The intended output of the command (options: table, json, html)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Update an existing user';

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
    protected $method = 'PUT';

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array
     */
    protected function promptForMissingArgumentsUsing()
    {
        return [
            'id' => 'Which user ID should be updated?',
        ];
    }
}
