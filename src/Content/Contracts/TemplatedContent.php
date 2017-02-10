<?php

namespace PhpEmail\Content\Contracts;

/**
 * Email templates allow rendering of content to be handled by third-party service providers such as Postmark,
 * Sparkpost and SendGrid. How an application stores the available third-party templates is up to the developer,
 * so the goal of this interface is to give a standard interaction with some templated email content, knowing that a
 * template must have an identifier provided by the third party service as well as an associative array of substitution
 * data to fill in the template.
 */
interface TemplatedContent
{
    /**
     * @return string
     */
    public function getTemplateId();

    /**
     * @return array|string[]
     */
    public function getTemplateData();
}
