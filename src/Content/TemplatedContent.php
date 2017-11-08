<?php

declare(strict_types=1);

namespace PhpEmail\Content;

use PhpEmail\Content;

class TemplatedContent implements Content\Contracts\TemplatedContent
{
    /**
     * @var string
     */
    protected $templateId;

    /**
     * @var array
     */
    protected $templateData;

    /**
     * @param string $templateId
     * @param array  $templateData
     */
    public function __construct(string $templateId, array $templateData)
    {
        $this->templateId   = $templateId;
        $this->templateData = $templateData;
    }

    /**
     * @return string
     */
    public function getTemplateId(): string
    {
        return $this->templateId;
    }

    /**
     * @return array|string[]
     */
    public function getTemplateData(): array
    {
        return $this->templateData;
    }
}
