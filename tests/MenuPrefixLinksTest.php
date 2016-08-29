<?php

namespace Spatie\Menu\Test;

use Spatie\Menu\Link;
use Spatie\Menu\Menu;

class MenuPrefixLinksTest extends MenuTestCase
{
    /** @test */
    public function it_can_prefix_link_urls_after_adding_them()
    {
        $this->menu = Menu::new()
            ->add(Link::to('/bar', 'Bar'))
            ->prefixLinks('/foo');

        $this->assertRenders('
            <ul>
                <li><a href="/foo/bar">Bar</a></li>
            </ul>
        ');
    }

    /** @test */
    public function it_can_prefix_link_urls_before_adding_them()
    {
        $this->menu = Menu::new()
            ->prefixLinks('/foo')
            ->add(Link::to('/bar', 'Bar'));

        $this->assertRenders('
            <ul>
                <li><a href="/foo/bar">Bar</a></li>
            </ul>
        ');
    }
}
