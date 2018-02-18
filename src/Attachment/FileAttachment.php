<?php

declare(strict_types=1);

namespace PhpEmail\Attachment;

use PhpEmail\Attachment;
use PhpEmail\Validate;

class FileAttachment extends AttachmentWithHeaders
{
    /**
     * @var string
     */
    private $file;

    /**
     * @var string|null
     */
    private $content;

    /**
     * @param string      $file
     * @param null|string $name        If null, the class will determine a name for the attachment based on the file path.
     * @param null|string $contentId
     * @param null|string $contentType
     * @param string      $charset
     */
    public function __construct(
        string $file,
        ?string $name = null,
        ?string $contentId = null,
        ?string $contentType = null,
        string $charset = self::DEFAULT_CHARSET
    ) {
        Validate::that()
            ->isFile('file', $file)
            ->now();

        $this->file        = $file;
        $this->name        = $name ?: basename($file);
        $this->charset     = $charset;
        $this->contentId   = $contentId;
        $this->contentType = $contentType;
    }

    /**
     * A static alias for the FileAttachment constructor.
     *
     * @param string      $file
     * @param null|string $name        If null, the class will determine a name for the attachment based on the file path.
     * @param null|string $contentId
     * @param null|string $contentType
     * @param string      $charset
     *
     * @return FileAttachment
     */
    public static function fromFile(
        string $file,
        ?string $name = null,
        ?string $contentId = null,
        ?string $contentType = null,
        string $charset = self::DEFAULT_CHARSET
    ): FileAttachment {
        return new self($file, $name, $contentId, $contentType, $charset);
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent(): string
    {
        if (!$this->content) {
            $this->content = file_get_contents($this->file);
        }

        return $this->content;
    }

    /**
     * {@inheritdoc}
     */
    public function getBase64Content(): string
    {
        return base64_encode($this->getContent());
    }

    protected function determineContentType(): string
    {
        return mime_content_type($this->file);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode([
            'file'      => $this->file,
            'name'      => $this->name,
            'contentId' => $this->contentId,
        ]);
    }
}
