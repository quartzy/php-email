<?php

declare(strict_types=1);

namespace PhpEmail\Content\SimpleContent;

class Message
{
    public const DEFAULT_CHARSET = 'utf-8';

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $charset;

    public function __construct(string $body, string $charset = self::DEFAULT_CHARSET)
    {
        $this->body = $body;
        $this->charset = $charset;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getCharset(): string
    {
        return $this->charset;
    }
}
