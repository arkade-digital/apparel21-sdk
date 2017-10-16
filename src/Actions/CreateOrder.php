<?php

namespace Arkade\Apparel21\Actions;

use Arkade\Support;
use GuzzleHttp\Psr7\Request;
use Arkade\Apparel21\Entities;
use Arkade\Apparel21\Contracts;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Arkade\Apparel21\Serializers\OrderSerializer;

class CreateOrder extends BaseAction implements Contracts\Action
{
    /**
     * Order.
     *
     * @var Entities\Order
     */
    public $order;

    /**
     * CreateOrder constructor.
     *
     * @param Entities\Order $order
     */
    public function __construct(Entities\Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build a PSR-7 request.
     *
     * @return RequestInterface
     */
    public function request()
    {
        return new Request(
            'POST',
            'Persons/'.$this->order->getCustomer()->getIdentifiers()->get('ap21_id').'/Orders',
            [],
            (new OrderSerializer)->serialize($this->order)
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
        $this->order->getIdentifiers()->put(
            'ap21_id',
            $this->parseLocationHeader($response)
        );

        return $this->order;
    }

    /**
     * Extract person ID from Location header.
     *
     * @param  ResponseInterface $response
     * @return integer
     */
    protected function parseLocationHeader(ResponseInterface $response)
    {
        return (int) array_last(
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