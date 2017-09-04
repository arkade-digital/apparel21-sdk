<?php

namespace Arkade\Apparel21\Actions;

use Mockery as m;
use Arkade\Apparel21\Client;
use GuzzleHttp\Psr7\Response;
use Arkade\Apparel21\Entities;
use Arkade\Apparel21\Contracts;
use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class GetProductTest extends TestCase
{
    use MockeryPHPUnitIntegration;

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

    /**
     * @test
     */
    public function action_calls_resolver_from_client()
    {
        $resolver = m::mock(Contracts\ReferenceResolver::class);
        $resolver->shouldReceive('resolveFromIds')->times(8)->andReturn(null);

        $client = m::mock(Client::class);
        $client->shouldReceive('getReferenceResolver')->andReturn($resolver);

        (new GetProduct('31321'))->setClient($client)->response(
            new Response(200, [], file_get_contents(__DIR__.'/../Stubs/Products/product.xml'))
        );
    }
}