<?php

namespace Arkade\Apparel21\Entities\Traits;

trait Sellable
{
    /**
     * Unique SKU identifier.
     *
     * @var string
     */
    protected $sku;

    /**
     * Return current stock level.
     *
     * @return integer
     */
    protected $stock;

    /**
     * Price as an integer of lowest denomination.
     *
     * Example 3.99 would be represented as 399.
     *
     * @var integer
     */
    protected $price;

    /**
     * Return unique SKU identifier.
     *
     * @return string
     */
    public function getSKU()
    {
        return $this->sku;
    }

    /**
     * Set unique SKU identifier.
     *
     * @param  string $sku
     * @return static
     */
    public function setSKU($sku = null)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Return current stock level.
     *
     * @return integer
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set current stock level.
     *
     * @param  integer $stock
     * @return static
     */
    public function setStock($stock = null)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Return price as an integer of lowest denomination.
     *
     * Example 3.99 would be represented as 399.
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price as an integer of lowest denomination.
     *
     * Example 3.99 would be represented as 399.
     *
     * @param  integer $price
     * @return static
     */
    public function setPrice($price = null)
    {
        $this->price = $price;

        return $this;
    }
}