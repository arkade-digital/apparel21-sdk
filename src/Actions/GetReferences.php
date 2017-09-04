<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Apparel21\Parsers;
use Arkade\Apparel21\Entities;
use Arkade\Apparel21\Contracts;
use Illuminate\Support\Collection;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetReferences extends BaseAction implements Contracts\Action
{
    /**
     * Reference type.
     *
     * @var Entities\ReferenceType
     */
    protected $type;

    /**
     * GetReferences constructor.
     *
     * @param Entities\ReferenceType $type
     */
    public function __construct(Entities\ReferenceType $type)
    {
        $this->type = $type;
    }

    /**
     * Build a PSR-7 request.
     *
     * @return RequestInterface
     */
    public function request()
    {
        return new GuzzleHttp\Psr7\Request('GET', 'References/'.$this->type->getId());
    }

    /**
     * Transform a PSR-7 response.
     *
     * @param  ResponseInterface $response
     * @return Entities\ReferenceType
     */
    public function response(ResponseInterface $response)
    {
        $data = (new Parsers\PayloadParser)->parse((string) $response->getBody());

        $referenceType = (new Entities\ReferenceType)
            ->setId((string) $data->ReferenceTypeId)
            ->setCode((string) $data->ReferenceTypeCode)
            ->setName((string) $data->ReferenceTypeName);

        foreach ($data->References->Reference as $reference) {

            $reference = (new Parsers\ReferenceParser)->parse($reference);

            $referenceType->getReferences()->offsetSet(
                $reference->getId(),
                $reference
            );

        }

        return $referenceType;
    }
}