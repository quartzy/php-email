<?php

declare(strict_types=1);

namespace PhpEmail\Attachment;

use PhpEmail\Attachment;
use PhpEmail\Validate;

class ResourceAttachment implements Attachment
{
    /**
     * @var resource
     */
    private $resource;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $content = null;

    /**
     * @var string|null
     */
    private $contentType = null;

    public function __construct($resource, ?string $name = null)
    {
        Validate::that()
            ->isStream('resource', $resource)
            ->now();

        $this->resource = $resource;
        $this->name     = $name ?: $this->determineName();
    }

    /**
     * @return resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent(): string
    {
        if ($this->content === null) {
            $this->content = stream_get_contents($this->resource);
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

    /**
     * {@inheritdoc}
     */
    public function getContentType(): string
    {
        if ($this->contentType === null) {
            $metadata = stream_get_meta_data($this->resource);

            $wrapperType = $metadata['wrapper_type'];
            $uri         = $metadata['uri'];

            switch ($wrapperType) {
                case 'plainfile':
                    $this->contentType = mime_content_type($uri);

                    break;

                case 'http':
                    $headers     = get_headers($uri, 1);
                    $contentType = $headers['Content-Type'] ?? null;

                    // Only use the actual type from the content type. Ignore the character set.
                    $this->contentType = explode(';', $contentType)[0];

                    break;

                default:
                    $this->contentType = 'application/octet-stream';
            }
        }

        return $this->contentType;
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
            'uri'  => stream_get_meta_data($this->resource)['uri'],
            'name' => $this->name,
        ]);
    }

    /**
     * @return string
     */
    protected function determineName(): string
    {
        $metadata = stream_get_meta_data($this->resource);

        if ($metadata['wrapper_type'] === 'http') {
            return urldecode(basename(parse_url($metadata['uri'], PHP_URL_PATH)));
        }

        return basename($metadata['uri']);
    }
}
