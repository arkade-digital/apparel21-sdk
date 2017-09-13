<?php

namespace Arkade\Apparel21\Parsers;

use Arkade\Apparel21\Entities;
use Illuminate\Support\Collection;
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
        $person = (new Entities\Person)
            ->setIdentifiers(new Collection([
                'ap21.id'   => (string) $payload->Id,
                'ap21.code' => (string) $payload->Code
            ]))
            ->setFirstName((string) $payload->Firstname)
            ->setLastName((string) $payload->Surname);

        foreach ($payload->Contacts as $contact)
        {
            $person->pushContact((new Entities\Contact)->setType('email')->setValue((string) $contact->Email));

            foreach ($contact->Phones as $phone) {
                $person->pushContact((new Entities\Contact)->setType('mobile_phone')->setValue((string) $phone->Mobile));
                $person->pushContact((new Entities\Contact)->setType('home_phone')->setValue((string) $phone->Home));
                $person->pushContact((new Entities\Contact)->setType('work_phone')->setValue((string) $phone->Work));
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
                $person->pushAddress((new Entities\Address)
                    ->setType('billing')
                    ->setContactName((string) $item->ContactName)
                    ->setCompanyName((string) $item->CompanyName)
                    ->setLine1((string) $item->AddressLine1)
                    ->setLine2((string) $item->AddressLine2)
                    ->setCity((string) $item->City)
                    ->setState((string) $item->State)
                    ->setPostalCode((string) $item->Postcode)
                    ->setCountry((string) $item->Country)
                );
            }
        }
        return $person;
    }

}