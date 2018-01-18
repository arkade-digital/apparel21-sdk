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

        $person->setContacts(
            (new ContactParser)->parseCollection($payload->Contacts)
        );

        $person->setAddresses(
            (new AddressParser)->parseCollection($payload->Addresses)
        );

        if($payload->Loyalties) {
            $person->setLoyalties(
                (new LoyaltyParser)->parseCollection($payload->Loyalties)
            );
        }

        return $person;
    }
}