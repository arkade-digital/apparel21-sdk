<?php

namespace Arkade\Apparel21\Parsers;

use SimpleXMLElement;
use Arkade\Apparel21\Entities;

class VoucherParser
{
    /**
     * Parse the given SimpleXmlElement to a Colour entity.
     *
     * @param  SimpleXMLElement $payload
     * @return Entities\Colour
     */
    public function parse(SimpleXMLElement $payload)
    {
        return (new Entities\Voucher)
            ->setVoucherNumber((integer) $payload->VoucherNumber)
            ->setExpiryDate((string) $payload->ExpiryDate)
            ->setOriginalAmount((integer) $payload->OriginalAmount)
            ->setUsedAmount((integer) $payload->UsedAmount)
            ->setAvailableAmount((integer)$payload->AvailableAmount)
            ->setValidationId((string) $payload->ValidationId);
        
    }
}