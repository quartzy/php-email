<?php

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
    public function __construct($file, $name = null)
    {
        Validate::that()
            ->isFile('file', $file)
            ->isNullOrString('name', $name)
            ->now();

        $this->file = $file;
        $this->name = $name ?: basename($file);
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return file_get_contents($this->file);
    }

    /**
     * {@inheritdoc}
     */
    public function getBase64Content()
    {
        return base64_encode($this->getContent());
    }

    /**
     * {@inheritdoc}
     */
    public function getContentType()
    {
        return mime_content_type($this->file);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode([
            'file' => $this->file,
            'name' => $this->name,
        ]);
    }
}
