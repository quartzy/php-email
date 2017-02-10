<?php

namespace Postcard;

use Assert\Assert;

class Sender
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @param string      $email
     * @param string|null $name
     *
     * @throws \Assert\LazyAssertionException
     */
    public function __construct($email, $name = null)
    {
        Assert::lazy()
            ->that($email, 'email')->email()
            ->that($name, 'name')->nullOr()->string()
            ->verifyNow();

        $this->email = $email;
        $this->name  = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        return json_encode([
            'email' => $this->email,
            'name'  => $this->name
        ]);
    }
}
