<?php

namespace Arkade\Apparel21\Parsers;

use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;

class FreeStockParserTest extends TestCase
{
    /**
     * @test
     */
    public function returns_collection_of_freestock_entities()
    {
        $collection = (new FreeStockParser)->parse(
            (new PayloadParser)->parse(file_get_contents(__DIR__ . '/../Stubs/Freestock/sku_response.xml'))
        );

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertInstanceOf(Entities\FreeStock::class, $collection->first());

        $example = $collection->first();

        $this->assertEquals('Decjuba Onehunga Store', $example->getStore()->getName());
        $this->assertEquals('20988', $example->getStore()->getIdentifiers()->get('ap21_id'));
        $this->assertEquals('207', $example->getStore()->getIdentifiers()->get('ap21_number'));

        $this->assertEquals('150077', $example->getVariant()->getIdentifiers()->get('ap21_id'));

        $this->assertEquals(2, $example->getFreeStock());
    }
}