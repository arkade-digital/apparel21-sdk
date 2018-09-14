<?php

namespace Arkade\Apparel21\Parsers;

use Arkade\Apparel21\Entities\Loyalty;
use SimpleXMLElement;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class LoyaltyParser
{
    /**
     * Parse a collection of loyalties.
     *
     * @param  SimpleXMLElement $xml
     * @return Collection
     */
    public function parseCollection(SimpleXMLElement $xml)
    {
        $collection = collect();

        if(!$xml->Loyalty || $xml->Loyalty->count() == 0) return $collection;

        foreach ($xml->Loyalty as $loyalty) {
            $collection->push(
                $this->parse($loyalty)
            );
        }

        return $collection;
    }


    public function parse(SimpleXMLElement $xml)
    {
        return (new Loyalty())
            ->setId((string) $xml->Id)
            ->setLoyaltyTypeId((string) $xml->LoyaltyTypeId)
            ->setLoyaltyType((string) $xml->LoyaltyType)
            ->setCardNo((string) $xml->CardNo)
            ->setJoinDate(Carbon::parse((string) $xml->JoinDate));
    }
}