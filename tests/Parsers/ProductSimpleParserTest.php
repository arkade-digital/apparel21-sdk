<?php

namespace Arkade\Apparel21\Parsers;

use Carbon\Carbon;
use Arkade\Support\Contracts;
use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;

class ProductSimpleParserTest extends TestCase
{
    /**
     * @test
     */
    public function returns_populated_product_entity()
    {
        $product = (new ProductSimpleParser)->parse(
            (new PayloadParser)->parse(file_get_contents(__DIR__.'/../Stubs/Products/product_simple.xml'))
        );

        $this->assertInstanceOf(Entities\Product::class, $product);
        $this->assertInstanceOf(Contracts\Product::class, $product);

        $this->assertEquals('31321', $product->getIdentifiers()->get('ap21.id'));
        $this->assertEquals('10005KNDE', $product->getIdentifiers()->get('ap21.code'));
        $this->assertEquals('IMOGEN CF CABLE KNIT', $product->getTitle());
        $this->assertEquals('TEST DESCRIPTION', $product->getDescription());
        $this->assertEquals(Carbon::parse('2017-06-07 15:06:26'), $product->getUpdatedAt());
    }
}