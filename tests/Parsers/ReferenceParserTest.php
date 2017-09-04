<?php

namespace Arkade\Apparel21\Parsers;

use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;

class ReferenceParserTest extends TestCase
{
    /**
     * @test
     */
    public function returns_populated_reference_type_entity()
    {
        $type = (new ReferenceParser)->parse(
            (new PayloadParser)->parse(file_get_contents(__DIR__.'/../Stubs/References/reference.xml'))
        );

        $this->assertInstanceOf(Entities\Reference::class, $type);

        $this->assertEquals('36167', $type->getId());
        $this->assertEquals('ACTIVEWEAR', $type->getCode());
        $this->assertEquals('Activewear', $type->getName());
    }
}