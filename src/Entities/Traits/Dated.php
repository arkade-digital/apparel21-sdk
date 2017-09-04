<?php

namespace Arkade\Apparel21\Entities\Traits;

use Carbon\Carbon;

trait Dated
{
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