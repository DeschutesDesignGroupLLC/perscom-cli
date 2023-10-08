<?php

namespace App\Transformers;

use App\Contracts\ResourceTransformerContract;
use Illuminate\Support\Str;

class ResourceTransformer implements ResourceTransformerContract
{
    protected array $displayKeys = [];

    public function transform(array $data = [], ?array $keys = []): array
    {
        if (count($data) == count($data, COUNT_RECURSIVE)) {
            $data = [$data];
        }

        $keys = collect(array_unique(array_merge($keys, $this->displayKeys)));

        $data = collect($data)->map(function ($user) use ($keys) {
            $object = [];

            $keys->each(function ($key) use ($user, &$object) {
                if (array_key_exists($key, $user)) {
                    $object[$key] = $user[$key];
                }
            });

            return $object;
        });

        return [$keys->map(function ($key) {
            return Str::title($key);
        })->toArray(), $data];
    }
}
