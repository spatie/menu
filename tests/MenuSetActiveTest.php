<?php

namespace Spatie\Menu\Test;

use Spatie\Menu\Link;
use Spatie\Menu\Menu;

class MenuSetActiveTest extends MenuTestCase
{
    /** @test */
    public function it_can_set_items_active_with_a_callable()
    {
        $this->menu = Menu::new()
            ->link('/', 'Home')
            ->link('/about', 'About')
            ->setActive(function (Link $link) {
                return $link->url() === '/about';
            });

        $this->assertRenders('
            <ul>
                <li><a href="/">Home</a></li>
                <li class="active"><a href="/about">About</a></li>
            </ul>
        ');
    }

    /** @test */
    public function it_can_set_items_active_recursively_through_submenus_with_a_callable()
    {
        $this->menu = Menu::new()
            ->add(Menu::new()
                ->link('/', 'Home')
                ->link('/about', 'About')
            )
            ->setActive(function (Link $link) {
                return $link->url() === '/about';
            });

        $this->assertRenders('
            <ul>
                <li class="active">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li class="active"><a href="/about">About</a></li>
                    </ul>
                </li>
            </ul>
        ');
    }

    /** @test */
    public function it_can_set_items_active_with_an_absolute_url()
    {
        $this->menu = Menu::new()
            ->link('http://example.com', 'Home')
            ->link('http://example.com/disclaimer', 'Disclaimer')
            ->link('http://example.com/disclaimer/intellectual-property', 'Intellectual Property')
            ->setActive('http://example.com/disclaimer');

        $this->assertRenders('
            <ul>
                <li><a href="http://example.com">Home</a></li>
                <li class="active">
                    <a href="http://example.com/disclaimer">Disclaimer</a>
                </li>
                <li>
                    <a href="http://example.com/disclaimer/intellectual-property">Intellectual Property</a>
                </li>
            </ul>
        ');
    }

    /** @test */
    public function it_can_set_items_active_recursively_through_submenus_from_an_absolute_url()
    {
        $this->menu = Menu::new()
            ->add(Menu::new()
                ->link('http://example.com', 'Home')
                ->link('http://example.com/disclaimer', 'Disclaimer')
                ->link('http://example.com/disclaimer/intellectual-property', 'Intellectual Property')
            )
            ->setActive('http://example.com/disclaimer');

        $this->assertRenders('
            <ul>
                <li class="active">
                    <ul>
                        <li><a href="http://example.com">Home</a></li>
                        <li class="active">
                            <a href="http://example.com/disclaimer">Disclaimer</a>
                        </li>
                        <li>
                            <a href="http://example.com/disclaimer/intellectual-property">Intellectual Property</a>
                        </li>
                    </ul>
                </li>
            </ul>
        ');
    }

    /** @test */
    public function it_can_set_items_active_from_a_relative_url()
    {
        $this->menu = Menu::new()
            ->link('/', 'Home')
            ->link('/disclaimer', 'Disclaimer')
            ->link('/disclaimer/intellectual-property', 'Intellectual Property')
            ->setActive('/disclaimer');

        $this->assertRenders('
            <ul>
                <li><a href="/">Home</a></li>
                <li class="active">
                    <a href="/disclaimer">Disclaimer</a>
                </li>
                <li>
                    <a href="/disclaimer/intellectual-property">Intellectual Property</a>
                </li>
            </ul>
        ');
    }

    /** @test */
    public function it_doesnt_set_items_active_if_the_paths_match_but_they_have_a_different_domain()
    {
        $this->menu = Menu::new()
            ->link('https://example.com/foo', 'Example Foo')
            ->link('https://another-example.com/foo', 'Another Example Foo')
            ->setActive('https://example.com/foo');

        $this->assertRenders('
            <ul>
                <li class="active"><a href="https://example.com/foo">Example Foo</a></li>
                <li><a href="https://another-example.com/foo">Another Example Foo</a></li>
            </ul>
        ');
    }

    /** @test */
    public function it_doesnt_set_items_active_if_the_paths_match_but_they_have_a_different_subdomain()
    {
        $this->menu = Menu::new()
            ->link('https://example.com/foo', 'Example Foo')
            ->link('https://sub.example.com/foo', 'Sub Example Foo')
            ->setActive('https://example.com/foo');

        $this->assertRenders('
            <ul>
                <li class="active"><a href="https://example.com/foo">Example Foo</a></li>
                <li><a href="https://sub.example.com/foo">Sub Example Foo</a></li>
            </ul>
        ');
    }

    /** @test */
    public function it_uses_a_request_root_to_ensure_top_level_links_arent_always_active()
    {
        $this->menu = Menu::new()
            ->link('/nl', 'Home')
            ->link('/nl/disclaimer', 'Disclaimer')
            ->link('/nl/disclaimer/intellectuele-eigendom', 'Intellectuële Eigendom')
            ->setActive('/nl/disclaimer', '/nl');

        $this->assertRenders('
            <ul>
                <li><a href="/nl">Home</a></li>
                <li class="active"><a href="/nl/disclaimer">Disclaimer</a></li>
                <li><a href="/nl/disclaimer/intellectuele-eigendom">Intellectuële Eigendom</a></li>
            </ul>
        ');
    }

    /** @test */
    public function the_request_root_also_works_when_not_prepended_by_a_slash()
    {
        $this->menu = Menu::new()
            ->link('/nl', 'Home')
            ->link('/nl/disclaimer', 'Disclaimer')
            ->link('/nl/disclaimer/intellectuele-eigendom', 'Intellectuële Eigendom')
            ->setActive('/nl/disclaimer', 'nl');

        $this->assertRenders('
            <ul>
                <li><a href="/nl">Home</a></li>
                <li class="active"><a href="/nl/disclaimer">Disclaimer</a></li>
                <li><a href="/nl/disclaimer/intellectuele-eigendom">Intellectuële Eigendom</a></li>
            </ul>
        ');
    }

    public function it_can_render_a_custom_active_class()
    {
        $this->menu = Menu::new()
            ->setActiveClass('-active')
            ->link('/', 'Home')
            ->link('/disclaimer', 'Disclaimer')
            ->link('/disclaimer/intellectual-property', 'Intellectual Property')
            ->setActive('http://example.com/disclaimer');

        $this->assertRenders('
            <ul>
                <li><a href="/">Home</a></li>
                <li class="-active">
                    <a href="/disclaimer">Disclaimer</a>
                </li>
                <li class="-active">
                    <a href="/disclaimer/intellectual-property">Intellectual Property</a>
                </li>
            </ul>
        ');
    }
}
