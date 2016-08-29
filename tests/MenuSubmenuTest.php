<?php

namespace Spatie\Menu\Test;

use Spatie\Menu\Link;
use Spatie\Menu\Menu;

class MenuSubmenuTest extends MenuTestCase
{
    /** @test */
    public function it_can_add_a_submenu_with_a_menu()
    {
        $this->menu = Menu::new()->submenu(Menu::new());

        $this->assertRenders('<ul><li><ul></ul></li></ul>');
    }

    /** @test */
    public function it_can_add_a_submenu_with_a_callable_menu()
    {
        $this->menu = Menu::new()->submenu(function (Menu $menu): Menu {
            return $menu;
        });

        $this->assertRenders('
            <ul>
                <li>
                    <ul></ul>
                </li>
            </ul>
        ');
    }

    /** @test */
    public function it_preserves_filters_with_callable_menus()
    {
        $this->menu = Menu::new()
            ->prefixLinks('/bar')
            ->submenu(function (Menu $menu): Menu {
                return $menu->link('/baz', 'Baz');
            });

        $this->assertRenders('
            <ul>
                <li>
                    <ul>
                        <li><a href="/bar/baz">Baz</a></li>
                    </ul>
                </li>
            </ul>
     
        ');
    }

    /** @test */
    public function it_can_add_a_submenu_with_a_string_header()
    {
        $this->menu = Menu::new()->submenu('Hi', Menu::new());

        $this->assertRenders('
            <ul>
                <li>Hi<ul></ul></li>
            </ul>
        ');
    }

    /** @test */
    public function it_can_add_a_submenu_with_an_item_header()
    {
        $this->menu = Menu::new()->submenu(Link::to('#', 'Hi'), Menu::new());

        $this->assertRenders('
            <ul>
                <li>
                    <a href="#">Hi</a>
                    <ul></ul>
                </li>
            </ul>
        ');
    }

    /** @test */
    public function it_can_conditionally_add_a_submenu()
    {
        $this->menu = Menu::new()->submenuIf(false, Menu::new());

        $this->assertRenders('<ul></ul>');
    }
}
