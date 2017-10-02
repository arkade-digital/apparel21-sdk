<?php

namespace Arkade\Apparel21\Serializers;

use PHPUnit\Framework\TestCase;
use Arkade\Apparel21\Factories;

class OrderSerializerTest extends TestCase
{
    /**
     * @test
     */
    public function returns_populated_xml()
    {
        $xml = (new OrderSerializer)->serialize(
            (new Factories\OrderFactory())->make()
        );

        $this->assertTrue(
            (new XMLHelper)->compare(
                file_get_contents(__DIR__.'/../Stubs/Orders/order.xml'),
                $xml
            )
        );
    }

}