<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp\Psr7\Response;
use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;

class GetColoursTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request()
    {
        $request = (new GetColours)->request();

        $this->assertEquals('Colours', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function response_is_a_collection_of_reference_types()
    {
        $collection = (new GetColours)->response(
            new Response(200, [], file_get_contents(__DIR__.'/../Stubs/Colours/get_colours_success.xml'))
        );

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertInstanceOf(Entities\Colour::class, $collection->first());
        $this->assertCount(282, $collection);
    }
}