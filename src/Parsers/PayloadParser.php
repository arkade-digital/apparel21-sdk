<?php

namespace Arkade\Apparel21\Parsers;

use SimpleXMLElement;

class PayloadParser
{
    /**
     * Parse the given XML payload to a SimpleXmlElement.
     *
     * @param  string $payload
     * @return SimpleXMLElement
     */
    public function parse($payload)
    {
        return new SimpleXMLElement($payload);
    }
}