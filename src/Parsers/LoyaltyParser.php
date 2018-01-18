<?php

namespace Arkade\Apparel21\Parsers;

use SimpleXMLElement;
use Illuminate\Support\Collection;
use Arkade\Apparel21\Entities\Loyalty;
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

        foreach ($xml->Loyalty as $loyalty) {
            $collection->push(
                $this->parse($loyalty)
            );
        }

        return $collection;
    }

    /**
     * Parse the given loyalty XML.
     *
     * @param  SimpleXMLElement $xml
     * @return Loyalty
     */
    public function parse(SimpleXMLElement $xml)
    {
        return (new Loyalty)
            ->setTypeId((string) $xml->LoyaltyTypeId)
            ->setTypeName((string) $xml->LoyaltyType)
            ->setCardNumber((string) $xml->CardNo)
            ->setJoinDate(Carbon::parse((string) $xml->JoinDate));
    }
}