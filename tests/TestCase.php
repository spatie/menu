<?php

namespace Spatie\Menu\Test;

use Spatie\Menu\Item;

class TestCase extends \PHPUnit_Framework_TestCase
{
    public function assertRenders(string $expected, Item $item, string $message = '')
    {
        $this->assertEquals($expected, $item->render(), $message);
    }

    public function assertHtmlEquals(string $expected, string $actual, string $message = '')
    {
        $this->assertEquals(
            $this->sanitizeHtmlWhitespace($expected),
            $this->sanitizeHtmlWhitespace($actual),
            $message
        );
    }

    protected function sanitizeHtmlWhitespace(string $subject) : string
    {
        $find = ['/>\s+</', '/(^\s+)|(\s+$)/'];
        $replace = ['><', ''];

        return preg_replace($find, $replace, $subject);
    }
}
