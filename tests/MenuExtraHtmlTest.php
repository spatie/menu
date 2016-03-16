<?php

namespace Spatie\Menu\Test;

use Spatie\Menu\Link;
use Spatie\Menu\Menu;

class MenuExtraHtmlTest extends MenuTestCase
{
    /** @test */
    function it_can_prepend_content()
    {
        $this->menu = Menu::new()->prepend('<h1>Hi!</h1>');

        $this->assertRenders('<h1>Hi!</h1><ul></ul>');
    }

    /** @test */
    function it_can_append_content()
    {
        $this->menu = Menu::new()->append('<aside>Bye!</aside>');

        $this->assertRenders('<ul></ul><aside>Bye!</aside>');
    }

    /** @test */
    function it_renders_classes()
    {
        $this->menu = Menu::new()->addClass('menu');

        $this->assertRenders('<ul class="menu"></ul>');
    }

    /** @test */
    function it_renders_attributes()
    {
        $this->menu = Menu::new()->setAttribute('data-role', 'navigation');

        $this->assertRenders('<ul data-role="navigation"></ul>');
    }

    /** @test */
    function it_renders_attributes_on_the_list_items()
    {
        $this->menu = Menu::new()
            ->add(Link::to('/foo', 'Foo')->setParentAttribute('data-foo'));

        $this->assertRenders('
            <ul>
                <li data-foo><a href="/foo">Foo</a></li>
            </ul>
        ');
    }

    /** @test */
    function it_renders_classes_on_the_list_items()
    {
        $this->menu = Menu::new()
            ->add(Link::to('/foo', 'Foo')->addParentClass('red'));

        $this->assertRenders('
            <ul>
                <li class="red"><a href="/foo">Foo</a></li>
            </ul>
        ');
    }

    /** @test */
    function it_renders_classes_on_the_list_items_when_they_are_active()
    {
        $this->menu = Menu::new()
            ->add(Link::to('/foo', 'Foo')->setActive()->addParentClass('red'));

        $this->assertRenders('
            <ul>
                <li class="active red"><a href="/foo">Foo</a></li>
            </ul>
        ');
    }
}
