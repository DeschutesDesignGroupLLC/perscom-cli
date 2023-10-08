<?php

namespace App\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class ConfigRepository
{
    public function __construct(protected string $path)
    {
        //
    }

    public function all(): array
    {
        if (! is_dir(dirname($this->path))) {
            mkdir(dirname($this->path), 0755, true);
        }

        if (file_exists($this->path)) {
            return json_decode(file_get_contents($this->path), true);
        }

        return [];
    }

    public function flush(): static
    {
        File::delete($this->path);

        return $this;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->all(), $key, $default);
    }

    public function set(string $key, mixed $value): static
    {
        $config = $this->all();

        Arr::set($config, $key, $value);

        file_put_contents($this->path, json_encode($config, JSON_PRETTY_PRINT));

        return $this;
    }
}
