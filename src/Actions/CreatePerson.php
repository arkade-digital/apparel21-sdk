<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Support;
use Arkade\Apparel21\Contracts;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SimpleXMLElement;

class CreatePerson extends BaseAction implements Contracts\Action
{
    /**
     * Person.
     *
     * @var Support\Contracts\Person
     */
    protected $person;

    /**
     * CreatePerson constructor.
     *
     * @param Support\Contracts\Person $person
     */
    public function __construct(Support\Contracts\Person $person)
    {
        $this->person = $person;
    }

    /**
     * Build a PSR-7 request.
     *
     * @return RequestInterface
     */
    public function request()
    {
        return new GuzzleHttp\Psr7\Request(
            'POST',
            'Persons',
            ['Content-Type' => 'text/xml'],
            (new Serializers\PersonSerializer)->serialize($this->person)
        );
    }

    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function response(ResponseInterface $response)
    {
        return $response;
    }
}