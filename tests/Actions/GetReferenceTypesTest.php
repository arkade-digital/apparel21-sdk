<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp\Psr7\Response;
use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;

class GetReferenceTypesTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request()
    {
        $request = (new GetReferenceTypes)->request();

        $this->assertEquals('ReferenceTypes', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function response_is_a_collection_of_reference_types()
    {
        $collection = (new GetReferenceTypes)->response(
            new Response(200, [], file_get_contents(__DIR__.'/../Stubs/ReferenceTypes/get_reference_types_success.xml'))
        );

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertInstanceOf(Entities\ReferenceType::class, $collection->first());
        $this->assertCount(251, $collection);
    }
}