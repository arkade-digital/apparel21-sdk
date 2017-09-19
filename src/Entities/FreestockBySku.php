<?php

namespace Arkade\Apparel21\Entities;

use Arkade\Support\Contracts;
use Arkade\Support\Traits;

class FreestockBySku implements Contracts\FreestockBySku, Contracts\Identifiable
{
    use Traits\FreestockBySku;
    use Traits\Identifiable;
}