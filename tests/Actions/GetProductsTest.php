<?php

namespace Arkade\Apparel21\Actions;

use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;

class GetProductsTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request_with_pagination()
    {
        $request = (new GetProducts)->skip(0)->take(10)->request();

        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEquals('ProductsSimple', $request->getUri()->getPath());
        $this->assertEquals(0, $query['startRow']);
        $this->assertEquals(10, $query['pageRows']);
    }

    /**
     * @test
     */
    public function builds_request_with_updated_after_constraint()
    {
        $request = (new GetProducts)->updatedAfter(Carbon::parse('2017-01-01 21:00'))->request();

        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEquals('ProductsSimple', $request->getUri()->getPath());
        $this->assertEquals('2017-01-01T21:00:00', $query['updatedAfter']);
    }

    /**
     * @test
     */
    public function response_is_a_collection_of_products()
    {
        $collection = (new GetProducts)->response(
            new Response(200, [], file_get_contents(__DIR__.'/../Stubs/Products/get_products_simple_success.xml'))
        );

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertInstanceOf(Entities\Product::class, $collection->first());
    }
}