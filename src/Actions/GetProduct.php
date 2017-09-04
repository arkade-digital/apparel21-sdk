<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Apparel21\Parsers;
use Arkade\Apparel21\Entities;
use Arkade\Apparel21\Contracts;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetProduct extends BaseAction implements Contracts\Action
{
    /**
     * Apparel21 product ID.
     *
     * @var string
     */
    protected $id;

    /**
     * GetProduct constructor.
     *
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Build a PSR-7 request.
     *
     * @return RequestInterface
     */
    public function request()
    {
        return new GuzzleHttp\Psr7\Request('GET', 'Products/'.$this->id);
    }

    /**
     * Transform a PSR-7 response.
     *
     * @param  ResponseInterface $response
     * @return Entities\Product
     */
    public function response(ResponseInterface $response)
    {
        return (new Parsers\ProductParser)
            ->setReferenceResolver($this->getClient() ? $this->getClient()->getReferenceResolver() : null)
            ->parse((new Parsers\PayloadParser)->parse((string) $response->getBody()));
    }
}