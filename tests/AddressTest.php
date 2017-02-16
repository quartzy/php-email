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

        $expectedEmail  = "\"$email\"";
        $expectedName   = $name ? "\"$name\"" : 'null';
        $expectedString = "{\"email\":$expectedEmail,\"name\":$expectedName}";

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
     * @expectedException \Assert\LazyAssertionException
     */
    public function validatesEmail($email)
    {
        new Address($email);
    }
}
