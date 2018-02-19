<?php

namespace Arkade\Apparel21\Serializers;

use Arkade\Apparel21\Entities;
use Illuminate\Support\Facades\Log;

class PersonSerializer
{
    use Concerns\MapContacts, Concerns\MapAddresses, Concerns\MapLoyalties, Concerns\MapAttributes;

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

        // Add the ID & UpdateTimeStamp fields to payload, which are required when sending PUT request
        if ($person->getIdentifiers()->has('ap21_id')) {
            $payload['ID'] = $person->getIdentifiers()->get('ap21_id');
            $payload['UpdateTimeStamp'] = $person->getAttributes()->get('updated_at');
        }else{
            // This is bad, AP21 will return a 403 error if you attempt to set the same
            // loyalty type id twice, so as a hack going to only allow setting of loyalties on create.. :(
            $payload = $this->mapLoyalties($payload, $person->getLoyalties());
        }

        $payload = $this->mapAddresses($payload, $person->getAddresses());
        $payload = $this->mapContacts($payload, $person->getContacts());
        $payload = $this->mapAttributes($payload, $person->getAttributes());

        return $payload;
    }
}