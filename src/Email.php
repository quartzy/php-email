<?php

declare(strict_types=1);

namespace PhpEmail;

class Email
{
    /**
     * @var array|Address[]
     */
    private $toRecipients;

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
     * @param Content $content
     * @param Address $from
     * @param array   $toRecipients
     * @param string  $subject
     *
     * @throws ValidationException
     */
    public function __construct(
        string $subject,
        Content $content,
        Address $from,
        array $toRecipients
    ) {
        Validate::that()
            ->allInstanceOf('toRecipients', $toRecipients, Address::class)
            ->hasMinLength('subject', $subject, 1)
            ->now();

        $this->content       = $content;
        $this->from          = $from;
        $this->subject       = $subject;

        $this->setToRecipients(...$toRecipients);
    }

    /**
     * @return array|Address[]
     */
    public function getToRecipients(): array
    {
        return $this->toRecipients;
    }

    /**
     * @param array|Address[] $toRecipients
     *
     * @return Email
     */
    public function setToRecipients(Address ...$toRecipients): Email
    {
        $this->toRecipients = $toRecipients;

        return $this;
    }

    /**
     * @param array|Address[] ...$toRecipients
     *
     * @return Email
     */
    public function addToRecipients(Address ...$toRecipients): Email
    {
        $this->toRecipients = array_values(array_unique(array_merge($this->toRecipients, $toRecipients)));

        return $this;
    }

    /**
     * @return array|Address[]
     */
    public function getCcRecipients(): array
    {
        return $this->ccRecipients;
    }

    /**
     * @param array|Address[] ...$ccRecipients
     *
     * @return Email
     */
    public function setCcRecipients(Address ...$ccRecipients): Email
    {
        $this->ccRecipients = $ccRecipients;

        return $this;
    }

    /**
     * @param array|Address[] ...$ccRecipients
     *
     * @return Email
     */
    public function addCcRecipients(Address ...$ccRecipients): Email
    {
        $this->ccRecipients = array_values(array_unique(array_merge($this->ccRecipients, $ccRecipients)));

        return $this;
    }

    /**
     * @return array|Address[]
     */
    public function getBccRecipients(): array
    {
        return $this->bccRecipients;
    }

    /**
     * @param array|Address[] ...$bccRecipients
     *
     * @return Email
     */
    public function setBccRecipients(Address ...$bccRecipients): Email
    {
        $this->bccRecipients = $bccRecipients;

        return $this;
    }

    /**
     * @param array|Address[] ...$bccRecipients
     *
     * @return Email
     */
    public function addBccRecipients(Address ...$bccRecipients): Email
    {
        $this->bccRecipients = array_values(array_unique(array_merge($this->bccRecipients, $bccRecipients)));

        return $this;
    }

    /**
     * @return Address
     */
    public function getFrom(): Address
    {
        return $this->from;
    }

    /**
     * @param Address $from
     *
     * @return Email
     */
    public function setFrom(Address $from): Email
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return array|Address[]
     */
    public function getReplyTos(): array
    {
        return $this->replyTos;
    }

    /**
     * @param array|Address[] $replyTos
     *
     * @return Email
     */
    public function setReplyTos(Address ...$replyTos): Email
    {
        $this->replyTos = $replyTos;

        return $this;
    }

    /**
     * @param array|Address[] ...$replyTos
     *
     * @return Email
     */
    public function addReplyTos(Address ...$replyTos): Email
    {
        $this->replyTos = array_values(array_unique(array_merge($this->replyTos, $replyTos)));

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     *
     * @throws ValidationException
     *
     * @return Email
     */
    public function setSubject(string $subject): Email
    {
        Validate::that()
            ->hasMinLength('subject', $subject, 1)
            ->now();

        $this->subject = $subject;

        return $this;
    }

    /**
     * @return Content
     */
    public function getContent(): Content
    {
        return $this->content;
    }

    /**
     * @param Content $content
     *
     * @return Email
     */
    public function setContent(Content $content): Email
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return array|Attachment[]
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * @param Attachment[] ...$attachments
     *
     * @throws ValidationException
     *
     * @return Email
     */
    public function setAttachments(Attachment ...$attachments): Email
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * @param Attachment[] $attachments
     *
     * @throws ValidationException
     *
     * @return Email
     */
    public function addAttachments(Attachment ...$attachments): Email
    {
        $this->attachments = array_values(array_unique(array_merge($this->attachments, $attachments)));

        return $this;
    }
}
