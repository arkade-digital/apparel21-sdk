<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Apparel21\Parsers;
use Arkade\Apparel21\Contracts;
use Illuminate\Support\Collection;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetPersons extends BaseAction implements Contracts\Action
{
    /**
     * Email address.
     *
     * @var string
     */
    public $email;

    /**
     * First name.
     *
     * @var string
     */
    public $firstname;

    /**
     * Surname.
     *
     * @var string
     */
    public $surname;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $code;

    /**
     * @param string $phone
     * @return static
     */
    public function phone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @param string $code
     * @return static
     */
    public function code($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Set email address.
     *
     * @param  string $email
     * @return static
     */
    public function email($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set first name.
     *
     * @param  string $firstname
     * @return static
     */
    public function firstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Set surname.
     *
     * @param  string $surname
     * @return static
     */
    public function surname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Build a PSR-7 request.
     *
     * @return RequestInterface
     */
    public function request()
    {
        $request = new GuzzleHttp\Psr7\Request('GET', 'Persons');

        return $request->withUri($request->getUri()->withQuery(http_build_query([
            'email'     => $this->email,
            'firstname' => $this->firstname,
            'surname'   => $this->surname,
            'phone'   => $this->phone,
            'code'   => $this->code,
        ])));
    }

    /**
     * Transform a PSR-7 response.
     *
     * @param  ResponseInterface $response
     * @return Collection
     */
    public function response(ResponseInterface $response)
    {
        $xml = (new Parsers\PayloadParser)->parse((string) $response->getBody());

        $collection = new Collection;

        foreach ($xml as $item) {
            $collection->push(
                (new Parsers\PersonParser)->parse($item)
            );
        }

        return $collection;
    }
}