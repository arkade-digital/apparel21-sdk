<?php

namespace Arkade\Apparel21;

use GuzzleHttp;
use Psr\Http\Message\RequestInterface;

class Client
{
    /**
     * Base URL.
     *
     * @var string
     */
    protected $base_url;

    /**
     * Username.
     *
     * @var string
     */
    protected $username;

    /**
     * Password.
     *
     * @var string
     */
    protected $password;

    /**
     * ISO country code.
     *
     * @var string
     */
    protected $countryCode;

    /**
     * Guzzle client for HTTP transport.
     *
     * @var GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * Client constructor.
     *
     * @param string $base_url
     */
    public function __construct($base_url)
    {
        $this->base_url = $base_url;

        $this->setupClient();
    }

    /**
     * Return base URL for REST API.
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->base_url;
    }

    /**
     * Return username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Return password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set username and password.
     *
     * @param  string $username
     * @param  string $password
     * @return Client
     */
    public function setCredentials($username, $password)
    {
        $this->username = $username;
        $this->password = $password;

        return $this;
    }

    /**
     * Return ISO country code.
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set ISO country code.
     *
     * @param  string $countryCode
     * @return Client
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Setup Guzzle client with optional provided handler stack.
     *
     * @param  GuzzleHttp\HandlerStack|null $stack
     * @return Client
     */
    public function setupClient(GuzzleHttp\HandlerStack $stack = null)
    {
        $stack = $stack ?: GuzzleHttp\HandlerStack::create();

        $this->bindHeadersMiddleware($stack);
        $this->bindCountryCodeMiddleware($stack);

        $this->client = new GuzzleHttp\Client([
            'handler'  => $stack,
            'base_uri' => $this->base_url,
        ]);

        return $this;
    }

    /**
     * Execute the given action.
     *
     * @param  Contracts\Action $action
     * @return Contracts\Entity $entity
     */
    public function do(Contracts\Action $action)
    {
        return $action->response(
            $this->client->send($action->request())
        );
    }

    /**
     * Pass unknown methods off to the underlying Guzzle client.
     *
     * @param  string $name
     * @param  array  $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->client, $name], $arguments);
    }

    /**
     * Bind outgoing request middleware for headers.
     *
     * @param  GuzzleHttp\HandlerStack $stack
     * @return void
     */
    protected function bindHeadersMiddleware(GuzzleHttp\HandlerStack $stack)
    {
        $stack->push(GuzzleHttp\Middleware::mapRequest(function (RequestInterface $request) {
            return $request
                ->withHeader('Accept', 'version_2.0')
                ->withHeader('Content-type', 'text/xml');
        }));
    }

    /**
     * Bind outgoing country code middleware.
     *
     * @param  GuzzleHttp\HandlerStack $stack
     * @return void
     */
    protected function bindCountryCodeMiddleware(GuzzleHttp\HandlerStack $stack)
    {
        $stack->push(GuzzleHttp\Middleware::mapRequest(function (RequestInterface $request)
        {
            if (! $this->countryCode) {
                throw new \DomainException('Requests cannot be sent without setting a country code on the client.');
            }

            return $request->withUri(
                GuzzleHttp\Psr7\Uri::withQueryValue($request->getUri(), 'CountryCode', $this->countryCode)
            );
        }));
    }
}
