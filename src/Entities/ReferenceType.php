<?php

namespace Arkade\Apparel21\Entities;

use Illuminate\Support\Collection;

class ReferenceType
{
    /**
     * Unique ID.
     *
     * @var integer
     */
    protected $id;

    /**
     * Unique code.
     *
     * @var string
     */
    protected $code;

    /**
     * Human readable name.
     *
     * @var string
     */
    protected $name;

    /**
     * Collection of references.
     *
     * @var Collection
     */
    protected $references;

    /**
     * Return unique ID.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set unique ID.
     *
     * @param  integer $id
     * @return static
     */
    public function setId($id = null)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Return unique code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set unique code.
     *
     * @param  string $code
     * @return static
     */
    public function setCode($code = null)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Return human readable name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set human readable name.
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
     * Return collection of references.
     *
     * @return Collection
     */
    public function getReferences()
    {
        return $this->references ?: $this->references = new Collection;
    }

    /**
     * Set collection of references.
     *
     * @param  Collection|null $references
     * @return static
     */
    public function setReferences(Collection $references = null)
    {
        $this->references = $references;

        return $this;
    }
}