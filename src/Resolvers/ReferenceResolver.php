<?php

namespace Arkade\Apparel21\Resolvers;

use Arkade\Apparel21\Client;
use Arkade\Apparel21\Actions;
use Arkade\Apparel21\Entities;
use Arkade\Apparel21\Contracts;
use Arkade\Apparel21\Exceptions;
use Illuminate\Support\Collection;

class ReferenceResolver implements Contracts\ReferenceResolver
{
    /**
     * SDK client.
     *
     * @var Client
     */
    protected $client;

    /**
     * Collection of types for caching purposes.
     *
     * @var Collection
     */
    protected $types;

    /**
     * ReferenceResolver constructor.
     *
     * @param Client          $client
     * @param Collection|null $types
     */
    public function __construct(Client $client, Collection $types = null)
    {
        $this->client = $client;
        $this->types  = $types ?: new Collection;
    }

    /**
     * Attempt to resolve a reference from the provided IDs.
     *
     * @param  string $typeId
     * @param  string $referenceId
     * @return Entities\Reference|null
     */
    public function resolveFromIds($typeId, $referenceId)
    {
        if (! $type = $this->resolveType($typeId)) return null;

        if (! $reference = $type->getReferences()->get($referenceId)) return null;

        // Avoid mutating cached items
        $reference = clone $reference;
        $type      = clone $type;

        $reference->setType($type->setReferences(null));

        return $reference;
    }

    /**
     * Resolve type and references from SDK.
     *
     * @param  string $typeId
     * @return Entities\ReferenceType|null
     */
    protected function resolveType($typeId)
    {
        // Already in cache
        if ($type = $this->resolveTypeFromCache($typeId)) {
            return $type;
        }

        // Fetch type from API
        try {
            $type = $this->client->action(
                new Actions\GetReferences(
                    (new Entities\ReferenceType)->setId($typeId)
                )
            );
        } catch (Exceptions\NotFoundException $e) {
            return null;
        }

        // Save to cache
        $this->persistTypeToCache($type);

        return $type;
    }

    /**
     * Resolve provided type ID from cache.
     *
     * @return Entities\ReferenceType|null
     */
    protected function resolveTypeFromCache($typeId)
    {
        return $this->types->get($typeId);
    }

    /**
     * Persist provided type into the cache.
     *
     * @param Entities\ReferenceType $type
     */
    protected function persistTypeToCache(Entities\ReferenceType $type)
    {
        $this->types->offsetSet($type->getId(), $type);
    }
}