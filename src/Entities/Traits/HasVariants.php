<?php

namespace Arkade\Apparel21\Entities\Traits;

use Illuminate\Support\Collection;

trait HasVariants
{
    /**
     * Collection of variants.
     *
     * @var Collection
     */
    protected $variants;

    /**
     * Collection of variant options.
     *
     * E.g. Collection(["colour": "Colour", "material": "Material"])
     *
     */
    protected $options;

    /**
     * Return collection of variants.
     *
     * @return Collection
     */
    public function getVariants()
    {
        return $this->variants ?: $this->variants = new Collection;
    }

    /**
     * Set collection of variants.
     *
     * @param  Collection $variants
     * @return static
     */
    public function setVariants(Collection $variants)
    {
        $this->variants = $variants;

        return $this;
    }

    /**
     * Return collection of variant options.
     *
     * E.g. Collection(["colour": "Colour", "material": "Material"])
     *
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options ?: $this->options = new Collection;
    }

    /**
     * Set collection of variant options.
     *
     * E.g. Collection(["colour": "Colour", "material": "Material"])
     *
     * @param  Collection $options
     * @return mixed
     */
    public function setOptions(Collection $options)
    {
        $this->options = $options;

        return $this;
    }
}