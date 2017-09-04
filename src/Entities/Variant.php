<?php

namespace Arkade\Apparel21\Entities;

use Arkade\Apparel21\Contracts;
use Arkade\Apparel21\Contracts\Commerce;

class Variant implements Commerce\Variant, Commerce\Sellable, Commerce\Identifiable, Commerce\Dated, Contracts\Entity
{
    use Traits\Variant, Traits\Sellable, Traits\Identifiable, Traits\Dated;
}