<?php

use Spatie\Menu\Menu;

it('can build a menu from an array of items with a reducer', function () {
    $items = [
        ['url' => '/', 'text' => 'Home'],
        ['url' => '/about', 'text' => 'About'],
        ['url' => '/contact', 'text' => 'Contact'],
    ];

    $this->menu = Menu::build($items, function (Menu $menu, $item) {
        return $menu->link($item['url'], $item['text']);
    });

    assertRenders('
        <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/about">About</a></li>
        <li><a href="/contact">Contact</a></li>
        </ul>
    ');
});

it('can build a menu from an array of items with keys with a reducer', function () {
    $items = [
        '/' => 'Home',
        '/about' => 'About',
        '/contact' => 'Contact',
    ];

    $this->menu = Menu::build($items, function (Menu $menu, string $text, string $url) {
        return $menu->link($url, $text);
    });

    assertRenders('
        <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/about">About</a></li>
        <li><a href="/contact">Contact</a></li>
        </ul>
    ');
});
