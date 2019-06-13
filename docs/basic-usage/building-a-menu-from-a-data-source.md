---
title: Building a menu from a data source
weight: 3
---

Menus can also be created from an array-like data source with the static `build` method, or the non-static `fill` method.

The methods accept a data source as their first parameter, and a callable as their second. The method calls the callable over every item in the data source. The callable has three parameters: the menu, the item and the item's key.

```php
$items = [
    '/' => 'Home',
    '/about' => 'About',
    '/contact' => 'Contact',
];

Menu::build($items, function ($menu, $label, $link) {
    $menu->link($link, $label);
});
```

The `build` and `fill` methods allow you to use any iteratable data source for a menu. Here's another example using the result of an Eloquent query in Laravel.

```php
$products = Product::all();

Menu::build($products, function ($menu, $product) {
    $menu->action('ProductController@detail', $product->name, $product->id);
});
```
