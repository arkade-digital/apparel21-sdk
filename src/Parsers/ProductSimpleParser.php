<?php

namespace Arkade\Apparel21\Parsers;

use Carbon\Carbon;
use SimpleXMLElement;
use Arkade\Apparel21\Entities;
use Illuminate\Support\Collection;

class ProductSimpleParser
{
    /**
     * Parse the given SimpleXmlElement to a Product entity.
     *
     * @param  SimpleXMLElement $payload
     * @return Entities\Product
     */
    public function parse(SimpleXMLElement $payload)
    {
        return (new Entities\Product)
            ->setIdentifiers(new Collection([
                'ap21_id'   => (string) $payload->Id,
                'ap21_code' => (string) $payload->Code
            ]))
            ->setTitle((string) $payload->Name)
            ->setDescription((string) $payload->Description)
            ->setUpdatedAt(Carbon::parse((string) $payload->UpdateTimeStamp));
    }
}