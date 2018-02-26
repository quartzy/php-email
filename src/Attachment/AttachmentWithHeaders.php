<?php

declare(strict_types=1);

namespace PhpEmail\Attachment;

use PhpEmail\Attachment;

abstract class AttachmentWithHeaders implements Attachment
{
    /**
     * @var string|null
     */
    protected $contentType;

    /**
     * @var string|null
     */
    protected $charset;

    /**
     * @var string|null
     */
    protected $contentId;

    /**
     * @var string
     */
    protected $name;

    /**
     * Determine the MIME content type for this attachment. This is generally done by accessing some metadata about the
     * attachment, and as such is only used after the content type is retrieved from the object, and assuming it was not
     * explicitly provided.
     *
     * @return string
     */
    abstract protected function determineContentType(): string;

    /**
     * {@inheritdoc}
     */
    public function getContentType(): string
    {
        if ($this->contentType === null) {
            $this->contentType = $this->determineContentType();
        }

        return  $this->contentType;
    }

    /**
     * {@inheritdoc}
     */
    public function setContentType(string $contentType): Attachment
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCharset(): ?string
    {
        return $this->charset;
    }

    /**
     * {@inheritdoc}
     */
    public function setCharset(string $charset): Attachment
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getContentId(): ?string
    {
        return $this->contentId;
    }

    /**
     * {@inheritdoc}
     */
    public function setContentId(string $contentId): Attachment
    {
        $this->contentId = $contentId;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(string $name): Attachment
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRfc2822ContentType(): string
    {
        $parts = [
            $this->getContentType(),
            sprintf('name="%s"', $this->getName()),
        ];

        if ($this->getCharset() !== null) {
            $parts[] = sprintf('charset="%s"', $this->getCharset());
        }

        return implode('; ', $parts);
    }
}
