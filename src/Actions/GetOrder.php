<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Apparel21\Parsers;
use Arkade\Apparel21\Entities;
use Arkade\Apparel21\Contracts;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetOrder extends BaseAction implements Contracts\Action
{
    /**
     * @var int $person
     */
    protected $personId;

    /**
     * @var int
     */
    private $orderId;

    /**
     * GetOrders constructor.
     *
     * @param int $personId
     * @param int $orderId
     */
    public function __construct($personId, $orderId)
    {
        $this->personId = $personId;
        $this->orderId = $orderId;
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
           'Persons/'.$this->personId.'/Orders/'.$this->orderId
       );
    }

    /**
     * Transform a PSR-7 response.
     *
     * @param  ResponseInterface $response
     * @return Entities\Order
     */
    public function response(ResponseInterface $response)
    {
        return (new Parsers\OrderParser)->parse(
            (new Parsers\PayloadParser)->parse((string) $response->getBody())
        );
    }

}