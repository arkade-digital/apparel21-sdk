<?php

namespace Arkade\Apparel21\Entities;

use Arkade\Support\Traits;
use Arkade\Support\Contracts;

class Order implements Contracts\Order, Contracts\Identifiable, Contracts\HasVariants
{
    use Traits\Order,
        Traits\Identifiable,
        Traits\HasVariants;

}