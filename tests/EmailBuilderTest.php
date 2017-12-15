<?php

declare(strict_types=1);

namespace PhpEmail\Test;

use PhpEmail\Address;
use PhpEmail\Attachment\InlineAttachment;
use PhpEmail\Attachment\FileAttachment;
use PhpEmail\Content\EmptyContent;
use PhpEmail\EmailBuilder;

/**
 * @covers \PhpEmail\EmailBuilder
 * @covers \PhpEmail\Email
 */
class EmailBuilderTest extends TestCase
{
    /**
     * @var string
     */
    private static $file = '/tmp/builder_attachment_test.txt';

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
     * @testdox It should build an email
     */
    public function buildsAnEmail()
    {
        $email = EmailBuilder::email()
            ->to('recipient.one@test.com', 'Recipient One')
            ->to('recipient.two@test.com', 'Recipient Two')
            ->from('sender@test.com')
            ->withSubject('Hello from the Builder')
            ->withContent(new EmptyContent())
            ->attach(new FileAttachment(self::$file))
            ->embed(new FileAttachment(self::$file), 'cid:test')
            ->bcc('blind@test.com')
            ->cc('copy@test.com')
            ->replyTo('reply.to@test.com')
            ->build();

        $expectedRecipients = [
            new Address('recipient.one@test.com', 'Recipient One'),
            new Address('recipient.two@test.com', 'Recipient Two'),
        ];

        self::assertEquals($expectedRecipients, $email->getToRecipients());
        self::assertEquals(new Address('sender@test.com'), $email->getFrom());
        self::assertEquals('Hello from the Builder', $email->getSubject());
        self::assertEquals(new EmptyContent(), $email->getContent());
        self::assertEquals([new FileAttachment(self::$file)], $email->getAttachments());
        self::assertEquals([new InlineAttachment(new FileAttachment(self::$file), 'cid:test')], $email->getEmbedded());
        self::assertEquals([new Address('blind@test.com')], $email->getBccRecipients());
        self::assertEquals([new Address('copy@test.com')], $email->getCcRecipients());
        self::assertEquals([new Address('reply.to@test.com')], $email->getReplyTos());
    }
}
