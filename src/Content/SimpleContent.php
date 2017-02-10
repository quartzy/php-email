<?php

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
    public function __construct($html, $text)
    {
        $this->html = $html;
        $this->text = $text;
    }

    /**
     * @param string $html
     *
     * @return self
     */
    public static function html($html)
    {
        return new self($html, null);
    }

    /**
     * @param string $text
     *
     * @return self
     */
    public static function text($text)
    {
        return new self(null, $text);
    }

    /**
     * @return string|null
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * @return string|null
     */
    public function getText()
    {
        return $this->text;
    }
}
