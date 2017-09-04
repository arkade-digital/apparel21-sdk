<?php

namespace Arkade\Apparel21\Resolvers;

use GuzzleHttp;
use Arkade\Apparel21\Client;
use PHPUnit\Framework\TestCase;

class ReferenceResolverTest extends TestCase
{
    /**
     * @test
     */
    public function resolve_from_ids_fetches_reference()
    {
        $stack = GuzzleHttp\HandlerStack::create(new GuzzleHttp\Handler\MockHandler([
            new GuzzleHttp\Psr7\Response(200, [], file_get_contents(__DIR__.'/../Stubs/References/get_references_success.xml'))
        ]));

        $client = (new Client('https://api.example.com'))->setCountryCode('AU')->setupClient($stack);

        $resolver = new ReferenceResolver($client);

        $reference = $resolver->resolveFromIds('123', '36167');

        $this->assertEquals('36167', $reference->getId());
        $this->assertEquals('ACTIVEWEAR', $reference->getCode());
        $this->assertEquals('Activewear', $reference->getName());

        $this->assertEquals('123', $reference->getType()->getId());
        $this->assertEquals('Category', $reference->getType()->getCode());
        $this->assertEquals('Category', $reference->getType()->getName());
    }

    /**
     * @test
     */
    public function resolve_from_ids_returns_null_when_type_not_found()
    {
        $stack = GuzzleHttp\HandlerStack::create(new GuzzleHttp\Handler\MockHandler([
            new GuzzleHttp\Psr7\Response(404)
        ]));

        $client = (new Client('https://api.example.com'))->setCountryCode('AU')->setupClient($stack);

        $resolver = new ReferenceResolver($client);

        $this->assertNull(
            $resolver->resolveFromIds('123', '36167')
        );
    }

    /**
     * @test
     */
    public function resolve_from_ids_returns_null_when_reference_not_found()
    {
        $stack = GuzzleHttp\HandlerStack::create(new GuzzleHttp\Handler\MockHandler([
            new GuzzleHttp\Psr7\Response(200, [], file_get_contents(__DIR__.'/../Stubs/References/get_references_success.xml'))
        ]));

        $client = (new Client('https://api.example.com'))->setCountryCode('AU')->setupClient($stack);

        $resolver = new ReferenceResolver($client);

        $this->assertNull(
            $resolver->resolveFromIds('123', '9999')
        );
    }
}