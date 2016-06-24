<?php

namespace Spatie\Menu\Test;

use Spatie\Menu\Link;
use Spatie\Menu\Menu;

class MenuAddTest extends MenuTestCase
{
    /** @test */
    function it_starts_as_an_empty_list()
    {
        $this->menu = Menu::new();

        $this->assertRenders('<ul></ul>');
    }

    /** @test */
    function an_item_can_be_added()
    {
        $this->menu = Menu::new()->add(Link::to('#', 'Hello'));

        $this->assertRenders('
            <ul>
                <li><a href="#">Hello</a></li>
            </ul>
        ');
    }

    /** @test */
    function a_link_can_be_added()
    {
        $this->menu = Menu::new()->link('#', 'Hello');

        $this->assertRenders('
            <ul>
                <li><a href="#">Hello</a></li>
            </ul>
        ');
    }

    /** @test */
    function multiple_items_can_be_added()
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
    function it_adds_an_active_class_to_active_items()
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
    function submenus_can_be_added()
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
    function it_adds_active_classes_to_active_submenus()
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
    function it_can_conditionally_add_an_item()
    {
        $this->menu = Menu::new()
            ->addIf(true, Link::to('#', 'Foo'))
            ->addIf(false, Link::to('#', 'Bar'));

        $this->assertRenders('
            <ul>
                <li><a href="#">Foo</a></li>
            </ul>
        ');
    }

    /** @test */
    function it_can_conditionally_add_a_link()
    {
        $this->menu = Menu::new()
            ->linkIf(true, '#', 'Foo')
            ->linkIf(false, '#', 'Bar');

        $this->assertRenders('
            <ul>
                <li><a href="#">Foo</a></li>
            </ul>
        ');
    }

    /** @test */
    function it_can_conditionally_add_html()
    {
        $this->menu = Menu::new()
            ->htmlIf(true, 'Foo')
            ->htmlIf(false, 'Bar');

        $this->assertRenders('
            <ul>
                <li>Foo</li>
            </ul>
        ');
    }

    /** @test */
    function it_can_add_void_items_with_parent_attributes()
    {
        $this->menu = Menu::new()->void(['role' => 'divider', 'data-divider']);

        $this->assertRenders('
            <ul>
                <li role="divider" data-divider></li>
            </ul>
        ');
    }

    /** @test */
    function it_can_conditionally_add_void_items_with_parent_attributes()
    {
        $this->menu = Menu::new()
            ->voidIf(true, ['class' => 'divider--a'])
            ->voidIf(false, ['class' => 'divider--b']);

        $this->assertRenders('
            <ul>
                <li class="divider--a"></li>
            </ul>
        ');
    }
}
