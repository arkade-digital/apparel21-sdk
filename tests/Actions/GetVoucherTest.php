<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp\Psr7\Response;
use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;

class GetVoucherTest extends TestCase
{
    /**
     * @test
     */
    public function builds_request()
    {
        $request = (new ValidateVoucher(500012))->pin(123)->request();

        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEquals('/Voucher/GVValid/500012', $request->getUri()->getPath());
        $this->assertEquals('123', $query['pin']);

    }
    
    

    /**
     * @test
     */
    public function response_is_a_voucher_with_validation_id()
    {
        $voucher = (new ValidateVoucher(6000226))->response(
            new Response(200, [], file_get_contents(__DIR__.'/../Stubs/Voucher/get_voucher_success.xml'))
        );
        
        $this->assertInstanceOf(Entities\Voucher::class, $voucher);

    }
}