<?php

namespace Arkade\Apparel21\Entities;

use Arkade\Support\Traits;
use Arkade\Support\Contracts;

class LineItem implements Contracts\LineItem, Contracts\HasAttributes, Contracts\Identifiable
{
    use Traits\LineItem,
        Traits\HasAttributes,
        Traits\Identifiable;

    /**
     * Service type.
     *
     * @var ServiceType
     */
    protected $serviceType;

    /**
     * Status.
     *
     * @var string
     */
    protected $status;

    /**
     * Return service type.
     *
     * @return ServiceType
     */
    public function getServiceType()
    {
        return $this->serviceType;
    }

    /**
     * Set service type.
     *
     * @param  ServiceType $serviceType
     * @return static
     */
    public function setServiceType(ServiceType $serviceType)
    {
        $this->serviceType = $serviceType;

        return $this;
    }

    /**
     * Return status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status.
     *
     * @param  string $status
     * @return static
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}