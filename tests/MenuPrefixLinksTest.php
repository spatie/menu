<?php

namespace Spatie\Menu\Test;

use Spatie\Menu\Link;
use Spatie\Menu\Menu;

class MenuPrefixLinksTest extends MenuTestCase
{
    /** @test */
    public function it_can_prefix_urls_after_adding_them()
    {
        $this->menu = Menu::new()
            ->add(Link::to('/bar', 'Bar'))
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
            ->add(Link::to('/bar', 'Bar'));

        $this->assertRenders('
            <ul>
                <li><a href="/foo/bar">Bar</a></li>
            </ul>
        ');
    }
}
