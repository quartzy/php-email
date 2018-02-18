<?php

declare(strict_types=1);

namespace PhpEmail\Attachment;

use PhpEmail\Attachment;
use PhpEmail\Validate;

/**
 * Attach a file by URL. This requires that the `allow_url_fopen` be enabled.
 */
class UrlAttachment extends AttachmentWithHeaders
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string|null
     */
    private $content = null;

    /**
     * @param string      $url
     * @param null|string $name        If null, the class will determine a name for the attachment based on the URL.
     * @param null|string $contentId
     * @param null|string $contentType
     * @param string      $charset
     */
    public function __construct(
        string $url,
        ?string $name = null,
        ?string $contentId = null,
        ?string $contentType = null,
        string $charset = self::DEFAULT_CHARSET
    ) {
        Validate::that()
            ->isUrl('url', $url)
            ->now();

        $this->url         = $url;
        $this->name        = $name ?: urldecode(basename(parse_url($url, PHP_URL_PATH)));
        $this->contentId   = $contentId;
        $this->contentType = $contentType;
        $this->charset     = $charset;
    }

    /**
     * A static constructor for the UrlAttachment constructor.
     *
     * @param string      $url
     * @param null|string $name        If null, the class will determine a name for the attachment based on the URL.
     * @param null|string $contentId
     * @param null|string $contentType
     * @param string      $charset
     *
     * @return UrlAttachment
     */
    public static function fromUrl(
        string $url,
        ?string $name = null,
        ?string $contentId = null,
        ?string $contentType = null,
        string $charset = self::DEFAULT_CHARSET
    ): UrlAttachment {
        return new self($url, $name, $contentId, $contentType, $charset);
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent(): string
    {
        if ($this->content === null) {
            $this->content = file_get_contents($this->url);
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
            'url'       => $this->url,
            'name'      => $this->name,
            'contentId' => $this->contentId,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function determineContentType(): string
    {
        $contentType = get_headers($this->url, 1)['Content-Type'] ?? null;

        if (!$contentType) {
            return 'application/octet-stream';
        } else {
            return explode(';', $contentType)[0];
        }
    }
}
