<?php

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
        $subject,
        Content $content,
        Address $from,
        array $toRecipients
    ) {
        Validate::that()
            ->allInstanceOf('toRecipients', $toRecipients, Address::class)
            ->isString('subject', $subject)
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
    public function getToRecipients()
    {
        return $this->toRecipients;
    }

    /**
     * @param array|Address[] $toRecipients
     *
     * @return Email
     */
    public function setToRecipients(Address ...$toRecipients)
    {
        $this->toRecipients = $toRecipients;

        return $this;
    }

    /**
     * @param array|Address[] ...$toRecipients
     *
     * @return $this
     */
    public function addToRecipients(Address ...$toRecipients)
    {
        $this->toRecipients = array_values(array_unique(array_merge($this->toRecipients, $toRecipients)));

        return $this;
    }

    /**
     * @return array|Address[]
     */
    public function getCcRecipients()
    {
        return $this->ccRecipients;
    }

    /**
     * @param array|Address[] ...$ccRecipients
     *
     * @return $this
     */
    public function setCcRecipients(Address ...$ccRecipients)
    {
        $this->ccRecipients = $ccRecipients;

        return $this;
    }

    /**
     * @param array|Address[] ...$ccRecipients
     *
     * @return $this
     */
    public function addCcRecipients(Address ...$ccRecipients)
    {
        $this->ccRecipients = array_values(array_unique(array_merge($this->ccRecipients, $ccRecipients)));

        return $this;
    }

    /**
     * @return array|Address[]
     */
    public function getBccRecipients()
    {
        return $this->bccRecipients;
    }

    /**
     * @param array|Address[] ...$bccRecipients
     *
     * @return $this
     */
    public function setBccRecipients(Address ...$bccRecipients)
    {
        $this->bccRecipients = $bccRecipients;

        return $this;
    }

    /**
     * @param array|Address[] ...$bccRecipients
     *
     * @return $this
     */
    public function addBccRecipients(Address ...$bccRecipients)
    {
        $this->bccRecipients = array_values(array_unique(array_merge($this->bccRecipients, $bccRecipients)));

        return $this;
    }

    /**
     * @return Address
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param Address $from
     *
     * @return Email
     */
    public function setFrom(Address $from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return array|Address[]
     */
    public function getReplyTos()
    {
        return $this->replyTos;
    }

    /**
     * @param array|Address[] $replyTos
     *
     * @return Email
     */
    public function setReplyTos(Address ...$replyTos)
    {
        $this->replyTos = $replyTos;

        return $this;
    }

    /**
     * @param array|Address[] ...$replyTos
     *
     * @return $this
     */
    public function addReplyTos(Address ...$replyTos)
    {
        $this->replyTos = array_values(array_unique(array_merge($this->replyTos, $replyTos)));

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
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
    public function setSubject($subject)
    {
        Validate::that()
            ->isString('subject', $subject)
            ->hasMinLength('subject', $subject, 1)
            ->now();

        $this->subject = $subject;

        return $this;
    }

    /**
     * @return Content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param Content $content
     *
     * @return Email
     */
    public function setContent(Content $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return array|Attachment[]
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param Attachment[] ...$attachments
     *
     * @throws ValidationException
     *
     * @return $this
     */
    public function setAttachments(Attachment ...$attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * @param Attachment[] $attachments
     *
     * @throws ValidationException
     *
     * @return $this
     */
    public function addAttachments(Attachment ...$attachments)
    {
        $this->attachments = array_values(array_unique(array_merge($this->attachments, $attachments)));

        return $this;
    }
}
