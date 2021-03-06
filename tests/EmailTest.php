<?php

declare(strict_types=1);

namespace PhpEmail\Test;

use PhpEmail\Address;
use PhpEmail\Attachment\FileAttachment;
use PhpEmail\Content\EmptyContent;
use PhpEmail\Content\SimpleContent;
use PhpEmail\Content\TemplatedContent;
use PhpEmail\Email;
use PhpEmail\Header;
use PhpEmail\ValidationException;

/**
 * @covers \PhpEmail\Email
 */
class EmailTest extends TestCase
{
    /**
     * @var string
     */
    private static $file = '/tmp/email_attachment_test.txt';

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
     * @testdox It should validate on construction
     */
    public function testValidatesOnConstruction()
    {
        self::expectException(ValidationException::class);

        new Email('', SimpleContent::text('hello'), new Address('sender@test.com'), ['recipient@test.com']);
    }

    public function testAllowsEmptySubjectWithTemplates()
    {
        $emptySubject = new Email('', new TemplatedContent('test', []), new Address('sender@test.com'), [new Address('recipient@test.com')]);

        self::assertEmpty($emptySubject->getSubject());

        $nullSubject = new Email(null, new TemplatedContent('test', []), new Address('sender@test.com'), [new Address('recipient@test.com')]);

        self::assertNull($nullSubject->getSubject());
    }

    /**
     * @testdox It should allow for adding details to a build email
     */
    public function testAddsDetails()
    {
        $email = new Email('Subject', SimpleContent::text('hello'), new Address('sender@test.com'), [new Address('receive@test.com')]);

        $secondReceiver = new Address('second.receiver@test.com');
        $cc             = new Address('cc@test.com');
        $bcc            = new Address('bcc@test.com');
        $from           = new Address('updated.sender@test.com');
        $replyTo        = new Address('reply.to@test.com');
        $content        = new EmptyContent();
        $attachment     = new FileAttachment(self::$file);
        $embedded       = new FileAttachment(self::$file);
        $header         = new Header('X-Test', 'test');

        $email
            ->addToRecipients($secondReceiver)
            ->addCcRecipients($cc)
            ->addBccRecipients($bcc)
            ->setFrom($from)
            ->addReplyTos($replyTo)
            ->setSubject('Updated Subject')
            ->setContent($content)
            ->addAttachments($attachment)
            ->addEmbedded($embedded)
            ->addHeaders($header);

        self::assertContains($secondReceiver, $email->getToRecipients());
        self::assertContains($cc, $email->getCcRecipients());
        self::assertContains($bcc, $email->getBccRecipients());
        self::assertSame($from, $email->getFrom());
        self::assertContains($replyTo, $email->getReplyTos());
        self::assertSame($content, $email->getContent());
        self::assertContains($attachment, $email->getAttachments());
        self::assertContains($embedded, $email->getEmbedded());
        self::assertEquals([$header], $email->getHeaders());
    }
}
