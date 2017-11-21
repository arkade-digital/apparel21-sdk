<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Apparel21\Parsers;
use Arkade\Apparel21\Contracts;
use Illuminate\Support\Collection;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ValidateVoucher extends BaseAction implements Contracts\Action
{
    /**
     * Apparel21 Voucher Number.
     *
     * @var string
     */
    public $voucherNumber;

    /**
     * GetPerson constructor.
     *
     * @param string $voucherNumber
     */
    public function __construct($voucherNumber)
    {
        $this->voucherNumber = $voucherNumber;
    }
    /**
     * Build a PSR-7 request.
     *
     * @return RequestInterface
     */
    public function request()
    {
        return new GuzzleHttp\Psr7\Request('GET', '/Voucher/GVValid/'.$this->voucherNumber);
    }

    /**
     * Transform a PSR-7 response.
     *
     * @param  ResponseInterface $response
     * @return Collection
     */
    public function response(ResponseInterface $response)
    {
        $data = (new Parsers\PayloadParser)->parse((string) $response->getBody());

        $collection = new Collection;

        $collection->push((new Parsers\VoucherParser())->parse($data->Voucher));

        return $collection;
    }
}