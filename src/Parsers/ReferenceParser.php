<?php

namespace Arkade\Apparel21\Parsers;

use SimpleXMLElement;
use Arkade\Apparel21\Entities;

class ReferenceParser
{
    /**
     * Parse the given SimpleXmlElement to a Reference entity.
     *
     * @param  SimpleXMLElement $payload
     * @return Entities\Reference
     */
    public function parse(SimpleXMLElement $payload)
    {
        return (new Entities\Reference)
            ->setId((string) $payload->Id)
            ->setCode((string) $payload->Code)
            ->setName((string) $payload->Name);
    }
}