<?php

declare(strict_types=1);

namespace PhpEmail\Content\Contracts;

use PhpEmail\Content;

interface SimpleContent extends Content
{
    /**
     * @return string|null
     */
    public function getHtml(): ?string;

    /**
     * @return string|null
     */
    public function getText(): ?string;
}
