<?php

namespace Arkade\Apparel21\Contracts\Commerce;

interface Product
{
    /**
     * Return human readable name for product.
     *
     * @return string
     */
    public function getName();

    /**
     * Set human readable name for product.
     *
     * @param  string $name
     * @return static
     */
    public function setName($name = null);

    /**
     * Return human readable description for product.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Set human readable description for product.
     *
     * @param  string $description
     * @return static
     */
    public function setDescription($description = null);
}