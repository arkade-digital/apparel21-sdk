<?php

namespace Arkade\Apparel21\Actions;

use Arkade\Apparel21\Factories\OrderFactory;
use PHPUnit\Framework\TestCase;

class CreateOrderTest extends TestCase
{

    /**
     * @test
     */
    public function builds_request()
    {
        $request = (new CreateOrder(
            '101451',
            (new OrderFactory)->make()
        ))->request();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('Persons/101451/Orders', $request->getUri()->getPath());
        $this->assertEquals('text/xml', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('version_2.0', $request->getHeaderLine('Accept'));

    }

}