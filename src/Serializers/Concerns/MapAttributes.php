<?php

namespace Arkade\Apparel21\Serializers\Concerns;

use Illuminate\Support\Collection;

trait MapAttributes
{
    /**
     * Map attributes to given payload array.
     *
     * @param array $payload
     * @param Collection $attributes
     *
     * @return array
     */
    protected function mapAttributes(array $payload, Collection $attributes)
    {
        $payload = array_merge(
            $payload,
            $this->serializeAttributes($attributes)
        );
        return $payload;
    }

    /**
     * Serialize given attribute.
     *
     * @param Collection $attributes
     *
     * @return array
     */
    protected function serializeAttributes(Collection $attributes)
    {
        return array_filter([
            'Title' => $attributes->get('title'),
            'Initials' => $attributes->get('initials'),
            'Sex' => $attributes->get('gender'),
            'DateOfBirth' => $attributes->get('dob'),
            'StartDate' => $attributes->get('join_date'),
            'JobTitle' => $attributes->get('job_title'),
            'Privacy' => $attributes->get('privacy'),
            'IsAgent' => $attributes->get('is_staff'),
        ]);
    }

}