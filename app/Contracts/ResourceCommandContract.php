<?php

namespace App\Contracts;

interface ResourceCommandContract
{
    public function performApiCall(): array;
}
