<?php

namespace Arkade\Apparel21\Parsers;

use Arkade\Apparel21\Entities;
use PHPUnit\Framework\TestCase;

class ProductNoteParserTest extends TestCase
{
    /**
     * @test
     */
    public function returns_populated_note_entity()
    {
        $note = (new ProductNoteParser)->parse(
            (new PayloadParser)->parse(file_get_contents(__DIR__.'/../Stubs/ProductNotes/note.xml'))
        );

        $this->assertInstanceOf(Entities\ProductNote::class, $note);

        $this->assertEquals('ONLINE 3', $note->getCode());
        $this->assertEquals('CARE AND WASHING DETAILS', $note->getName());
        $this->assertEquals('EXAMPLE NOTE', $note->getNote());
    }
}