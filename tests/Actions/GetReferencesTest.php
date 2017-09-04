<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp\Psr7\Response;
use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;

class GetReferencesTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request()
    {
        $request = (new GetReferences((new Entities\ReferenceType)->setId('123')))->request();

        $this->assertEquals('References/123', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function response_is_a_reference_type_with_references_collection()
    {
        $referenceType = (new GetReferences((new Entities\ReferenceType)->setId('123')))->response(
            new Response(200, [], file_get_contents(__DIR__.'/../Stubs/References/get_references_success.xml'))
        );

        $this->assertInstanceOf(Entities\ReferenceType::class, $referenceType);
        $this->assertEquals('123', $referenceType->getId());
        $this->assertEquals('Category', $referenceType->getCode());
        $this->assertEquals('Category', $referenceType->getName());

        $this->assertInstanceOf(Collection::class, $referenceType->getReferences());
        $this->assertCount(160, $referenceType->getReferences());

        $this->assertInstanceOf(Entities\Reference::class, $referenceType->getReferences()->first());
        $this->assertEquals('36167', $referenceType->getReferences()->first()->getId());
        $this->assertEquals('ACTIVEWEAR', $referenceType->getReferences()->first()->getCode());
        $this->assertEquals('Activewear', $referenceType->getReferences()->first()->getName());
    }

    /**
     * @test
     */
    public function references_collection_is_keyed_by_id()
    {
        $referenceType = (new GetReferences((new Entities\ReferenceType)->setId('123')))->response(
            new Response(200, [], file_get_contents(__DIR__.'/../Stubs/References/get_references_success.xml'))
        );

        $this->assertEquals('36167', $referenceType->getReferences()->get('36167')->getId());
    }
}