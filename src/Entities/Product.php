<?php

namespace Arkade\Apparel21\Entities;

use Arkade\Support\Traits;
use Arkade\Support\Contracts;

class Product implements Contracts\Product, Contracts\HasVariants, Contracts\Identifiable, Contracts\HasDates
{
    use Traits\Product, Traits\HasVariants, Traits\Identifiable, Traits\HasDates;
}