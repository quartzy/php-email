<?php

declare(strict_types=1);

namespace PhpEmail\Test\Attachment;

use PhpEmail\Attachment\FileAttachment;
use PhpEmail\Test\TestCase;

/**
 * @covers \PhpEmail\Attachment\FileAttachment
 */
class FileAttachmentTest extends TestCase
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
     * @testdox It should create an attachment using a file on the disk
     */
    public function testHandlesLocalFile()
    {
        $attachment = new FileAttachment(self::$file);

        self::assertEquals('text/plain', $attachment->getContentType());
        self::assertEquals('QXR0YWNobWVudCBmaWxl', $attachment->getBase64Content());
        self::assertEquals('Attachment file', $attachment->getContent());
        self::assertEquals('attachment_test.txt', $attachment->getName());
        self::assertEquals('/tmp/attachment_test.txt', $attachment->getFile());
        self::assertEquals(
            '{"file":"\/tmp\/attachment_test.txt","name":"attachment_test.txt"}',
            $attachment->__toString()
        );
    }
}
