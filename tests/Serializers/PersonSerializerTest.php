<?php

namespace Arkade\Apparel21\Serializers;

use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;

class PersonSerializerTest extends TestCase
{
    /**
     * @test
     */
    public function returns_populated_xml()
    {
        $xml = (new PersonSerializer)->serialize($this->build_person());



        $expectedXml = new \SimpleXMLElement(
            file_get_contents(__DIR__.'/../Stubs/Persons/create_person_request.xml')
        );

        dd(str_replace(
            ["\r", "\n"],
            '',
            file_get_contents(__DIR__.'/../Stubs/Persons/create_person_request.xml')
        ));

        dd($expectedXml->asXML());

        $this->assertEquals(
            file_get_contents(__DIR__.'/../Stubs/Persons/create_person_request.xml'),
            $xml
        );
    }

    /**
     * Build an example person entity.
     *
     * @return Entities\Person
     */
    protected function build_person()
    {
        $person = (new Entities\Person)
            ->setFirstName('Bob')
            ->setLastName('Norman');

        $person->getContacts()->push(
            (new Entities\Contact)
                ->setType('email')
                ->setValue('bob.norman@example.com')
        );

        $person->getContacts()->push(
            (new Entities\Contact)
                ->setType('mobile_phone')
                ->setValue('555-625-1199')
        );

        $person->getAddresses()->push(
            (new Entities\Address)->setType('billing')
                ->setLine1('Chestnut Street 92')
                ->setLine2('')
                ->setCity('Louisville')
                ->setState('Kentucky')
                ->setCountry('United States')
                ->setPostcode('40202')
        );

        $person->getAddresses()->push(
            (new Entities\Address)->setType('delivery')
                ->setLine1('Foo bar Street 123')
                ->setLine2('')
                ->setCity('Melbourne')
                ->setState('Victoria')
                ->setCountry('Australia')
                ->setPostcode('3000')
        );

        return $person;
    }
}