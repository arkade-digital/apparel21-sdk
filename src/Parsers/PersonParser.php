<?php

namespace Arkade\Apparel21\Parsers;

use SimpleXMLElement;
use Arkade\Apparel21\Entities;
use Illuminate\Support\Collection;

class PersonParser
{
    /**
     * Parse the given SimpleXmlElement to a Person entity.
     *
     * @param  SimpleXMLElement $payload
     * @return Entities\Person
     */
    public function parse(SimpleXMLElement $payload)
    {
        $person = (new Entities\Person)
            ->setIdentifiers(new Collection([
                'ap21_id'   => (string) $payload->Id,
                'ap21_code' => (string) $payload->Code
            ]))
            ->setFirstName((string) $payload->Firstname)
            ->setLastName((string) $payload->Surname)
            ->setAttributes(
                (new Collection([
                    'title'         => (string) $payload->Title,
                    'initials'      => (string) $payload->Initials,
                    'date_of_birth' => (string) $payload->DateOfBirth,
                    'job_title'     => (string) $payload->JobTitle,
                    'start_date'    => (string) $payload->StartDate,
                    'privacy'       => (string) $payload->Privacy,
                    'updated_at'    => (string) $payload->UpdateTimeStamp,
                    'is_agent'      => (string) $payload->IsAgent
                ]))->filter()
            );

        foreach ($payload->Contacts as $contact)
        {
            $person->getContacts()->push(
                (new Entities\Contact)->setType('email')->setValue((string) $contact->Email)
            );

            foreach ($contact->Phones as $phone)
            {
                $person->getContacts()->push(
                    (new Entities\Contact)->setType('mobile_phone')->setValue((string) $phone->Mobile)
                );

                $person->getContacts()->push(
                    (new Entities\Contact)->setType('home_phone')->setValue((string) $phone->Home)
                );

                $person->getContacts()->push(
                    (new Entities\Contact)->setType('work_phone')->setValue((string) $phone->Work)
                );
            }
        }

        // Filter out empty contacts
        $person->setContacts(
            $person
                ->getContacts()
                ->reject(function (Entities\Contact $contact) {
                    return empty($contact->getValue());
                })
        );

        foreach ($payload->Addresses as $address) {
            foreach ($address->Billing as $item) {
                $person->getAddresses()->push(
                    $this->parseAddress($item, 'billing')
                );
            }

            foreach ($address->Delivery as $item) {
                $person->getAddresses()->push(
                    $this->parseAddress($item, 'delivery')
                );
            }
        }

        return $person;
    }

    /**
     * Parse the given address XML.
     *
     * @param  SimpleXMLElement $xml
     * @param  string           $type
     * @return Entities\Address
     */
    protected function parseAddress(SimpleXMLElement $xml, $type = null)
    {
        return (new Entities\Address)
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