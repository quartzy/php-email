<?php

namespace PhpEmail\Content\Contracts;

use PhpEmail\Content;

interface SimpleContent extends Content
{
    /**
     * @return string|null
     */
    public function getHtml();

    /**
     * @return string|null
     */
    public function getText();
}
