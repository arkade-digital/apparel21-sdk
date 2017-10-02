<?php

namespace Arkade\Apparel21\Parsers;

use Arkade\Apparel21\Entities\Address;
use Arkade\Apparel21\Entities\Contact;
use SimpleXMLElement;

class HelperParser
{
    /**
     * @param $contacts
     * @param $entity
     *
     * @return mixed
     */
    public function parseContactsToEntity($contacts, $entity)
    {
        foreach ($contacts as $contact)
        {
            $entity->getContacts()->push(
                (new Contact)->setType('email')->setValue((string) $contact->Email)
            );

            foreach ($contact->Phones as $phone)
            {
                $entity->getContacts()->push(
                    (new Contact)->setType('mobile_phone')->setValue((string) $phone->Mobile)
                );

                $entity->getContacts()->push(
                    (new Contact)->setType('home_phone')->setValue((string) $phone->Home)
                );

                $entity->getContacts()->push(
                    (new Contact)->setType('work_phone')->setValue((string) $phone->Work)
                );
            }
        }

        // Return filtered out empty contacts
        return $entity->setContacts(
            $entity
                ->getContacts()
                ->reject(function (Contact $contact) {
                    return empty($contact->getValue());
                })
        );
    }

    /**
     * @param $addresses
     * @param $entity
     *
     * @return mixed
     */
    public function parseAddressesToEntity($addresses, $entity)
    {
        foreach ($addresses as $address) {
            foreach ($address->Billing as $item) {
                $entity->getAddresses()->push(
                    $this->parseAddress($item, 'billing')
                );
            }

            foreach ($address->Delivery as $item) {
                $entity->getAddresses()->push(
                    $this->parseAddress($item, 'delivery')
                );
            }
        }

        return $entity;

    }

    /**
     * Parse the given address XML.
     *
     * @param  SimpleXMLElement $xml
     * @param  string $type
     * @return Address
     */
    protected function parseAddress(SimpleXMLElement $xml, $type = null)
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