<?php

namespace Arkade\Apparel21\Contracts\Commerce;

interface Sellable
{
    /**
     * Return unique SKU identifier.
     *
     * @return string
     */
    public function getSKU();

    /**
     * Set unique SKU identifier.
     *
     * @param  string $sku
     * @return static
     */
    public function setSKU($sku = null);

    /**
     * Return current stock level.
     *
     * @return integer
     */
    public function getStock();

    /**
     * Set current stock level.
     *
     * @param  integer $stock
     * @return static
     */
    public function setStock($stock = null);

    /**
     * Return price as an integer of lowest denomination.
     *
     * Example 3.99 would be represented as 399.
     *
     * @return integer
     */
    public function getPrice();

    /**
     * Set price as an integer of lowest denomination.
     *
     * Example 3.99 would be represented as 399.
     *
     * @param  integer $price
     * @return static
     */
    public function setPrice($price = null);
}