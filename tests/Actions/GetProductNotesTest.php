<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp\Psr7\Response;
use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;

class GetProductNotesTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request()
    {
        $request = (new GetProductNotes('31321'))->request();

        $this->assertEquals('ProductNotes/31321', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function response_is_a_collection_of_notes()
    {
        $notes = (new GetProductNotes('31321'))->response(
            new Response(200, [], file_get_contents(__DIR__.'/../Stubs/ProductNotes/get_product_notes_success.xml'))
        );

        $this->assertInstanceOf(Collection::class, $notes);
        $this->assertInstanceOf(Entities\ProductNote::class, $notes->first());
    }
}