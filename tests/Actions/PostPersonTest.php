<?php

namespace Arkade\Apparel21\Actions;

use Arkade\Apparel21\Parsers\PayloadParser;
use PHPUnit\Framework\TestCase;

class PostPersonTest extends TestCase
{
    /**
     * @test
     */
    public function build_request()
    {
        $person = new PostPerson();
        $person->body(
            $body = (new PayloadParser)->parse(
                (file_get_contents(__DIR__.'/../Stubs/Persons/post_person.xml'))
            )
        );

        $request = $person->request();

        $this->assertEquals('Persons', $request->getUri()->getPath());

    }

}