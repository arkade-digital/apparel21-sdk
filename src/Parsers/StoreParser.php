<?php

namespace Arkade\Apparel21\Parsers;

use Illuminate\Support\Collection;
use SimpleXMLElement;
use Arkade\Apparel21\Entities;

class StoreParser
{
    /**
     * Parse the given SimpleXmlElement to a Store entity.
     *
     * @param  SimpleXMLElement $payload
     * @return Entities\Store $store
     */
    public function parse(SimpleXMLElement $payload)
    {
        return (new Entities\Store)
            ->setIdentifiers(new Collection([
                'store_id' => (string) $payload->attributes()->StoreId
            ]))
            ->setName((string) $payload->attributes()->Name)
            ->setStoreNumber((string) $payload->attributes()->StoreNumber)
            ->setFreestock((string) $payload->attributes()->FreeStock);
    }
}