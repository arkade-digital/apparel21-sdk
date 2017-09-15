<?php

namespace Arkade\Apparel21\Entities;

use Arkade\Support\Traits;
use Arkade\Support\Contracts;
use Illuminate\Support\Collection;

class Product implements Contracts\Product,
    Contracts\HasVariants,
    Contracts\Identifiable,
    Contracts\HasDates,
    Contracts\HasAttributes
{
    use Traits\Product,
        Traits\HasVariants,
        Traits\Identifiable,
        Traits\HasDates,
        Traits\HasAttributes;

    /**
     * Notes collection.
     *
     * @var Collection
     */
    protected $notes;

    /**
     * Get notes collection.
     *
     * @return Collection
     */
    public function getNotes()
    {
        return $this->notes ?: $this->notes = new Collection;
    }

    /**
     * Set notes collection.
     *
     * @param  Collection $notes
     * @return static
     */
    public function setNotes(Collection $notes)
    {
        $this->notes = $notes;

        return $this;
    }
}