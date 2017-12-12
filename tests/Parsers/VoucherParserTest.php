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
        $voucher = (new VoucherParser)->parse(
            (new PayloadParser)->parse(file_get_contents(__DIR__.'/../Stubs/Voucher/voucher.xml'))
        );

        $this->assertInstanceOf(Entities\Voucher::class, $voucher);

        $this->assertEquals('6000226', $voucher->getNumber());
        $this->assertEquals('2017-02-17', $voucher->getExpiryDate()->format('Y-m-d'));
        $this->assertEquals(10000, $voucher->getOriginalAmount());
        $this->assertEquals(0, $voucher->getUsedAmount());
        $this->assertEquals(10000, $voucher->getAvailableAmount());
    }
}