<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Apparel21\Parsers;
use Arkade\Apparel21\Contracts;
use Illuminate\Support\Collection;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetStores extends BaseAction implements Contracts\Action
{

    /**
     * GetStores constructor.
     */
    public function __construct()
    {
    }

    /**
     * Build a PSR-7 request.
     *
     * @return RequestInterface
     */
    public function request()
    {
       return new GuzzleHttp\Psr7\Request(
           'GET',
           'Stores/'
       );
    }

    /**
     * Transform a PSR-7 response.
     *
     * @param  ResponseInterface $response
     * @return Collection
     */
    public function response(ResponseInterface $response)
    {
        $xml = (new Parsers\PayloadParser)->parse((string) $response->getBody());

        $collection = new Collection;

        foreach ($xml as $item) {
            $collection->push(
                (new Parsers\StoreParser)->parse($item)
            );
        }

        return $collection;
    }
}