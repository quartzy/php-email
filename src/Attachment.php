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
     * Get the name of the attachment.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Must be implemented to support comparison.
     *
     * @return string
     */
    public function __toString(): string;
}
