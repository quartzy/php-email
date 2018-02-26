<?php

declare(strict_types=1);

namespace PhpEmail;

interface Attachment
{
    /**
     * Get the full content of the attachment.
     *
     * @return string
     */
    public function getContent(): string;

    /**
     * Get the full content of the attachment in a base64 encoded format commonly used by third party providers for
     * sending the data.
     *
     * @return string
     */
    public function getBase64Content(): string;

    /**
     * Return the MIME content type of the attachment.
     *
     * @return string
     */
    public function getContentType(): string;

    /**
     * Set the MIME content type of the attachment.
     *
     * @param string $contentType
     *
     * @return Attachment
     */
    public function setContentType(string $contentType): Attachment;

    /**
     * Get the character set defined on the attachment.
     *
     * @return string|null
     */
    public function getCharset(): ?string;

    /**
     * Set the character set for the attachment.
     *
     * @param string $charset
     *
     * @return Attachment
     */
    public function setCharset(string $charset): Attachment;

    /**
     * Get the Content-ID of the attachment.
     *
     * @return null|string
     */
    public function getContentId(): ?string;

    /**
     * Set the Content-ID of the attachment.
     *
     * @param string $contentId
     *
     * @return Attachment
     */
    public function setContentId(string $contentId): Attachment;

    /**
     * Get the name of the attachment.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Set the name of the attachment.
     *
     * @param string $name
     *
     * @return Attachment
     */
    public function setName(string $name): Attachment;

    /**
     * Get a common representation of the RFC 822 formatted Content Type headers, including:
     *  - content type
     *  - name
     *  - character set.
     *
     * @return string
     */
    public function getRfc2822ContentType(): string;

    /**
     * Must be implemented to support comparison.
     *
     * @return string
     */
    public function __toString(): string;
}
