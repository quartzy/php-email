<?php

namespace Postcard;

use Assert\Assert;
use Assert\Assertion;

class Email
{
    /**
     * @var array|Recipient[]
     */
    private $toRecipients;

    /**
     * @var array|Recipient[]
     */
    private $ccRecipients;

    /**
     * @var array|Recipient[]
     */
    private $bccRecipients;

    /**
     * @var Sender
     */
    private $from;

    /**
     * @var array|Sender[]
     */
    private $replyTos;

    /**
     * @var Content
     */
    private $content;

    /**
     * @var array|string[]
     */
    private $attachments;

    /**
     * @param Content $content
     * @param Sender  $from
     * @param array   $toRecipients
     *
     * @throws \Assert\LazyAssertionException
     */
    public function __construct(
        Content $content,
        Sender $from,
        array $toRecipients
    ) {
        Assert::lazy()
            ->that($toRecipients, 'toRecipients')->all()->isInstanceOf(Recipient::class)
            ->verifyNow();

        $this->content       = $content;
        $this->from          = $from;
        $this->toRecipients  = $toRecipients;
    }

    /**
     * @return array|Recipient[]
     */
    public function getToRecipients()
    {
        return $this->toRecipients;
    }

    /**
     * @param array|Recipient[] $toRecipients
     *
     * @return Email
     */
    public function setToRecipients(Recipient ...$toRecipients)
    {
        $this->toRecipients = $toRecipients;

        return $this;
    }

    /**
     * @param array|Recipient[] ...$toRecipients
     *
     * @return $this
     */
    public function addToRecipients(Recipient ...$toRecipients)
    {
        $this->toRecipients = array_values(array_unique(array_merge($this->toRecipients, $toRecipients)));

        return $this;
    }

    /**
     * @return array|Recipient[]
     */
    public function getCcRecipients()
    {
        return $this->ccRecipients;
    }

    /**
     * @param array|Recipient[] ...$ccRecipients
     *
     * @return $this
     */
    public function setCcRecipients(Recipient ...$ccRecipients)
    {
        $this->ccRecipients = $ccRecipients;

        return $this;
    }

    /**
     * @param array|Recipient[] ...$ccRecipients
     *
     * @return $this
     */
    public function addCcRecipients(Recipient ...$ccRecipients)
    {
        $this->ccRecipients = array_values(array_unique(array_merge($this->ccRecipients, $ccRecipients)));

        return $this;
    }

    /**
     * @return array|Recipient[]
     */
    public function getBccRecipients()
    {
        return $this->bccRecipients;
    }

    /**
     * @param array|Recipient[] ...$bccRecipients
     *
     * @return $this
     */
    public function setBccRecipients(Recipient ...$bccRecipients)
    {
        $this->bccRecipients = $bccRecipients;

        return $this;
    }

    /**
     * @param array|Recipient[] ...$bccRecipients
     *
     * @return $this
     */
    public function addBccRecipients(Recipient ...$bccRecipients)
    {
        $this->bccRecipients = array_values(array_unique(array_merge($this->bccRecipients, $bccRecipients)));

        return $this;
    }

    /**
     * @return Sender
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param Sender $from
     *
     * @return Email
     */
    public function setFrom(Sender $from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return array|Sender[]
     */
    public function getReplyTos()
    {
        return $this->replyTos;
    }

    /**
     * @param array|Sender[] $replyTos
     *
     * @return Email
     */
    public function setReplyTos(Sender ...$replyTos)
    {
        $this->replyTos = $replyTos;

        return $this;
    }

    /**
     * @param array|Sender[] ...$replyTos
     *
     * @return $this
     */
    public function addReplyTos(Sender ...$replyTos)
    {
        $this->replyTos = array_values(array_unique(array_merge($this->replyTos, $replyTos)));

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
     * @throws \Assert\AssertionFailedException
     */
    public function setAttachments(...$attachments)
    {
        Assertion::allFile($attachments);

        $this->attachments = $attachments;

        return $this;
    }

    /**
     * @param array|string[] $attachments
     *
     * @return $this
     *
     * @throws \Assert\AssertionFailedException
     */
    public function addAttachments(...$attachments)
    {
        Assertion::allFile($attachments);

        $this->attachments = array_values(array_unique(array_merge($this->attachments, $attachments)));

        return $this;
    }
}
