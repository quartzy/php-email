<?php

namespace PhpEmail\Test;

use PhpEmail\Recipient;

class RecipientTest extends TestCase
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
        $recipient = new Recipient($email, $name);

        $expectedEmail  = "\"$email\"";
        $expectedName   = $name ? "\"$name\"" : 'null';
        $expectedString = "{\"email\":$expectedEmail,\"name\":$expectedName}";

        self::assertEquals($expectedString, $recipient->__toString());
    }

    public function emails()
    {
        return [
            ['test@test'],
            ['test'],
        ];
    }

    /**
     * @testdox It should validate that the email is acceptable
     * @dataProvider emails
     * @expectedException \Assert\AssertionFailedException
     */
    public function validatesEmail($email)
    {
        new Recipient($email);
    }
}
