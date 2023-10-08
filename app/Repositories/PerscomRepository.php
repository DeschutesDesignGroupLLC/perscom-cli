<?php

namespace App\Repositories;

use Perscom\Exceptions\NotFoundHttpException;
use Perscom\PerscomConnection;

/**
 * @mixin PerscomConnection
 */
class PerscomRepository
{
    public function __construct(protected ConfigRepository $config, protected PerscomConnection $client)
    {
        //
    }

    public function setClient(PerscomConnection $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function __call(string $method, array $parameters): mixed
    {
        $this->ensureApiKeyAndPerscomIdSet();

        return $this->client->{$method}(...$parameters);
    }

    protected function ensureApiKeyAndPerscomIdSet(): void
    {
        $perscomId = $this->config->get('perscomId', $_SERVER['PERSCOM_ID'] ?? getenv('PERSCOM_ID') ?: null);
        $apiKey = $this->config->get('apiKey', $_SERVER['PERSCOM_API_KEY'] ?? getenv('PERSCOM_API_KEY') ?: null);

        abort_if($perscomId === null || $apiKey === null, 1, 'Please authenticate using the \'install\' command before proceeding.');
    }
}
