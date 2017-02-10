<?php

namespace PhpEmail\Content\Contracts;

interface SimpleContent
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
