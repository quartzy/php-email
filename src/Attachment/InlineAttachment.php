<?php

declare(strict_types=1);

namespace PhpEmail\Attachment;

use PhpEmail\Attachment;

/**
 * Attachments, generally images, may be selected to be embedded directly (inlined) into the content of an email. In
 * this case, the attachment must be given a unique Content-ID to be referenced in the body of the email.
 */
class InlineAttachment implements Attachment
{
    /**
     * @var Attachment
     */
    private $attachment;

    /**
     * @var string
     */
    private $cid;

    /**
     * @param Attachment  $attachment
     * @param string|null $cid
     */
    public function __construct(Attachment $attachment, ?string $cid = null)
    {
        $this->attachment = $attachment;
        $this->cid        = $cid ?: $attachment->getName();
    }

    /**
     * Get the full content of the attachment.
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->attachment->getContent();
    }

    /**
     * Get the full content of the attachment in a base64 encoded format commonly used by third party providers for
     * sending the data.
     *
     * @return string
     */
    public function getBase64Content(): string
    {
        return $this->attachment->getBase64Content();
    }

    /**
     * Return the MIME content type of the attachment.
     *
     * @return string
     */
    public function getContentType(): string
    {
        return $this->attachment->getContentType();
    }

    /**
     * Get the name of the attachment.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->attachment->getName();
    }

    /**
     * @return string
     */
    public function getCid(): string
    {
        return $this->cid;
    }

    /**
     * @return Attachment
     */
    public function getAttachment(): Attachment
    {
        return $this->attachment;
    }

    /**
     * Must be implemented to support comparison.
     *
     * @return string
     */
    public function __toString(): string
    {
        return json_encode([
            'cid'        => $this->cid,
            'attachment' => $this->attachment->__toString(),
        ]);
    }
}
