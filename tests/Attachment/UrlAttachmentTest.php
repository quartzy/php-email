<?php

declare(strict_types=1);

namespace PhpEmail\Test\Attachment;

use PhpEmail\Attachment\UrlAttachment;
use PhpEmail\Test\TestCase;

/**
 * @covers \PhpEmail\Attachment\UrlAttachment
 */
class UrlAttachmentTest extends TestCase
{
    private const TEST_FILE = '/tmp/test.txt';

    private static $pid;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        file_put_contents(self::TEST_FILE, 'Attachment file');

        $command = 'php -S localhost:8777 -t /tmp >/dev/null 2>&1 & echo $!';

        // Execute the command and store the process ID
        $output = [];
        exec($command, $output);
        self::$pid = (int) $output[0];

        // Give the server time to start
        sleep(1);

        // Kill the web server when the process ends
        register_shutdown_function(function () {
            exec('kill ' . self::$pid);
        });
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        unlink(self::TEST_FILE);
    }

    /**
     * @testdox It should create an attachment using a URL
     */
    public function handlesRemoteFile()
    {
        $attachment = new UrlAttachment('http://localhost:8777/test.txt');

        self::assertEquals('text/plain', $attachment->getContentType());
        self::assertEquals('QXR0YWNobWVudCBmaWxl', $attachment->getBase64Content());
        self::assertEquals('Attachment file', $attachment->getContent());
        self::assertEquals('test.txt', $attachment->getName());
        self::assertEquals('http://localhost:8777/test.txt', $attachment->getUrl());
        self::assertEquals(
            '{"url":"http:\/\/localhost:8777\/test.txt","name":"test.txt"}',
            $attachment->__toString()
        );
    }
}
