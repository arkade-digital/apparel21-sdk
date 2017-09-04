<?php

namespace Arkade\Apparel21\Parsers;

use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;

class ReferenceTypeParserTest extends TestCase
{
    /**
     * @test
     */
    public function returns_populated_reference_type_entity()
    {
        $type = (new ReferenceTypeParser)->parse(
            (new PayloadParser)->parse(file_get_contents(__DIR__.'/../Stubs/ReferenceTypes/reference_type.xml'))
        );

        $this->assertInstanceOf(Entities\ReferenceType::class, $type);

        $this->assertEquals('335', $type->getId());
        $this->assertEquals('APCONT', $type->getCode());
        $this->assertEquals('AP Control Account', $type->getName());
    }
}