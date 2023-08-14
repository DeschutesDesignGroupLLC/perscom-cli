<?php

namespace App\Commands\Users;

use App\Commands\ResourceCommand;
use App\Transformers\UsersTransformer;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class UsersDeleteCommand extends ResourceCommand implements PromptsForMissingInput
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'users:delete
                            {id : The ID of the user being deleted}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Delete an existing user';

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
    protected $method = 'DELETE';

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array
     */
    protected function promptForMissingArgumentsUsing()
    {
        return [
            'id' => 'Which user ID should be deleted?',
        ];
    }
}
