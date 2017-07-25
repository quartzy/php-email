<?php

namespace PhpEmail\Test\Content;

use PhpEmail\Content\SimpleContent;
use PhpEmail\Test\TestCase;

/**
 * @covers \PhpEmail\Content\SimpleContent
 */
class SimpleContentTest extends TestCase
{
    /**
     * @testdox It should allow for content made up of text and html
     */
    public function containsTextAndHtml()
    {
        $content = new SimpleContent('<b>Text</b>', 'Text');

        self::assertEquals('<b>Text</b>', $content->getHtml());
        self::assertEquals('Text', $content->getText());
    }

    /**
     * @testdox It should support building text-only content
     */
    public function containsTextOnly()
    {
        $content = SimpleContent::text('Text');

        self::assertEquals(null, $content->getHtml());
        self::assertEquals('Text', $content->getText());
    }

    /**
     * @testdox It should support building html-only content
     */
    public function containsHtmlOnly()
    {
        $content = SimpleContent::html('<b>Text</b>');

        self::assertEquals('<b>Text</b>', $content->getHtml());
        self::assertEquals(null, $content->getText());
    }
}
