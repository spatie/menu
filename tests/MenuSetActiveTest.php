<?php

namespace Spatie\Menu\Test;

use Spatie\Menu\Link;
use Spatie\Menu\Menu;

it('can set items active with a callable', function () {
    $this->menu = Menu::new()
        ->link('/', 'Home')
        ->link('/about', 'About')
        ->setActive(function (Link $link) {
            return $link->url() === '/about';
        });

    assertRenders('
        <ul>
        <li><a href="/">Home</a></li>
        <li class="active exact-active"><a href="/about">About</a></li>
        </ul>
    ');
});

it('can set items exact active', function () {
    $this->menu = Menu::new()
        ->link('/', 'Home')
        ->link('/people', 'People')
        ->link('/people/sebastian', 'Sebastian')
        ->setActive('/people/sebastian');

    assertRenders('
        <ul>
        <li><a href="/">Home</a></li>
        <li class="active"><a href="/people">People</a></li>
        <li class="active exact-active"><a href="/people/sebastian">Sebastian</a></li>
        </ul>
    ');
});

it('can set exact active for submenu header', function () {
    $this->menu = Menu::new()
        ->link('/', 'Home')
        ->submenu(Link::to('/people', 'People'), Menu::new()->link('/people/sebastian', 'Sebastian'))
        ->setActive('/people');

    assertRenders('
        <ul>
        <li><a href="/">Home</a></li>
        <li class="active exact-active">
            <a href="/people">People</a>
            <ul>
            <li><a href="/people/sebastian">Sebastian</a></li>
            </ul>
        </li>
        </ul>
    ');
});

it('can set active for submenu header', function () {
    $this->menu = Menu::new()
        ->link('/', 'Home')
        ->submenu(Link::to('/people', 'People'), Menu::new()->link('/people/sebastian', 'Sebastian'))
        ->setActive('/people/sebastian');

    assertRenders('
        <ul>
        <li><a href="/">Home</a></li>
        <li class="active">
            <a href="/people">People</a>
            <ul>
            <li class="active exact-active"><a href="/people/sebastian">Sebastian</a></li>
            </ul>
        </li>
        </ul>
    ');
});

it('can set link exact active for submenu header', function () {
    $submenu = Menu::new()
        ->link('/people/sebastian', 'Sebastian')
        ->setActiveClassOnLink(true)
        ->setActiveClassOnParent(false);

    $this->menu = Menu::new()
        ->link('/', 'Home')
        ->submenu(Link::to('/people', 'People'), $submenu)
        ->setActive('/people')
        ->setActiveClassOnLink(true)
        ->setActiveClassOnParent(false);

    assertRenders('
        <ul>
        <li><a href="/">Home</a></li>
        <li>
            <a href="/people" class="active exact-active">People</a>
            <ul>
            <li><a href="/people/sebastian">Sebastian</a></li>
            </ul>
        </li>
        </ul>
    ');
});

it('can set link active for submenu header', function () {
    $submenu = Menu::new()
        ->link('/people/sebastian', 'Sebastian')
        ->setActiveClassOnLink(true)
        ->setActiveClassOnParent(false);

    $this->menu = Menu::new()
        ->link('/', 'Home')
        ->submenu(Link::to('/people', 'People'), $submenu)
        ->setActive('/people/sebastian')
        ->setActiveClassOnLink(true)
        ->setActiveClassOnParent(false);

    assertRenders('
        <ul>
        <li><a href="/">Home</a></li>
        <li>
            <a href="/people" class="active">People</a>
            <ul>
            <li><a href="/people/sebastian" class="active exact-active">Sebastian</a></li>
            </ul>
        </li>
        </ul>
    ');
});

it('only sets exact active on exact url match', function () {
    $this->menu = Menu::new()
        ->link('/', 'Home')
        ->link('/people', 'People')
        ->link('/people/sebastian', 'Sebastian')
        ->link('/people/sebastian/bio', 'Bio')
        ->setActive('/people/sebastian');

    assertRenders('
        <ul>
        <li><a href="/">Home</a></li>
        <li class="active"><a href="/people">People</a></li>
        <li class="active exact-active"><a href="/people/sebastian">Sebastian</a></li>
        <li><a href="/people/sebastian/bio">Bio</a></li>
        </ul>
    ');
});

it('can set items active recursively through submenus with a callable', function () {
    $this->menu = Menu::new()
        ->add(
            Menu::new()
            ->link('/', 'Home')
            ->link('/about', 'About')
        )
        ->setActive(function (Link $link) {
            return $link->url() === '/about';
        });

    assertRenders('
        <ul>
        <li class="active">
            <ul>
            <li><a href="/">Home</a></li>
            <li class="active exact-active"><a href="/about">About</a></li>
            </ul>
        </li>
        </ul>
    ');
});

it('can set items active while items exists with startswith true', function () {
    $this->menu = Menu::new()
        ->link('http://example.com', 'Home')
        ->link('http://example.com/disclaimer', 'Disclaimer')
        ->link('http://example.com/disclaimer-full', 'Full Disclaimer')
        ->setActive('http://example.com/disclaimer-full');

    assertRenders('
        <ul>
        <li><a href="http://example.com">Home</a></li>
        <li>
            <a href="http://example.com/disclaimer">Disclaimer</a>
        </li>
        <li class="active exact-active">
            <a href="http://example.com/disclaimer-full">Full Disclaimer</a>
        </li>
        </ul>
    ');
});

it('can set items active with an absolute url', function () {
    $this->menu = Menu::new()
        ->link('http://example.com', 'Home')
        ->link('http://example.com/disclaimer', 'Disclaimer')
        ->link('http://example.com/disclaimer/intellectual-property', 'Intellectual Property')
        ->setActive('http://example.com/disclaimer');

    assertRenders('
        <ul>
        <li><a href="http://example.com">Home</a></li>
        <li class="active exact-active">
            <a href="http://example.com/disclaimer">Disclaimer</a>
        </li>
        <li>
            <a href="http://example.com/disclaimer/intellectual-property">Intellectual Property</a>
        </li>
        </ul>
    ');
});

it('can set items active recursively through submenus from an absolute url', function () {
    $this->menu = Menu::new()
        ->add(
            Menu::new()
            ->link('http://example.com', 'Home')
            ->link('http://example.com/disclaimer', 'Disclaimer')
            ->link('http://example.com/disclaimer/intellectual-property', 'Intellectual Property')
        )
        ->setActive('http://example.com/disclaimer');

    assertRenders('
        <ul>
        <li class="active">
            <ul>
            <li><a href="http://example.com">Home</a></li>
            <li class="active exact-active">
                <a href="http://example.com/disclaimer">Disclaimer</a>
            </li>
            <li>
                <a href="http://example.com/disclaimer/intellectual-property">Intellectual Property</a>
            </li>
            </ul>
        </li>
        </ul>
    ');
});

it('can set items active from a relative url', function () {
    $this->menu = Menu::new()
        ->link('/', 'Home')
        ->link('/disclaimer', 'Disclaimer')
        ->link('/disclaimer/intellectual-property', 'Intellectual Property')
        ->setActive('/disclaimer');

    assertRenders('
        <ul>
        <li><a href="/">Home</a></li>
        <li class="active exact-active">
            <a href="/disclaimer">Disclaimer</a>
        </li>
        <li>
            <a href="/disclaimer/intellectual-property">Intellectual Property</a>
        </li>
        </ul>
    ');
});

it('doesnt set items active if the paths match but they have a different domain', function () {
    $this->menu = Menu::new()
        ->link('https://example.com/foo', 'Example Foo')
        ->link('https://another-example.com/foo', 'Another Example Foo')
        ->setActive('https://example.com/foo');

    assertRenders('
        <ul>
        <li class="active exact-active"><a href="https://example.com/foo">Example Foo</a></li>
        <li><a href="https://another-example.com/foo">Another Example Foo</a></li>
        </ul>
    ');
});

it('doesnt set items active if the paths match but they have a different subdomain', function () {
    $this->menu = Menu::new()
        ->link('https://example.com/foo', 'Example Foo')
        ->link('https://sub.example.com/foo', 'Sub Example Foo')
        ->setActive('https://example.com/foo');

    assertRenders('
        <ul>
        <li class="active exact-active"><a href="https://example.com/foo">Example Foo</a></li>
        <li><a href="https://sub.example.com/foo">Sub Example Foo</a></li>
        </ul>
    ');
});

it('uses a request root to ensure top level links arent always active', function () {
    $this->menu = Menu::new()
        ->link('/nl', 'Home')
        ->link('/nl/disclaimer', 'Disclaimer')
        ->link('/nl/disclaimer/intellectuele-eigendom', 'Intellectuële Eigendom')
        ->setActive('/nl/disclaimer', '/nl');

    assertRenders('
        <ul>
        <li><a href="/nl">Home</a></li>
        <li class="active exact-active"><a href="/nl/disclaimer">Disclaimer</a></li>
        <li><a href="/nl/disclaimer/intellectuele-eigendom">Intellectuële Eigendom</a></li>
        </ul>
    ');
});

it('the request root also works when not prepended by a slash', function () {
    $this->menu = Menu::new()
        ->link('/nl', 'Home')
        ->link('/nl/disclaimer', 'Disclaimer')
        ->link('/nl/disclaimer/intellectuele-eigendom', 'Intellectuële Eigendom')
        ->setActive('/nl/disclaimer', 'nl');

    assertRenders('
        <ul>
        <li><a href="/nl">Home</a></li>
        <li class="active exact-active"><a href="/nl/disclaimer">Disclaimer</a></li>
        <li><a href="/nl/disclaimer/intellectuele-eigendom">Intellectuële Eigendom</a></li>
        </ul>
    ');
});

it('and we can still set the root as active', function () {
    $this->menu = Menu::new()
        ->link('/nl', 'Home')
        ->link('/nl/disclaimer', 'Disclaimer')
        ->link('/nl/disclaimer/intellectuele-eigendom', 'Intellectuële Eigendom')
        ->setActive('/nl/', '/nl');

    assertRenders('
        <ul>
        <li class="active exact-active"><a href="/nl">Home</a></li>
        <li><a href="/nl/disclaimer">Disclaimer</a></li>
        <li><a href="/nl/disclaimer/intellectuele-eigendom">Intellectuële Eigendom</a></li>
        </ul>
    ');
});

it('can render a custom active class', function () {
    $this->menu = Menu::new()
        ->setActiveClass('-active')
        ->link('/', 'Home')
        ->link('/disclaimer', 'Disclaimer')
        ->link('/disclaimer/intellectual-property', 'Intellectual Property')
        ->setActive('http://example.com/disclaimer');

    assertRenders('
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
})->skip();

it('can render a custom exact active class', function () {
    $this->menu = Menu::new()
        ->setExactActiveClass('e-active')
        ->link('/', 'Home')
        ->link('/disclaimer', 'Disclaimer')
        ->link('/disclaimer/intellectual-property', 'Intellectual Property')
        ->setActive('/disclaimer');

    assertRenders('
        <ul>
        <li><a href="/">Home</a></li>
        <li class="active e-active">
            <a href="/disclaimer">Disclaimer</a>
        </li>
        <li>
            <a href="/disclaimer/intellectual-property">Intellectual Property</a>
        </li>
        </ul>
    ');
});

it('can render active on custom tag', function () {
    $this->menu = Menu::new()
        ->setWrapperTag('div')
        ->link('/', 'Home')
        ->link('/about', 'About')
        ->setActive(function (Link $link) {
            return $link->url() === '/about';
        });

    assertRenders('
        <div>
        <li><a href="/">Home</a></li>
        <li class="active exact-active"><a href="/about">About</a></li>
        </div>
    ');
});

it('can render active without list items', function () {
    $this->menu = Menu::new()
        ->withoutParentTag()
        ->setActiveClassOnLink()
        ->link('/', 'Home')
        ->link('/about', 'About')
        ->setActive(function (Link $link) {
            return $link->url() === '/about';
        });

    assertRenders('
        <ul>
        <a href="/">Home</a>
        <a href="/about" class="active exact-active">About</a>
        </ul>
    ');
});

it('can render active on custom tag without list items', function () {
    $this->menu = Menu::new()
        ->setWrapperTag('div')
        ->withoutParentTag()
        ->setActiveClassOnLink()
        ->link('/', 'Home')
        ->link('/about', 'About')
        ->setActive(function (Link $link) {
            return $link->url() === '/about';
        });

    assertRenders('
        <div>
        <a href="/">Home</a>
        <a href="/about" class="active exact-active">About</a>
        </div>
    ');
});

it('can render active on a bootstrap 4 menu', function () {
    $submenu = Menu::new()
        ->setWrapperTag('div')
        ->addClass('dropdown-menu')
        ->withoutParentTag()
        ->setActiveClassOnLink()
        ->add(Link::to('/', 'Home')->addParentClass('nav-item')->addClass('dropdown-item'));

    $this->menu = Menu::new()
        ->addClass('navbar-nav')
        ->add(Link::to('/about', 'About')->addParentClass('nav-item')->addClass('nav-link'))
        ->submenu(Link::to('#', 'Dropdown link')->addClass('nav-link dropdown-toggle')->setAttribute('data-toggle', 'dropdown'), $submenu->addParentClass('nav-item dropdown'))
        ->setActive(function (Link $link) {
            return $link->url() === '/about';
        });

    assertRenders('
        <ul class="navbar-nav">
        <li class="active exact-active nav-item">
            <a href="/about" class="nav-link">About</a>
        </li>
        <li class="nav-item dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle">Dropdown link</a>
            <div class="dropdown-menu">
            <a href="/" class="dropdown-item">Home</a>
            </div>
        </li>
        </ul>
    ');
});

it('can render active on a bootstrap 4 submenu', function () {
    $submenu = Menu::new()
        ->setWrapperTag('div')
        ->withoutParentTag()
        ->setActiveClassOnLink()
        ->addClass('dropdown-menu')
        ->add(Link::to('/about', 'About')->addParentClass('nav-item')->addClass('dropdown-item'));

    $this->menu = Menu::new()
        ->addClass('navbar-nav')
        ->add(Link::to('/', 'Home')->addParentClass('nav-item')->addClass('nav-link'))
        ->submenu(Link::to('#', 'Dropdown link')->addClass('nav-link dropdown-toggle')->setAttribute('data-toggle', 'dropdown'), $submenu->addParentClass('nav-item dropdown'))
        ->setActive(function (Link $link) {
            return $link->url() === '/about';
        });

    assertRenders('
        <ul class="navbar-nav">
        <li class="nav-item">
            <a href="/" class="nav-link">Home</a>
        </li>
        <li class="active nav-item dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle">Dropdown link</a>
            <div class="dropdown-menu">
            <a href="/about" class="dropdown-item active exact-active">About</a>
            </div>
        </li>
        </ul>
    ');
});

it('can have no active class', function () {
    $this->menu = Menu::new()
        ->link('/', 'Home')
        ->link('/disclaimer', 'Disclaimer')
        ->link('/disclaimer/intellectual-property', 'Intellectual Property')
        ->setActiveClassOnParent(false)
        ->setActive('/disclaimer');

    assertRenders('
        <ul>
        <li><a href="/">Home</a></li>
        <li>
            <a href="/disclaimer">Disclaimer</a>
        </li>
        <li>
            <a href="/disclaimer/intellectual-property">Intellectual Property</a>
        </li>
        </ul>
    ');
});
