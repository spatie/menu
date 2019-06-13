---
title: Manipulating Items
weight: 2
---

There are three methods to manipulate items in a menu:

- `each`: Goes over all existing items and applies a manipulation
- `registerFilter`: Registers a manipulation that will be applied to all items added afterwards
- `applyToAll`: Applies a manipulation to all existing and all future items

## Typehinting Callables

All methods require a `callable` as their first and only parameter. The callable will receive the item as it's parameter. If this parameter is typehinted, the manipulation will only be applied to items of that type.

```php
Menu::new()
    ->add(Link::to('/', 'Home'))
    ->add(Html::raw('<a href="#" data-avatar>Profile</a>'))
    ->each(function (Link $link) {
        $link->addClass('link');
    })
    ->each(function (Html $html) {
        $html->addParentClass('html');
    });
```

In the above example, all links will receive a `link` class, and all html chunk parents (`li`'s) will receive an `html` class.

## each

Iterates over all existing items, and applies a manipulation.

```php
Menu::new()
    ->add(Link::to('/foo-before', 'Foo before'))
    ->add(Link::to('/bar-before', 'Bar before'))
    ->each(function (Link $link) {

        // Return if string doesn't contain 'Foo'
        if (strpos($link->getText(), 'Foo') === false) {
            return;
        }

        $link->addClass('-has-foo');
    })
    ->add(Link::to('/foo-after', 'Foo after'))
    ->add(Link::to('/bar-after', 'Bar after'))
```

```html
<ul>
    <li><a href="/foo-before" class="-has-foo">Foo before</a></li>
    <li><a href="/bar-before">Bar before</a></li>
    <li><a href="/foo-after">Foo after</a></li>
    <li><a href="/bar-after">Bar after</a></li>
</ul>
```

## registerFilter

Registers a manipulation that will be applied on every new item.

```php
Menu::new()
    ->add(Link::to('/foo-before', 'Foo before'))
    ->add(Link::to('/bar-before', 'Bar before'))
    ->registerFilter(function (Link $link) {

        // Return if string doesn't contain 'Foo'
        if (strpos($link->getText(), 'Foo') === false) {
            return;
        }

        $link->addClass('-has-foo');
    })
    ->add(Link::to('/foo-after', 'Foo after'))
    ->add(Link::to('/bar-after', 'Bar after'))
```

```html
<ul>
    <li><a href="/foo-before">Foo before</a></li>
    <li><a href="/bar-before">Bar before</a></li>
    <li><a href="/foo-after" class="-has-foo">Foo after</a></li>
    <li><a href="/bar-after">Bar after</a></li>
</ul>
```

## applyToAll

Applies a manipulation to all existing and future items no matter where it's called.

```php
Menu::new()
    ->add(Link::to('/foo-before', 'Foo before'))
    ->add(Link::to('/bar-before', 'Bar before'))
    ->applyToAll(function (Link $link) {

        // Return if string doesn't contain 'Foo'
        if (strpos($link->getText(), 'Foo') === false) {
            return;
        }

        $link->addClass('-has-foo');
    })
    ->add(Link::to('/foo-after', 'Foo after'))
    ->add(Link::to('/bar-after', 'Bar after'))
```

```html
<ul>
    <li><a href="/foo-before" class="-has-foo">Foo before</a></li>
    <li><a href="/bar-before">Bar before</a></li>
    <li><a href="/foo-after" class="-has-foo">Foo after</a></li>
    <li><a href="/bar-after">Bar after</a></li>
</ul>
```
