<?php

declare(strict_types=1);

namespace PhpEmail;

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
     * @var Attachment[]
     */
    private $embedded = [];

    /**
     * @var Header[]
     */
    private $headers = [];

    /**
     * @return EmailBuilder
     */
    public static function email(): self
    {
        return new static();
    }

    /**
     * @param string      $email
     * @param string|null $name
     *
     * @return EmailBuilder
     */
    public function to(string $email, ?string $name = null): self
    {
        $this->toRecipients[] = new Address($email, $name);

        return $this;
    }

    /**
     * @param string      $email
     * @param string|null $name
     *
     * @return EmailBuilder
     */
    public function cc(string $email, ?string $name = null): self
    {
        $this->ccRecipients[] = new Address($email, $name);

        return $this;
    }

    /**
     * @param string      $email
     * @param string|null $name
     *
     * @return EmailBuilder
     */
    public function bcc(string $email, ?string $name = null): self
    {
        $this->bccRecipients[] = new Address($email, $name);

        return $this;
    }

    /**
     * @param string      $email
     * @param string|null $name
     *
     * @return EmailBuilder
     */
    public function from(string $email, ?string $name = null): self
    {
        $this->from = new Address($email, $name);

        return $this;
    }

    /**
     * @param string      $email
     * @param string|null $name
     *
     * @return EmailBuilder
     */
    public function replyTo(string $email, ?string $name = null): self
    {
        $this->replyTos[] = new Address($email, $name);

        return $this;
    }

    /**
     * @param $subject
     *
     * @return EmailBuilder
     */
    public function withSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @param Content $content
     *
     * @return EmailBuilder
     */
    public function withContent(Content $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @var Attachment
     *
     * @return EmailBuilder
     */
    public function attach(Attachment $attachment): self
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    public function embed(Attachment $attachment, ?string $contentId = null): self
    {
        $contentId = $contentId ?? $attachment->getContentId() ?? $attachment->getName();

        $this->embedded[$contentId] = $attachment->setContentId($contentId);

        return $this;
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @return EmailBuilder
     */
    public function addHeader(string $field, string $value): self
    {
        $this->headers[] = new Header($field, $value);

        return $this;
    }

    /**
     * @return Email
     */
    public function build(): Email
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
            ->setAttachments(...$this->attachments)
            ->setEmbedded(...array_values($this->embedded))
            ->setHeaders(...$this->headers);

        return $email;
    }
}
