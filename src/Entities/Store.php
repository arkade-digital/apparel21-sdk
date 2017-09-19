<?php

namespace Arkade\Apparel21\Entities;

use Arkade\Support\Contracts;
use Arkade\Support\Traits;

class Store implements Contracts\Store, Contracts\Identifiable
{
    use Traits\Store;
    use Traits\Identifiable;
}