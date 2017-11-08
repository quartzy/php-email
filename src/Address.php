<?php

declare(strict_types=1);

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
    public function __construct(string $email, ?string $name = null)
    {
        Validate::that()
            ->isEmail('email', $email)
            ->now();

        $this->email = $email;
        $this->name  = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Create a RFC 2822 compliant string version of the address.
     *
     * @return string
     */
    public function toRfc2822(): string
    {
        if ($this->getName()) {
            return sprintf('"%s" <%s>', $this->getName(), $this->getEmail());
        }

        return $this->getEmail();
    }

    /**
     * Create an Address from a valid RFC 2822 compliant string.
     *
     * @param string $str
     *
     * @return Address
     */
    public static function fromRfc2822(string $str)
    {
        $parts = explode(' ', $str);

        // Pop the email address off of the parts of the string
        $email = trim(array_pop($parts), '<>');

        $name = null;

        // If there are more parts to the address string, combine them to use as the name
        if ($parts) {
            // Trim any extraneous quotes from the name
            $name = trim(implode(' ', $parts), '"');
        }

        return new static($email, $name);
    }

    /**
     * Create an Address from a string.
     *
     * @param string $str
     *
     * @return Address
     */
    public static function fromString(string $str)
    {
        return self::fromRfc2822($str);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toRfc2822();
    }
}
