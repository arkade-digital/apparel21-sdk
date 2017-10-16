<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp\Psr7\Response;
use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;
use Arkade\Apparel21\Factories;

class CreateOrderTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request()
    {
        $request = (new CreateOrder((new Factories\OrderFactory)->make()))->request();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('Persons/745619/Orders', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function response_is_order_with_populated_id()
    {
        $order = (new CreateOrder((new Factories\OrderFactory)->make()))->response(
            new Response(
                201,
                ['Location' => 'http://api.example.com.au/RetailAPI/Persons/745619/Orders/362832?CountryCode=AU']
            )
        );

        $this->assertInstanceOf(Entities\Order::class, $order);
        $this->assertEquals(362832, $order->getIdentifiers()->get('ap21_id'));
    }
}