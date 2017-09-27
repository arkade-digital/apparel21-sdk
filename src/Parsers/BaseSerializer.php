<?php

namespace Arkade\Apparel21\Parsers;

use Arkade\Apparel21\Serializers\XMLHelper;
use Arkade\Support\Contracts\Address;
use Arkade\Support\Contracts\Contact;
use SimpleXMLElement;

class BaseSerializer
{

    /**
     * Convert Serialize.
     *
     * @param SimpleXMLElement $payload
     * @param array $payloadArray
     * @param $contract
     *
     * @return string
     */
    public function convert($contract, SimpleXMLElement $payload, array $payloadArray = [])
    {
        (new XMLHelper)->appendXML(
            $this->buildXMLArray($payloadArray, $contract),
            $payload
        );

        return (new XMLHelper)->stripHeader($payload->asXML());
    }

    /**
     * Build an array of data to be converted to XML.
     *
     * @param array $payload
     * @param mixed $contract
     *
     * @return array
     */
    protected function buildXMLArray(array $payload = [], $contract)
    {
        $payload = $this->mapContacts($payload, $contract);
        $payload = $this->mapAddresses($payload, $contract);

        return $payload;
    }

    /**
     * Map contacts to given payload array.
     *
     * @param  array $payload
     * @param  mixed $contract
     * @return array
     */
    protected function mapContacts(array $payload, $contract)
    {
        collect([
            'email'        => 'Contacts.Email',
            'work_phone'   => 'Contacts.Phones.Work',
            'home_phone'   => 'Contacts.Phones.Home',
            'mobile_phone' => 'Contacts.Phones.Mobile',
        ])->each(function ($payloadKey, $contactType) use ($contract, &$payload) {

            if ($contact = $contract->getContacts()->first(function (Contact $contact) use ($contactType) {
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
     * @param  mixed $contract
     *
     * @return array
     */
    protected function mapAddresses(array $payload, $contract)
    {
        collect([
            'billing'  => 'Addresses.Billing',
            'delivery' => 'Addresses.Delivery',
        ])->each(function ($payloadKey, $addressType) use ($contract, &$payload) {

            if ($address = $contract->getAddresses()->first(function (Address $address) use ($addressType) {
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
     * @param Address $address
     *
     * @return array
     */
    protected function serializeAddress(Address $address)
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