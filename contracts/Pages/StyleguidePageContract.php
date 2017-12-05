<?php

namespace Contracts\Pages;

interface StyleguidePageContract
{
    /**
     * Get the page data from the page factory.
     *
     * @return array
     */
    public function getPageData();

    /**
     * Get the page path.
     *
     * @return string
     */
    public function getPath();
}
