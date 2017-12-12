<?php

namespace Arkade\Apparel21\Entities;

use Carbon\Carbon;

class Voucher
{
    /**
     * Number.
     *
     * @var string
     */
    protected $number;

    /**
     * Expiry date.
     *
     * @var Carbon
     */
    protected $expiryDate;

    /**
     * Original amount in cents.
     *
     * @var integer
     */
    protected $originalAmount;

    /**
     * Used amount in cents.
     *
     * @var integer
     */
    protected $usedAmount;

    /**
     * Available amount in cents.
     *
     * @var integer
     */
    protected $availableAmount;

    /**
     * Validation ID.
     *
     * @var string
     */
    protected $validationId;

    /**
     * Return number.
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set number.
     *
     * @param  string $number
     * @return static
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Return expiry date.
     *
     * @return Carbon
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * Set expiry date.
     *
     * @param  Carbon $expiryDate
     * @return static
     */
    public function setExpiryDate(Carbon $expiryDate = null)
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    /**
     * Return original amount in cents.
     *
     * @return integer
     */
    public function getOriginalAmount()
    {
        return $this->originalAmount;
    }

    /**
     * Set original amount in cents.
     *
     * @param  integer $originalAmount
     * @return static
     */
    public function setOriginalAmount($originalAmount)
    {
        $this->originalAmount = $originalAmount;

        return $this;
    }

    /**
     * Return used amount in cents.
     *
     * @return integer
     */
    public function getUsedAmount()
    {
        return $this->usedAmount;
    }

    /**
     * Set used amount in cents.
     *
     * @param  integer $usedAmount
     * @return static
     */
    public function setUsedAmount($usedAmount)
    {
        $this->usedAmount = $usedAmount;

        return $this;
    }

    /**
     * Return available amount in cents.
     *
     * @return integer
     */
    public function getAvailableAmount()
    {
        return $this->availableAmount;
    }

    /**
     * Set available amount in cents.
     *
     * @param  integer $availableAmount
     * @return static
     */
    public function setAvailableAmount($availableAmount)
    {
        $this->availableAmount = $availableAmount;

        return $this;
    }

    /**
     * Return validation ID.
     *
     * @return string
     */
    public function getValidationId()
    {
        return $this->validationId;
    }

    /**
     * Set validation ID.
     *
     * @param  string $validationId
     * @return static
     */
    public function setValidationId($validationId)
    {
        $this->validationId = $validationId;

        return $this;
    }
}