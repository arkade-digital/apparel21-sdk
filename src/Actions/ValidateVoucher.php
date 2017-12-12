<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Apparel21\Parsers;
use Arkade\Apparel21\Entities;
use Arkade\Apparel21\Contracts;
use Illuminate\Support\Collection;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ValidateVoucher extends BaseAction implements Contracts\Action
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
     * @var integer
     */
    public $pin;

    /**
     * Amount to be validated in cents.
     * 
     * @var integer
     */
    public $amount;
    
    /**
     * ValidateVoucher constructor.
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
     * Set amount to be validated in cents.
     *
     * @param  integer $amount
     * @return static
     */
    public function amount($amount)
    {
        $this->amount = $amount;
        
        return $this;
    }
    
    /**
     * Build a PSR-7 request.
     *
     * @return RequestInterface
     */
    public function request()
    {
        $request = new GuzzleHttp\Psr7\Request('GET', 'Voucher/GVValid/'.$this->number);
        
        return $request->withUri($request->getUri()->withQuery(http_build_query([
            'pin'    => $this->pin,
            'amount' => $this->amount / 100
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