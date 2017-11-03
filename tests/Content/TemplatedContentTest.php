<?php

declare(strict_types=1);

namespace PhpEmail\Test\Content;

use PhpEmail\Content\TemplatedContent;
use PhpEmail\Test\TestCase;

/**
 * @covers \PhpEmail\Content\TemplatedContent
 */
class TemplatedContentTest extends TestCase
{
    /**
     * @testdox It should support content with a template ID and data
     */
    public function supportTemplateContent()
    {
        $content = new TemplatedContent('1234', ['key' => 'value']);

        self::assertEquals('1234', $content->getTemplateId());
        self::assertEquals(['key' => 'value'], $content->getTemplateData());
    }
}
