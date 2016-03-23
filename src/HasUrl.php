<?php

namespace Spatie\Menu;

interface HasUrl
{
    /**
     * Return a segment of the link's URL. This function works for both absolute and relative URL's.
     * The index is a 1-index based number. Trailing and double slashes are ignored.
     *
     * Example: (new Link('Open Source', 'https://spatie.be/opensource'))->segment(1) => 'opensource'
     *
     * @param int $index
     *
     * @return string|null
     */
    public function segment(int $index);

    /**
     * @return string
     */
    public function getUrl() : string;

    /**
     * @param string $prefix
     *
     * @return $this
     */
    public function prefix(string $prefix);
}
