<?php

namespace Arkade\Apparel21\Parsers;

use Arkade\Apparel21\Entities;
use SimpleXMLElement;

class PersonParser
{
    /**
     * Parse the given SimpleXmlElement to a Person entity.
     *
     * @param SimpleXMLElement $payload
     * @return Entities\Person
     */
    public function parse(SimpleXMLElement $payload)
    {
        //TODO:CARLOS it can be a collection.
        $person = (new Entities\Person)
            ->setEmail((string) $payload->Email)
            ->setFirstName((string) $payload->FirstName)
            ->setLastName((string) $payload->Surname)
        ;

        return $person;
    }

}