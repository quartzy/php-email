<?php

declare(strict_types=1);

namespace PhpEmail\Content;

use PhpEmail\Content;
use PhpEmail\Content\SimpleContent\Message;

/**
 * The standard content of an email, as we have always used it. All that is required is some HTML or a text string.
 */
class SimpleContent implements Content\Contracts\SimpleContent
{
    /**
     * @var Message|null
     */
    private $html;

    /**
     * @var Message|null
     */
    private $text;

    /**
     * SimpleContent constructor.
     *
     * @param Message|null $html
     * @param Message|null $text
     */
    public function __construct(?Message $html, ?Message $text)
    {
        $this->html = $html;
        $this->text = $text;
    }

    /**
     * @param string $html
     * @param string $charset
     *
     * @return SimpleContent
     */
    public static function html(string $html, string $charset = Message::DEFAULT_CHARSET): self
    {
        return new self(new Message($html, $charset), null);
    }

    /**
     * @param string $html
     * @param string $charset
     *
     * @return SimpleContent
     */
    public function addHtml(string $html, string $charset = Message::DEFAULT_CHARSET): self
    {
        return new self(new Message($html, $charset), clone $this->text);
    }

    /**
     * @param string $text
     * @param string $charset
     *
     * @return SimpleContent
     */
    public static function text(string $text, string $charset = Message::DEFAULT_CHARSET): self
    {
        return new self(null, new Message($text, $charset));
    }

    /**
     * @param string $text
     * @param string $charset
     *
     * @return SimpleContent
     */
    public function addText(string $text, string $charset = Message::DEFAULT_CHARSET): self
    {
        return new self(clone $this->html, new Message($text, $charset));
    }

    /**
     * @return Message|null
     */
    public function getHtml(): ?Message
    {
        return $this->html;
    }

    /**
     * @return Message|null
     */
    public function getText(): ?Message
    {
        return $this->text;
    }
}
