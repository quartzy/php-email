<?php

declare(strict_types=1);

namespace PhpEmail;

class Header
{
    /**
     * @var string
     */
    private $field;
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $field
     * @param string $value
     */
    public function __construct(string $field, string $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * @param string $header
     *
     * @return Header
     */
    public static function fromRfc2822(string $header): Header
    {
        $parts = explode(':', $header, 2);

        return new static($parts[0], trim($parts[1]));
    }

    /**
     * @param string $header
     *
     * @return Header
     */
    public static function fromString(string $header): Header
    {
        return self::fromRfc2822($header);
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function toRfc2822(): string
    {
        return sprintf('%s: %s', $this->field, $this->value);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toRfc2822();
    }
}
