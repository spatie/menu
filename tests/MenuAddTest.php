<?php

namespace Spatie\Menu\Test;

use Spatie\Menu\Link;
use Spatie\Menu\Menu;

class MenuAddTest extends MenuTestCase
{
    /** @test */
    public function it_starts_as_an_empty_list()
    {
        $this->menu = Menu::new();

        $this->assertRenders('<ul></ul>');
    }

    /** @test */
    public function an_item_can_be_added()
    {
        $this->menu = Menu::new()->add(Link::to('#', 'Hello'));

        $this->assertRenders('
            <ul>
                <li><a href="#">Hello</a></li>
            </ul>
        ');
    }

    /** @test */
    public function a_link_can_be_added()
    {
        $this->menu = Menu::new()->link('#', 'Hello');

        $this->assertRenders('
            <ul>
                <li><a href="#">Hello</a></li>
            </ul>
        ');
    }

    /** @test */
    public function an_empty_item_can_be_added()
    {
        $this->menu = Menu::new()->empty();

        $this->assertRenders('
            <ul>
                <li></li>
            </ul>
        ');
    }

    /** @test */
    public function multiple_items_can_be_added()
    {
        $this->menu = Menu::new()
            ->add(Link::to('#', 'Hello'))
            ->add(Link::to('#', 'World'));

        $this->assertRenders('
            <ul>
                <li><a href="#">Hello</a></li>
                <li><a href="#">World</a></li>
            </ul>
        ');
    }

    /** @test */
    public function it_adds_an_active_class_to_active_items()
    {
        $this->menu = Menu::new()
            ->add(Link::to('#', 'Hello')->setActive());

        $this->assertRenders('
            <ul>
                <li class="active"><a href="#">Hello</a></li>
            </ul>
        ');
    }

    /** @test */
    public function submenus_can_be_added()
    {
        $this->menu = Menu::new()
            ->add(Menu::new()
                ->add(Link::to('#', 'In Too Deep'))
            );

        $this->assertRenders('
            <ul>
                <li>
                    <ul>
                        <li><a href="#">In Too Deep</a></li>
                    </ul>
                </li>
            </ul>
        ');
    }

    /** @test */
    public function it_adds_active_classes_to_active_submenus()
    {
        $this->menu = Menu::new()
            ->add(Menu::new()
                ->add(Link::to('#', 'In Too Deep')->setActive())
            );

        $this->assertRenders('
            <ul>
                <li class="active">
                    <ul>
                        <li class="active"><a href="#">In Too Deep</a></li>
                    </ul>
                </li>
            </ul>
        ');
    }

    /** @test */
    public function it_can_conditionally_add_an_item()
    {
        $this->menu = Menu::new()
            ->addIf(true, Link::to('#', 'Foo'))
            ->addIf(false, Link::to('#', 'Bar'))
            ->addIf(function () {
                return true;
            }, Link::to('#', 'Baz'))
            ->addIf(function () {
                return false;
            }, Link::to('#', 'Qux'))
            ->addIf('is_true', Link::to('#', 'Quux'))
            ->addIf('is_false', Link::to('#', 'Quuz'));

        $this->assertRenders('
            <ul>
                <li><a href="#">Foo</a></li>
                <li><a href="#">Baz</a></li>
                <li><a href="#">Quux</a></li>
            </ul>
        ');
    }

    /** @test */
    public function it_can_conditionally_add_a_link()
    {
        $this->menu = Menu::new()
            ->linkIf(true, '#', 'Foo')
            ->linkIf(false, '#', 'Bar')
            ->linkIf(function () {
                return true;
            }, '#', 'Baz')
            ->linkIf(function () {
                return false;
            }, '#', 'Qux')
            ->linkIf('is_true', '#', 'Quux')
            ->linkIf('is_false', '#', 'Quuz');

        $this->assertRenders('
            <ul>
                <li><a href="#">Foo</a></li>
                <li><a href="#">Baz</a></li>
                <li><a href="#">Quux</a></li>
            </ul>
        ');
    }

    /** @test */
    public function it_can_conditionally_add_html()
    {
        $this->menu = Menu::new()
            ->htmlIf(true, 'Foo')
            ->htmlIf(false, 'Bar')
            ->htmlIf(function () {
                return true;
            }, 'Baz')
            ->htmlIf(function () {
                return false;
            }, 'Qux')
            ->htmlIf('is_true', 'Quux')
            ->htmlIf('is_false', 'Quuz');

        $this->assertRenders('
            <ul>
                <li>Foo</li>
                <li>Baz</li>
                <li>Quux</li>
            </ul>
        ');
    }

    /** @test */
    public function it_will_only_add_classes_to_all_links_in_the_menu_not_submenus()
    {
        $this->menu = Menu::new()
            ->addClass('nav')
            ->addItemParentClass('nav-item')
            ->addItemClass('nav-link')
            ->link('#', 'Main Menu Link 1')
            ->link('#', 'Main Menu Link 2')
            ->submenu(
                Link::to('#', 'Sub Menu')->addClass('nav-link nav-dropdown-toggle'),
                Menu::new()
                    ->addClass('nav-dropdown-items') // this has nav-link class from parent menu but it shouldn't
                    ->addParentClass('nav-dropdown')
                    ->addItemParentClass('nav-item')
                    ->addItemClass('nav-link')
                    ->link('#', 'Sub Menu Item 1')
                    ->link('#', 'Sub Menu Item 2')
            );

        $this->menu->render();

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
}
