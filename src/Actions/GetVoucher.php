<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Apparel21\Parsers;
use Arkade\Apparel21\Contracts;
use Illuminate\Support\Collection;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetVoucher extends BaseAction implements Contracts\Action
{
    /**
     * Apparel21 Voucher Number.
     *
     * @var string
     */
    public $voucherNumber;

    /**
     * pin for particular voucher
     * 
     * @var integer
     */
    public $pin;
    
    /**
     * ValidateVoucher constructor.
     *
     * @param string $voucherNumber
     */
    public function __construct($voucherNumber)
    {
        $this->voucherNumber = $voucherNumber;
    }

    /**
     * @param $pin
     * @return $this
     */
    public function pin($pin) 
    {
        $this->pin = $pin;
        
        return $this;
    }
    
    /**
     * Build a PSR-7 request.
     *
     * @return RequestInterface
     */
    public function request()
    {
        $request = new GuzzleHttp\Psr7\Request('GET', 'Voucher/'.$this->voucherNumber);
        
        return $request->withUri($request->getUri()->withQuery(http_build_query([
            'pin'     => $this->pin,
        ])));
    }

    /**
     * Transform a PSR-7 response.
     *
     * @param  ResponseInterface $response
     * @return Collection
     */
    public function response(ResponseInterface $response)
    {
        $voucher = (new Parsers\PayloadParser)->parse((string) $response->getBody());

        return (new Parsers\VoucherParser())->parse($voucher);
    }
}