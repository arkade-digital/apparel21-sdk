<?php

namespace Arkade\Apparel21\Parsers;

use Carbon\Carbon;
use SimpleXMLElement;
use Arkade\Apparel21\Entities;

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
            ->setIdentifier('ap21_id', (string) $payload->Id)
            ->setIdentifier('ap21_code', (string) $payload->Code)
            ->setName((string) $payload->Name)
            ->setDescription((string) $payload->Description)
            ->setUpdatedAt(Carbon::parse((string) $payload->UpdateTimeStamp));
    }
}