<?php

declare(strict_types=1);

namespace PhpEmail\Test;

use PhpEmail\Address;
use PhpEmail\Content;
use PhpEmail\Validate;

/**
 * @covers \PhpEmail\Validate
 * @covers \PhpEmail\ValidationException
 */
class ValidatorTest extends TestCase
{
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
        file_put_contents('/tmp/validate.txt', 'test');

        Validate::that()
            ->isFile('file', '/tmp/validate.txt')
            ->now();

        self::assertTrue(true);

        unlink('/tmp/validate.txt');
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
