<?php

namespace Arkade\Apparel21\Entities;

class Reference
{
    /**
     * Unique ID.
     *
     * @var string
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
     * Reference type.
     *
     * @var ReferenceType
     */
    protected $type;

    /**
     * Return unique ID.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set unique ID.
     *
     * @param  string $id
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
     * Return reference type.
     *
     * @return ReferenceType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set reference type.
     *
     * @param  ReferenceType|null $type
     * @return static
     */
    public function setType(ReferenceType $type = null)
    {
        $this->type = $type;

        return $this;
    }
}