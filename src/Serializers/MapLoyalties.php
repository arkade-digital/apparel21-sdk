<?php

namespace Omneo\Apparel21\Serializers\Concerns;

use Arkade\Apparel21\Entities;
use Illuminate\Support\Collection;

trait MapLoyalties
{
    /**
     * @param array $payload
     * @param Collection $loyalties
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
     * @param Entities\Loyalty $loyalty
     * @return array
     */
    protected function serializeLoyalty(Entities\Loyalty $loyalty)
    {
        return array_filter([
            '@node'         => 'Loyalty',
            'Id'            => $loyalty->getId(),
            'LoyaltyTypeId' => $loyalty->getLoyaltyTypeId(),
            'LoyaltyType'   => $loyalty->getLoyaltyType(),
            'CardNo'        => $loyalty->getCardNo(),
            'JoinDate'      => $loyalty->getJoinDate()->toDateString(),
        ]);
    }
}