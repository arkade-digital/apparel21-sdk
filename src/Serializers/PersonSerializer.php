<?php

namespace Arkade\Apparel21\Serializers;

use Arkade\Apparel21\Entities\Person;
use Arkade\Support;

class PersonSerializer
{
    /**
     * Serialize.
     *
     * @param  Support\Contracts\Person $person
     * @return string
     */
    public function serialize(Support\Contracts\Person $person)
    {
        $payload = new \SimpleXMLElement("<Person></Person>");

        (new XMLHelper)->appendXML(
            $this->buildXMLArray($person),
            $payload
        );

        return $payload->asXML();
    }

    /**
     * Build an array of data to be converted to XML.
     *
     * @param  Support\Contracts\Person $person
     * @return array
     */
    protected function buildXMLArray(Support\Contracts\Person $person)
    {
        $payload = [
            'Firstname' => $person->getFirstName(),
            'Surname' => $person->getLastName()
        ];

        $payload = $this->mapContacts($payload, $person);
        $payload = $this->mapAddresses($payload, $person);

        return $payload;
    }

    protected function mapContacts(array $payload, Support\Contracts\Person $person)
    {
        collect([
            'email'        => 'Contacts.Email',
            'work_phone'   => 'Contacts.Work',
            'home_phone'   => 'Contacts.Home',
            'mobile_phone' => 'Contacts.Mobile',
        ])->each(function ($payloadKey, $contactType) use ($person, &$payload) {

            if ($contact = $person->getContacts()->first(function (Support\Contracts\Contact $contact) use ($contactType) {
                return $contactType === $contact->getType();
            })) {
                array_set($payload, $payloadKey, $contact->getValue());
            }

        });

        return $payload;
    }

    protected function mapAddresses(array $payload, Support\Contracts\Person $person)
    {
        collect([
            'billing'  => 'Addresses.Billing',
            'delivery' => 'Addresses.Delivery',
        ])->each(function ($payloadKey, $addressType) use ($person, &$payload) {

            if ($address = $person->getAddresses()->first(function (Support\Contracts\Address $address) use ($addressType) {
                return $addressType === $address->getType();
            })) {
                array_set($payload, $payloadKey, $this->mapAddress($address));
            }

        });

        return $payload;
    }

    protected function mapAddress(Support\Contracts\Address $address)
    {
        return [
            'AddressLine1' => $address->getLine1(),
            'AddressLine2' => $address->getLine2(),
            'City' => $address->getCity(),
            'State' => $address->getState(),
            'PostCode' => $address->getPostcode(),
            'Country' => $address->getCountry()
        ];
    }
}