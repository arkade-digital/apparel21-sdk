<?php

namespace Arkade\Apparel21\Parsers;

use Carbon\Carbon;
use SimpleXMLElement;
use Arkade\Apparel21\Entities;
use Illuminate\Support\Collection;

class StoreParser
{
    /**
     * Parse the given SimpleXmlElement to a Store entity.
     *
     * @param  SimpleXMLElement $payload
     * @return Entities\Store
     */
    public function parse(SimpleXMLElement $payload)
    {
        $store = (new Entities\Store())
            ->setIdentifiers(new Collection([
                'ap21_id'     => (integer) $payload->StoreId,
                'ap21_code' => (string) $payload->Code,
                'store_number' => (integer) $payload->StoreNo
            ]))
            ->setName((string) $payload->Name)
            ->setLine1((string) $payload->Address1)
            ->setLine2((string) $payload->Address2)
            ->setCity((string) $payload->City)
            ->setState((string) $payload->State)
            ->setPostcode((string) $payload->Postcode)
            ->setCountry((string) $payload->Country)
            ->setEmail((string) $payload->Email);

        return $store;
    }
}