<?php

namespace Arkade\Apparel21;

use GuzzleHttp;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function constructor_sets_base_url()
    {
        $client = new Client('https://api.example.com');

        $this->assertEquals('https://api.example.com', $client->getBaseUrl());
    }

    /**
     * @test
     */
    public function set_credentials_actually_sets_credentials()
    {
        $client = new Client('https://api.example.com');

        $client->setCredentials('username', 'password');

        $this->assertEquals('username', $client->getUsername());
        $this->assertEquals('password', $client->getPassword());
    }

    /**
     * @test
     */
    public function set_credentials_is_chainable()
    {
        $client = new Client('https://api.example.com');

        $chainable = $client->setCredentials('username', 'password');

        $this->assertInstanceOf(Client::class, $chainable);
    }

    /**
     * @test
     */
    public function set_country_code_sets_country_code()
    {
        $client = new Client('https://api.example.com');

        $client->setCountryCode('AU');

        $this->assertEquals('AU', $client->getCountryCode());
    }

    /**
     * @test
     */
    public function set_country_code_is_chainable()
    {
        $client = new Client('https://api.example.com');

        $chainable = $client->setCountryCode('AU');

        $this->assertInstanceOf(Client::class, $chainable);
    }

    /**
     * @test
     */
    public function country_code_middleware_sets_country_code()
    {
        $container = [];

        $stack = GuzzleHttp\HandlerStack::create(new GuzzleHttp\Handler\MockHandler([
            new GuzzleHttp\Psr7\Response
        ]));

        $client = (new Client('https://api.example.com'))
            ->setupClient($stack)
            ->setCountryCode('AU');

        // Make sure history middleware comes after setupClient as it needs to be called last
        $stack->push(GuzzleHttp\Middleware::history($container));

        $client->get('/');

        parse_str($container[0]['request']->getUri()->getQuery(), $query);

        $this->assertEquals('AU', $query['CountryCode']);
    }

    /**
     * @test
     * @expectedException \DomainException
     */
    public function country_code_middleware_throws_exception_when_country_code_unset()
    {
        $stack = GuzzleHttp\HandlerStack::create(new GuzzleHttp\Handler\MockHandler([
            new GuzzleHttp\Psr7\Response
        ]));

        $client = (new Client('https://api.example.com'))->setupClient($stack);

        $client->get('/');
    }

//    public function test_real_request()
//    {
//        $response = (new Client('http://api.decjuba.com.au/RetailAPITest/'))
//            ->setCountryCode('AU')
//            ->do(new Actions\GetProduct('31321'));
//
//        var_dump($response, (string) $response->getBody());
//    }
}