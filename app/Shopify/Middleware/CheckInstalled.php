<?php

namespace App\Shopify\Middleware;

use Closure;
use App\Shopify;

class CheckInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $context = resolve(Shopify\Services\Context::class);

        // Shop cannot be resolved
        if (! $context->getShop()) {
            return redirect()->to('shopify/install?shop='.$context->getShopSlug());
        }

        return $next($request);
    }
}
