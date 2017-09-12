<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp\Psr7\Response;
use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;

class GetPersonsTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request_with_email()
    {
        $request = (new GetPersons)->email('foo@example.com')->request();

        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEquals('Persons', $request->getUri()->getPath());
        $this->assertEquals('foo@example.com', $query['email']);
    }

    /**
     * @test
     */
    public function builds_request_with_firstname()
    {
        $request = (new GetPersons)->firstname('Foo')->request();

        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEquals('Persons', $request->getUri()->getPath());
        $this->assertEquals('Foo', $query['firstname']);
    }

    /**
     * @test
     */
    public function builds_request_with_surname()
    {
        $request = (new GetPersons)->surname('Example')->request();

        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEquals('Persons', $request->getUri()->getPath());
        $this->assertEquals('Example', $query['surname']);
    }

    /**
     * @test
     */
    public function builds_request_with_phone()
    {
        $request = (new GetPersons)->phone('012345678')->request();

        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEquals('Persons', $request->getUri()->getPath());
        $this->assertEquals('012345678', $query['phone']);
    }

    /**
     * @test
     */
    public function builds_request_with_code()
    {
        $request = (new GetPersons)->code('AHWADA00')->request();

        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEquals('Persons', $request->getUri()->getPath());
        $this->assertEquals('AHWADA00', $query['code']);
    }

    /**
     * @test
     */
    public function response_is_a_collection_of_persons()
    {
        $collection = (new GetPersons)->response(
            new Response(200, [], file_get_contents(__DIR__.'/../Stubs/Persons/get_persons_success.xml'))
        );

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertInstanceOf(Entities\Person::class, $collection->first());
        $this->assertEquals(3, $collection->count());
    }
}