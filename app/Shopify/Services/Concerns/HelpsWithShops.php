<?php

namespace App\Shopify\Services\Concerns;

trait HelpsWithShops
{
    /**
     * Return short version of shop domain.
     *
     * @param  string $shop
     * @return string
     */
    public function shopSlug($shop)
    {
        return str_replace([
            '.myshopify.com', '.myshopify.com/', 'http://', 'https://'
        ], '', $shop);
    }

    /**
     * Return full domain for given shop.
     *
     * @param  string $shop
     * @return string
     */
    public function shopDomain($shop)
    {
        return $this->shopSlug($shop).'.myshopify.com';
    }

    /**
     * Return full URL with protocol for given shop.
     *
     * @param  string $shop
     * @return string
     */
    public function shopUrl($shop)
    {
        return 'https://'.$this->shopDomain($shop);
    }

    /**
     * Return app URL inside shop admin.
     *
     * @param  string $shop
     * @return string
     */
    public function appUrl($shop)
    {
        return $this->shopurl($shop).'/admin/apps/'.config('services.shopify.client_id');
    }
}