<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp\Psr7\Response;
use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;

class GetStoresTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request()
    {
        $request = (new GetStores)->request();

        $this->assertEquals('Stores/', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function response_is_a_collection_of_reference_types()
    {
        $collection = (new GetStores)->response(
            new Response(200, [], file_get_contents(__DIR__.'/../Stubs/Stores/get_stores_success.xml'))
        );

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertInstanceOf(Entities\Store::class, $collection->first());
        $this->assertCount(66, $collection);
    }
}