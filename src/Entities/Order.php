<?php

namespace Arkade\Apparel21\Entities;

use Arkade\Support\Traits;
use Arkade\Support\Contracts;

class Order implements Contracts\Order, Contracts\Identifiable
{
    use Traits\Order, Traits\Identifiable;

    /**
     * Freight option.
     *
     * @var FreightOption
     */
    protected $freightOption;

    /**
     * Get freight option.
     *
     * @return FreightOption
     */
    public function getFreightOption()
    {
        return $this->freightOption;
    }

    /**
     * Set freight option.
     *
     * @param  FreightOption $freightOption
     * @return static
     */
    public function setFreightOption(FreightOption $freightOption)
    {
        $this->freightOption = $freightOption;

        return $this;
    }
}