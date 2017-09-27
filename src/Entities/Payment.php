<?php

namespace Arkade\Apparel21\Entities;

use Arkade\Support\Traits;
use Arkade\Support\Contracts;

class Payment implements Contracts\Payment, Contracts\Identifiable
{
    use Traits\Payment,
        Traits\Identifiable;
}