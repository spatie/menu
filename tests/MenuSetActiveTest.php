<?php

namespace Spatie\Menu\Test;

use Spatie\Menu\Link;
use Spatie\Menu\Menu;

class MenuSetActiveTest extends MenuTestCase
{
    /** @test */
    function it_can_set_items_active_with_a_callable()
    {
        $this->menu = Menu::new()
            ->add(Link::to('/', 'Home'))
            ->add(Link::to('/about', 'About'))
            ->setActive(function (Link $link) {
                return $link->getUrl() === '/about';
            });

        $this->assertRenders('
            <ul>
                <li><a href="/">Home</a></li>
                <li class="active"><a href="/about">About</a></li>
            </ul>
        ');
    }

    /** @test */
    function it_can_set_items_active_recursively_through_submenus_with_a_callable()
    {
        $this->menu = Menu::new()
            ->add(Menu::new()
                ->add(Link::to('/', 'Home'))
                ->add(Link::to('/about', 'About'))
            )
            ->setActive(function (Link $link) {
                return $link->getUrl() === '/about';
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
    function it_can_set_items_active_from_an_absolute_url()
    {
        $this->menu = Menu::new()
            ->add(Link::to('/', 'Home'))
            ->add(Link::to('/disclaimer', 'Disclaimer'))
            ->add(Link::to('/disclaimer/intellectual-property', 'Intellectual Property'))
            ->setActive('http://example.com/disclaimer');

        $this->assertRenders('
            <ul>
                <li><a href="/">Home</a></li>
                <li class="active">
                    <a href="/disclaimer">Disclaimer</a>
                </li>
                <li class="active">
                    <a href="/disclaimer/intellectual-property">Intellectual Property</a>
                </li>
            </ul>
        ');
    }

    /** @test */
    function it_can_set_items_active_recursively_through_submenus_from_an_absolute_url()
    {
        $this->menu = Menu::new()
            ->add(Menu::new()
                ->add(Link::to('/', 'Home'))
                ->add(Link::to('/disclaimer', 'Disclaimer'))
                ->add(Link::to('/disclaimer/intellectual-property', 'Intellectual Property'))
            )
            ->setActive('http://example.com/disclaimer');

        $this->assertRenders('
            <ul>
                <li class="active">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li class="active">
                            <a href="/disclaimer">Disclaimer</a>
                        </li>
                        <li class="active">
                            <a href="/disclaimer/intellectual-property">Intellectual Property</a>
                        </li>
                    </ul>
                </li>
            </ul>
        ');
    }

    /** @test */
    function it_can_set_items_active_from_a_relative_url()
    {
        $this->menu = Menu::new()
            ->add(Link::to('/', 'Home'))
            ->add(Link::to('/disclaimer', 'Disclaimer'))
            ->add(Link::to('/disclaimer/intellectual-property', 'Intellectual Property'))
            ->setActive('/disclaimer');

        $this->assertRenders('
            <ul>
                <li><a href="/">Home</a></li>
                <li class="active">
                    <a href="/disclaimer">Disclaimer</a>
                </li>
                <li class="active">
                    <a href="/disclaimer/intellectual-property">Intellectual Property</a>
                </li>
            </ul>
        ');
    }

    /** @test */
    function it_doesnt_set_items_active_if_the_paths_match_but_they_have_a_different_domain()
    {
        $this->menu = Menu::new()
            ->add(Link::to('https://example.com/foo', 'Example Foo'))
            ->add(Link::to('https://another-example.com/foo', 'Another Example Foo'))
            ->setActive('https://example.com/foo');

        $this->assertRenders('
            <ul>
                <li class="active"><a href="https://example.com/foo">Example Foo</a></li>
                <li><a href="https://another-example.com/foo">Another Example Foo</a></li>
            </ul>
        ');
    }

    /** @test */
    function it_doesnt_set_items_active_if_the_paths_match_but_they_have_a_different_subdomain()
    {
        $this->menu = Menu::new()
            ->add(Link::to('https://example.com/foo', 'Example Foo'))
            ->add(Link::to('https://sub.example.com/foo', 'Sub Example Foo'))
            ->setActive('https://example.com/foo');

        $this->assertRenders('
            <ul>
                <li class="active"><a href="https://example.com/foo">Example Foo</a></li>
                <li><a href="https://sub.example.com/foo">Sub Example Foo</a></li>
            </ul>
        ');
    }

    /** @test */
    function it_uses_a_request_root_to_ensure_top_level_links_arent_always_active()
    {
        $this->menu = Menu::new()
            ->add(Link::to('/nl', 'Home'))
            ->add(Link::to('/nl/disclaimer', 'Disclaimer'))
            ->add(Link::to('/nl/disclaimer/intellectuele-eigendom', 'Intellectuële Eigendom'))
            ->setActive('https://example.com/nl', '/nl');

        $this->assertRenders('
            <ul>
                <li class="active"><a href="/nl">Home</a></li>
                <li><a href="/nl/disclaimer">Disclaimer</a></li>
                <li><a href="/nl/disclaimer/intellectuele-eigendom">Intellectuële Eigendom</a></li>
            </ul>
        ');
    }

    function it_can_render_a_custom_active_class()
    {
        $this->menu = Menu::new()
            ->setActiveClass('-active')
            ->add(Link::to('/', 'Home'))
            ->add(Link::to('/disclaimer', 'Disclaimer'))
            ->add(Link::to('/disclaimer/intellectual-property', 'Intellectual Property'))
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
