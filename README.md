# Html Menu Generator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/menu.svg?style=flat-square)](https://packagist.org/packages/spatie/menu)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/menu/master.svg?style=flat-square)](https://travis-ci.org/spatie/menu)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/315e0520-ff38-4441-9b6a-ebb6efe3bcb2.svg?style=flat-square)](https://insight.sensiolabs.com/projects/315e0520-ff38-4441-9b6a-ebb6efe3bcb2)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/menu.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/menu)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/menu.svg?style=flat-square)](https://packagist.org/packages/spatie/menu)

The `spatie/menu` package provides a fluent interface to build menus of any size in your php application. If you're building your app with Laravel, the [`spatie/laravel-menu`](https://github.com/spatie/laravel-menu) provides some extra treats.

Documentation is available at https://docs.spatie.be/menu.

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
    ->link('/about', 'About');
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
    ->addClass('navigation');
    ->add(Link::to('/', 'Home')->addClass('home-link'))
    ->add(Link::to('/about', 'About'))
    ->add(Link::to('/contact', 'Contact')->addParentClass('float-right'))
    ->wrap('div.wrapper')
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

## Not Afraid of Depths

The menu supports submenus, which in turn can be nested infinitely.

```php
Menu::new()
    ->add(Link::to('/', 'Home'))
    ->submenu('More', Menu::new()
        ->addClass('submenu')
        ->link('/about', 'About'))
        ->link('/contact', 'Contact'))
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

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Postcardware

You're free to use this package (it's [MIT-licensed](LICENSE.md)), but if it makes it to your production environment you are required to send us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

The best postcards will get published on the open source page on our website.

## Install

You can install the package via composer:

``` bash
$ composer require spatie/menu
```

## Usage

Documentation is available at https://docs.spatie.be/menu.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## About Spatie
Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
