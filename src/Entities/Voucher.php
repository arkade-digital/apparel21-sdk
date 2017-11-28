<?php

namespace Arkade\Apparel21\Entities;

use Illuminate\Support\Collection;

class Voucher
{
    /**
     * Unique number.
     *
     * @var integer
     */
    protected $voucherNumber;

    /**
     * Human readable date.
     *
     * @var string
     */
    protected $expiryDate;

    /**
     * Original amount voucher created with
     *
     * @var integer
     */
    protected $originalAmount;

    /**
     * Already used amount
     *
     * @var integer
     */
    protected $usedAmount;
    /**
     * amount available to spend
     *
     * @var integer
     */
    protected $availableAmount;

    /**
     * unique validation id
     *
     * @var string
     */
    protected $validationId;

    /**
     * Return unique voucher number.
     *
     * @return string
     */
    public function getVoucherNumber()
    {
        return $this->voucherNumber;
    }

    /**
     * Set unique voucher number.
     *
     * @param null $voucherNumber
     * @return $this
     */
    public function setVoucherNumber($voucherNumber = null)
    {
        $this->voucherNumber = $voucherNumber;

        return $this;
    }

    /**
     * Return human readable date.
     *
     * @return string
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * Set human readable name.
     *
     * @param  string $expiryDate
     * @return static
     */
    public function setExpiryDate($expiryDate = null)
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    /**
     * Return originalAmount.
     *
     * @return string
     */
    public function getOriginalAmount()
    {
        return $this->originalAmount;
    }

    /**
     * Set originalAmount.
     *
     * @param  integer $originalAmount
     * @return string
     */
    public function setOriginalAmount($originalAmount = null)
    {
        $this->originalAmount = $originalAmount;

        return $this;
    }

    /**
     * Return usedAmount.
     *
     * @return string
     */
    public function getUsedAmount()
    {
        return $this->usedAmount;
    }

    /**
     * Set usedAmount.
     *
     * @param  integer $usedAmount
     * @return string
     */
    public function setUsedAmount($usedAmount = null)
    {
        $this->usedAmount = $usedAmount;

        return $this;
    }

    /**
     * Return availableAmount.
     *
     * @return string
     */
    public function getAvailableAmount()
    {
        return $this->availableAmount;
    }

    /**
     * Set originalAmount.
     *
     * @param  integer $availableAmount
     * @return string
     */
    public function setAvailableAmount($availableAmount = null)
    {
        $this->availableAmount = $availableAmount;

        return $this;
    }

    /**
     * Return unique validation id
     *
     * @return string
     */
    public function getValidationId()
    {
        return $this->validationId;
    }

    /**
     * set validation id
     *
     * @param string $validationId
     * @return $this
     */
    public function setValidationId($validationId = null)
    {
        $this->validationId = $validationId;

        return $this;
    }

}