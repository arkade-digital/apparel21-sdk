<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;
use Arkade\Apparel21\Factories;

class CreatePersonTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request()
    {
        $request = (new CreatePerson(
            (new Factories\PersonFactory)->make()
        ))->request();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('Persons', $request->getUri()->getPath());
        $this->assertEquals('text/xml', $request->getHeaderLine('Content-Type'));
    }

    /**
     * @test
     */
    public function response_is_person_with_id()
    {
        $person = (new CreatePerson(
            (new Factories\PersonFactory)->make()
        ))->response(
            new GuzzleHttp\Psr7\Response(
                201,
                [
                    'Location' => 'http://api.example.com/RetailAPI/Persons/745580?countryCode=AU'
                ],
                ''
            )
        );

        $this->assertInstanceOf(Entities\Person::class, $person);
        $this->assertEquals('745580', $person->getIdentifiers()->get('ap21_id'));
    }
}