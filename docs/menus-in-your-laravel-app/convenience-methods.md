---
title: Convenience Methods
weight: 1
---

The items provided in the `laravel-menu` package have some added convenience methods linked to Laravel's url generator.

## Link

`Spatie\Menu\Laravel\Link`

The `Link` class has three added factory methods, `url`, `route` and `action`. The methods require require the same parameters as their Laravel helper function counterparts, with a `$text` parameter squished between as the second one.

```php
Link::url('/', 'Home');
Link::route('contact', 'Contact');
Link::action('PageController@about', 'About', [Page::findOrFail(1)]);
```

For a more detailed description head over to the [API docs](/menu/v1/api/link).

## Menu

`Spatie\Menu\Laravel\Menu`

The `Menu` class has convenience methods for all of the above link factory methods.

```php
Menu::new()
    ->url('/', 'Home')
    ->route('contact', 'Contact')
    ->action('PageController@detail', 'About', [Page::findOrFail(1)]);
```
