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
     * Resolve reference by ID.
     *
     * @param  integer $referenceId
     * @param  integer $referenceTypeId
     * @return Entities\Reference|null
     */
    public function resolve($referenceId, $referenceTypeId)
    {
        if ($reference = $this->resolveFromCache($referenceId, $referenceTypeId)) {
            return $reference;
        }

        if (! $referenceType = $this->fetchReferenceType($referenceTypeId)) {
            return null;
        }

        $this->writeToCache($referenceType);

        return optional($referenceType->getReferences()->get($referenceId))->setType($referenceType);
    }

    /**
     * Fetch reference type from API.
     *
     * @param  integer $referenceTypeId
     * @return Entities\ReferenceType|null
     */
    protected function fetchReferenceType($referenceTypeId)
    {
        try {
            return $this->client->action(
                new Actions\GetReferences(
                    (new Entities\ReferenceType)->setId($referenceTypeId)
                )
            );
        } catch (Exceptions\NotFoundException $e) {
            return null;
        }
    }

    /**
     * Resolve type from cache.
     *
     * @param  integer $referenceId
     * @param  integer $referenceTypeId
     * @return Entities\Reference|null
     */
    protected function resolveFromCache($referenceId, $referenceTypeId)
    {
        if (! $type = $this->types->get($referenceTypeId)) {
            return null;
        }

        return optional($type->getReferences()->get($referenceId))->setType($type);
    }

    /**
     * Write type to cache.
     *
     * @param  Entities\ReferenceType $referenceType
     * @return void
     */
    protected function writeToCache(Entities\ReferenceType $referenceType)
    {
        $this->types->put($referenceType->getId(), $referenceType);
    }
}