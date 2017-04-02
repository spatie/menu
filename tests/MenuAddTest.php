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
            ->addIf(function () { return true; }, Link::to('#', 'Baz'))
            ->addIf(function () { return false; }, Link::to('#', 'Qux'));

        $this->assertRenders('
            <ul>
                <li><a href="#">Foo</a></li>
                <li><a href="#">Baz</a></li>
            </ul>
        ');
    }

    /** @test */
    public function it_can_conditionally_add_a_link()
    {
        $this->menu = Menu::new()
            ->linkIf(true, '#', 'Foo')
            ->linkIf(false, '#', 'Bar')
            ->linkIf(function () { return true; }, '#', 'Baz')
            ->linkIf(function () { return false; }, '#', 'Qux');

        $this->assertRenders('
            <ul>
                <li><a href="#">Foo</a></li>
                <li><a href="#">Baz</a></li>
            </ul>
        ');
    }

    /** @test */
    public function it_can_conditionally_add_html()
    {
        $this->menu = Menu::new()
            ->htmlIf(true, 'Foo')
            ->htmlIf(false, 'Bar')
            ->htmlIf(function () { return true; }, 'Baz')
            ->htmlIf(function () { return false; }, 'Qux');

        $this->assertRenders('
            <ul>
                <li>Foo</li>
                <li>Baz</li>
            </ul>
        ');
    }
}
