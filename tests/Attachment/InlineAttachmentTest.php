<?php

declare(strict_types=1);

namespace PhpEmail\Test\Attachment;

use PhpEmail\Attachment\FileAttachment;
use PhpEmail\Attachment\InlineAttachment;
use PhpEmail\Test\TestCase;

/**
 * @covers \PhpEmail\Attachment\InlineAttachment
 */
class InlineAttachmentTest extends TestCase
{
    /**
     * @var string
     */
    private static $file = '/tmp/attachment_test.txt';

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        file_put_contents(self::$file, 'Attachment file');
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        unlink(self::$file);
    }

    /**
     * @testdox It should build an inline attachment with a default Content-ID
     */
    public function buildsWithDefaultContentId()
    {
        $attachment = new InlineAttachment(new FileAttachment(self::$file));

        self::assertEquals('attachment_test.txt', $attachment->getCid());
    }

    /**
     * @testdox It should build an inline attachment with a stated Content-ID
     */
    public function buildsWithStatedContentId()
    {
        $attachment = new InlineAttachment(new FileAttachment(self::$file), 'cid:test');

        self::assertEquals('cid:test', $attachment->getCid());
    }

    /**
     * @testdox It should use the attachment information from the nested attachment
     */
    public function usesNestedAttachment()
    {
        $attachment = new InlineAttachment(new FileAttachment(self::$file), 'cid:test');

        self::assertEquals('text/plain', $attachment->getContentType());
        self::assertEquals('QXR0YWNobWVudCBmaWxl', $attachment->getBase64Content());
        self::assertEquals('Attachment file', $attachment->getContent());
        self::assertEquals('attachment_test.txt', $attachment->getName());
        self::assertEquals('/tmp/attachment_test.txt', $attachment->getAttachment()->getFile());
        self::assertEquals(
            '{"cid":"cid:test","attachment":"{\"file\":\"\\\\\/tmp\\\\\/attachment_test.txt\",\"name\":\"attachment_test.txt\"}"}',
            $attachment->__toString()
        );
    }
}
