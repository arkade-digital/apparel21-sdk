<?php

namespace Arkade\Apparel21\Entities;

class FreightOption
{
    /**
     * Unique ID.
     *
     * @var integer
     */
    protected $id;

    /**
     * Name.
     *
     * @var string
     */
    protected $name;

    /**
     * Dollar value.
     *
     * @var integer
     */
    protected $value;

    /**
     * Return unique ID.
     *
     * @return int
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
     * Return name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
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
     * Return dollar value.
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set dollar value.
     *
     * @param  integer $value
     * @return static
     */
    public function setValue($value = null)
    {
        $this->value = $value;

        return $this;
    }
}