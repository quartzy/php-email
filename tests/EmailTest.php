<?php

namespace PhpEmail\Test;

use PhpEmail\Content\SimpleContent;
use PhpEmail\Email;
use PhpEmail\Sender;

/**
 * @covers \PhpEmail\Email
 */
class EmailTest extends TestCase
{
    /**
     * @testdox It should validate on construction
     * @expectedException \Assert\LazyAssertionException
     */
    public function validatesOnConstruction()
    {
        new Email('', SimpleContent::text('hello'), new Sender('sender@test.com'), ['hello']);
    }
}
