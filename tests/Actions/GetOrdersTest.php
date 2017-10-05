<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Apparel21\Entities;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class GetOrdersTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request()
    {
        $request = (new GetOrders(101451))->request();

        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEquals('Persons/101451/Orders', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function response_is_a_collection_of_orders()
    {
        $collection = (new GetOrders(101451))->response(
            new GuzzleHttp\Psr7\Response(
                200,
                [],
                file_get_contents(__DIR__.'/../Stubs/Orders/orders.xml')
            )
        );

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertInstanceOf(Entities\Order::class, $collection->first());
        $this->assertEquals(2, $collection->count());
    }
}