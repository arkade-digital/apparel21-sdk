<?php

namespace Arkade\Apparel21\Actions;

use Arkade\Apparel21\Contracts\Action;
use Arkade\Apparel21\Parsers;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

class GetCustomersByEmail extends BaseAction implements Action
{
    /**
     * Apparel21 country code for Persons
     *
     * @var string
     */
    protected $countyCode = 'AU';

    /**
     * Person's email
     *
     * @var string
     */
    protected $email;

    /**
     * GetPersons constructor.
     * @param string $email
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    public function request()
    {
        $request = new Request(
            'GET',
            'Persons?countryCode='.$this->countyCode.'&email='.$this->email
        );
    }

    public function response(ResponseInterface $response)
    {
        return (new Parsers\PersonParser)
            ->parse((new Parsers\PayloadParser)->parse((string) $response->getBody()));
    }


}