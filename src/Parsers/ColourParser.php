<?php

namespace Arkade\Apparel21\Parsers;

use SimpleXMLElement;
use Arkade\Apparel21\Entities;

class ColourParser
{
    /**
     * Parse the given SimpleXmlElement to a Colour entity.
     *
     * @param  SimpleXMLElement $payload
     * @return Entities\Colour
     */
    public function parse(SimpleXMLElement $payload)
    {
        return (new Entities\Colour)
            ->setCode((string) $payload->Code)
            ->setName((string) $payload->Name)
            ->setRowNumber((integer) $payload->RowNumber);
    }
}