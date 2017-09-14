<?php

namespace Arkade\Apparel21\Actions;

use GuzzleHttp;
use Arkade\Apparel21\Parsers;
use Arkade\Apparel21\Entities;
use Arkade\Apparel21\Contracts;
use Illuminate\Support\Collection;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GetProductNotes extends BaseAction implements Contracts\Action
{
    /**
     * Apparel21 product ID.
     *
     * @var string
     */
    protected $id;

    /**
     * GetProductNotes constructor.
     *
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Get Apparel21 product ID.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Build a PSR-7 request.
     *
     * @return RequestInterface
     */
    public function request()
    {
        return new GuzzleHttp\Psr7\Request('GET', 'ProductNotes/'.$this->id);
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

        foreach ($data->ProductNoteType as $note) {
            $collection->push((new Parsers\ProductNoteParser)->parse($note));
        }

        return $collection;
    }
}