<?php

namespace Arkade\Apparel21;

use Exception;
use GuzzleHttp;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;
use Arkade\Apparel21\Exceptions;
use Illuminate\Support\Collection;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;

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
     * Reference resolver.
     *
     * @var Contracts\ReferenceResolver
     */
    protected $referenceResolver;

    /**
     * Guzzle client for HTTP transport.
     *
     * @var GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * Stream resource for debug output.
     *
     * @var resource
     */
    protected $debug;

    /**
     * Enable logging of guzzle requests / responses
     *
     * @var bool
     */
    protected $logging = false;

    /**
     * PSR-3 logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Verify peer SSL
     *
     * @var bool
     */
    protected $verifyPeer = true;

    /**
     * Set connection timeout
     *
     * @var int
     */
    protected $timeout = 900;

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
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->base_url;
    }

    /**
     * @param string $base_url
     * @return Client
     */
    public function setBaseUrl($base_url)
    {
        $this->base_url = $base_url;
        return $this;
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
     * @param string $username
     * @return Client
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @param string $password
     * @return Client
     */
    public function setPassword($password)
    {
        return $this->password;
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
     * Return reference resolver.
     *
     * @return Contracts\ReferenceResolver
     */
    public function getReferenceResolver()
    {
        return $this->referenceResolver ?: $this->referenceResolver = new Resolvers\ReferenceResolver($this);
    }

    /**
     * Set reference resolver.
     *
     * @param  Contracts\ReferenceResolver $referenceResolver
     * @return static
     */
    public function setReferenceResolver(Contracts\ReferenceResolver $referenceResolver)
    {
        $this->referenceResolver = $referenceResolver;

        return $this;
    }

    /**
     * @return bool
     */
    public function getLogging()
    {
        return $this->logging;
    }

    /**
     * @param bool $logging
     * @return Client
     */
    public function setLogging($logging)
    {
        $this->logging = $logging;
        return $this;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     * @return Client
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @return bool
     */
    public function getVerifyPeer()
    {
        return $this->verifyPeer;
    }

    /**
     * @param bool $verifyPeer
     * @return Client
     */
    public function setVerifyPeer($verifyPeer)
    {
        $this->verifyPeer = $verifyPeer;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     * @return Client
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * Enable debug mode.
     *
     * @return void
     */
    public function debug()
    {
        $this->debug = fopen('php://temp', 'r+');
    }

    /**
     * Return debug output.
     *
     * @return string|null
     */
    public function getDebugOutput()
    {
        if (! $this->debug) return null;

        fseek($this->debug, 0);

        return stream_get_contents($this->debug);
    }

    /**
     * Setup Guzzle client with optional provided handler stack.
     *
     * @param  GuzzleHttp\HandlerStack|null $stack
     * @param  array                        $options
     * @return Client
     */
    public function setupClient(GuzzleHttp\HandlerStack $stack = null, $options = [])
    {
        $stack = $stack ?: GuzzleHttp\HandlerStack::create();

        $this->bindHeadersMiddleware($stack);
        $this->bindCountryCodeMiddleware($stack);
        $this->bindBasicAuthMiddleware($stack);

        if($this->logging) $this->bindLoggingMiddleware($stack);

        $this->client = new GuzzleHttp\Client(array_merge([
            'handler'  => $stack,
            'base_uri' => $this->getBaseUrl(),
            'verify' => $this->getVerifyPeer(),
            'timeout'  => $this->getTimeout(),
        ], $options));

        return $this;
    }

    /**
     * Execute the given action.
     *
     * @param  Contracts\Action $action
     * @return mixed|Collection
     * @throws Exceptions\Apparel21Exception
     */
    public function action(Contracts\Action $action)
    {
        try {
            return $action
                ->setClient($this)
                ->response(
                    $this->client->send($action->request())
                );
        } catch (Exception $e) {
            throw $this->convertException($e);
        }
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
     * Convert the provided exception.
     *
     * @param  Exception $e
     * @return Exceptions\Apparel21Exception|Exception
     */
    protected function convertException(Exception $e)
    {
        if ($e instanceof GuzzleHttp\Exception\ClientException && 404 == $e->getResponse()->getStatusCode()) {
            return new Exceptions\NotFoundException;
        }

        return $e;
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
     * Bind basic auth middleware for headers.
     *
     * @param  GuzzleHttp\HandlerStack $stack
     * @return void
     */
    protected function bindBasicAuthMiddleware(GuzzleHttp\HandlerStack $stack)
    {
        if(!($this->getUsername() && $this->getPassword())) return;
            $stack->push(GuzzleHttp\Middleware::mapRequest(function (RequestInterface $request) {
            return $request
                ->withHeader('Authorization', ['Basic ' . base64_encode($this->getUsername() . ':' . $this->getPassword())]);
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

    /**
     * Bind logging middleware.
     *
     * @param  GuzzleHttp\HandlerStack $stack
     * @return void
     */
    protected function bindLoggingMiddleware(GuzzleHttp\HandlerStack $stack)
    {
        $stack->push(Middleware::log(
            $this->logger,
            new MessageFormatter('{request} - {response}')
        ));
    }
}
