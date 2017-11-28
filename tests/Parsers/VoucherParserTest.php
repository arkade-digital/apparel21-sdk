<?php

namespace Arkade\Apparel21\Parsers;

use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;

class VoucherParserTest extends TestCase
{
    /**
     * @test
     */
    public function returns_populated_voucher()
    {
        $voucher = (new VoucherParser())->parse(
            (new PayloadParser)->parse(file_get_contents(__DIR__.'/../Stubs/Voucher/voucher.xml'))
        );

        $this->assertInstanceOf(Entities\Voucher::class, $voucher);

        $this->assertEquals(6000226, $voucher->getVoucherNumber());
        $this->assertEquals('2017-02-17T00:00:00', $voucher->getExpiryDate());
        $this->assertEquals(100, $voucher->getOriginalAmount());
        $this->assertEquals(0, $voucher->getUsedAmount());
        $this->assertEquals(100, $voucher->getAvailableAmount());

    }
}