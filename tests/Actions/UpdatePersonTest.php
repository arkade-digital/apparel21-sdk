<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;
use Arkade\Apparel21\Factories;

class UpdatePersonTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request()
    {
        $request = (new UpdatePerson(
            1,
            (new Factories\PersonFactory)->make()
        ))->request();

        $this->assertEquals('PUT', $request->getMethod());
        $this->assertEquals('Persons/1', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function response_is_person_with_id()
    {
        $person = (new UpdatePerson(
            1,
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