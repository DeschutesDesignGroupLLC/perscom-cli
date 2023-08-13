<?php

namespace App\Transformers;

class UsersTransformer extends ResourceTransformer
{
    protected array $displayKeys = ['id', 'name', 'email'];
}
