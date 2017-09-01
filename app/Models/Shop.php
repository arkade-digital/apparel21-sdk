<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use Concerns\HasUuid, SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['shopify_updated_at', 'ap21_updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'shopify_scopes' => 'collection'
    ];

    /**
     * Create or update shop by Shopify connection.
     *
     * @param  string $shopSlug
     * @param  string $token
     * @param  array  $scopes
     * @return Shop
     */
    public function connectShopify($shopSlug, $token, array $scopes)
    {
        $shop = static::withTrashed()->where('shopify_slug', $shopSlug)->first() ?: new static;

        $shop->shopify_slug       = $shopSlug;
        $shop->shopify_token      = $token;
        $shop->shopify_scopes     = $scopes;
        $shop->shopify_updated_at = Carbon::now();

        $shop->save();

        if ($shop->trashed()) {
            $shop->restore();
        }

        return $shop;
    }

    /**
     * Return whether or not this shop has AP21 credentials yet.
     *
     * @return bool
     */
    public function hasAp21Credentials()
    {
        return !! $this->ap21_username && !! $this->ap21_password;
    }
}
