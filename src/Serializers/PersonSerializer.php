<?php

namespace Arkade\Apparel21\Serializers;

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

        return (new XMLHelper)->stripHeader($payload->asXML());
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
            'Surname'   => $person->getLastName()
        ];

        $payload = $this->mapContacts($payload, $person);
        $payload = $this->mapAddresses($payload, $person);

        return $payload;
    }

    /**
     * Map contacts to given payload array.
     *
     * @param  array $payload
     * @param  Support\Contracts\Person $person
     * @return array
     */
    protected function mapContacts(array $payload, Support\Contracts\Person $person)
    {
        collect([
            'email'        => 'Contacts.Email',
            'work_phone'   => 'Contacts.Phones.Work',
            'home_phone'   => 'Contacts.Phones.Home',
            'mobile_phone' => 'Contacts.Phones.Mobile',
        ])->each(function ($payloadKey, $contactType) use ($person, &$payload) {

            if ($contact = $person->getContacts()->first(function (Support\Contracts\Contact $contact) use ($contactType) {
                return $contactType === $contact->getType();
            })) {
                array_set($payload, $payloadKey, $contact->getValue());
            }

        });

        return $payload;
    }

    /**
     * Map addresses to given payload array.
     *
     * @param  array $payload
     * @param  Support\Contracts\Person $person
     * @return array
     */
    protected function mapAddresses(array $payload, Support\Contracts\Person $person)
    {
        collect([
            'billing'  => 'Addresses.Billing',
            'delivery' => 'Addresses.Delivery',
        ])->each(function ($payloadKey, $addressType) use ($person, &$payload) {

            if ($address = $person->getAddresses()->first(function (Support\Contracts\Address $address) use ($addressType) {
                return $addressType === $address->getType();
            })) {
                array_set($payload, $payloadKey, $this->serializeAddress($address));
            }

        });

        return $payload;
    }

    /**
     * Serialize given address.
     *
     * @param  Support\Contracts\Address $address
     * @return array
     */
    protected function serializeAddress(Support\Contracts\Address $address)
    {
        return [
            'AddressLine1' => $address->getLine1(),
            'AddressLine2' => $address->getLine2(),
            'City'         => $address->getCity(),
            'State'        => $address->getState(),
            'PostCode'     => $address->getPostcode(),
            'Country'      => $address->getCountry()
        ];
    }
}