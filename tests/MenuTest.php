<?php

namespace Spatie\Menu\Test;

use Spatie\Menu\Items\Link;
use Spatie\Menu\Menu;

class MenuTest extends TestCase
{
    /** @test */
    function it_starts_as_an_empty_list()
    {
        $this->assertRenders(
            '<ul></ul>',
            Menu::new()
        );
    }

    /** @test */
    function it_renders_an_item()
    {
        $this->assertRenders(
            '<ul><li><a href="#">Hello</a></li></ul>',
            Menu::new()->add(Link::to('#', 'Hello'))
        );
    }

    /** @test */
    function it_renders_multiple_items()
    {
        $this->assertRenders(
            '<ul><li><a href="#">Hello</a></li><li><a href="#">World</a></li></ul>',
            Menu::new()->add(Link::to('#', 'Hello'))->add(Link::to('#', 'World'))
        );
    }

    /** @test */
    function it_adds_an_active_class_to_active_items()
    {
        $this->assertRenders(
            '<ul><li class="active"><a href="#">Hello</a></li></ul>',
            Menu::new()->add(Link::to('#', 'Hello')->setActive())
        );
    }

    /** @test */
    function it_can_prefix_link_urls_after_adding_them()
    {
        $this->assertRenders(
            '<ul><li><a href="/foo/bar">Bar</a></li></ul>',
            Menu::new()->add(Link::to('/bar', 'Bar'))->prefixLinks('/foo')
        );
    }

    /** @test */
    function it_can_prefix_link_urls_before_adding_them()
    {
        $this->assertRenders(
            '<ul><li><a href="/foo/bar">Bar</a></li></ul>',
            Menu::new()->prefixLinks('/foo')->add(Link::to('/bar', 'Bar'))
        );
    }

    /** @test */
    function it_can_prepend_content()
    {
        $this->assertRenders(
            '<h1>Hi!</h1><ul></ul>',
            Menu::new()->prepend('<h1>Hi!</h1>')
        );
    }

    /** @test */
    function it_can_append_content()
    {
        $this->assertRenders(
            '<ul></ul><aside>Bye!</aside>',
            Menu::new()->append('<aside>Bye!</aside>')
        );
    }

    /** @test */
    function it_renders_classes()
    {
        $this->assertRenders(
            '<ul class="menu"></ul>',
            Menu::new()->addClass('menu')
        );
    }

    /** @test */
    function it_renders_attributes()
    {
        $this->assertRenders(
            '<ul data-role="navigation"></ul>',
            Menu::new()->setAttribute('data-role', 'navigation')
        );
    }

    /** @test */
    function it_renders_attributes_on_the_list_items()
    {
        $this->assertRenders(
            '<ul><li data-foo><a href="/foo">Foo</a></li></ul>',
            Menu::new()->add(Link::to('/foo', 'Foo')->setParentAttribute('data-foo'))
        );
    }

    /** @test */
    function it_renders_classes_on_the_list_items()
    {
        $this->assertRenders(
            '<ul><li class="red"><a href="/foo">Foo</a></li></ul>',
            Menu::new()->add(Link::to('/foo', 'Foo')->addParentClass('red'))
        );
    }

    /** @test */
    function it_renders_classes_on_the_list_items_when_they_are_active()
    {
        $this->assertRenders(
            '<ul><li class="active red"><a href="/foo">Foo</a></li></ul>',
            Menu::new()->add(Link::to('/foo', 'Foo')->setActive()->addParentClass('red'))
        );
    }

    /** @test */
    function it_renders_submenus()
    {
        $this->assertRenders(
            '<ul><li><ul><li><a href="#">In Too Deep</a></li></ul></li></ul>',
            Menu::new()->add(Menu::new()->add(Link::to('#', 'In Too Deep')))
        );
    }

    /** @test */
    function it_adds_active_classes_to_active_submenus()
    {
        $this->assertRenders(
            '<ul><li class="active"><ul><li class="active"><a href="#">In Too Deep</a></li></ul></li></ul>',
            Menu::new()->add(Menu::new()->add(Link::to('#', 'In Too Deep')->setActive()))
        );
    }
}
