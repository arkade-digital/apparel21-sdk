<?php

namespace Arkade\Apparel21\Actions;

use PHPUnit\Framework\TestCase;

class GetCustomerByEmailTest extends TestCase
{
    /**
     * Run a request to get customers by email.
     */
    public function builds_request()
    {
        $req = (new GetCustomersByEmail('foo@mail.com'))->request();

        $this->assertEquals('Person/123', $req->getUri()->getPath());
    }

}