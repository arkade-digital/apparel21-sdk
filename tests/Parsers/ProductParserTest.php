<?php

namespace Arkade\Apparel21\Parsers;

use Carbon\Carbon;
use Arkade\Apparel21\Entities;
use Arkade\Apparel21\Contracts;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;

class ProductParserTest extends TestCase
{
    /**
     * @test
     */
    public function returns_populated_product_entity()
    {
        $product = (new ProductParser)->parse(
            (new PayloadParser)->parse(file_get_contents(__DIR__.'/../Stubs/Products/product.xml'))
        );

        $this->assertInstanceOf(Entities\Product::class, $product);
        $this->assertInstanceOf(Contracts\Commerce\Product::class, $product);

        $this->assertEquals('31321', $product->getIdentifiers()->get('ap21_id'));
        $this->assertEquals('10005KNDE', $product->getIdentifiers()->get('ap21_code'));
        $this->assertEquals('IMOGEN CF CABLE KNIT', $product->getName());
        $this->assertEquals('TEST DESCRIPTION', $product->getDescription());
        $this->assertEquals(['colour' => 'Colour', 'size' => 'Size'], $product->getOptions()->toArray());
        $this->assertEquals(Carbon::parse('2017-06-07 15:06:26'), $product->getUpdatedAt());

        $this->assertInstanceOf(Collection::class, $product->getVariants());
        $this->assertCount(3, $product->getVariants());

        $this->assertInstanceOf(Entities\Variant::class, $product->getVariants()->first());
        $this->assertInstanceOf(Contracts\Commerce\Sellable::class, $product->getVariants()->first());

        $this->assertEquals('150077', $product->getVariants()->first()->getIdentifiers()->get('ap21_id'));
        $this->assertEquals('63090', $product->getVariants()->first()->getIdentifiers()->get('ap21_colour_id'));
        $this->assertEquals('MIDGRYMRL', $product->getVariants()->first()->getIdentifiers()->get('ap21_colour_code'));
        $this->assertEquals('S', $product->getVariants()->first()->getIdentifiers()->get('ap21_size_code'));

        $this->assertEquals('Mid Grey Marle - S', $product->getVariants()->first()->getTitle());
        $this->assertEquals('9342033270762', $product->getVariants()->first()->getSKU());
        $this->assertEquals(5000, $product->getVariants()->first()->getPrice());
        $this->assertEquals(20, $product->getVariants()->first()->getStock());

        $this->assertEquals('Mid Grey Marle', $product->getVariants()->first()->getOptions()->get('colour'));
        $this->assertEquals('S', $product->getVariants()->first()->getOptions()->get('size'));
    }
}