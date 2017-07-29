<?php

namespace PhpEmail\Test;

use PhpEmail\Address;

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
    public function hasToString($email, $name)
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
     * @expectedException \PhpEmail\ValidationException
     */
    public function validatesEmail($email)
    {
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
    public function parsesRfcAddressString($str, $expected)
    {
        self::assertEquals(Address::fromRfc2822($str), $expected);
    }

    public function invalidAddressStrings()
    {
        return [
            [null],
            [123],
            [['test@test.com']],
            ['test@test'],
            ['<test@test.com> Test Tester'],
            [''],
        ];
    }

    /**
     * @testdox It should throw a validation exception if the string is not parsable to an Address
     * @expectedException \PhpEmail\ValidationException
     * @dataProvider invalidAddressStrings
     */
    public function handlesInvalidRfcAddressString($str)
    {
        Address::fromRfc2822($str);
    }
}
