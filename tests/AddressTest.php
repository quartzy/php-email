<?php

declare(strict_types=1);

namespace PhpEmail\Test;

use PhpEmail\Address;
use PhpEmail\ValidationException;

class AddressTest extends TestCase
{
    public function recipients()
    {
        return [
            [
                'test@test.com',
                'Tester TestTest',
            ],
            [
                'test@test.com',
                null,
            ],
        ];
    }

    /**
     * @testdox It should create a recipient and convert it to a string
     * @dataProvider recipients
     */
    public function testHasToString($email, $name)
    {
        $recipient = new Address($email, $name);

        $expectedString = $email;

        if ($name) {
            $expectedString = "\"$name\" <$email>";
        }

        self::assertEquals($expectedString, $recipient->__toString());
    }

    public function addresses()
    {
        return [
            ['test@test'],
            ['test'],
        ];
    }

    /**
     * @testdox It should validate that the email is acceptable
     * @dataProvider addresses
     */
    public function testValidatesEmail($email)
    {
        self::expectException(ValidationException::class);

        new Address($email);
    }

    public function addressStrings()
    {
        return [
            ['test@test.com', new Address('test@test.com')],
            ['Test Tester <test@test.com>', new Address('test@test.com', 'Test Tester')],
            ['"Test Tester" <test@test.com>', new Address('test@test.com', 'Test Tester')],
        ];
    }

    /**
     * @testdox It should parse a valid RFC address string to an Address
     * @dataProvider addressStrings
     */
    public function testParsesRfcAddressString($str, $expected)
    {
        self::assertEquals(Address::fromRfc2822($str), $expected);
    }

    public function invalidAddressStrings()
    {
        return [
            ['test@test'],
            ['<test@test.com> Test Tester'],
            [''],
        ];
    }

    /**
     * @testdox It should throw a validation exception if the string is not parsable to an Address
     * @dataProvider invalidAddressStrings
     */
    public function testHandlesInvalidRfcAddressString($str)
    {
        self::expectException(ValidationException::class);

        Address::fromRfc2822($str);
    }

    /**
     * @testdox It should parse a string into an Address
     * @dataProvider addressStrings
     */
    public function testParsesStringToAddress($str, $expected)
    {
        self::assertEquals(Address::fromString($str), $expected);
    }
}
