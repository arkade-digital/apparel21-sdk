<?php

namespace Arkade\Apparel21\Entities;

use Arkade\Support\Traits;
use Arkade\Support\Contracts;

class Variant implements Contracts\Variant, Contracts\Sellable, Contracts\Identifiable, Contracts\HasDates
{
    use Traits\Variant, Traits\Sellable, Traits\Identifiable, Traits\HasDates;
}