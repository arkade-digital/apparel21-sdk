<?php

namespace Arkade\Apparel21\Parsers;

use Carbon\Carbon;
use SimpleXMLElement;
use Arkade\Apparel21\Entities;
use Arkade\Apparel21\Contracts;
use Illuminate\Support\Collection;

class ColourReferencesParser
{
    /**
     * Reference resolver.
     *
     * @var Contracts\ReferenceResolver
     */
    protected $referenceResolver;

    /**
     * Set reference resolver.
     *
     * @param  Contracts\ReferenceResolver|null $referenceResolver
     * @return static
     */
    public function setReferenceResolver(Contracts\ReferenceResolver $referenceResolver = null)
    {
        $this->referenceResolver = $referenceResolver;

        return $this;
    }

    /**
     * Parse the given SimpleXmlElement to a Product entity.
     *
     * @param  SimpleXMLElement $payload
     * @return Entities\Product
     */
    public function parse(SimpleXMLElement $payload)
    {
        $colourReferences = $this->parseReferences($payload->References);;
        return $colourReferences;
    }

    /**
     * Parse references to attributes on product.
     *
     * @param Entities\Product $product
     * @param SimpleXMLElement $payload
     */
    protected function parseReferences(SimpleXMLElement $payload)
    {
        $references = array();
        if (! $this->referenceResolver) return $references;

        foreach ($payload->Reference as $r) {

            $reference = $this->referenceResolver->resolve(
                (integer) $r->Id,
                (integer) $r->ReferenceTypeId
            );



            if ($reference) {
                $type = $reference->getType()->getCode();
                $value = $reference->getName();

                if($type) {
                    $references[$type] = $value;
                }
            }

        }

        return $references;
    }
}