<?php

namespace Spatie\Menu\Test;

use Spatie\Menu\Link;
use Spatie\Menu\Menu;
use Spatie\Menu\Activatable;

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
            ->registerFilter(function (Activatable $item) {
                $item->setUrl('/bar'.$item->url());
            })
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

    /** @test */
    public function it_can_render_a_submenu_without_the_menu_item_class() {
        $this->menu = Menu::new()
            ->addClass('nav')
            ->addItemParentClass('nav-item')
            ->addItemClass('nav-link')

            ->link('#', 'Main Menu Link 1')
            ->link('#', 'Main Menu Link 2')
            ->submenu(
                Link::to('#', 'Sub Menu')
                    ->addClass('nav-link nav-dropdown-toggle')
                ,
                Menu::new()
                    ->addClass('nav-dropdown-items') // this has nav-link class from parent menu but it shouldn't
                    ->addParentClass('nav-dropdown')
                    ->addItemParentClass('nav-item')
                    ->addItemClass('nav-link')
                    ->link('#', 'Sub Menu Item 1')
                    ->link('#', 'Sub Menu Item 2')
            );

        $this->assertRenders('
            <ul class="nav">
                <li class="nav-item"><a href="#" class="nav-link">Main Menu Link 1</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Main Menu Link 2</a></li>
                <li class="nav-dropdown nav-item"><a href="#" class="nav-link nav-dropdown-toggle">Sub Menu</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item"><a href="#" class="nav-link">Sub Menu Item 1</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Sub Menu Item 2</a></li>
                    </ul>
                </li>
            </ul>
        ');
    }

    /** @test */
    public function it_can_render_a_submenu_with_the_menu_item_class_when_it_has_the_override_Set() {
        $this->menu = Menu::new()
            ->addClass('nav')
            ->addItemParentClass('nav-item')
            ->addItemClass('nav-link', true)

            ->link('#', 'Main Menu Link 1')
            ->link('#', 'Main Menu Link 2')
            ->submenu(
                Link::to('#', 'Sub Menu')
                    ->addClass('nav-link nav-dropdown-toggle')
                ,
                Menu::new()
                    ->addClass('nav-dropdown-items') // this has nav-link class from parent menu but it shouldn't
                    ->addParentClass('nav-dropdown')
                    ->addItemParentClass('nav-item')
                    ->addItemClass('nav-link')
                    ->link('#', 'Sub Menu Item 1')
                    ->link('#', 'Sub Menu Item 2')
            );

        $this->assertRenders('
            <ul class="nav">
                <li class="nav-item"><a href="#" class="nav-link">Main Menu Link 1</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Main Menu Link 2</a></li>
                <li class="nav-dropdown nav-item"><a href="#" class="nav-link nav-dropdown-toggle">Sub Menu</a>
                    <ul class="nav-dropdown-items nav-link">
                        <li class="nav-item"><a href="#" class="nav-link">Sub Menu Item 1</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Sub Menu Item 2</a></li>
                    </ul>
                </li>
            </ul>
        ');
    }
}
