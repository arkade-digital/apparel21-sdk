<?php

namespace Arkade\Apparel21\Entities;

use Illuminate\Support\Collection;

class Colour
{
    /**
     * Unique Code.
     *
     * @var integer
     */
    protected $code;

    /**
     * Human readable name.
     *
     * @var string
     */
    protected $name;

    /**
     * Row number in the given result set
     *
     * @var string
     */
    protected $rowNumber;

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
     * @return string
     */
    public function getRowNumber()
    {
        return $this->rowNumber;
    }

    /**
     * @param integer $rowNumber
     * @return string
     */
    public function setRowNumber($rowNumber = null)
    {
        $this->rowNumber = $rowNumber;

        return $this;
    }
}