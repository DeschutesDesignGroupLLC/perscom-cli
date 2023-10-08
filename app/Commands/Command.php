<?php

namespace App\Commands;

use App\Repositories\ConfigRepository;
use App\Repositories\PerscomRepository;
use LaravelZero\Framework\Commands\Command as BaseCommand;

abstract class Command extends BaseCommand
{
    protected $aliases = [];

    protected ConfigRepository $config;

    protected PerscomRepository $perscom;

    public function __construct(ConfigRepository $config, PerscomRepository $perscom)
    {
        parent::__construct();

        $this->config = $config;
        $this->perscom = $perscom;

        $this->setAliases($this->aliases);
    }
}
