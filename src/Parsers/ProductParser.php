<?php

namespace Arkade\Apparel21\Parsers;

use Carbon\Carbon;
use SimpleXMLElement;
use Arkade\Apparel21\Entities;
use Illuminate\Support\Collection;

class ProductParser
{
    /**
     * Parse the given SimpleXmlElement to a Product entity.
     *
     * @param  SimpleXMLElement $payload
     * @return Entities\Product
     */
    public function parse(SimpleXMLElement $payload)
    {
        $product = (new Entities\Product)
            ->setIdentifiers(new Collection([
                'ap21_id'   => (string) $payload->Id,
                'ap21_code' => (string) $payload->Code
            ]))
            ->setOptions(new Collection(['colour' => 'Colour', 'size'   => 'Size']))
            ->setName((string) $payload->Name)
            ->setDescription((string) $payload->Description)
            ->setUpdatedAt(Carbon::parse((string) $payload->UpdateTimeStamp));

        foreach ($payload->Clrs->Clr as $colour) {
            foreach ($colour->SKUs->SKU as $sku) {

                $product->getVariants()->push(
                    (new Entities\Variant)
                        ->setIdentifiers(new Collection([
                            'ap21_colour_id'   => (string) $colour->Id,
                            'ap21_colour_code' => (string) $colour->Code,
                            'ap21_id'          => (string) $sku->Id,
                            'ap21_size_code'   => (string) $sku->SizeCode
                        ]))
                        ->setOptions(new Collection([
                            'colour' => (string) $colour->Name,
                            'size'   => (string) $sku->SizeCode
                        ]))
                        ->setTitle(implode(' - ', [(string) $colour->Name, (string) $sku->SizeCode]))
                        ->setSKU((string) $sku->Barcode)
                        ->setStock((int) $sku->FreeStock)
                        ->setPrice((int) ((float) $sku->Price * 100))
                );

            }
        }

        return $product;
    }
}