---
title: Introduction
weight: 1
---

The `spatie/menu` package provides a fluent interface to build menus of any size in your php application. If you're building your app with Laravel, the `spatie/laravel-menu` provides some extra treats.

## Human Readable, Fluent Interface

All classes provide a human readable, fluent interface (no array configuration). Additionally, you can opt for a more verbose and flexible syntax, or for convenience methods that cover most use cases.

```php
Menu::new()
    ->add(Link::to('/', 'Home'))
    ->add(Link::to('/about', 'About'))
    ->add(Link::to('/contact', 'Contact'))
    ->render();

// Or just...
Menu::new()
    ->link('/', 'Home')
    ->link('/about', 'About')
    ->link('/contact', 'Contact');
```

```html
<ul>
    <li><a href="/">Home</a></li>
    <li><a href="/about">About</a></li>
    <li><a href="/contact">Contact</a></li>
</ul>
```

## Strong Control Over the Html Output

You can programatically add html classes and attributes to any item in the menu, or to the menu itself.

```php
Menu::new()
    ->addClass('navigation')
    ->add(Link::to('/', 'Home')->addClass('home-link'))
    ->add(Link::to('/about', 'About'))
    ->add(Link::to('/contact', 'Contact')->addParentClass('float-right'))
    ->wrap('div', ['class' => 'wrapper'])
```

```html
<div class="wrapper">
    <ul class="navigation">
        <li><a href="/" class="home-link">Home</a></li>
        <li><a href="/about">About</a></li>
        <li class="float-right"><a href="/contact">Contact</a></li>
    </ul>
</div
```

## Adding an ID to elements

You can add id, so you can easily target some of these elements with CSS or JS.

```php
Menu::new()
    ->id('navigation')
    ->add(Link::to('/', 'Home')->id('home-link'))
    ->add(Link::to('/about', 'About'))
    ->add(Link::to('/contact', 'Contact'))
```

```html
<ul id="navigation">
    <li><a href="/" id="home-link">Home</a></li>
    <li><a href="/about">About</a></li>
    <li><a href="/contact">Contact</a></li>
</ul>
```

## Not Afraid of Depths

The menu supports submenus, which in turn can be nested infinitely.

```php
Menu::new()
    ->add(Link::to('/', 'Home'))
    ->submenu('More', Menu::new()
        ->addClass('submenu')
        ->link('/about', 'About')
        ->link('/contact', 'Contact')
    );
```

```html
<ul>
    <li><a href="/">Home</a></li>
    <li>
        More
        <ul class="submenu">
            <li><a href="/about">About</a></li>
            <li><a href="/contact">Contact</a></li>
        </ul>
    </li>
</ul>
```

## Some Extra Treats for Laravel Apps

The Laravel version of the menu package adds some extras like convenience methods for generating URLs and macros.

```php
Menu::macro('main', function () {
    return Menu::new()
        ->action('HomeController@index', 'Home')
        ->action('AboutController@index', 'About')
        ->action('ContactController@index', 'Contact')
        ->setActiveFromRequest();
});
```

```html
<nav class="navigation">
    {!! Menu::main() !!}
</nav>
```

## We have badges!

<section class="article_badges">
    <a href="https://packagist.org/packages/spatie/menu"><img src="https://img.shields.io/badge/packagist-spatie/menu-orange.svg?style=flat-square" alt="spatie/menu"></a>
    <a href="https://packagist.org/packages/spatie/menu"><img src="https://img.shields.io/packagist/v/spatie/menu.svg?style=flat-square" alt="Latest Version on Packagist"></a>
    <a href="https://github.com/spatie/menu/blob/master/LICENSE.md"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></a>
    <a href="https://travis-ci.org/spatie/menu"><img src="https://img.shields.io/travis/spatie/menu/master.svg?style=flat-square" alt="Build Status"></a>
    <a href="https://scrutinizer-ci.com/g/spatie/menu"><img src="https://img.shields.io/scrutinizer/g/spatie/menu.svg?style=flat-square" alt="Quality Score"></a>
    <a href="https://packagist.org/packages/spatie/menu"><img src="https://img.shields.io/packagist/dt/spatie/menu.svg?style=flat-square" alt="Total Downloads"></a>
</section>

<section class="article_badges">
    <a href="https://packagist.org/packages/spatie/laravel-menu"><img src="https://img.shields.io/badge/packagist-spatie/laravel--menu-orange.svg?style=flat-square" alt="spatie/laravel-menu"></a>
    <a href="https://packagist.org/packages/spatie/laravel-menu"><img src="https://img.shields.io/packagist/v/spatie/laravel-menu.svg?style=flat-square" alt="Latest Version on Packagist"></a>
    <a href="https://github.com/spatie/laravel-menu/blob/master/LICENSE.md"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></a>
    <a href="https://travis-ci.org/spatie/laravel-menu"><img src="https://img.shields.io/travis/spatie/laravel-menu/master.svg?style=flat-square" alt="Build Status"></a>
    <a href="https://scrutinizer-ci.com/g/spatie/laravel-menu"><img src="https://img.shields.io/scrutinizer/g/spatie/laravel-menu.svg?style=flat-square" alt="Quality Score"></a>
    <a href="https://packagist.org/packages/spatie/laravel-menu"><img src="https://img.shields.io/packagist/dt/spatie/laravel-menu.svg?style=flat-square" alt="Total Downloads"></a>
</section>
