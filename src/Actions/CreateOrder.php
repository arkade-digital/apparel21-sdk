<?php

namespace Arkade\Apparel21\Actions;

use Arkade\Support;
use Arkade\Apparel21\Contracts;
use Arkade\Support\Contracts\Order;
use Arkade\Apparel21\Serializers\OrderSerializer;
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
     *
     * @return Order
     */
    public function response(ResponseInterface $response)
    {
        if ($this->order instanceof Support\Contracts\Identifiable) {
            $this->order->getIdentifiers()->put(
                'ap21_order_id',
                $this->parseLocationHeader($response)
            );
        }
        return $this->order;
    }

    /**
     * Get person ID from Location header.
     *
     * @param  ResponseInterface $response
     * @return string
     */
    protected function parseLocationHeader(ResponseInterface $response)
    {
        return array_last(
            explode(
                '/',
                parse_url(
                    $response->getHeaderLine('Location'),
                    PHP_URL_PATH
                )
            )
        );
    }
}