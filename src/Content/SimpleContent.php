<?php

declare(strict_types=1);

namespace PhpEmail\Content;

use PhpEmail\Content;

/**
 * The standard content of an email, as we have always used it. All that is required is some HTML or a text string.
 */
class SimpleContent implements Content\Contracts\SimpleContent
{
    /**
     * @var string|null
     */
    private $html;

    /**
     * @var string|null
     */
    private $text;

    /**
     * SimpleContent constructor.
     *
     * @param string|null $html
     * @param string|null $text
     */
    public function __construct(?string $html, ?string $text)
    {
        $this->html = $html;
        $this->text = $text;
    }

    /**
     * @param string $html
     *
     * @return SimpleContent
     */
    public static function html(?string $html): self
    {
        return new self($html, null);
    }

    /**
     * @param string $text
     *
     * @return SimpleContent
     */
    public static function text(?string $text): self
    {
        return new self(null, $text);
    }

    /**
     * @return string|null
     */
    public function getHtml(): ?string
    {
        return $this->html;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }
}
