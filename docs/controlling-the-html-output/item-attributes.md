---
title: Item Attributes
weight: 1
---

The `Menu` and `Link` classes use the `HtmlAttributes` trait, which enables you to add attributes to their main elements (respectively the `ul` and `a` tags).

## Adding classes to a menu

The trait provides two methods to set attributes: `setAttribute` and `addClass`.

```php
Menu::new()
    ->setAttribute('role', 'navigation')
    ->addClass('nav');
```

```html
<ul role="navigation" class="nav"></ul>
```

The `setAttribute` and `addClass` methods are smart enough to merge class names on render. The latter can also accepts both arrays and strings.

```php
Link::to('#', 'Back to top')
    ->setAttribute('class', 'link')
    ->addClass(['button', 'top']);
```

```html
<a href="#" class="link button top">Back to top</a>
```

If you want to add classes or set attributes to all items in a menu, the `Menu` class provides some convenience methods: `addItemClass`, `setItemAttribute`.

## Adding an ID to a menu

The trait provides two methods to set attributes: `setAttribute` and `id`.

```php
Menu::new()
    ->setAttribute('role', 'navigation')
    ->id('nav');
```

```html
<ul role="navigation" id="nav"></ul>
```

