<?php

namespace Arkade\Apparel21\Serializers;

use PHPUnit\Framework\TestCase;
use Arkade\Apparel21\Factories;

class PersonSerializerTest extends TestCase
{
    /**
     * @test
     */
    public function returns_populated_with_loyalty_xml()
    {
        $xml = (new PersonSerializer)->serialize(
            (new Factories\PersonFactoryWithLoyalty)->make()
        );
        var_dump($xml);
        $this->assertTrue(
            (new XMLHelper)->compare(
                file_get_contents(__DIR__.'/../Stubs/Persons/create_person_request_with_loyalty.xml'),
                $xml
            )
        );
    }

    /**
     * @test
     */
    public function returns_populated_xml()
    {
        $xml = (new PersonSerializer)->serialize(
            (new Factories\PersonFactory)->make()
        );
        var_dump($xml);
        $this->assertTrue(
            (new XMLHelper)->compare(
                file_get_contents(__DIR__.'/../Stubs/Persons/create_person_request.xml'),
                $xml
            )
        );
    }
}