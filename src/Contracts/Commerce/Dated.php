<?php

namespace Arkade\Apparel21\Contracts\Commerce;

use Carbon\Carbon;

interface Dated
{
    /**
     * Return created at timestamp.
     *
     * @return Carbon
     */
    public function getCreatedAt();

    /**
     * Set created at timestamp.
     *
     * @param  Carbon $createdAt
     * @return static
     */
    public function setCreatedAt(Carbon $createdAt = null);

    /**
     * Return updated at timestamp.
     *
     * @return Carbon
     */
    public function getUpdatedAt();

    /**
     * Set updated at timestamp.
     *
     * @param  Carbon $updatedAt
     * @return static
     */
    public function setUpdatedAt(Carbon $updatedAt = null);
}