<?php

namespace Arkade\Apparel21\Parsers;

use PHPUnit\Framework\TestCase;
use Arkade\Apparel21\Entities;

class StoreParserTest extends TestCase
{
    /**
     * @test
     */
    public function returns_stores()
    {
        $xml = (new PayloadParser)
            ->parse(file_get_contents(__DIR__ . '/../Stubs/Store/store.xml'));

        $store = (new StoreParser)->parse($xml);

        $this->assertInstanceOf(Entities\Store::class, $store);

        $this->assertEquals('Decjuba Onehunga Store', $store->getName());
        $this->assertEquals('20988', $store->getIdentifiers()->get('store_id'));
        $this->assertEquals('207', $store->getStoreNumber());
        $this->assertEquals('2', $store->getFreestock());
    }
}