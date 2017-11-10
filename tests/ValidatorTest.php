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
    public function validatesEmail()
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
     * @expectedException \PhpEmail\ValidationException
     * @dataProvider nonEmails
     */
    public function invalidatesNonEmail($value)
    {
        Validate::that()
            ->isEmail('email', $value)
            ->now();
    }

    /**
     * @testdox It should validate that all items in a list are of a specified type
     */
    public function validatesAllInstanceOf()
    {
        Validate::that()
            ->allInstanceOf('instances', [new Address('email@test.com')], Address::class)
            ->now();

        self::assertTrue(true);
    }

    /**
     * @testdox It should throw an error if one of the values is not an instance
     * @expectedException \PhpEmail\ValidationException
     */
    public function invalidatesNonInstance()
    {
        Validate::that()
            ->allInstanceOf('instances', [new Address('email@test.com')], Content::class)
            ->now();
    }

    /**
     * @testdox It should validate that a value has a minimum given length
     */
    public function validatesMinimumLength()
    {
        Validate::that()
            ->hasMinLength('len', 'blah', 4)
            ->now();

        self::assertTrue(true);
    }

    /**
     * @testdox It should throw an error if the length is too short
     * @expectedException \PhpEmail\ValidationException
     */
    public function invalidatesLengthTooShort()
    {
        Validate::that()
            ->hasMinLength('len', 'Blah', 5)
            ->now();
    }

    /**
     * @testdox It should validate that a given path is a file
     */
    public function validatesFile()
    {
        Validate::that()
            ->isFile('file', '/tmp/validate.txt')
            ->now();

        self::assertTrue(true);
    }

    /**
     * @testdox It should throw an error if the file does not exist
     * @expectedException \PhpEmail\ValidationException
     */
    public function invalidatesNonExistingFile()
    {
        Validate::that()
            ->isFile('file', 'blah.txt')
            ->now();
    }

    /**
     * @testdox It should validate that a resource is a stream
     */
    public function validatesStreams()
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
    public function invalidatesNonStream()
    {
        self::expectException(ValidationException::class);

        $shm_key = ftok(__FILE__, 't');
        $shm     = shmop_open($shm_key, 'c', 0644, 100);

        Validate::that()
            ->isStream('shm', $shm)
            ->now();

        shmop_close($shm);
    }

    /**
     * @testdox It should validate an full URL
     */
    public function validatesUrl()
    {
        Validate::that()
            ->isUrl('url', 'http://test.com/test.jpg')
            ->now();

        self::assertTrue(true);
    }

    /**
     * @testdox It should invalidate a partial URL
     */
    public function invalidatesPartialUrl()
    {
        self::expectException(ValidationException::class);

        Validate::that()
            ->isUrl('url', 'test.com/test.jpg')
            ->now();
    }

    /**
     * @testdox It should validate a single property multiple times
     * @expectedException \PhpEmail\ValidationException
     */
    public function validatesPropertyMultipleTimes()
    {
        Validate::that()
            ->isEmail('str', 1234)
            ->hasMinLength('str', 1234, 5)
            ->now();
    }
}
