<?php

namespace App\Commands\Users;

use App\Commands\ResourceCommand;
use App\Transformers\UsersTransformer;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class UsersDeleteCommand extends ResourceCommand implements PromptsForMissingInput
{
    protected $signature = 'users:delete
                            {id : The ID of the user being deleted}';

    protected $description = 'Delete an existing user';

    protected string $transformer = UsersTransformer::class;

    public function performApiCall(): array
    {
        return $this->perscom->users()->delete($this->argument('id'))->json('data');
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'id' => 'Which user ID should be deleted?',
        ];
    }
}
