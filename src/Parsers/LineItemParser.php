<?php

namespace Arkade\Apparel21\Parsers;

use SimpleXMLElement;
use Arkade\Apparel21\Entities\Variant;
use Arkade\Apparel21\Entities\LineItem;
use Arkade\Apparel21\Entities\ServiceType;

class LineItemParser
{
    /**
     * Parse the given line item XML.
     *
     * @param  SimpleXMLElement $xml
     * @return LineItem
     */
    public function parse(SimpleXMLElement $xml)
    {
        return (new LineItem)
            ->setIdentifiers(collect([
                'ap21_id' => (integer) $xml->Id
            ]))
            ->setAttributes(collect([
                'gift_wrap'         => 'true' === (string) $xml->GiftWrap,
                'gift_wrap_message' => (string) $xml->GiftWrapMessage,
                'sender_name'       => (string) $xml->SenderName,
                'receiver_name'     => (string) $xml->ReceiverName,
                'carrier'           => (string) $xml->Carrier,
                'carrier_url'       => (string) $xml->CarrierUrl,
                'con_note'          => (string) $xml->ConNote,
            ]))
            ->setServiceType(
                (new ServiceType)->setIdentifiers(collect([
                    'ap21_id'   => (integer) $xml->ServiceType->Id,
                    'ap21_code' => (string) $xml->ServiceType->Code,
                ]))
            )
            ->setQuantity((integer) $xml->Quantity)
	        ->setDiscount((int) ((float) $xml->Discount * 100))
            ->setTotal((int) ((float) $xml->Value * 100))
            ->setStatus((string) $xml->Status)
            ->setSellable(
                (new Variant)
                    ->setIdentifiers(collect([
                        'ap21_product_id'   => (integer) $xml->ProductId,
                        'ap21_product_code' => (string)  $xml->ProductCode,
                        'ap21_colour_id'    => (integer) $xml->ColourId,
                        'ap21_colour_code'  => (string)  $xml->ColourCode,
                        'ap21_sku_id'       => (integer) $xml->SkuId,
                        'ap21_size_code'    => (string)  $xml->SizeCode
                    ]))
                    ->setTitle((string) $xml->ProductName)
                    ->setPrice((int) ((float) $xml->Price * 100))
            );
    }
}