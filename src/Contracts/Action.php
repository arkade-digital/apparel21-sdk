<?php

namespace Arkade\Apparel21\Contracts;

use Illuminate\Support\Collection;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface Action
{
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
     * @return Entity|Collection
     */
    public function response(ResponseInterface $response);
}