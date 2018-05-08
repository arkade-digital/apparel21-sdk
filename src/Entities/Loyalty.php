<?php

namespace Arkade\Apparel21\Entities;

use Carbon\Carbon;

class Loyalty
{
    /**
     * Type Id
     *
     * @var string
     */
    protected $typeId;

    /**
     * Type Name
     *
     * @var string
     */
    protected $typeName;

    /**
     * Card Number
     *
     * @var string
     */
    protected $cardNumber;

    /**
     * Join Date
     *
     * @var Carbon
     */
    protected $joinDate;

    /**
     * @return string
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * @param string $typeId
     * @return Loyalty
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTypeName()
    {
        return $this->typeName;
    }

    /**
     * @param string $typeName
     * @return Loyalty
     */
    public function setTypeName($typeName)
    {
        $this->typeName = $typeName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * @param string $cardNumber
     * @return Loyalty
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getJoinDate()
    {
        return $this->joinDate;
    }

    /**
     * @param Carbon $joinDate
     * @return Loyalty
     */
    public function setJoinDate(Carbon $joinDate = null)
    {
        $this->joinDate = $joinDate;
        return $this;
    }

}