<?php

namespace Arkade\Apparel21\Entities;

use Arkade\Apparel21\Contracts;
use Arkade\Apparel21\Contracts\Commerce;

class Product implements Commerce\Product, Commerce\HasVariants, Commerce\Identifiable, Commerce\Dated, Contracts\Entity
{
    use Traits\Product, Traits\HasVariants, Traits\Identifiable, Traits\Dated;
}