<?php

namespace App\Shopify\Middleware;

use Closure;
use ZfrShopify\Validator\RequestValidator;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;

class VerifyRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     * @throws \ZfrShopify\Exception\InvalidRequestException
     */
    public function handle($request, Closure $next)
    {
        (new RequestValidator)->validateRequest(
            (new DiactorosFactory)->createRequest($request),
            config('services.shopify.client_secret')
        );

        return $next($request);
    }
}
