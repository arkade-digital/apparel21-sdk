<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp\Psr7\Request;
use Arkade\Apparel21\Parsers;
use Arkade\Apparel21\Contracts;
use Illuminate\Support\Collection;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetFreeStock extends BaseAction implements Contracts\Action
{
    /**
     * Lookup type.
     *
     * @var string
     */
    public $lookupType;

    /**
     * Lookup value.
     *
     * @var string
     */
    public $lookupValue;

    /**
     * Set SKU for lookup.
     *
     * @param  string $sku
     * @return static
     */
    public function sku($sku)
    {
        $this->lookupType  = 'sku';
        $this->lookupValue = $sku;

        return $this;
    }

    /**
     * Build a PSR-7 request.
     *
     * @return RequestInterface
     */
    public function request()
    {
        return new Request('GET', sprintf(
            'Freestock/%s/%s',
            $this->lookupType,
            $this->lookupValue
        ));
    }

    /**
     * Transform a PSR-7 response.
     *
     * @param  ResponseInterface $response
     * @return Collection
     */
    public function response(ResponseInterface $response)
    {
        return (new Parsers\FreeStockParser)->parse(
            (new Parsers\PayloadParser)->parse((string) $response->getBody())
        );
    }
}