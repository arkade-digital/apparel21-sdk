<?php

namespace App\Shopify\Controllers;

use ZfrShopify;
use GuzzleHttp;
use App\Models;
use App\Shopify;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Shopify\Exceptions\AuthRejectedException;

class AuthController extends Controller
{
    /**
     * Shopify context.
     *
     * @var Shopify\Services\Context
     */
    protected $context;

    /**
     * Shopify helper.
     *
     * @var Shopify\Services\Helper
     */
    protected $helper;

    /**
     * Shopify token exchanger.
     *
     * @var ZfrShopify\OAuth\TokenExchanger
     */
    protected $tokenExchanger;

    /**
     * ShopifyAppController constructor.
     *
     * @param Shopify\Services\Context        $context
     * @param Shopify\Services\Helper         $helper
     * @param ZfrShopify\OAuth\TokenExchanger $tokenExchanger
     */
    public function __construct(
        Shopify\Services\Context $context,
        Shopify\Services\Helper $helper,
        ZfrShopify\OAuth\TokenExchanger $tokenExchanger
    ) {
        $this->context        = $context;
        $this->helper         = $helper;
        $this->tokenExchanger = $tokenExchanger;
    }

    /**
     * Show the install page.
     *
     * @return ZfrShopify\OAuth\AuthorizationRedirectResponse
     * @throws AuthRejectedException
     */
    public function install()
    {
        if (! $shop = $this->context->getShopSlug()) {
            return view('shopify::install');
        }

        $this->verifyShop($shop);

        $redirect = new ZfrShopify\OAuth\AuthorizationRedirectResponse(
            config('services.shopify.client_id'),
            $shop,
            $this->helper->getScopes(),
            url('shopify/authorize'),
            $this->helper->generateNonce($shop)
        );

        return view('shopify::redirect', [
            'url'  => $redirect->getHeaderLine('location'),
            'shop' => $this->helper->shopUrl($shop)
        ]);
    }

    /**
     * Process oAuth authorization callback.
     *
     * @param  Request $request
     * @return Response
     * @throws AuthRejectedException|RedirectResponse
     */
    public function auth(Request $request)
    {
        $shop = $this->context->getShopSlug();

        $this->verifyShop($shop);
        $this->verifyNonce($shop, $request->input('state'));

        try {
            $token = $this->tokenExchanger->exchangeCodeForToken(
                config('services.shopify.client_id'),
                config('services.shopify.client_secret'),
                $this->helper->shopDomain($request->input('shop')),
                $this->helper->getExplicitScopes(),
                $request->input('code')
            );
        } catch (GuzzleHttp\Exception\ClientException $e) {
            throw new AuthRejectedException;
        } catch (ZfrShopify\Exception\RuntimeException $e) {
            throw new AuthRejectedException;
        }

        $shop = (new Models\Shop)->connectShopify($shop, $token, $this->helper->getExplicitScopes());

        return view('shopify::redirect', [
            'url'  => $this->helper->appUrl($shop->shopify_slug),
            'shop' => $this->helper->shopUrl($shop->shopify_slug)
        ]);
    }

    /**
     * Verify shop is provided and is allowed.
     *
     * @param  string $shop
     * @throws AuthRejectedException
     */
    protected function verifyShop($shop)
    {
        if (! in_array($shop, ['the-foobar-company'])) {
            throw new AuthRejectedException('Shop '.$shop.' is not permitted for installation');
        }
    }

    /**
     * Verify nonce is provided and is valid.
     *
     * @param  string $shop
     * @param  string $nonce
     * @throws AuthRejectedException
     */
    protected function verifyNonce($shop, $nonce)
    {
        if (! $nonce || ! $this->helper->verifyNonce($nonce, $shop)) {
            throw new AuthRejectedException('Nonce cannot be verified');
        }
    }
}
