<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Apparel21\Client;
use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;

class GetPersonTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request_with_id()
    {
        $request = (new GetPerson('77284'))->request();

        $this->assertEquals('Persons/77284', $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function response_is_a_single_person()
    {
        $person = (new GetPerson('77284'))->response(
            new GuzzleHttp\Psr7\Response(
                200,
                [],
                file_get_contents(__DIR__.'/../Stubs/Persons/person.xml')
            )
        );

        $this->assertInstanceOf(Entities\Person::class, $person);
    }

    /**
     * @test
     * @expectedException \Arkade\Apparel21\Exceptions\NotFoundException
     */
    public function throws_not_found_exception_when_missing()
    {
        $stack = GuzzleHttp\HandlerStack::create(new GuzzleHttp\Handler\MockHandler([
            new GuzzleHttp\Psr7\Response(
                404,
                [],
                file_get_contents(__DIR__.'/../Stubs/Persons/get_persons_not_found.xml')
            )
        ]));

        (new Client('https://api.example.com'))
            ->setupClient($stack)
            ->setCountryCode('AU')
            ->action(new GetPerson('77284'));
    }
}