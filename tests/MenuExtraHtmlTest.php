<?php

use Spatie\Menu\Link;
use Spatie\Menu\Menu;

it('can prepend content', function () {
    $this->menu = Menu::new()->prepend('<h1>Hi!</h1>');

    assertRenders('<h1>Hi!</h1><ul></ul>');
});

it('can prepend items', function () {
    $this->menu = Menu::new()->prepend(Link::to('#', 'Hi!'));

    assertRenders('<a href="#">Hi!</a><ul></ul>');
});

it('can conditionally prepend content', function ($condition, string $prepend, string $expected) {
    $this->menu = Menu::new()->prependIf($condition, $prepend);

    assertRenders($expected);
})->with('prepend_if');

it('can append content', function () {
    $this->menu = Menu::new()->append('<aside>Bye!</aside>');

    assertRenders('<ul></ul><aside>Bye!</aside>');
});

it('can append items', function () {
    $this->menu = Menu::new()->append(Link::to('#', 'Bye!'));

    assertRenders('<ul></ul><a href="#">Bye!</a>');
});

it('can conditionally append content', function ($condition, string $prepend, string $expected) {
    $this->menu = Menu::new()->appendIf($condition, $prepend);

    assertRenders($expected);
})->with('append_if');

it('renders classes', function () {
    $this->menu = Menu::new()->addClass('menu');

    assertRenders('<ul class="menu"></ul>');
});

it('renders attributes', function () {
    $this->menu = Menu::new()->setAttribute('data-role', 'navigation');

    assertRenders('<ul data-role="navigation"></ul>');
});

it('renders attributes on the list items', function () {
    $this->menu = Menu::new()
        ->add(Link::to('/foo', 'Foo')->setParentAttribute('data-foo'));

    assertRenders('
        <ul>
        <li data-foo><a href="/foo">Foo</a></li>
        </ul>
    ');
});

it('renders classes on the list items', function () {
    $this->menu = Menu::new()
        ->add(Link::to('/foo', 'Foo')->addParentClass('red'));

    assertRenders('
        <ul>
        <li class="red"><a href="/foo">Foo</a></li>
        </ul>
    ');
});

it('renders classes on the list items when they are active', function () {
    $this->menu = Menu::new()
        ->add(Link::to('/foo', 'Foo')->setActive()->addParentClass('red'));

    assertRenders('
        <ul>
        <li class="active red"><a href="/foo">Foo</a></li>
        </ul>
    ');
});

it('can be wrapped in an element', function () {
    $this->menu = Menu::new()->link('#', 'Foo')->wrap('div');

    assertRenders('
        <div>
        <ul>
            <li><a href="#">Foo</a></li>
        </ul>
        </div>
    ');
});

it('can render without wrapping anything', function () {
    $this->menu = Menu::new()
        ->withoutWrapperTag()
        ->withoutParentTag()
        ->link('#', 'Foo');

    assertRenders('
        <a href="#">Foo</a>
    ');
});

it('can render as another tag with a custom wrapper tag', function () {
    $this->menu = Menu::new()
        ->setWrapperTag('div')
        ->withoutParentTag()
        ->link('#', 'Foo');

    assertRenders('
        <div>
        <a href="#">Foo</a>
        </div>
    ');
});

it('can render as another tag with custom parent tags', function () {
    $this->menu = Menu::new()
        ->withoutWrapperTag()
        ->setParentTag('span')
        ->link('#', 'Foo');

    assertRenders('
        <span><a href="#">Foo</a></span>
    ');
});

it('can render as a bootstrap 4 menu', function () {
    $submenu = Menu::new()
        ->setWrapperTag('div')
        ->withoutParentTag()
        ->addClass('dropdown-menu')
        ->add(Link::to('#', 'Foo')->addParentClass('nav-item')->addClass('dropdown-item'));

    $this->menu = Menu::new()
        ->addClass('navbar-nav')
        ->add(Link::to('#', 'Foo')->addParentClass('nav-item')->addClass('nav-link'))
        ->submenu(Link::to('#', 'Dropdown link')->addClass('nav-link dropdown-toggle')->setAttribute('data-toggle', 'dropdown'), $submenu->addParentClass('nav-item dropdown'));

    assertRenders('
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
});
