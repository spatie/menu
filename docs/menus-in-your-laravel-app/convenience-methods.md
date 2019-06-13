---
title: Convenience Methods
weight: 1
---

The items provided in the `laravel-menu` package have some added convenience methods linked to Laravel's url generator.

## Link

`Spatie\Menu\Laravel\Link`

The `Link` class has three added factory methods, `toUrl`, `toRoute` and `toAction`. The methods require the same parameters as their Laravel helper function counterparts, with a `$text` parameter squished between as the second one.

```php
Link::toUrl('/', 'Home');
Link::toRoute('contact', 'Contact');
Link::toAction('PageController@about', 'About');
```

## Menu

`Spatie\Menu\Laravel\Menu`

The `Menu` class has convenience methods for all of the above link factory methods.

```php
Menu::new()
    ->url('/', 'Home')
    ->route('contact', 'Contact')
    ->action('PageController@about', 'About');
```
