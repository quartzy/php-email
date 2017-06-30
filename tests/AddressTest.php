<?php

namespace PhpEmail\Test;

use PhpEmail\Address;

class AddressTest extends TestCase
{
    public function recipients()
    {
        return [
            [
                "test@test.com",
                "Tester TestTest"
            ],
            [
                "test@test.com",
                null
            ]
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
}
