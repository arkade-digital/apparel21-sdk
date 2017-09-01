<?php

namespace App\Shopify;

use GuzzleHttp;
use App\Shopify;
use ZfrShopify\ShopifyClient;
use ZfrShopify\OAuth\TokenExchanger;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(resource_path('shopify/views'), 'shopify');

        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->bootViewComposer();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMiddleware();
        $this->bindContext();
        $this->bindClient();
        $this->bindTokenExchanger();
    }

    /**
     * Boot the Shopify app view composer.
     *
     * @return void
     */
    protected function bootViewComposer()
    {
        View::composer('shopify::app', function ()
        {
            $context = resolve(Shopify\Services\Context::class);
            $helper  = resolve(Shopify\Services\Helper::class);

            resolve('JavaScript')->put([
                'clientId' => config('services.shopify.client_id'),
                'token' => $context->getShop()->shopify_token,
                'origin' => $helper->shopUrl($context->getShop()->shopify_slug),
                'appBase' => '/apps/'.config('services.shopify.client_id'),
                'hasAp21Credentials' => $context->getShop()->hasAp21Credentials()
            ]);
        });
    }

    /**
     * Register Shopify middleware.
     *
     * @return void
     */
    protected function registerMiddleware()
    {
        $this->app['router']->aliasMiddleware('shopify-request', Middleware\VerifyRequest::class);
        $this->app['router']->aliasMiddleware('shopify-webhook-request', Middleware\VerifyWebhookRequest::class);
        $this->app['router']->aliasMiddleware('shopify-context', Middleware\CaptureContext::class);
        $this->app['router']->aliasMiddleware('shopify-installed', Middleware\CheckInstalled::class);
    }

    /**
     * Bind context singleton.
     *
     * @return void
     */
    protected function bindContext()
    {
        $this->app->singleton(Services\Context::class, function () {
            return new Services\Context(new Services\Helper);
        });
    }

    /**
     * Bind Shopify client.
     *
     * @return void
     */
    protected function bindClient()
    {
        $this->app->bind(ShopifyClient::class, function ($app)
        {
            if (! $shop = $app[Services\Context::class]->getShop()) {
                throw new \DomainException('Cannot resolve ShopifyClient with an empty shop context.');
            }

            return new ShopifyClient([
                'private_app'   => false,
                'api_key'       => config('services.shopify.client_id'),
                'access_token'  => $shop->shopify_token,
                'shop'          => $app[Services\Helper::class]->shopDomain($shop->slug)
            ]);
        });
    }

    /**
     * Bind Shopify token exchanger.
     *
     * @return void
     */
    protected function bindTokenExchanger()
    {
        $this->app->bind(TokenExchanger::class, function () {
            return new TokenExchanger(new GuzzleHttp\Client);
        });
    }
}
