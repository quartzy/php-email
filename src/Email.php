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
     * @var Attachment[]
     */
    private $embedded = [];

    /**
     * @var Header[]
     */
    private $headers = [];

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

        $this->content = $content;
        $this->from    = $from;
        $this->subject = $subject;

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
    public function setToRecipients(Address ...$toRecipients): self
    {
        $this->toRecipients = $toRecipients;

        return $this;
    }

    /**
     * @param array|Address[] ...$toRecipients
     *
     * @return Email
     */
    public function addToRecipients(Address ...$toRecipients): self
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
    public function setCcRecipients(Address ...$ccRecipients): self
    {
        $this->ccRecipients = $ccRecipients;

        return $this;
    }

    /**
     * @param array|Address[] ...$ccRecipients
     *
     * @return Email
     */
    public function addCcRecipients(Address ...$ccRecipients): self
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
    public function setBccRecipients(Address ...$bccRecipients): self
    {
        $this->bccRecipients = $bccRecipients;

        return $this;
    }

    /**
     * @param array|Address[] ...$bccRecipients
     *
     * @return Email
     */
    public function addBccRecipients(Address ...$bccRecipients): self
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
    public function setFrom(Address $from): self
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
    public function setReplyTos(Address ...$replyTos): self
    {
        $this->replyTos = $replyTos;

        return $this;
    }

    /**
     * @param array|Address[] ...$replyTos
     *
     * @return Email
     */
    public function addReplyTos(Address ...$replyTos): self
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
    public function setSubject(string $subject): self
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
    public function setContent(Content $content): self
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
    public function setAttachments(Attachment ...$attachments): self
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
    public function addAttachments(Attachment ...$attachments): self
    {
        $this->attachments = array_values(array_unique(array_merge($this->attachments, $attachments)));

        return $this;
    }

    /**
     * Embed an attachment into the email, setting the Content ID.
     *
     * @param Attachment  $attachment
     * @param null|string $contentId
     *
     * @return Email
     */
    public function embed(Attachment $attachment, ?string $contentId = null): self
    {
        $contentId = $contentId ?? $attachment->getContentId() ?? $attachment->getName();

        $this->embedded[$attachment->getContentId()] = $attachment->setContentId($contentId);

        return $this;
    }

    /**
     * Set the embedded attachments for the email.
     *
     * This function assumes that all attachments already have a Content ID set, or it will use the default value. This
     * function will remove all currently embedded attachments.
     *
     * @param Attachment[] ...$attachments
     *
     * @return Email
     */
    public function setEmbedded(Attachment ...$attachments): self
    {
        $this->embedded = [];

        return $this->addEmbedded(...$attachments);
    }

    /**
     * Add a collection of attachments to the email.
     *
     * This function assumes that all attachments already have a Content ID set, or it will use the default value.
     *
     * @param Attachment[] ...$attachments
     *
     * @return Email
     */
    public function addEmbedded(Attachment ...$attachments): self
    {
        foreach ($attachments as $attachment) {
            $this->embed($attachment);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getEmbedded(): array
    {
        return array_values($this->embedded);
    }

    /**
     * @return Header[]
     */
    public function getHeaders(): array
    {
        return array_values($this->headers);
    }

    /**
     * @param Header[] $headers
     *
     * @return Email
     */
    public function setHeaders(Header ...$headers): self
    {
        $this->headers = [];

        return $this->addHeaders(...$headers);
    }

    /**
     * @param Header[] $headers
     *
     * @return Email
     */
    public function addHeaders(Header ...$headers): self
    {
        foreach ($headers as $header) {
            $this->headers[$header->getField()] = $header;
        }

        return $this;
    }
}
