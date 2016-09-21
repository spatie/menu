<?php

namespace Spatie\Menu\Test;

use Spatie\Menu\Menu;

class MenuPrefixLinksTest extends MenuTestCase
{
    /** @test */
    public function it_can_prefix_urls_after_adding_them()
    {
        $this->menu = Menu::new()
            ->link('/bar', 'Bar')
            ->prefixUrls('/foo');

        $this->assertRenders('
            <ul>
                <li><a href="/foo/bar">Bar</a></li>
            </ul>
        ');
    }

    /** @test */
    public function it_can_prefix_urls_before_adding_them()
    {
        $this->menu = Menu::new()
            ->prefixUrls('/foo')
            ->link('/bar', 'Bar');

        $this->assertRenders('
            <ul>
                <li><a href="/foo/bar">Bar</a></li>
            </ul>
        ');
    }

    /** @test */
    public function it_prefixes_urls_in_submenus()
    {
        $this->menu = Menu::new()
            ->prefixUrls('/foo')
            ->link('/bar', 'Bar')
            ->submenu(function (Menu $menu) {
                return $menu->prefixUrls('/baz')->link('qux', 'Qux');
            });

        $this->assertRenders('
            <ul>
                <li><a href="/foo/bar">Bar</a></li>
                <li>
                    <ul>
                        <li><a href="/foo/baz/qux">Qux</a></li>
                    </ul>
                </li>
            </ul>
        ');
    }
}
