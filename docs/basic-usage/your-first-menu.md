---
title: Your First Menu
weight: 1
---

Let's get things started by building a simple menu with two links. All of the following examples are using classes from the `Spatie\Menu` namespace.

```html
<ul>
    <li><a href="/">Home</a></li>
    <li><a href="/about">About</a></li>
</ul>
```

Menu's are created via the `new` factory method.

```php
$menu = Menu::new();
```

Links are created with the `to` factory method, which requires a url and a string of text (or html) as parameters.

```php
$link = Link::to('/', 'Home');
```

A menu can be instantiated with an array of items, or items can be added fluently with the `add` method.

```php
// With an array:
$menu = Menu::new([
    Link::to('/', 'Home'),
    Link::to('/about', 'About'),
]);

// Or fluently:
$menu = Menu::new()
    ->add(Link::to('/', 'Home'))
    ->add(Link::to('/about', 'About'));
```

When we render or echo the menu, it will output our intended html string.

```php
// Via the `render` method:
echo $menu->render();

// Or just through `__toString`:
echo $menu;
```

```html
<ul>
    <li><a href="/">Home</a></li>
    <li><a href="/about">About</a></li>
</ul>
```
