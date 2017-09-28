<?php

namespace Arkade\Apparel21\Serializers;

use Arkade\Support\Contracts\Person;

class PersonSerializer extends BaseSerializer
{
    /**
     * Serialize.
     *
     * @param  Person $person
     * @return string
     */
    public function serialize(Person $person)
    {
        $payload = new \SimpleXMLElement("<Person></Person>");

        $payloadArray = [
            'Firstname' => $person->getFirstName(),
            'Surname'   => $person->getLastName()
        ];

        return $this->convert($person, $payload, $payloadArray);
    }
}