<?php

namespace Arkade\Apparel21\Parsers;

use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;

class ColourParserTest extends TestCase
{
    /**
     * @test
     */
    public function returns_populated_colour_entity()
    {
        $colour = (new ColourParser())->parse(
            (new PayloadParser)->parse(file_get_contents(__DIR__.'/../Stubs/Colours/colour.xml'))
        );

        $this->assertInstanceOf(Entities\Colour::class, $colour);

        $this->assertEquals('2TONEDEN', $colour->getCode());
        $this->assertEquals('2 Tone Denim', $colour->getName());
        $this->assertEquals('1', $colour->getRowNumber());
    }
}