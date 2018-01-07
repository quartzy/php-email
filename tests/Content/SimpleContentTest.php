<?php

declare(strict_types=1);

namespace PhpEmail\Test\Content;

use PhpEmail\Content\SimpleContent;
use PhpEmail\Test\TestCase;

/**
 * @covers \PhpEmail\Content\SimpleContent
 * @covers \PhpEmail\Content\SimpleContent\Message
 */
class SimpleContentTest extends TestCase
{
    /**
     * @testdox It should add text to a HTML message
     */
    public function addsTextToHtml()
    {
        $content = SimpleContent::html('<b>Text</b>')
            ->addText('Text');

        self::assertEquals('<b>Text</b>', $content->getHtml()->getBody());
        self::assertEquals('utf-8', $content->getHtml()->getCharset());
        self::assertEquals('Text', $content->getText()->getBody());
        self::assertEquals('utf-8', $content->getText()->getCharset());
    }

    /**
     * @testdox It should add HTML to a text message
     */
    public function addsHtmlToText()
    {
        $content = SimpleContent::text('Text')
            ->addHtml('<b>Text</b>');

        self::assertEquals('<b>Text</b>', $content->getHtml()->getBody());
        self::assertEquals('utf-8', $content->getHtml()->getCharset());
        self::assertEquals('Text', $content->getText()->getBody());
        self::assertEquals('utf-8', $content->getText()->getCharset());
    }

    /**
     * @testdox It should support building text-only content with headers
     */
    public function containsTextOnly()
    {
        $content = SimpleContent::text('Text', 'utf-16');

        self::assertEquals(null, $content->getHtml());
        self::assertEquals('Text', $content->getText()->getBody());
        self::assertEquals('utf-16', $content->getText()->getCharset());
    }

    /**
     * @testdox It should support building html-only content with headers
     */
    public function containsHtmlOnly()
    {
        $content = SimpleContent::html('<b>Text</b>', 'utf-16');

        self::assertEquals(null, $content->getText());
        self::assertEquals('<b>Text</b>', $content->getHtml()->getBody());
        self::assertEquals('utf-16', $content->getHtml()->getCharset());
    }
}
