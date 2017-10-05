<?php

namespace Arkade\Apparel21\Actions;

use Arkade\Apparel21\Entities;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class GetOrderTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request()
    {
        $request = (new GetOrder(101451, 362812))->request();

        $this->assertEquals('Persons/101451/Orders/362812', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function response_is_an_order()
    {
        $order = (new GetOrder(101451, 123456))->response(
            new Response(200, [], file_get_contents(__DIR__.'/../Stubs/Orders/order.xml'))
        );

        $this->assertInstanceOf(Entities\Order::class, $order);
    }

}