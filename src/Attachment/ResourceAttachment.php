<?php

declare(strict_types=1);

namespace PhpEmail\Attachment;

use PhpEmail\Attachment;
use PhpEmail\Validate;

class ResourceAttachment extends AttachmentWithHeaders
{
    /**
     * @var resource
     */
    private $resource;

    /**
     * @var string|null
     */
    private $content = null;

    /**
     * @param             $resource
     * @param null|string $name If null, the class will determine a name for the attachment based on the resource.
     * @param null|string $contentId
     * @param null|string $contentType
     * @param string      $charset
     */
    public function __construct(
        $resource,
        ?string $name = null,
        ?string $contentId = null,
        ?string $contentType = null,
        string $charset = self::DEFAULT_CHARSET
    ) {
        Validate::that()
            ->isStream('resource', $resource)
            ->now();

        $this->resource    = $resource;
        $this->name        = $name ?: $this->determineName();
        $this->contentId   = $contentId;
        $this->contentType = $contentType;
        $this->charset     = $charset;
    }

    public static function fromResource(
        $resource,
        ?string $name = null,
        ?string $contentId = null,
        ?string $contentType = null,
        string $charset = self::DEFAULT_CHARSET
    ): ResourceAttachment {
        return new self($resource, $name, $contentId, $contentType, $charset);
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
     * @return string
     */
    public function __toString(): string
    {
        return json_encode([
            'uri'       => stream_get_meta_data($this->resource)['uri'],
            'name'      => $this->name,
            'contentId' => $this->contentId,
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

    protected function determineContentType(): string
    {
        $metadata = stream_get_meta_data($this->resource);

        $wrapperType = $metadata['wrapper_type'];
        $uri         = $metadata['uri'];

        switch ($wrapperType) {
            case 'plainfile':
                return mime_content_type($uri);

                break;

            case 'http':
                $contentType = get_headers($uri, 1)['Content-Type'] ?? null;

                if (!$contentType) {
                    return 'application/octet-stream';
                } else {
                    return explode(';', $contentType)[0];
                }

                break;

            default:
                return 'application/octet-stream';
        }
    }
}
