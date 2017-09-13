<?php

namespace Arkade\Apparel21\Entities;

use Arkade\Support\Traits;
use Arkade\Support\Contracts;

class Person implements Contracts\Person
{
    use Traits\Person,
        Traits\Identifiable;
}