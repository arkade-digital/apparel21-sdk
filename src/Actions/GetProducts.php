<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Carbon\Carbon;
use Arkade\Apparel21\Parsers;
use Arkade\Apparel21\Contracts;
use Illuminate\Support\Collection;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class GetProducts extends BaseAction implements Contracts\Action
{
    /**
     * How many records to skip.
     *
     * @var integer
     */
    public $skip;

    /**
     * How many records to take.
     *
     * @var integer
     */
    public $take;

    /**
     * Timestamp to search updated after.
     *
     * @var Carbon
     */
    public $updatedAfter;

    /**
     * Set how many records to skip.
     *
     * @param  integer $skip
     * @return static
     */
    public function skip($skip)
    {
        $this->skip = $skip;

        return $this;
    }

    /**
     * Set how many records to take.
     *
     * @param  integer $take
     * @return static
     */
    public function take($take)
    {
        $this->take = $take;

        return $this;
    }

    /**
     * Set timestamp to search updated after.
     *
     * @param  Carbon $updatedAfter
     * @return static
     */
    public function updatedAfter(Carbon $updatedAfter)
    {
        $this->updatedAfter = $updatedAfter;

        return $this;
    }

    /**
     * Build a PSR-7 request.
     *
     * @return RequestInterface
     */
    public function request()
    {
        $request = new GuzzleHttp\Psr7\Request('GET', 'ProductsSimple');

        return $request->withUri($request->getUri()->withQuery(http_build_query([
            'startRow'     => $this->skip ? $this->skip + 1 : null,
            'pageRows'     => $this->take,
            'updatedAfter' => $this->updatedAfter ? $this->updatedAfter->format('Y-m-d\TH:i:s') : null
        ])));
    }

    /**
     * Transform a PSR-7 response.
     *
     * @param  ResponseInterface $response
     * @return LengthAwarePaginator|Collection
     */
    public function response(ResponseInterface $response)
    {
        $data = (new Parsers\PayloadParser)->parse((string) $response->getBody());

        $collection = new Collection;

        foreach ($data->ProductSimple as $product) {
            $collection->push((new Parsers\ProductSimpleParser)->parse($product));
        }

        if ($this->take) {
            return new LengthAwarePaginator(
                $collection,
                (int) $data->attributes()->TotalRows,
                $this->take,
                ceil(($this->skip / $this->take) + 1)
            );
        }

        return $collection;
    }
}