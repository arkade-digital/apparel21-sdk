<?php

namespace Arkade\Apparel21\Parsers;

use SimpleXMLElement;
use Arkade\Apparel21\Entities;

class ProductNoteParser
{
    /**
     * Parse the given SimpleXmlElement to a Note entity.
     *
     * @param  SimpleXMLElement $payload
     * @return Entities\ProductNote
     */
    public function parse(SimpleXMLElement $payload)
    {
        return (new Entities\ProductNote)
            ->setCode((string) $payload->Code)
            ->setName((string) $payload->Name)
            ->setNote((string) $payload->Note);
    }
}