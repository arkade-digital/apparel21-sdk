<?php

namespace Arkade\Apparel21\Entities;

use Arkade\Support\Traits;
use Arkade\Support\Contracts;

class Store implements Contracts\Identifiable
{
    use Traits\Identifiable;

    /**
     * Name of store.
     *
     * @var string
     */
    protected $name;

    /**
     * Email of store.
     *
     * @var string
     */
    protected $email;

    /**
     * Address line 1 of store.
     *
     * @var string
     */
    protected $line1;

    /**
     * Address line 2 of store.
     *
     * @var string
     */
    protected $line2;

    /**
     * City of store.
     *
     * @var string
     */
    protected $city;

    /**
     * State of store.
     *
     * @var string
     */
    protected $state;

    /**
     * Postcode of store.
     *
     * @var string
     */
    protected $postcode;

    /**
     * Country of store.
     *
     * @var string
     */
    protected $country;

    /**
     * Get name of store.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name of store.
     *
     * @param  string $name
     * @return static
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getLine1()
    {
        return $this->line1;
    }

    /**
     * @param string $line1
     * @return Store
     */
    public function setLine1($line1)
    {
        $this->line1 = $line1;
        return $this;
    }

    /**
     * @return string
     */
    public function getLine2()
    {
        return $this->line2;
    }

    /**
     * @param string $line2
     * @return Store
     */
    public function setLine2($line2)
    {
        $this->line2 = $line2;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Store
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return Store
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param string $postcode
     * @return Store
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return Store
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Get email of store.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email of store.
     *
     * @param  string $email
     * @return static
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}