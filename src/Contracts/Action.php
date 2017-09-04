<?php

namespace Arkade\Apparel21\Contracts;

use Arkade\Apparel21\Client;
use Arkade\Support\Contracts;
use Illuminate\Support\Collection;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface Action
{
    /**
     * Set SDK client.
     *
     * @param  Client $client
     * @return static
     */
    public function setClient(Client $client);

    /**
     * Return SDK client.
     *
     * @return Client
     */
    public function getClient();

    /**
     * Build a PSR-7 request.
     *
     * @return RequestInterface
     */
    public function request();

    /**
     * Transform a PSR-7 response.
     *
     * @param  ResponseInterface $response
     * @return Contracts\Identifiable|Collection
     */
    public function response(ResponseInterface $response);
}