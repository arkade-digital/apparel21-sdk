<?php

namespace Arkade\Apparel21\Entities\Traits;

trait Product
{
    /**
     * Human readable name for product.
     *
     * @var string
     */
    protected $name;

    /**
     * Human readable description for product.
     *
     * @var string
     */
    protected $description;

    /**
     * Return human readable name for sellable.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set human readable name for sellable.
     *
     * @param  string $name
     * @return static
     */
    public function setName($name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Return human readable description for sellable.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set human readable description for sellable.
     *
     * @param  string $description
     * @return static
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }
}