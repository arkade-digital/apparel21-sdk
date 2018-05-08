<?php

namespace Arkade\Apparel21\Factories;

use Arkade\Apparel21\Entities;
use Carbon\Carbon;

class PersonFactory
{
    /**
     * Make a person entity.
     *
     * @return Entities\Person
     */
    public function make()
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
                ->setCity('Louisville')
                ->setState('Kentucky')
                ->setCountry('United States')
                ->setPostcode('40202')
        );

        $person->getAddresses()->push(
            (new Entities\Address)->setType('delivery')
                ->setLine1('Foo bar Street 123')
                ->setCity('Melbourne')
                ->setState('Victoria')
                ->setCountry('Australia')
                ->setPostcode('3000')
        );

        $person->getLoyalties()->push(
            (new Entities\Loyalty)
                ->setTypeId('1000')
                ->setTypeName('Arkade Loyalty Card')
                ->setCardNumber('LM100001')
                ->setJoinDate(Carbon::parse('2018-01-01'))
        );

        return $person;
    }
}