<?php

namespace Arkade\Apparel21\Parsers;

use Carbon\Carbon;
use SimpleXMLElement;
use Arkade\Apparel21\Entities;

class VoucherParser
{
    /**
     * Parse the given SimpleXmlElement to a voucher entity.
     *
     * @param  SimpleXMLElement $payload
     * @return Entities\Voucher
     */
    public function parse(SimpleXMLElement $payload)
    {
        $voucher = (new Entities\Voucher)
            ->setNumber((string) $payload->VoucherNumber)
            ->setExpiryDate(Carbon::parse((string) $payload->ExpiryDate))
            ->setOriginalAmount($this->convertAmountToCents((string) $payload->OriginalAmount))
            ->setUsedAmount($this->convertAmountToCents((string) $payload->UsedAmount))
            ->setAvailableAmount($this->convertAmountToCents((string) $payload->AvailableAmount));

        if ($validationId = (string) $payload->ValidationId) {
            $voucher->setValidationId($validationId);
        }

        return $voucher;
    }

    /**
     * Convert the given amount into a cents integer.
     *
     * Sometimes, AP21 will return an int (like 100) and sometimes a float (like 10.50). This method will properly
     * convert both representations into a cent integer e.g. 10.50 = 1050.
     *
     * @param  string $amount
     * @return integer
     */
    protected function convertAmountToCents($amount)
    {
        return (int) ($amount * 100);
    }
}