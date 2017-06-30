<?php

namespace PhpEmail\Test;

use PhpEmail\Address;
use PhpEmail\Attachment\FileAttachment;
use PhpEmail\Content\EmptyContent;
use PhpEmail\Content\SimpleContent;
use PhpEmail\Email;

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
     * @expectedException \PhpEmail\ValidationException
     */
    public function validatesOnConstruction()
    {
        new Email('', SimpleContent::text('hello'), new Address('sender@test.com'), ['hello']);
    }

    /**
     * @testdox It should allow for adding details to a build email
     */
    public function addsDetails()
    {
        $email = new Email('Subject', SimpleContent::text('hello'), new Address('sender@test.com'), [new Address('receive@test.com')]);

        $secondReceiver = new Address('second.receiver@test.com');
        $cc             = new Address('cc@test.com');
        $bcc            = new Address('bcc@test.com');
        $from           = new Address('updated.sender@test.com');
        $replyTo        = new Address('reply.to@test.com');
        $content        = new EmptyContent();
        $attachment     = new FileAttachment(self::$file);

        $email
            ->addToRecipients($secondReceiver)
            ->addCcRecipients($cc)
            ->addBccRecipients($bcc)
            ->setFrom($from)
            ->addReplyTos($replyTo)
            ->setSubject('Updated Subject')
            ->setContent($content)
            ->addAttachments($attachment);

        self::assertContains($secondReceiver, $email->getToRecipients());
        self::assertContains($cc, $email->getCcRecipients());
        self::assertContains($bcc, $email->getBccRecipients());
        self::assertSame($from, $email->getFrom());
        self::assertContains($replyTo, $email->getReplyTos());
        self::assertSame($content, $email->getContent());
        self::assertContains($attachment, $email->getAttachments());
    }
}