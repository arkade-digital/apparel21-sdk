<?php

namespace Arkade\Apparel21\Parsers;

use SimpleXMLElement;
use Arkade\Apparel21\Entities;
use Arkade\Apparel21\Exceptions;
use Illuminate\Support\Collection;

class FreeStockParser
{
    /**
     * Parse the given SimpleXmlElement to a collection of FreeStock entities.
     *
     * @param  SimpleXMLElement $payload
     * @return Collection
     * @throws Exceptions\Apparel21Exception
     */
    public function parse(SimpleXMLElement $payload)
    {
        if ('Style' === $payload->getName()) {
            return $this->parseStyleResponse($payload);
        }

        if ('Clr' === $payload->getName()) {
            return $this->parseClrResponse($payload);
        }

        if ('Sku' === $payload->getName()) {
            return $this->parseSkuResponse($payload);
        }

        throw new Exceptions\Apparel21Exception(sprintf(
            'Unrecognised response lookup root %s',
            $payload->getName()
        ));
    }

    /**
     * Parse a "Style" lookup response.
     *
     * @param  \SimpleXMLElement $payload
     * @return Collection
     */
    protected function parseStyleResponse(\SimpleXMLElement $payload)
    {
        $collection = new Collection;

        foreach ($payload->Clr as $colour) {
            foreach ($colour->Sku as $sku) {
                $this->parseSku($sku, $collection);
            }
        }

        return $collection;
    }

    /**
     * Parse a "Clr" lookup response.
     *
     * @param  \SimpleXMLElement $payload
     * @return Collection
     */
    protected function parseClrResponse(\SimpleXMLElement $payload)
    {
        $collection = new Collection;

        foreach ($payload->Sku as $sku) {
            $this->parseSku($sku, $collection);
        }

        return $collection;
    }

    /**
     * Parse a "Sku" lookup response.
     *
     * @param  \SimpleXMLElement $payload
     * @return Collection
     */
    protected function parseSkuResponse(\SimpleXMLElement $payload)
    {
        return $this->parseSku($payload, $collection = new Collection);
    }

    /**
     * Parse a single SKU.
     *
     * @param  \SimpleXMLElement $payload
     * @param  Collection        $collection
     * @return Collection
     */
    protected function parseSku(\SimpleXMLElement $payload, Collection $collection)
    {
        $variant = tap(new Entities\Variant, function ($variant) use ($payload) {
            $variant->getIdentifiers()->put('ap21_id', (string) $payload['SkuIdx']);
        });

        foreach ($payload->Store as $node) {

            $store = (new Entities\Store)->setName(trim((string) $node['Name']));

            $store->getIdentifiers()
                ->put('ap21_id', (string) $node['StoreId'])
                ->put('ap21_number', (string) $node['StoreNumber']);

            $collection->push(new Entities\FreeStock($variant, $store, (int) $node['FreeStock']));

        }

        return $collection;
    }
}