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
}
