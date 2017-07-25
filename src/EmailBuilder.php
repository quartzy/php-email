<?php

namespace PhpEmail;

use PhpEmail\Attachment\FileAttachment;

class EmailBuilder
{
    /**
     * @var array|Address[]
     */
    private $toRecipients = [];

    /**
     * @var array|Address[]
     */
    private $ccRecipients = [];

    /**
     * @var array|Address[]
     */
    private $bccRecipients = [];

    /**
     * @var Address
     */
    private $from;

    /**
     * @var array|Address[]
     */
    private $replyTos = [];

    /**
     * @var string
     */
    private $subject;

    /**
     * @var Content
     */
    private $content;

    /**
     * @var array|Attachment[]
     */
    private $attachments = [];

    /**
     * @return EmailBuilder
     */
    public static function email()
    {
        return new static();
    }

    /**
     * @param string      $email
     * @param string|null $name
     *
     * @return self
     */
    public function to($email, $name = null)
    {
        $this->toRecipients[] = new Address($email, $name);

        return $this;
    }

    /**
     * @param string      $email
     * @param string|null $name
     *
     * @return self
     */
    public function cc($email, $name = null)
    {
        $this->ccRecipients[] = new Address($email, $name);

        return $this;
    }

    /**
     * @param string      $email
     * @param string|null $name
     *
     * @return self
     */
    public function bcc($email, $name = null)
    {
        $this->bccRecipients[] = new Address($email, $name);

        return $this;
    }

    /**
     * @param string      $email
     * @param string|null $name
     *
     * @return self
     */
    public function from($email, $name = null)
    {
        $this->from = new Address($email, $name);

        return $this;
    }

    /**
     * @param string      $email
     * @param string|null $name
     *
     * @return self
     */
    public function replyTo($email, $name = null)
    {
        $this->replyTos[] = new Address($email, $name);

        return $this;
    }

    /**
     * @param $subject
     *
     * @return self
     */
    public function withSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @param Content $content
     *
     * @return self
     */
    public function withContent(Content $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param string      $file
     * @param string|null $name
     *
     * @return EmailBuilder
     */
    public function attach($file, $name = null)
    {
        $this->attachments[] = new FileAttachment($file, $name);

        return $this;
    }

    /**
     * @return Email
     */
    public function build()
    {
        $email = new Email(
            $this->subject,
            $this->content,
            $this->from,
            $this->toRecipients
        );

        $email
            ->setCcRecipients(...$this->ccRecipients)
            ->setBccRecipients(...$this->bccRecipients)
            ->setReplyTos(...$this->replyTos)
            ->setAttachments(...$this->attachments);

        return $email;
    }
}
