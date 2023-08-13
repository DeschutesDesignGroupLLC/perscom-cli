<?php

namespace App\Contracts;

interface ResourceTransformerContract
{
    public function transform(array $data = [], array $keys = []): static;
}
