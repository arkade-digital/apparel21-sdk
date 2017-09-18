<?php

namespace Arkade\Apparel21\Serializers;

use PHPUnit\Framework\TestCase;
use Arkade\Apparel21\Factories;

class PersonSerializerTest extends TestCase
{
    /**
     * @test
     */
    public function returns_populated_xml()
    {
        $xml = (new PersonSerializer)->serialize(
            (new Factories\PersonFactory)->make()
        );

        $this->assertTrue(
            (new XMLHelper)->compare(
                file_get_contents(__DIR__.'/../Stubs/Persons/create_person_request.xml'),
                $xml
            )
        );
    }
}