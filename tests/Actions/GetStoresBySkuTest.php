<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use Arkade\Apparel21\Entities;

class GetStoresBySkuTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request()
    {
        $req = (new GetStoresBySku('150077'))->request();

        $this->assertEquals('Freestock/sku/150077', $req->getUri()->getPath());
    }

    /**
     * @test
     */
    public function response_is_a_store_collection()
    {
        $collection = (new GetStoresBySku('150077'))->response(
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/../Stubs/Store/single_sku_with_stores.xml')
            )
        );

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertInstanceOf(Entities\Store::class, $collection->first());
        $this->assertEquals(7, ($collection->count()));
    }
}