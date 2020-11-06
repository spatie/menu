<?php

namespace Spatie\Menu\Test;

use Spatie\Menu\Menu;

class MenuBuildTest extends MenuTestCase
{
    /** @test */
    public function it_can_build_a_menu_from_an_array_of_items_with_a_reducer()
    {
        $items = [
            ['url' => '/', 'text' => 'Home'],
            ['url' => '/about', 'text' => 'About'],
            ['url' => '/contact', 'text' => 'Contact'],
        ];

        $this->menu = Menu::build($items, function (Menu $menu, $item) {
            return $menu->link($item['url'], $item['text']);
        });

        $this->assertRenders('
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>        
        ');
    }

    /** @test */
    public function it_can_build_a_menu_from_an_array_of_items_with_keys_with_a_reducer()
    {
        $items = [
            '/'        => 'Home',
            '/about'   => 'About',
            '/contact' => 'Contact',
        ];

        $this->menu = Menu::build($items, function (Menu $menu, string $text, string $url) {
            return $menu->link($url, $text);
        });

        $this->assertRenders('
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>        
        ');
    }
}
