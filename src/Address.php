<?php

namespace PhpEmail;

class Address
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
     * Recipient constructor.
     *
     * @param string      $email
     * @param string|null $name
     *
     * @throws ValidationException
     */
    public function __construct($email, $name = null)
    {
        Validate::that()
            ->isEmail('email', $email)
            ->isNullOrString('name', $name)
            ->now();

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

    /**
     * Create a RFC 2822 compliant string version of the address.
     *
     * @return string
     */
    public function toRfc2822()
    {
        if ($this->getName()) {
            return sprintf('"%s" <%s>', $this->getName(), $this->getEmail());
        }

        return $this->getEmail();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toRfc2822();
    }
}
