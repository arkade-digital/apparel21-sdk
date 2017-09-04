<?php

namespace Arkade\Apparel21\Contracts\Commerce;

use Illuminate\Support\Collection;

interface Variant
{
    /**
     * Return title for variant.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set title for variant.
     *
     * @param  string $title
     * @return static
     */
    public function setTitle($title = null);

    /**
     * Return collection of valued variant options.
     *
     * E.g. Collection(["colour": "Colour", "material": "Material"])
     *
     * @return Collection
     */
    public function getOptions();

    /**
     * Set collection of valued variant options.
     *
     * E.g. Collection(["colour": "Red", "material": "Silk"])
     *
     * @param  Collection $options
     * @return static
     */
    public function setOptions(Collection $options);
}