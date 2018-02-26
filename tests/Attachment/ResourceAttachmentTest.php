<?php

declare(strict_types=1);

namespace PhpEmail\Test\Attachment;

use PhpEmail\Attachment\ResourceAttachment;
use PhpEmail\Test\TestCase;

/**
 * @covers \PhpEmail\Attachment\ResourceAttachment
 * @covers \PhpEmail\Attachment\AttachmentWithHeaders
 */
class ResourceAttachmentTest extends TestCase
{
    /**
     * @var string
     */
    private static $file = '/tmp/attachment test.txt';

    /**
     * @var int
     */
    private $pid;

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

    public function tearDown()
    {
        parent::tearDown();

        fclose($this->resource);
    }

    /**
     * @testdox It should create an attachment using a file on the disk
     */
    public function testHandlesLocalFile()
    {
        $this->resource = fopen(self::$file, 'r');

        $attachment = new ResourceAttachment($this->resource);


        self::assertEquals('text/plain', $attachment->getContentType());
        self::assertEquals(null, $attachment->getCharset());
        self::assertEquals(null, $attachment->getContentId());
        self::assertEquals('QXR0YWNobWVudCBmaWxl', $attachment->getBase64Content());
        self::assertEquals('Attachment file', $attachment->getContent());
        self::assertEquals('attachment test.txt', $attachment->getName());
        self::assertEquals($this->resource, $attachment->getResource());
        self::assertEquals('text/plain; name="attachment test.txt"', $attachment->getRfc2822ContentType());
        self::assertEquals(
            '{"uri":"\/tmp\/attachment test.txt","name":"attachment test.txt","contentId":null}',
            $attachment->__toString()
        );
    }

    /**
     * @testdox It should create an attachment using a file on disk and set headers
     */
    public function handlesLocalFileWithHeaders()
    {
        $this->resource = fopen(self::$file, 'r');

        $attachment = ResourceAttachment::fromResource($this->resource)
            ->setContentType('text/json')
            ->setContentId('testid')
            ->setName('testfile.txt')
            ->setCharset('utf-16');

        self::assertEquals('text/json', $attachment->getContentType());
        self::assertEquals('utf-16', $attachment->getCharset());
        self::assertEquals('testid', $attachment->getContentId());
        self::assertEquals('QXR0YWNobWVudCBmaWxl', $attachment->getBase64Content());
        self::assertEquals('Attachment file', $attachment->getContent());
        self::assertEquals('testfile.txt', $attachment->getName());
        self::assertEquals($this->resource, $attachment->getResource());
        self::assertEquals('text/json; name="testfile.txt"; charset="utf-16"', $attachment->getRfc2822ContentType());
        self::assertEquals(
            '{"uri":"\/tmp\/attachment test.txt","name":"testfile.txt","contentId":"testid"}',
            $attachment->__toString()
        );
    }

    /**
     * @testdox It should create an attachment using a file on a remote server
     */
    public function testHandlesRemoteFile()
    {
        $this->setupServer();
        $this->resource = fopen('http://localhost:8777/attachment%20test.txt?withquery=1', 'r');

        $attachment = new ResourceAttachment($this->resource);

        self::assertEquals('text/plain', $attachment->getContentType());
        self::assertEquals(null, $attachment->getCharset());
        self::assertEquals(null, $attachment->getContentId());
        self::assertEquals('QXR0YWNobWVudCBmaWxl', $attachment->getBase64Content());
        self::assertEquals('Attachment file', $attachment->getContent());
        self::assertEquals('attachment test.txt', $attachment->getName());
        self::assertEquals($this->resource, $attachment->getResource());
        self::assertEquals(
            '{"uri":"http:\/\/localhost:8777\/attachment%20test.txt?withquery=1","name":"attachment test.txt","contentId":null}',
            $attachment->__toString()
        );
    }

    private function setupServer()
    {
        $command = 'php -S localhost:8777 -t /tmp >/dev/null 2>&1 & echo $!';

        // Execute the command and store the process ID
        $output = [];
        exec($command, $output);
        $this->pid = (int) $output[0];

        // Give the server time to start
        sleep(1);

        // Kill the web server when the process ends
        register_shutdown_function(function () {
            if (posix_kill($this->pid, 0)) {
                exec('kill ' . $this->pid);
            }
        });
    }
}
