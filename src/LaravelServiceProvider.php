<?php

namespace Arkade\Apparel21;

use GuzzleHttp;
use Illuminate\Support\Facades\Log;
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
            $client->setLogging(config('services.apparel21.logging'));
            $client->setVerifyPeer(config('services.apparel21.verify'));
            $client->setLogger(Log::getMonolog());

            $this->setupRecorder($client);

            return $client;
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
        if (! $this->app->bound('Omneo\Plugins\HttpRecorder\Recorder')) {
            return $client->setupClient();
        }

        $stack = GuzzleHttp\HandlerStack::create();

        $stack->push(
            $this->app
                ->make('Omneo\Plugins\HttpRecorder\GuzzleIntegration')
                ->getMiddleware(['apparel21', 'outgoing'])
        );

        return $client->setupClient($stack);
    }
}
