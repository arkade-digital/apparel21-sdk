<?php

namespace Arkade\Apparel21\Parsers;

use Carbon\Carbon;
use Arkade\Support\Contracts;
use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;

class PersonParserTest extends TestCase
{
    /**
     * @test
     */
    public function returns_populated_person_entity()
    {
        $person = (new PersonParser)->parse(
            (new PayloadParser)->parse(file_get_contents(__DIR__.'/../Stubs/Persons/person.xml'))
        );

        $this->assertInstanceOf(Entities\Person::class, $person);
        $this->assertInstanceOf(Contracts\Person::class, $person);

        $this->assertEquals('77284', $person->getIdentifiers()->get('ap21.id'));
        $this->assertEquals('AHWADA00', $person->getIdentifiers()->get('ap21.code'));

        $this->assertEquals('Dan', $person->getFirstName());
        $this->assertEquals('Ahwa', $person->getLastName());
    }

    /**
     * @test
     */
    public function returns_populated_person_with_contacts()
    {
        $person = (new PersonParser)->parse(
            (new PayloadParser)->parse(file_get_contents(__DIR__.'/../Stubs/Persons/person.xml'))
        );

        $this->assertInstanceOf(Collection::class, $person->getContacts());
        $this->assertCount(3, $person->getContacts());
        $this->assertInstanceOf(Entities\Contact::class, $person->getContacts()->first());
        $this->assertInstanceOf(Contracts\Contact::class, $person->getContacts()->first());

        $this->assertEquals('danahwa@example.com', $person->getContacts()->first(function (Entities\Contact $contact) {
            return 'email' == $contact->getType();
        })->getValue());

        $this->assertEquals('0123456789', $person->getContacts()->first(function (Entities\Contact $contact) {
            return 'home_phone' == $contact->getType();
        })->getValue());

        $this->assertEquals('0987654321', $person->getContacts()->first(function (Entities\Contact $contact) {
            return 'work_phone' == $contact->getType();
        })->getValue());

        $this->assertNull($person->getContacts()->first(function (Entities\Contact $contact) {
            return 'mobile_phone' == $contact->getType();
        }));
    }
}