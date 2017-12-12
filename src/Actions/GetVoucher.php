<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Apparel21\Parsers;
use Arkade\Apparel21\Entities;
use Arkade\Apparel21\Contracts;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetVoucher extends BaseAction implements Contracts\Action
{
    /**
     * Number.
     *
     * @var string
     */
    public $number;

    /**
     * PIN.
     * 
     * @var string
     */
    public $pin;
    
    /**
     * GetVoucher constructor.
     *
     * @param string $number
     */
    public function __construct($number)
    {
        $this->number = $number;
    }

    /**
     * Set PIN.
     *
     * @param  string $pin
     * @return static
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
        $request = new GuzzleHttp\Psr7\Request('GET', 'Voucher/'.$this->number);
        
        return $request->withUri($request->getUri()->withQuery(http_build_query([
            'pin' => $this->pin
        ])));
    }

    /**
     * Transform a PSR-7 response.
     *
     * @param  ResponseInterface $response
     * @return Entities\Voucher
     */
    public function response(ResponseInterface $response)
    {
        return (new Parsers\VoucherParser)->parse(
            (new Parsers\PayloadParser)->parse((string) $response->getBody())
        );
    }
}