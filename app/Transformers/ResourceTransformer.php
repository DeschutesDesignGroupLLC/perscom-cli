<?php

namespace App\Transformers;

use App\Contracts\ResourceTransformerContract;
use Illuminate\Support\Arr;

class ResourceTransformer implements ResourceTransformerContract
{
    protected array $displayKeys = [];

    public array $keys = [];

    public array $data = [];

    public function transform(array $data = [], ?array $keys = []): static
    {
        if (count($data) === count($data, COUNT_RECURSIVE)) {
            $data = [$data];
        }

        $this->data = $data;

        if ($keys) {
            $this->displayKeys = array_unique(array_merge($keys, $this->displayKeys));
        }

        $resource = collect(collect($data)->first());

        $this->keys = $resource->keys()->filter(function ($key) {
            return in_array($key, $this->displayKeys);
        })->toArray();

        return $this;
    }
}
