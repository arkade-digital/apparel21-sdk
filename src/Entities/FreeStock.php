<?php

namespace Arkade\Apparel21\Entities;

class FreeStock
{
    /**
     * Variant.
     *
     * @var Variant
     */
    protected $variant;

    /**
     * Store.
     *
     * @var Store
     */
    protected $store;

    /**
     * Free stock.
     *
     * @var integer
     */
    protected $freeStock;

    /**
     * FreeStock constructor.
     *
     * @param Variant $variant
     * @param Store   $store
     * @param integer $freeStock
     */
    public function __construct(Variant $variant, Store $store, $freeStock)
    {
        $this->variant   = $variant;
        $this->store     = $store;
        $this->freeStock = $freeStock;
    }

    /**
     * Get variant.
     *
     * @return Variant
     */
    public function getVariant()
    {
        return $this->variant;
    }

    /**
     * Get store.
     *
     * @return Store
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * Get free stock.
     *
     * @return int
     */
    public function getFreeStock()
    {
        return $this->freeStock;
    }
}