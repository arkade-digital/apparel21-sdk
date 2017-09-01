<?php

namespace App\Shopify\Services\Concerns;

use Lcobucci\JWT;
use Illuminate\Support\Str;

trait HelpsWithAuth
{
    /**
     * Return array of Shopify API scopes.
     *
     * @return array
     */
    public function getScopes()
    {
        return [
            'read_products',  'write_products',
            'read_customers', 'write_customers',
            'read_orders',    'write_orders'
        ];
    }

    /**
     * Return explicit Shopify API scopes.
     *
     * As "write" scopes implicitly include "read" scopes, only "write" scopes are returned as being included in a
     * Shopify token. Here, we only return the "explicit" scopes for the check to work.
     *
     * @return array
     */
    public function getExplicitScopes()
    {
        return ['write_products', 'write_customers', 'write_orders'];
    }

    /**
     * Generate a nonce for the given shop.
     *
     * @param  string $shop
     * @return string
     */
    public function generateNonce($shop)
    {
        $token = (string) (new JWT\Builder)
            ->set('sub', $shop)
            ->sign(new JWT\Signer\Hmac\Sha256, $this->getNonceSecret())
            ->getToken();

        return implode('.', [
            explode('.', $token)[1],
            explode('.', $token)[2]
        ]);
    }

    /**
     * Verify the provided nonce.
     *
     * @param  string $nonce
     * @param  string $shop
     * @return bool
     */
    public function verifyNonce($nonce, $shop)
    {
        // Reattach header is required.
        if (3 !== count(explode('.', $nonce))) {
            $nonce = $this->getNonceHeader().'.'.$nonce;
        }

        // Parse JWT token.
        try {
            $token = (new JWT\Parser)->parse($nonce);
        } catch (\RuntimeException $e) {
            return false;
        }

        return
            $shop == $token->getClaim('sub')
            && $token->verify(new JWT\Signer\Hmac\Sha256, $this->getNonceSecret());
    }

    /**
     * Get JWT header for nonce.
     *
     * @return string
     */
    public function getNonceHeader()
    {
        $encoder = new JWT\Parsing\Encoder;
        return $encoder->base64UrlEncode($encoder->jsonEncode(['typ' => 'JWT', 'alg' => 'HS256']));
    }

    /**
     * Return decoded nonce secret bytes.
     *
     * @return string
     */
    public function getNonceSecret()
    {
        if (Str::startsWith($key = config('app.key'), 'base64:')) {
            return base64_decode(substr($key, 7));
        }

        return $key;
    }
}