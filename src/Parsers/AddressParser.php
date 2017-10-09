<?php

namespace Arkade\Apparel21\Parsers;

use SimpleXMLElement;
use Illuminate\Support\Collection;
use Arkade\Apparel21\Entities\Address;

class AddressParser
{
    /**
     * Parse a collection of addresses.
     *
     * @param  SimpleXMLElement $xml
     * @return Collection
     */
    public function parseCollection(SimpleXMLElement $xml)
    {
        $collection = collect();

        foreach ($xml->Billing as $address) {
            $collection->push(
                $this->parse($address, 'billing')
            );
        }

        foreach ($xml->Delivery as $address) {
            $collection->push(
                $this->parse($address, 'delivery')
            );
        }

        return $collection;
    }

    /**
     * Parse the given address XML.
     *
     * @param  SimpleXMLElement $xml
     * @param  string           $type
     * @return Address
     */
    public function parse(SimpleXMLElement $xml, $type = null)
    {
        return (new Address)
            ->setType($type)
            ->setContactName((string) $xml->ContactName)
            ->setCompanyName((string) $xml->CompanyName)
            ->setLine1((string) $xml->AddressLine1)
            ->setLine2((string) $xml->AddressLine2)
            ->setCity((string) $xml->City)
            ->setState((string) $xml->State)
            ->setPostcode((string) $xml->Postcode)
            ->setCountry((string) $xml->Country);
    }
}