<?php

declare(strict_types=1);

namespace PhpEmail\Content\Contracts;

use PhpEmail\Content;
use PhpEmail\Content\SimpleContent\Message;

interface SimpleContent extends Content
{
    /**
     * @return Message|null
     */
    public function getHtml(): ?Message;

    /**
     * @return Message|null
     */
    public function getText(): ?Message;
}
