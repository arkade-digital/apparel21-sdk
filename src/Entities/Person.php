<?php

namespace Arkade\Apparel21\Entities;

use Arkade\Support\Traits;
use Arkade\Support\Contracts;

class Person implements Contracts\Person
{
    use Traits\Person,
        Traits\Identifiable;

    public function getAddresses() {
        type: 'billing'
        contactName: 'Dan'
        line1
        line2
        town
        state
        country
        postcode
    }
}