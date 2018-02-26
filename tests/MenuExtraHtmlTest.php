<?php

namespace Spatie\Menu\Test;

use Spatie\Menu\Link;
use Spatie\Menu\Menu;

class MenuExtraHtmlTest extends MenuTestCase
{
    /** @test */
    public function it_can_prepend_content()
    {
        $this->menu = Menu::new()->prepend('<h1>Hi!</h1>');

        $this->assertRenders('<h1>Hi!</h1><ul></ul>');
    }

    public function prependIfDataProvider()
    {
        return [
            [true, '<h1>Hi!</h1>', '<h1>Hi!</h1><ul></ul>'],
            [false, '<h1>Hi!</h1>', '<ul></ul>'],
            [function () {
                return true;
            }, '<h1>Hi!</h1>', '<h1>Hi!</h1><ul></ul>'],
            [function () {
                return false;
            }, '<h1>Hi!</h1>', '<ul></ul>'],
            ['is_true', '<h1>Hi!</h1>', '<h1>Hi!</h1><ul></ul>'],
            ['is_false', '<h1>Hi!</h1>', '<ul></ul>'],
        ];
    }

    /**
     * @test
     * @dataProvider prependIfDataProvider
     * @param \Closure|bool $condition
     * @param string $prepend
     * @param string $expected
     */
    public function it_can_conditionally_prepend_content($condition, string $prepend, string $expected)
    {
        $this->menu = Menu::new()->prependIf($condition, $prepend);

        $this->assertRenders($expected);
    }

    /** @test */
    public function it_can_append_content()
    {
        $this->menu = Menu::new()->append('<aside>Bye!</aside>');

        $this->assertRenders('<ul></ul><aside>Bye!</aside>');
    }

    public function appendIfDataProvider()
    {
        return [
            [true, '<aside>Bye!</aside>', '<ul></ul><aside>Bye!</aside>'],
            [false, '<aside>Bye!</aside>', '<ul></ul>'],
            [function () {
                return true;
            }, '<aside>Bye!</aside>', '<ul></ul><aside>Bye!</aside>'],
            [function () {
                return false;
            }, '<aside>Bye!</aside>', '<ul></ul>'],
            ['is_true', '<aside>Bye!</aside>', '<ul></ul><aside>Bye!</aside>'],
            ['is_false', '<aside>Bye!</aside>', '<ul></ul>'],
        ];
    }

    /**
     * @test
     * @dataProvider appendIfDataProvider
     * @param \Closure|bool $condition
     * @param string $prepend
     * @param string $expected
     */
    public function it_can_conditionally_append_content($condition, string $prepend, string $expected)
    {
        $this->menu = Menu::new()->appendIf($condition, $prepend);

        $this->assertRenders($expected);
    }

    /** @test */
    public function it_renders_classes()
    {
        $this->menu = Menu::new()->addClass('menu');

        $this->assertRenders('<ul class="menu"></ul>');
    }

    /** @test */
    public function it_renders_attributes()
    {
        $this->menu = Menu::new()->setAttribute('data-role', 'navigation');

        $this->assertRenders('<ul data-role="navigation"></ul>');
    }

    /** @test */
    public function it_renders_attributes_on_the_list_items()
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
    public function it_renders_classes_on_the_list_items()
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
    public function it_renders_classes_on_the_list_items_when_they_are_active()
    {
        $this->menu = Menu::new()
            ->add(Link::to('/foo', 'Foo')->setActive()->addParentClass('red'));

        $this->assertRenders('
            <ul>
                <li class="active red"><a href="/foo">Foo</a></li>
            </ul>
        ');
    }

    /** @test */
    public function it_can_be_wrapped_in_an_element()
    {
        $this->menu = Menu::new()->link('#', 'Foo')->wrap('div');

        $this->assertRenders('
            <div>
                <ul>
                    <li><a href="#">Foo</a></li>
                </ul>
            </div>
        ');
    }

    /** @test */
    public function it_can_render_as_another_tag()
    {
        $this->menu = Menu::new()->setTagName('div')->link('#', 'Foo');

        $this->assertRenders('
            <div>
                <li><a href="#">Foo</a></li>
            </div>
        ');
    }

    /** @test */
    public function it_can_render_without_wrapping_links_in_list()
    {
        $this->menu = Menu::new()->wrapLinksInList(false)->link('#', 'Foo');

        $this->assertRenders('
            <ul>
                <a href="#">Foo</a>
            </ul>
        ');
    }

    /** @test */
    public function it_can_render_as_another_tag_without_wrapping_links_in_list()
    {
        $this->menu = Menu::new()
            ->wrapLinksInList(false)
            ->setTagName('div')
            ->link('#', 'Foo');

        $this->assertRenders('
            <div>
                <a href="#">Foo</a>
            </div>
        ');
    }

    /** @test */
    public function it_can_render_as_a_bootstrap_4_menu()
    {
        $submenu = Menu::new()
            ->setTagName('div')
            ->addClass('dropdown-menu')
            ->wrapLinksInList(false)
            ->add(Link::to('#', 'Foo')->addParentClass('nav-item')->addClass('dropdown-item'));

        $this->menu = Menu::new()
            ->addClass('navbar-nav')
            ->add(Link::to('#', 'Foo')->addParentClass('nav-item')->addClass('nav-link'))
            ->submenu(Link::to('#', 'Dropdown link')->addClass('nav-link dropdown-toggle')->setAttribute('data-toggle', 'dropdown'), $submenu->addParentClass('nav-item dropdown'));

        $this->assertRenders('
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="#" class="nav-link">Foo</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle">Dropdown link</a>
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item">Foo</a>
                    </div>
                </li>
            </ul>
        ');
    }
}
