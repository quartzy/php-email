<?php

declare(strict_types=1);

namespace PhpEmail\Test;

use PhpEmail\Address;
use PhpEmail\Content;
use PhpEmail\Validate;
use PhpEmail\ValidationException;

/**
 * @covers \PhpEmail\Validate
 * @covers \PhpEmail\ValidationException
 */
class ValidatorTest extends TestCase
{
    private const TEST_FILE = '/tmp/validate.txt';

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        file_put_contents(self::TEST_FILE, 'test');
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        unlink(self::TEST_FILE);
    }

    /**
     * @testdox It should validate that a value is a valid email address
     */
    public function testValidatesEmail()
    {
        Validate::that()
            ->isEmail('email', 'email@test.com')
            ->now();

        self::assertTrue(true);
    }

    public function nonEmails()
    {
        return [
            ['test@test'],
            ['test'],
        ];
    }

    /**
     * @testdox It should throw an error if the value is not a valid email
     * @dataProvider nonEmails
     */
    public function testInvalidatesNonEmail($value)
    {
        self::expectException(ValidationException::class);

        Validate::that()
            ->isEmail('email', $value)
            ->now();
    }

    /**
     * @testdox It should validate that all items in a list are of a specified type
     */
    public function testValidatesAllInstanceOf()
    {
        Validate::that()
            ->allInstanceOf('instances', [new Address('email@test.com')], Address::class)
            ->now();

        self::assertTrue(true);
    }

    /**
     * @testdox It should throw an error if one of the values is not an instance
     */
    public function testInvalidatesNonInstance()
    {
        self::expectException(ValidationException::class);

        Validate::that()
            ->allInstanceOf('instances', [new Address('email@test.com')], Content::class)
            ->now();
    }

    /**
     * @testdox It should validate that a value has a minimum given length
     */
    public function testValidatesMinimumLength()
    {
        Validate::that()
            ->hasMinLength('len', 'blah', 4)
            ->now();

        self::assertTrue(true);
    }

    /**
     * @testdox It should throw an error if the length is too short
     */
    public function testInvalidatesLengthTooShort()
    {
        self::expectException(ValidationException::class);

        Validate::that()
            ->hasMinLength('len', 'Blah', 5)
            ->now();
    }

    /**
     * @testdox It should validate that a given path is a file
     */
    public function testValidatesFile()
    {
        Validate::that()
            ->isFile('file', self::TEST_FILE)
            ->now();

        self::assertTrue(true);
    }

    /**
     * @testdox It should throw an error if the file does not exist
     */
    public function testInvalidatesNonExistingFile()
    {
        self::expectException(ValidationException::class);

        Validate::that()
            ->isFile('file', 'blah.txt')
            ->now();
    }

    /**
     * @testdox It should validate that a resource is a stream
     */
    public function testValidatesStreams()
    {
        $fh = fopen(self::TEST_FILE, 'r');

        Validate::that()
            ->isStream('fh', $fh)
            ->now();

        self::assertTrue(true);
    }

    /**
     * @testdox It should throw an error if the resource is not a stream
     */
    public function testInvalidatesNonStream()
    {
        self::expectException(ValidationException::class);

        $xml = xml_parser_create();

        Validate::that()
            ->isStream('xml', $xml)
            ->now();
    }

    /**
     * @testdox It should validate an full URL
     */
    public function testValidatesUrl()
    {
        Validate::that()
            ->isUrl('url', 'http://test.com/test.jpg')
            ->now();

        self::assertTrue(true);
    }

    /**
     * @testdox It should invalidate a partial URL
     */
    public function testInvalidatesPartialUrl()
    {
        self::expectException(ValidationException::class);

        Validate::that()
            ->isUrl('url', 'test.com/test.jpg')
            ->now();
    }

    /**
     * @testdox It should validate a single property multiple times
     */
    public function testValidatesPropertyMultipleTimes()
    {
        self::expectException(ValidationException::class);

        Validate::that()
            ->isEmail('str', 1234)
            ->hasMinLength('str', 1234, 5)
            ->now();
    }
}
