# Html Menu Generator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/menu.svg?style=flat-square)](https://packagist.org/packages/spatie/menu)
[![Build Status](https://img.shields.io/travis/spatie/menu/master.svg?style=flat-square)](https://travis-ci.org/spatie/menu)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/menu.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/menu)
[![StyleCI](https://styleci.io/repos/51363080/shield?branch=master)](https://styleci.io/repos/51363080)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/menu.svg?style=flat-square)](https://packagist.org/packages/spatie/menu)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)


The `spatie/menu` package provides a fluent interface to build menus of any size in your php application. If you're building your app with Laravel, the [`spatie/laravel-menu`](https://github.com/spatie/laravel-menu) provides some extra treats.

Documentation is available at https://docs.spatie.be/menu.

Upgrading from version 1? There's a [guide](https://github.com/spatie/menu#upgrading-to-20) for that!

## Human Readable, Fluent Interface

All classes provide a human readable, fluent interface (no array configuration). Additionally, you can opt for a more verbose and flexible syntax, or for convenience methods that cover most use cases.

```php
Menu::new()
    ->add(Link::to('/', 'Home'))
    ->add(Link::to('/about', 'About'))
    ->add(Link::to('/contact', 'Contact'))
    ->add(Html::empty())
    ->render();

// Or just...
Menu::new()
    ->link('/', 'Home')
    ->link('/about', 'About')
    ->link('/contact', 'Contact')
    ->empty()
```

```html
<ul>
    <li><a href="/">Home</a></li>
    <li><a href="/about">About</a></li>
    <li><a href="/contact">Contact</a></li>
    <li></li>
</ul>
```

## Or a More Programmatic Approach

Menus can also be created through a reduce-like callable.

```php
$pages = [
    '/' => 'Home',
    '/about' => 'About',
    '/contact' => 'Contact',
];

Menu::build($pages, function ($menu, $label, $url) {
    $menu->add($url, $label);
})->render();
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
    ->link('/', 'Home')
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
    {{ Menu::main() }}
</nav>
```

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Install

You can install the package via composer:

``` bash
composer require spatie/menu
```

## Usage

Documentation is available at https://docs.spatie.be/menu.

## Upgrading to 2.0

Upgrading to 2.0 should be pretty painless for most use cases.

### If you're just building menus...

- The `void` and `voidIf` have been removed. These can be replaced by `html` and `htmlIf`, with empty strings as their first arguments
- The `prefixLinks` and `prefixUrls` methods have been removed because they were too unpredictable in some case. There currently isn't an alternative for these, besides writing your own logic and applying it with `applyToAll`.

### If you're using custom `Item` implementations...

- The `HtmlAttributes` and `ParentAttributes` traits have been renamed to `HasHtmlAttributes` and `HasParentAttributes`.
- The `HasUrl` interface and trait has been removed. Url-related methods now also are part of the `Activatable` interface and trait.

### New features...

- Added the static `Menu::build` and non-static `Menu::fill` methods to create menu's from arrays.
- The `setActive` method on `Activatable` now also accepts a non-strict boolean or callable parameter to set `$active` to true or false.
- `Menu::html` and `Menu::htmlIf` now accept a `$parentAttributes` array as their second arguments.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## Support us

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie).
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
