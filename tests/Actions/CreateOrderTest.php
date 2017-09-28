<?php

namespace Arkade\Apparel21\Actions;

use Arkade\Apparel21\Entities\Order;
use Arkade\Apparel21\Factories\OrderFactory;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class CreateOrderTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request()
    {
        $request = (new CreateOrder(
            '101451',
            (new OrderFactory)->make()
        ))->request();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('Persons/101451/Orders', $request->getUri()->getPath());
        $this->assertEquals('text/xml', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('version_2.0', $request->getHeaderLine('Accept'));
    }

    /**
     * @test
     */
    public function response_is_order_with_number()
    {
        $order = (new CreateOrder(
            '101451',
            (new OrderFactory)->make()
        ))->response(
            new Response(
                201,
                ['Location' => 'http://api.example.com/RetailAPI/Persons/101451/Orders/7894567?countryCode=AU'],
                ''
            )
        );

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals('7894567', $order->getIdentifiers()->get('ap21_order_id'));
        $this->assertEquals('101451', $order->getIdentifiers()->get('ap21_person_id'));
    }
}