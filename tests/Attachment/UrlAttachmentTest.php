<?php

declare(strict_types=1);

namespace PhpEmail\Test\Attachment;

use PhpEmail\Attachment\UrlAttachment;
use PhpEmail\Test\TestCase;

/**
 * @covers \PhpEmail\Attachment\UrlAttachment
 * @covers \PhpEmail\Attachment\AttachmentWithHeaders
 */
class UrlAttachmentTest extends TestCase
{
    private const TEST_FILE = '/tmp/test test.txt';

    /**
     * @var int
     */
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
            if (posix_kill(self::$pid, 0)) {
                exec('kill ' . self::$pid);
            }
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
    public function testHandlesRemoteFileWithDefaults()
    {
        $attachment = new UrlAttachment('http://localhost:8777/test%20test.txt?withquery=1');

        self::assertEquals('text/plain', $attachment->getContentType());
        self::assertEquals('utf-8', $attachment->getCharset());
        self::assertEquals(null, $attachment->getContentId());
        self::assertEquals('QXR0YWNobWVudCBmaWxl', $attachment->getBase64Content());
        self::assertEquals('Attachment file', $attachment->getContent());
        self::assertEquals('test test.txt', $attachment->getName());
        self::assertEquals('http://localhost:8777/test%20test.txt?withquery=1', $attachment->getUrl());
        self::assertEquals(
            '{"url":"http:\/\/localhost:8777\/test%20test.txt?withquery=1","name":"test test.txt","contentId":null}',
            $attachment->__toString()
        );
    }

    /**
     * @testdox It should create an attachment using a URL and define headers
     */
    public function testHandlesRemoteFileWithHeaders()
    {
        $attachment = UrlAttachment::fromUrl('http://localhost:8777/test%20test.txt?withquery=1')
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
        self::assertEquals('http://localhost:8777/test%20test.txt?withquery=1', $attachment->getUrl());
        self::assertEquals(
            '{"url":"http:\/\/localhost:8777\/test%20test.txt?withquery=1","name":"testfile.txt","contentId":"testid"}',
            $attachment->__toString()
        );
    }
}
