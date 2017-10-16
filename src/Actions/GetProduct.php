<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Apparel21\Parsers;
use Arkade\Apparel21\Entities;
use Arkade\Apparel21\Contracts;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetProduct extends BaseAction implements Contracts\Action
{
    /**
     * Apparel21 product ID.
     *
     * @var string
     */
    public $id;

    /**
     * Implicitly fetch references for product.
     *
     * @var bool
     */
    public $withReferences = true;

    /**
     * Implicitly fetch notes for product.
     *
     * @var bool
     */
    public $withNotes = false;

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
     * Implicitly fetch references for product.
     *
     * @return static
     */
    public function withReferences()
    {
        $this->withReferences = true;

        return $this;
    }

    /**
     * Do not implicitly fetch references for product.
     *
     * @return static
     */
    public function withoutReferences()
    {
        $this->withReferences = false;

        return $this;
    }

    /**
     * Implicitly fetch notes for product.
     *
     * @return static
     */
    public function withNotes()
    {
        $this->withNotes = true;

        return $this;
    }

    /**
     * Do not implicitly fetch notes for product.
     *
     * @return static
     */
    public function withoutNotes()
    {
        $this->withNotes = false;

        return $this;
    }

    /**
     * Build a PSR-7 request.
     *
     * @return RequestInterface
     */
    public function request()
    {
        return new GuzzleHttp\Psr7\Request('GET', 'Products/'.$this->id);
    }

    /**
     * Transform a PSR-7 response.
     *
     * @param  ResponseInterface $response
     * @return Entities\Product
     */
    public function response(ResponseInterface $response)
    {
        $parser = new Parsers\ProductParser;

        // Implicitly fetch references
        if ($this->client && $this->withReferences) {
            $parser->setReferenceResolver(
                $this->client->getReferenceResolver()
            );
        }

        $product = $parser->parse(
            (new Parsers\PayloadParser)->parse((string) $response->getBody())
        );

        // Implicitly fetch notes
        if ($this->client && $this->withNotes) {
            $product->setNotes(
                $this->client->action(new GetProductNotes($this->id))
            );
        }

        return $product;
    }
}