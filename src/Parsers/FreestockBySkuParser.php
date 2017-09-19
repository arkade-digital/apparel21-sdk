<?php

namespace Arkade\Apparel21\Parsers;

use Illuminate\Support\Collection;
use SimpleXMLElement;
use Arkade\Apparel21\Entities;

class FreestockBySkuParser
{

    /**
     * Parse the given SimpleXmlElement to a FreestockBySku entity.
     *
     * @param  SimpleXMLElement $payload
     * @return Entities\FreestockBySku
     */
    public function parse(SimpleXMLElement $payload)
    {
        $freestockBySku = (new Entities\FreestockBySku)
            ->setIdentifiers(new Collection([
                    'sku_id' => (string) $payload->SkuIdx
                ])
            )->setSkuName((string) $payload->Name);

        foreach ($payload->Stores as $store) {
            foreach ($store->Store as $singleStore) {
                $freestockBySku->getStores()->push(
                    (new Entities\Store)
                        ->setName($singleStore->Name)
                        ->setIdentifiers(new Collection([
                            'store_id' => $singleStore->StoreId
                        ]))
                        ->setStoreNumber($singleStore->StoreNumber)
                        ->setFreestock($singleStore->FreeStock)
                );
            }
        }
        return $freestockBySku;
    }
}