<?php

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
    public function __construct($templateId, $templateData)
    {
        $this->templateId   = $templateId;
        $this->templateData = $templateData;
    }

    /**
     * @return string
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }

    /**
     * @return array|string[]
     */
    public function getTemplateData()
    {
        return $this->templateData;
    }
}
