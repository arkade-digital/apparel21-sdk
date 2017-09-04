<?php

namespace Arkade\Apparel21\Entities\Traits;

use Illuminate\Support\Collection;

trait Identifiable
{
    /**
     * Collection of identifiers.
     *
     * @var Collection
     */
    protected $identifiers;

    /**
     * Return collection of identifiers.
     *
     * @return Collection
     */
    public function getIdentifiers()
    {
        return $this->identifiers ?: $this->identifiers = new Collection;
    }

    /**
     * Set collection of identifiers.
     *
     * @param  Collection $identifiers
     * @return static
     */
    public function setIdentifiers(Collection $identifiers)
    {
        $this->identifiers = $identifiers;

        return $this;
    }
}