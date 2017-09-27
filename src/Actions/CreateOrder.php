<?php

namespace Arkade\Apparel21\Actions;

use Arkade\Apparel21\Contracts;
use Arkade\Apparel21\Parsers\OrderSerializer;
use Arkade\Support\Contracts\Order;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Request;

class CreateOrder extends BaseAction implements Contracts\Action
{

    /**
     * @var integer $person
     */
    protected $personId;
    /**
     * @var $order
     */
    protected $order;

    /**
     * CreateOrder constructor.
     *
     * @param string $personId
     * @param Order $order
     */
    public function __construct($personId, Order $order)
    {
        $this->personId = $personId;
        $this->order = $order;
    }

    /**
     * @return Request
     */
    public function request()
    {
        return new Request(
            'POST',
            'Persons/'.$this->personId.'/Orders',
            ['Content-Type' => 'text/xml', 'Accept' => 'version_2.0'],
            (new OrderSerializer)->serialize($this->order)
        );
    }

    /**
     * @param ResponseInterface $response
     */
    public function response(ResponseInterface $response)
    {
        return $this->order;

    }


}