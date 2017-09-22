<?php

namespace Arkade\Apparel21\Entities;

use Arkade\Support\Traits;
use Arkade\Support\Contracts;

class Store implements Contracts\Identifiable
{
    use Traits\Identifiable;

    /**
     * Name of store.
     *
     * @var string
     */
    protected $name;

    /**
     * Get name of store.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name of store.
     *
     * @param  string $name
     * @return static
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}