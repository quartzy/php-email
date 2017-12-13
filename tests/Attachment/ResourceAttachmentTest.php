<?php

declare(strict_types=1);

namespace PhpEmail\Test\Attachment;

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
    private static $file = '/tmp/attachment test.txt';

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
    public function handlesLocalFile()
    {
        $this->resource = fopen(self::$file, 'r');

        $attachment = new ResourceAttachment($this->resource);

        self::assertEquals('text/plain', $attachment->getContentType());
        self::assertEquals('QXR0YWNobWVudCBmaWxl', $attachment->getBase64Content());
        self::assertEquals('Attachment file', $attachment->getContent());
        self::assertEquals('attachment test.txt', $attachment->getName());
        self::assertEquals($this->resource, $attachment->getResource());
        self::assertEquals(
            '{"uri":"\/tmp\/attachment test.txt","name":"attachment test.txt"}',
            $attachment->__toString()
        );
    }

    /**
     * @testdox It should create an attachment using a file on a remote server
     */
    public function handlesRemoteFile()
    {
        $this->setupServer();
        $this->resource = fopen('http://localhost:8777/attachment%20test.txt?withquery=1', 'r');

        $attachment = new ResourceAttachment($this->resource);

        self::assertEquals('text/plain', $attachment->getContentType());
        self::assertEquals('QXR0YWNobWVudCBmaWxl', $attachment->getBase64Content());
        self::assertEquals('Attachment file', $attachment->getContent());
        self::assertEquals('attachment test.txt', $attachment->getName());
        self::assertEquals($this->resource, $attachment->getResource());
        self::assertEquals(
            '{"uri":"http:\/\/localhost:8777\/attachment%20test.txt?withquery=1","name":"attachment test.txt"}',
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
            if (posix_kill($this->pid, 0)){
                exec('kill ' . $this->pid);
            }
        });
    }
}
