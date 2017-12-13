<?php

declare(strict_types=1);

namespace PhpEmail\Attachment;

use PhpEmail\Attachment;
use PhpEmail\Validate;
use RuntimeException;

/**
 * Attach a file by URL. This requires that the `allow_url_fopen` be enabled.
 */
class UrlAttachment implements Attachment
{
    /**
     * @var string
     */
    private $url;

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

    public function __construct(string $url, ?string $name = null)
    {
        Validate::that()
            ->isUrl('url', $url)
            ->now();

        $this->url  = $url;
        $this->name = $name ?: urldecode(basename(parse_url($url, PHP_URL_PATH)));
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
     * {@inheritdoc}
     */
    public function getContentType(): string
    {
        if ($this->contentType === null) {
            $headers = get_headers($this->url, 1);

            $this->contentType = $headers['Content-Type'] ?? null;

            if ($this->contentType === null) {
                throw new RuntimeException('Unable to determine content type of ' . $this->url);
            }

            // Only use the actual type from the content type. Ignore the character set.
            $this->contentType = explode(';', $this->contentType)[0];
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
            'url'  => $this->url,
            'name' => $this->name,
        ]);
    }
}
