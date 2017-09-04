<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Apparel21\Parsers;
use Arkade\Apparel21\Contracts;
use Illuminate\Support\Collection;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetReferenceTypes extends BaseAction implements Contracts\Action
{
    /**
     * Build a PSR-7 request.
     *
     * @return RequestInterface
     */
    public function request()
    {
        return new GuzzleHttp\Psr7\Request('GET', 'ReferenceTypes');
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

        foreach ($data->ReferenceType as $type) {
            $collection->push((new Parsers\ReferenceTypeParser)->parse($type));
        }

        return $collection;
    }
}