<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp\Psr7\Response;
use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;

class GetFreeStockTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request()
    {
        $req = (new GetFreeStock)->sku('150077')->request();

        $this->assertEquals('Freestock/sku/150077', $req->getUri()->getPath());
    }

    /**
     * @test
     */
    public function response_is_a_collection_of_freestock_entities()
    {
        $collection = (new GetFreeStock)->sku('150077')->response(
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/../Stubs/Freestock/sku_response.xml')
            )
        );

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertInstanceOf(Entities\FreeStock::class, $collection->first());
        $this->assertEquals(7, $collection->count());
    }
}