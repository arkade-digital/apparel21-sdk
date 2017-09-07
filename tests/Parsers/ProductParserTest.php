<?php

namespace Arkade\Apparel21\Parsers;

use Mockery as m;
use Carbon\Carbon;
use Arkade\Support\Contracts;
use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;
use Arkade\Apparel21\Contracts\ReferenceResolver;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class ProductParserTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @test
     */
    public function returns_populated_product_entity()
    {
        $product = (new ProductParser)->parse(
            (new PayloadParser)->parse(file_get_contents(__DIR__.'/../Stubs/Products/product.xml'))
        );

        $this->assertInstanceOf(Entities\Product::class, $product);
        $this->assertInstanceOf(Contracts\Product::class, $product);

        $this->assertEquals('31321', $product->getIdentifiers()->get('ap21_id'));
        $this->assertEquals('10005KNDE', $product->getIdentifiers()->get('ap21_code'));
        $this->assertEquals('IMOGEN CF CABLE KNIT', $product->getTitle());
        $this->assertEquals('TEST DESCRIPTION', $product->getDescription());
        $this->assertEquals(['colour' => 'Colour', 'size' => 'Size'], $product->getOptions()->toArray());
        $this->assertEquals(Carbon::parse('2017-06-07 15:06:26'), $product->getUpdatedAt());

        $this->assertInstanceOf(Collection::class, $product->getVariants());
        $this->assertCount(3, $product->getVariants());

        $this->assertInstanceOf(Entities\Variant::class, $product->getVariants()->first());
        $this->assertInstanceOf(Contracts\Sellable::class, $product->getVariants()->first());

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

    /**
     * @test
     */
    public function attributes_populated_via_resolver()
    {
        $resolver = m::mock(ReferenceResolver::class);

        $resolver->shouldReceive('resolveFromIds')
            ->once()
            ->with('258', '3957')
            ->andReturn(
                (new Entities\Reference)
                    ->setId('3957')
                    ->setCode('SPORTS')
                    ->setName('Sports')
                    ->setType(
                        (new Entities\ReferenceType)
                            ->setId('258')
                            ->setCode('CATEGORY')
                            ->setName('Product category')
                    )
            );

        $resolver->shouldReceive('resolveFromIds')
            ->once()
            ->with('1', '36182')
            ->andReturn(
                (new Entities\Reference)
                    ->setId('36182')
                    ->setCode('APPAREL')
                    ->setName('Apparel')
                    ->setType(
                        (new Entities\ReferenceType)
                            ->setId('1')
                            ->setCode('TYPE')
                            ->setName('Product type')
                    )
            );

        $resolver->shouldReceive('resolveFromIds')->times(6)->andReturn(null);

        $product = (new ProductParser)->setReferenceResolver($resolver)->parse(
            (new PayloadParser)->parse(file_get_contents(__DIR__.'/../Stubs/Products/product.xml'))
        );

        $this->assertInstanceOf(Collection::class, $product->getAttributes());
        $this->assertCount(2, $product->getAttributes());

        $this->assertEquals([
            'ap21_CATEGORY' => 'SPORTS',
            'ap21_TYPE'     => 'APPAREL'
        ], $product->getAttributes()->toArray());
    }
}