<?php

namespace Spatie\Menu\Test;

abstract class MenuTestCase extends TestCase
{
    /** @var \Spatie\Menu\Menu */
    protected $menu;

    public function assertRenders(string $expected)
    {
        $this->assertHtmlEquals($expected, $this->menu->render());
    }
}
