<?php

namespace Arkade\Apparel21\Actions;

use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;

class GetProductTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request()
    {
        $request = (new GetProduct('31321'))->request();

        $this->assertEquals('Products/31321', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function response_is_a_product()
    {
        $product = (new GetProduct('31321'))->response(
            new Response(200, [], file_get_contents(__DIR__.'/../Stubs/Products/product.xml'))
        );

        $this->assertInstanceOf(Entities\Product::class, $product);
    }
}