<?php

declare(strict_types=1);

namespace PhpEmail\Attachment;

use PhpEmail\Attachment;
use PhpEmail\Validate;

class FileAttachment implements Attachment
{
    /**
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $name;

    /**
     * @param string      $file
     * @param string|null $name
     *
     * @throws \PhpEmail\ValidationException
     */
    public function __construct(string $file, ?string $name = null)
    {
        Validate::that()
            ->isFile('file', $file)
            ->now();

        $this->file = $file;
        $this->name = $name ?: basename($file);
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
        return file_get_contents($this->file);
    }

    /**
     * {@inheritdoc}
     */
    public function getBase64Content(): string
    {
        return base64_encode($this->getContent());
    }

    /**
     * {@inheritdoc}
     */
    public function getContentType(): string
    {
        return mime_content_type($this->file);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode([
            'file' => $this->file,
            'name' => $this->name,
        ]);
    }
}
