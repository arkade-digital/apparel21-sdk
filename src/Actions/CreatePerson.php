<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Support;
use Arkade\Apparel21\Contracts;
use Arkade\Apparel21\Serializers;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CreatePerson extends BaseAction implements Contracts\Action
{
    /**
     * Person.
     *
     * @var Support\Contracts\Person
     */
    public $person;

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
            [],
            (new Serializers\PersonSerializer)->serialize($this->person)
        );
    }

    /**
     * Transform a PSR-7 response.
     *
     * @param  ResponseInterface $response
     * @return Support\Contracts\Person
     */
    public function response(ResponseInterface $response)
    {
        // Populate ID from Location header if possible
        if ($this->person instanceof Support\Contracts\Identifiable) {
            $this->person->getIdentifiers()->put(
                'ap21_id',
                $this->parseLocationHeader($response)
            );
        }

        return $this->person;
    }

    /**
     * Get person ID from Location header.
     *
     * @param  ResponseInterface $response
     * @return string
     */
    protected function parseLocationHeader(ResponseInterface $response)
    {
        return array_last(
            explode(
                '/',
                parse_url(
                    $response->getHeaderLine('Location'),
                    PHP_URL_PATH
                )
            )
        );
    }
}