<?php

namespace App\Shopify\Services;

use App\Models;

class Context
{
    /**
     * Shopify helper.
     *
     * @var Helper
     */
    protected $helper;

    /**
     * Shop slug.
     *
     * @var string
     */
    protected $shopSlug;

    /**
     * Resolved shop.
     *
     * @var Models\Shop|null
     */
    protected $shop;

    /**
     * AppContext constructor.
     *
     * @param Helper $helper
     */
    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Set shop slug.
     *
     * @param string $shopSlug
     */
    public function setShopSlug($shopSlug)
    {
        $this->shopSlug = $this->helper->shopSlug($shopSlug);
    }

    /**
     * Return shop slug.
     *
     * @return string
     */
    public function getShopSlug()
    {
        return $this->shopSlug;
    }

    /**
     * Return resolved shop.
     *
     * @return string;
     */
    public function getShop()
    {
        if ($this->shop && $this->shop->shopify_slug == $this->shopSlug) {
            return $this->shop;
        }

        return $this->shop = (new Models\Shop)->where('shopify_slug', $this->shopSlug)->first();
    }
}