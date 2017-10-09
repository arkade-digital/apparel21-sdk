<?php

namespace Arkade\Apparel21\Parsers;

use SimpleXMLElement;
use Illuminate\Support\Collection;
use Arkade\Apparel21\Entities\Contact;

class ContactParser
{
    /**
     * Parse a collection of contacts.
     *
     * @param  SimpleXMLElement $xml
     * @return Collection
     */
    public function parseCollection(SimpleXMLElement $xml)
    {
        $collection = collect();

        foreach ($xml->Email as $value) {
            $collection->push((new Contact)->setType('email')->setValue((string) $value));
        }

        foreach ($xml->Phones->Mobile as $value) {
            $collection->push((new Contact)->setType('mobile_phone')->setValue((string) $value));
        }

        foreach ($xml->Phones->Home as $value) {
            $collection->push((new Contact)->setType('home_phone')->setValue((string) $value));
        }

        foreach ($xml->Phones->Work as $value) {
            $collection->push((new Contact)->setType('work_phone')->setValue((string) $value));
        }

        return $collection->reject(function (Contact $contact) {
            return empty($contact->getValue());
        });
    }
}