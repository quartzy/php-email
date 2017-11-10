<?php

declare(strict_types=1);

namespace PhpEmail\Test\Attachment;

use PhpEmail\Attachment\FileAttachment;
use PhpEmail\Attachment\ResourceAttachment;
use PhpEmail\Test\TestCase;

/**
 * @covers \PhpEmail\Attachment\ResourceAttachment
 */
class ResourceAttachmentTest extends TestCase
{
    /**
     * @var string
     */
    private static $file = '/tmp/attachment_test.txt';

    /**
     * @var resource
     */
    private $resource;

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

    public function setUp()
    {
        parent::setUp();

        $this->resource = fopen(self::$file, 'r');
    }

    public function tearDown()
    {
        parent::tearDown();

        fclose($this->resource);
    }

    /**
     * @testdox It should create an attachment using a file on the disk
     */
    public function handlesLocalFile()
    {
        $attachment = new ResourceAttachment($this->resource);

        self::assertEquals('text/plain', $attachment->getContentType());
        self::assertEquals('QXR0YWNobWVudCBmaWxl', $attachment->getBase64Content());
        self::assertEquals('Attachment file', $attachment->getContent());
        self::assertEquals('attachment_test.txt', $attachment->getName());
        self::assertEquals($this->resource, $attachment->getResource());
        self::assertEquals(
            '{"uri":"\/tmp\/attachment_test.txt","name":"attachment_test.txt"}',
            $attachment->__toString()
        );
    }
}
