<?php

namespace Arkade\Apparel21\Actions;

use Arkade\Apparel21\Client;

abstract class BaseAction
{
    /**
     * SDK client.
     *
     * @var Client
     */
    protected $client;

    /**
     * Set SDK client.
     *
     * @param  Client $client
     * @return static
     */
    public function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Return SDK client.
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }
}