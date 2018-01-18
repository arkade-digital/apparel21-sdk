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
            (new PayloadParser)->parse(file_get_contents(__DIR__ . '/../Stubs/Persons/person.xml'))
        );

        $this->assertInstanceOf(Entities\Person::class, $person);
        $this->assertInstanceOf(Contracts\Person::class, $person);

        $this->assertEquals('77284', $person->getIdentifiers()->get('ap21_id'));
        $this->assertEquals('AHWADA00', $person->getIdentifiers()->get('ap21_code'));

        $this->assertEquals('Dan', $person->getFirstName());
        $this->assertEquals('Ahwa', $person->getLastName());
    }

    /**
     * @test
     */
    public function returns_populated_person_with_contacts()
    {
        $person = (new PersonParser)->parse(
            (new PayloadParser)->parse(file_get_contents(__DIR__ . '/../Stubs/Persons/person.xml'))
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

    /**
     * @test
     */
    public function returns_populated_person_with_address()
    {
        $person = (new PersonParser)->parse(
            (new PayloadParser)->parse(file_get_contents(__DIR__ . '/../Stubs/Persons/person.xml'))
        );

        $this->assertInstanceOf(Collection::class, $person->getAddresses());
        $this->assertCount(1, $person->getAddresses());

        $this->assertInstanceOf(Entities\Address::class, $person->getAddresses()->first());
        $this->assertInstanceOf(Contracts\Address::class, $person->getAddresses()->first());

        $this->assertEquals('billing', $person->getAddresses()->first()->getType());
        $this->assertEquals('Dan Ahwa', $person->getAddresses()->first()->getContactName());
        $this->assertEquals('ACME Corp', $person->getAddresses()->first()->getCompanyName());
        $this->assertEquals('123 Springfield Lane', $person->getAddresses()->first()->getLine1());
        $this->assertEquals('', $person->getAddresses()->first()->getLine2());
        $this->assertEquals('Melbourne', $person->getAddresses()->first()->getCity());
        $this->assertEquals('VIC', $person->getAddresses()->first()->getState());
        $this->assertEquals('3000', $person->getAddresses()->first()->getPostcode());
        $this->assertEquals('Australia', $person->getAddresses()->first()->getCountry());
    }

    /**
     * @test
     */
    public function returns_populated_person_with_attributes()
    {
        $person = (new PersonParser)->parse(
            (new PayloadParser)->parse(file_get_contents(__DIR__ . '/../Stubs/Persons/person.xml'))
        );

        $this->assertEquals('Mr', $person->getAttributes()->get('title'));
        $this->assertEquals('DA', $person->getAttributes()->get('initials'));
        $this->assertNull($person->getAttributes()->get('sex'));
        $this->assertNull($person->getAttributes()->get('date_of_birth'));
        $this->assertNull($person->getAttributes()->get('start_date'));
        $this->assertEquals('Stylist', $person->getAttributes()->get('job_title'));
        $this->assertEquals('false', $person->getAttributes()->get('privacy'));
        $this->assertEquals('20/03/2012 10:39:55 AM', $person->getAttributes()->get('updated_at'));
        $this->assertEquals('false', $person->getAttributes()->get('is_agent'));
    }

    /**
     * @test
     */
    public function returns_populated_person_with_loyalties()
    {
        $person = (new PersonParser)->parse(
            (new PayloadParser)->parse(file_get_contents(__DIR__ . '/../Stubs/Persons/person_with_loyalties.xml'))
        );

        $this->assertEquals('1000', $person->getLoyalties()->first()->getTypeId());
        $this->assertEquals('Arkade Loyalty Card', $person->getLoyalties()->first()->getTypeName());
        $this->assertEquals('LM100001', $person->getLoyalties()->first()->getCardNumber());
        $this->assertEquals('2018-01-01', $person->getLoyalties()->first()->getJoinDate()->toDateString());

    }
}