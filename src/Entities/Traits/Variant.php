<?php

namespace Arkade\Apparel21\Entities\Traits;

use Illuminate\Support\Collection;

trait Variant
{
    /**
     * Title for variant.
     *
     * @var string
     */
    protected $title;

    /**
     * Collection of valued variant options.
     *
     * E.g. Collection(["colour": "Colour", "material": "Material"])
     *
     * @var Collection
     */
    protected $options;

    /**
     * Return title for variant.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title for variant.
     *
     * @param  string $title
     * @return static
     */
    public function setTitle($title = null)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Return collection of valued variant options.
     *
     * E.g. Collection(["colour": "Colour", "material": "Material"])
     *
     * @return Collection
     */
    public function getOptions()
    {
        return $this->options ?: $this->options = new Collection;
    }

    /**
     * Set collection of valued variant options.
     *
     * E.g. Collection(["colour": "Red", "material": "Silk"])
     *
     * @param  Collection $options
     * @return static
     */
    public function setOptions(Collection $options)
    {
        $this->options = $options;

        return $this;
    }
}