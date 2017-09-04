<?php

namespace App\Shopify\Middleware;

use Closure;
use App\Shopify;

class CaptureContext
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
        if ($shop = $request->input('shop')) {
            resolve(Shopify\Services\Context::class)->setShopSlug($shop);
        }

        return $next($request);
    }
}
