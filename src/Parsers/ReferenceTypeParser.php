<?php

namespace Arkade\Apparel21\Parsers;

use SimpleXMLElement;
use Arkade\Apparel21\Entities;

class ReferenceTypeParser
{
    /**
     * Parse the given SimpleXmlElement to a ReferenceType entity.
     *
     * @param  SimpleXMLElement $payload
     * @return Entities\ReferenceType
     */
    public function parse(SimpleXMLElement $payload)
    {
        return (new Entities\ReferenceType)
            ->setId((integer) $payload->Id)
            ->setCode((string) $payload->Code)
            ->setName((string) $payload->Name);
    }
}