<?php

use Spatie\Menu\Link;
use Spatie\Menu\Menu;

it('starts as an empty list', function () {
    $this->menu = Menu::new();

    assertRenders('<ul></ul>');
});

it('an item can be added', function () {
    $this->menu = Menu::new()->add(Link::to('#', 'Hello'));

    assertRenders('
        <ul>
        <li><a href="#">Hello</a></li>
        </ul>
    ');
});

it('a link can be added', function () {
    $this->menu = Menu::new()->link('#', 'Hello');

    assertRenders('
        <ul>
        <li><a href="#">Hello</a></li>
        </ul>
    ');
});

it('an empty item can be added', function () {
    $this->menu = Menu::new()->empty();

    assertRenders('
        <ul>
        <li></li>
        </ul>
    ');
});

it('multiple items can be added', function () {
    $this->menu = Menu::new()
        ->add(Link::to('#', 'Hello'))
        ->add(Link::to('#', 'World'));

    assertRenders('
        <ul>
        <li><a href="#">Hello</a></li>
        <li><a href="#">World</a></li>
        </ul>
    ');
});

it('adds an active class to active items', function () {
    $this->menu = Menu::new()
        ->add(Link::to('#', 'Hello')->setActive());

    assertRenders('
        <ul>
        <li class="active"><a href="#">Hello</a></li>
        </ul>
    ');
});

it('submenus can be added', function () {
    $this->menu = Menu::new()
        ->add(
        Menu::new()
        ->add(Link::to('#', 'In Too Deep'))
        );

    assertRenders('
        <ul>
        <li>
            <ul>
            <li><a href="#">In Too Deep</a></li>
            </ul>
        </li>
        </ul>
    ');
});

it('adds active classes to active submenus', function () {
    $this->menu = Menu::new()
        ->add(
        Menu::new()
        ->add(Link::to('#', 'In Too Deep')->setActive())
        );

    assertRenders('
        <ul>
        <li class="active">
            <ul>
            <li class="active"><a href="#">In Too Deep</a></li>
            </ul>
        </li>
        </ul>
    ');
});

it('can conditionally add an item', function () {
    $this->menu = Menu::new()
        ->addIf(true, Link::to('#', 'Foo'))
        ->addIf(false, Link::to('#', 'Bar'))
        ->addIf(function () {
        return true;
        }, Link::to('#', 'Baz'))
        ->addIf(function () {
        return false;
        }, Link::to('#', 'Qux'))
        ->addIf('is_true', Link::to('#', 'Quux'))
        ->addIf('is_false', Link::to('#', 'Quuz'));

    assertRenders('
        <ul>
        <li><a href="#">Foo</a></li>
        <li><a href="#">Baz</a></li>
        <li><a href="#">Quux</a></li>
        </ul>
    ');
});

it('can conditionally add a link', function () {
    $this->menu = Menu::new()
        ->linkIf(true, '#', 'Foo')
        ->linkIf(false, '#', 'Bar')
        ->linkIf(function () {
        return true;
        }, '#', 'Baz')
        ->linkIf(function () {
        return false;
        }, '#', 'Qux')
        ->linkIf('is_true', '#', 'Quux')
        ->linkIf('is_false', '#', 'Quuz');

    assertRenders('
        <ul>
        <li><a href="#">Foo</a></li>
        <li><a href="#">Baz</a></li>
        <li><a href="#">Quux</a></li>
        </ul>
    ');
});

it('can conditionally add html', function () {
    $this->menu = Menu::new()
        ->htmlIf(true, 'Foo')
        ->htmlIf(false, 'Bar')
        ->htmlIf(function () {
        return true;
        }, 'Baz')
        ->htmlIf(function () {
        return false;
        }, 'Qux')
        ->htmlIf('is_true', 'Quux')
        ->htmlIf('is_false', 'Quuz');

    assertRenders('
        <ul>
        <li>Foo</li>
        <li>Baz</li>
        <li>Quux</li>
        </ul>
    ');
});
