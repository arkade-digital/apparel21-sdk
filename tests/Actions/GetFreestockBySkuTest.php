<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use Arkade\Apparel21\Entities;

class GetFreestockBySkuTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request()
    {
        $req = (new GetFreestockBySku('13224'))->request();

        $this->assertEquals('Freestock/sku/13224', $req->getUri()->getPath());
    }

    /**
     * @test
     */
    public function response_has_store_collection()
    {
        $freestock = (new GetFreestockBySku('13224'))->response(
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/../Stubs/Stock/single_sku_with_stores.xml')
            )
        );

        $this->assertInstanceOf(Entities\FreestockBySku::class, $freestock);
        $this->assertEquals(3, ($freestock->getStores()->count()));
    }
}