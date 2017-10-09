<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Apparel21\Parsers;
use Arkade\Apparel21\Contracts;
use Illuminate\Support\Collection;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetOrders extends BaseAction implements Contracts\Action
{
    /**
     * Person ID.
     *
     * @var int
     */
    protected $personId;

    /**
     * GetOrders constructor.
     *
     * @param int $personId
     */
    public function __construct($personId)
    {
        $this->personId = $personId;
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
           'Persons/'.$this->personId.'/Orders'
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
                (new Parsers\OrderParser)->parse($item)
            );
        }

        return $collection;
    }
}