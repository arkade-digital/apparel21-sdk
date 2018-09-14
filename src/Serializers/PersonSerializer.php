<?php

namespace Arkade\Apparel21\Serializers;

use Arkade\Apparel21\Entities;

class PersonSerializer
{
    use Concerns\MapContacts, Concerns\MapAddresses;

    /**
     * Serialize.
     *
     * @param  Entities\Person $person
     * @return string
     */
    public function serialize(Entities\Person $person)
    {
        $payload = new \SimpleXMLElement("<Person></Person>");

        (new XMLHelper)->appendXML(
            $this->buildXMLArray($person),
            $payload
        );

        return (new XMLHelper)->stripHeader($payload->asXML());
    }

    /**
     * Build an array of data to be converted to XML.
     *
     * @param  Entities\Person $person
     * @return array
     */
    protected function buildXMLArray(Entities\Person $person)
    {
        $payload = [
            'Firstname' => $person->getFirstName(),
            'Surname'   => $person->getLastName()
        ];

        $payload = $this->mapContacts($payload, $person->getContacts());
        $payload = $this->mapAddresses($payload, $person->getAddresses());
        $payload = $this->mapLoyalties($payload, $person->getLoyalties());

        return $payload;
    }
}