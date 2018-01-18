<?php

namespace Arkade\Apparel21;

use GuzzleHttp;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Client::class, function ($app)
        {
            $client = new Client(config('services.apparel21.base_url'));

            $client->setCredentials(
                config('services.apparel21.username'),
                config('services.apparel21.password')
            );
            $client->setCountryCode(config('services.apparel21.country_code'));

            $this->setupRecorder($client);

            return $client->setupClient();
        });
    }

    /**
     * Setup recorder middleware if the HttpRecorder package is bound.
     *
     * @param  Client $client
     * @return Client
     */
    protected function setupRecorder(Client $client)
    {
        if (! $this->app->bound('Arkade\HttpRecorder\Integrations\Guzzle\MiddlewareFactory')) {
            return $client;
        }

        $stack = GuzzleHttp\HandlerStack::create();

        $stack->push(
            $this->app
                ->make('Arkade\HttpRecorder\Integrations\Guzzle\MiddlewareFactory')
                ->make(['apparel21', 'outgoing'])
        );

        return $client->setupClient($stack);
    }
}
