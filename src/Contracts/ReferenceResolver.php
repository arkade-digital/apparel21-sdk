<?php

namespace Arkade\Apparel21\Contracts;

use Arkade\Apparel21\Entities;

interface ReferenceResolver
{
    /**
     * Attempt to resolve a reference from the provided IDs.
     *
     * @param  string $typeId
     * @param  string $referenceId
     * @return Entities\Reference|null
     */
    public function resolveFromIds($typeId, $referenceId);
}