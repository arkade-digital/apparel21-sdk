<?php

namespace Arkade\Apparel21\Parsers;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use Arkade\Support\Contracts;
use Arkade\Apparel21\Entities;

class FreestockBySkuParserTest extends TestCase
{
    /**
     * @test
     */
    public function returns_populated_freestockBySku_entity()
    {
        $freestock = $this->getFreestockMockXML();

        $this->assertInstanceOf(Entities\FreestockBySku::class, $freestock);
        $this->assertInstanceOf(Contracts\FreestockBySku::class, $freestock);

        $this->assertEquals('13224', $freestock->getIdentifiers()->get('sku_id'));
        $this->assertEquals('Jeans Sizes AVOCADO 1', $freestock->getSkuName());
    }

    /**
     * @test
     */
    public function returns_populated_freestockBySku_with_stores()
    {
        $stores = ($this->getFreestockMockXML())->getStores();

        $this->assertInstanceOf(Collection::class, $stores);
        $this->assertCount(3, $stores);

        $this->assertInstanceOf(Entities\Store::class, $stores->first());
        $this->assertInstanceOf(Contracts\Store::class, $stores->first());

        $this->assertEquals('Pitt St Store', $stores->first()->getName());
        $this->assertEquals('109864', $stores->first()->getIdentifiers()->get('store_id'));
        $this->assertEquals('100', $stores->first()->getStoreNumber());
        $this->assertEquals('4', $stores->first()->getFreestock());
    }

    /**
     * @return Entities\FreestockBySku
     */
    protected function getFreestockMockXML()
    {
        return (new FreestockBySkuParser)->parse(
            (new PayloadParser)->parse(
                file_get_contents(__DIR__ . '/../Stubs/Stock/single_sku_with_stores.xml')
            )
        );
    }
}