<?php

namespace Arkade\Apparel21\Serializers\Concerns;

use Arkade\Apparel21\Entities;
use Illuminate\Support\Collection;

trait MapLoyalties
{
    /**
     * Map loyalties to given payload array.
     *
     * @param  array      $payload
     * @param  Collection $payments
     * @return array
     */
    protected function mapLoyalties(array $payload, Collection $loyalties)
    {
        if($loyalties->count() == 0) return $payload;

        array_set($payload, 'Loyalties', [
            '@attributes' => ['Type' => 'Array'],
        ]);

        $loyalties->each(function (Entities\Loyalty $loyalty) use (&$payload) {
            array_push($payload['Loyalties'], $this->serializeLoyalty($loyalty));
        });

        return $payload;
    }

    /**
     * Serialize given loyalty.
     *
     * @param  Entities\Loyalty $payment
     * @return array
     */
    protected function serializeLoyalty(Entities\Loyalty $loyalty)
    {
        return array_filter([
            '@node'         => 'Loyalty',
            'LoyaltyTypeId' => $loyalty->getTypeId(),
            'LoyaltyType'   => $loyalty->getTypeName(),
            'CardNo'        => $loyalty->getCardNumber(),
            'JoinDate'      => $loyalty->getJoinDate()->toDateString(),
        ]);
    }
}