<?php

namespace PhpEmail\Test;

use PhpEmail\Address;
use PhpEmail\Content\SimpleContent;
use PhpEmail\Email;

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
        new Email('', SimpleContent::text('hello'), new Address('sender@test.com'), ['hello']);
    }
}
