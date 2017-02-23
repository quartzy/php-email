<?php

namespace PhpEmail;

use Assert\LazyAssertion;

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
     * @var array|string[]
     */
    private $attachments = [];

    /**
     * @param Content $content
     * @param Address $from
     * @param array   $toRecipients
     * @param string  $subject
     */
    public function __construct(
        $subject,
        Content $content,
        Address $from,
        array $toRecipients
    ) {
        (new LazyAssertion())
            ->that($toRecipients, 'toRecipients')->all()->isInstanceOf(Address::class)
            ->that($subject, 'subject')->string()->minLength(1)
            ->verifyNow();

        $this->content       = $content;
        $this->from          = $from;
        $this->toRecipients  = $toRecipients;
        $this->subject       = $subject;
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
     * @return Email
     */
    public function setSubject($subject)
    {
        (new LazyAssertion())
            ->that($subject, 'subject')
            ->string()
            ->minLength(1)
            ->verifyNow();

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
     * @return array|string[]
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param array ...$attachments
     *
     * @return $this
     *
     * @throws \Assert\LazyAssertionException
     */
    public function setAttachments(...$attachments)
    {
        (new LazyAssertion())
            ->that($attachments, 'attachments')->all()->file()
            ->verifyNow();

        $this->attachments = $attachments;

        return $this;
    }

    /**
     * @param array|string[] $attachments
     *
     * @return $this
     *
     * @throws \Assert\LazyAssertionException
     */
    public function addAttachments(...$attachments)
    {
        (new LazyAssertion())
            ->that($attachments, 'attacments')->all()->file()
            ->verifyNow();

        $this->attachments = array_values(array_unique(array_merge($this->attachments, $attachments)));

        return $this;
    }
}
