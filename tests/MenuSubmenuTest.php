<?php

use Spatie\Menu\Activatable;
use Spatie\Menu\Link;
use Spatie\Menu\Menu;

it('can add a submenu with a menu', function () {
    $this->menu = Menu::new()->submenu(Menu::new());

    assertRenders('<ul><li><ul></ul></li></ul>');
});

it('can add a submenu with a callable menu', function () {
    $this->menu = Menu::new()->submenu(function (Menu $menu): Menu {
        return $menu;
    });

    assertRenders('
        <ul>
        <li>
            <ul></ul>
        </li>
        </ul>
    ');
});

it('preserves filters with callable menus', function () {
    $this->menu = Menu::new()
        ->registerFilter(function (Activatable $item) {
        $item->setUrl('/bar'.$item->url());
        })
        ->submenu(function (Menu $menu): Menu {
        return $menu->link('/baz', 'Baz');
        });

    assertRenders('
        <ul>
        <li>
            <ul>
            <li><a href="/bar/baz">Baz</a></li>
            </ul>
        </li>
        </ul>
    ');
});

it('can add a submenu with a string header', function () {
    $this->menu = Menu::new()->submenu('Hi', Menu::new());

    assertRenders('
        <ul>
        <li>Hi<ul></ul></li>
        </ul>
    ');
});

it('can add a submenu with an item header', function () {
    $this->menu = Menu::new()->submenu(Link::to('#', 'Hi'), Menu::new());

    assertRenders('
        <ul>
        <li>
            <a href="#">Hi</a>
            <ul></ul>
        </li>
        </ul>
    ');
});

it('can conditionally add a submenu', function () {
    $this->menu = Menu::new()->submenuIf(false, Menu::new());

    assertRenders('<ul></ul>');
});
