<?php

namespace Arkade\Apparel21\Actions;

use Arkade\Apparel21\Parsers;
use GuzzleHttp\Psr7\Request;
use Arkade\Apparel21\Entities;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetFreestockBySku extends BaseAction
{
    /**
     * @var string $sku
     */
    protected $sku;

    /**
     * GetFreestockBySku constructor.
     *
     * @param int $sku
     */
    public function __construct($sku)
    {
        $this->sku = $sku;
    }

    /**
     * Transform a PSR-7 response.
     *
     * @param  ResponseInterface $response
     * @return Entities\FreestockBySku
     */
    public function response(ResponseInterface $response)
    {
        $xml = (new Parsers\PayloadParser)->parse((string) $response->getBody());

        return (new Parsers\FreestockBySkuParser)->parse($xml);
    }

    /**
     * Build a PSR-7 request.
     *
     * @return RequestInterface
     */
    public function request()
    {
        return new Request('GET', 'Freestock/sku/'.$this->sku);
    }
}