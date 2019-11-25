<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Apparel21\Parsers;
use Arkade\Apparel21\Entities;
use Arkade\Apparel21\Contracts;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetColourReferences extends BaseAction implements Contracts\Action
{
    /**
     * Apparel21 colour ID.
     *
     * @var string
     */
    public $id;

    /**
     * GetProduct constructor.
     *
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Build a PSR-7 request.
     *
     * @return RequestInterface
     */
    public function request()
    {
        return new GuzzleHttp\Psr7\Request('GET', 'ProductColourReferences/'.$this->id);
    }

    /**
     * Transform a PSR-7 response.
     *
     * @param  ResponseInterface $response
     * @return Entities\Product
     */
    public function response(ResponseInterface $response)
    {
        $parser = new Parsers\ColourReferencesParser();

        // Implicitly fetch references
        if ($this->client) {
            $parser->setReferenceResolver(
                $this->client->getReferenceResolver()
            );
        }

        $colourReferences = $parser->parse(
            (new Parsers\PayloadParser)->parse((string) $response->getBody())
        );

        return $colourReferences;
    }
}