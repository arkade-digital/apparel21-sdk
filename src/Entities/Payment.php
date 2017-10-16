<?php

namespace Arkade\Apparel21\Entities;

use Arkade\Support\Traits;
use Arkade\Support\Contracts;

class Payment implements Contracts\Payment, Contracts\Identifiable, Contracts\HasAttributes
{
    use Traits\Payment, Traits\Identifiable, Traits\HasAttributes;
}