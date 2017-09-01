<?php

namespace Arkade\Apparel21\Entities;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class Product
{
    /**
     * Collection of identifiers.
     *
     * @var Collection
     */
    protected $identifiers;

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
     * Current stock level.
     *
     * @var integer
     */
    protected $stock;

    /**
     * Created at timestamp.
     *
     * @var Carbon
     */
    protected $createdAt;

    /**
     * Updated at timestamp.
     *
     * @var Carbon
     */
    protected $updatedAt;

    /**
     * Return collection of identifiers.
     *
     * @return Collection
     */
    public function getIdentifiers()
    {
        return $this->identifiers ?: $this->identifiers = new Collection;
    }

    /**
     * Set identifier by key.
     *
     * @param  string $key
     * @param  string $value
     * @return static
     */
    public function setIdentifier($key, $value = null)
    {
        $this->getIdentifiers()->offsetSet($key, $value);

        return $this;
    }

    /**
     * Unset identifier by key.
     *
     * @param  string $key
     * @return static
     */
    public function unsetIdentifier($key)
    {
        $this->getIdentifiers()->offsetUnset($key);

        return $this;
    }

    /**
     * Get identifier by key.
     *
     * @param  string $key
     * @return string
     */
    public function getIdentifier($key)
    {
        return $this->getIdentifiers()->get($key);
    }

    /**
     * Return human readable name for product.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set human readable name for product.
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
     * Return human readable description for product.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set human readable description for product.
     *
     * @param  string $description
     * @return static
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

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
     * Return created at timestamp.
     *
     * @return Carbon
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set created at timestamp.
     *
     * @param  Carbon $createdAt
     * @return static
     */
    public function setCreatedAt(Carbon $createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Return updated at timestamp.
     *
     * @return Carbon
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set updated at timestamp.
     *
     * @param  Carbon $updatedAt
     * @return static
     */
    public function setUpdatedAt(Carbon $updatedAt = null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}