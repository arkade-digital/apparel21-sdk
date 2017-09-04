<?php

namespace Arkade\Apparel21\Contracts\Commerce;

use Illuminate\Support\Collection;

interface HasVariants
{
    /**
     * Return collection of variants.
     *
     * @return Collection
     */
    public function getVariants();

    /**
     * Set collection of variants.
     *
     * @param  Collection $variants
     * @return static
     */
    public function setVariants(Collection $variants);

    /**
     * Return collection of variant options.
     *
     * E.g. Collection(["colour": "Colour", "material": "Material"])
     *
     * @return mixed
     */
    public function getOptions();

    /**
     * Set collection of variant options.
     *
     * E.g. Collection(["colour": "Colour", "material": "Material"])
     *
     * @param  Collection $options
     * @return mixed
     */
    public function setOptions(Collection $options);
}