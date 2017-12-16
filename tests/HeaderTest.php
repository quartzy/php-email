<?php

declare(strict_types=1);

namespace PhpEmail\Test;

use PhpEmail\Header;

/**
 * @covers \PhpEmail\Header
 */
class HeaderTest extends TestCase
{
    /**
     * @testdox It should create a header
     */
    public function createsHeader()
    {
        $header = new Header('X-Test', 'test');

        self::assertEquals('X-Test', $header->getField());
        self::assertEquals('test', $header->getValue());
        self::assertEquals('X-Test: test', $header->__toString());
        self::assertEquals('X-Test: test', $header->toRfc2822());
    }

    /**
     * @testdox It should support creating a header from a string
     */
    public function createsFromString()
    {
        $rfcHeader = Header::fromRfc2822('X-Test: test');
        $header    = Header::fromString('X-Test: test');

        self::assertEquals($header, $rfcHeader);
        self::assertEquals($header->getField(), 'X-Test');
        self::assertEquals($header->getValue(), 'test');
    }
}
