<?php

namespace Arkade\Apparel21\Parsers;

use SimpleXMLElement;
use Arkade\Apparel21\Entities\Payment;

class PaymentParser
{
    /**
     * Parse the given payment XML.
     *
     * @param  SimpleXMLElement $xml
     * @return Payment
     */
    public function parse(SimpleXMLElement $xml)
    {
        return (new Payment)
            ->setIdentifiers(collect([
                'ap21_id'          => (integer) $xml->Id,
                'ap21_stan'        => (integer) $xml->Stan,
                'ap21_settlement'  => (integer) $xml->Settlement,
                'ap21_reference'   => (string) $xml->Reference,
                'ap21_merchant_id' => (string) $xml->MerchantId,
                'ap21_account_id'  => (string) $xml->AccountId,
            ]))
            ->setAttributes(collect([
                'card_type' => (string) $xml->CardType,
                'auth_code' => (string) $xml->AuthCode,
                'message'   => (string) $xml->Message,
            ]))
            ->setType((string) $xml->Origin)
            ->setAmount((int) ((float) $xml->Amount * 100));
    }
}