<?php

namespace Arkade\Apparel21\Entities;

use Arkade\Support\Traits;
use Arkade\Support\Contracts;

class Order implements Contracts\Order, Contracts\Identifiable
{
    use Traits\Order, Traits\Identifiable;
}