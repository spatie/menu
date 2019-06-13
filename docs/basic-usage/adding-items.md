---
title: Adding Items
weight: 2
---

## Links

`Spatie\Menu\Link`

Links are created with the `to` factory method, which requires a url and a string of text (or html) as parameters. There's also a convenience method on the `Menu` class.

```php
Menu::new()->add(Link::to('/', 'Home'));
```

```php
Menu::new()->link('/', 'Home');
```

```html
<ul>
    <li><a href="/">Home</a></li>
</ul>
```

<div class="alert -info">
When using convenience methods to add items, you can't simultanuously add classes or attributes to the item since there isn't an instance variable.
</div>

## Raw Html

`Spatie\Menu\Html`

Raw html chunks can be added as menu items via the `Html` class or convenience method.

```php
Menu::new()->add(Html::raw('<span>Hi!</span>'));
```

```php
Menu::new()->html('<span>Hi!</span>');
```

```html
<ul>
    <li><span>Hi!</span></li>
</ul>
```

It is also possible to add html directly into link display text, by calling `render` on the raw html and concatenating it with the rest of your desired output text or by writing the html directly into the display text. Please note, that this does not parse Laravel Blade syntax.

```php
Menu::new()->link('/hi',Html::raw('<b>Hello</b>')->render()." World")
```

```php
Menu::new()->link('/hi',"<b>Hello</b> World")
```

```html
<ul>
    <li>
        <a href="/hi">
            <b>Hello</b> World
        </a>
    </li>
</ul>
```

## Submenus

`Spatie\Menu\Menu`

Since the `Menu` class itself implements the `Item` interface, menus can be nested. All you need to do is pass a new `Menu` instance to the `add` function:

```php
Menu::new()
    ->link('/', 'Menu')
    ->add(Menu::new()
        ->link('/basic-usage/your-first-menu', 'Your First Menu')
        ->link('/basic-usage/adding-submenus', 'Adding Submenus')
    );
```

```html
<ul>
    <li>
        <a href="/">Menu</a>
    </li>
    <li>
        <ul>
            <li>
                <a href="/basic-usage/your-first-menu">
                    Your First Menu
                </a>
            </li>
            <li>
                <a href="/basic-usage/adding-submenus">
                    Adding Submenus
                </a>
            </li>
        </ul>
    </li>
</ul>
```

You can also use submenus to divide your menu in sections. A header is optional, and can be a plain string or an instance of `item`. The menu parameter can be an instance of `Menu` or a callable which will pass through a new `Menu` as it's first parameter.

```php
Menu::new()
    // No header, `Menu` instance
    ->submenu(Menu::new()
        ->link('/introduction', 'Introduction')
        ->link('/requirements', 'Requirements')
        ->link('/installation-setup', 'Installation and Setup')
    )
    // String header, `callable`
    ->submenu('<h2>Basic Usage</h2>', function (Menu $menu) {
        $menu
            ->prefixLinks('/basic-usage')
            ->link('/your-first-menu', 'Your First Menu')
            ->link('/working-with-items', 'Working With Items')
            ->link('/adding-sub-menus', 'Adding Sub Menus');
    });
```

```html
<ul>
    <li>
        <ul>
            <li><a href="/introduction">Introduction</a></li>
            <li><a href="/requirements">Requirements</a></li>
            <li><a href="/installation-setup">Installation and Setup</a></li>
        </ul>
    </li>
    <li>
        <h2>Basic Usage</h2>
        <ul>
            <li><a href="/basic-usage/your-first-menu">Your First Menu</a></li>
            <li><a href="/basic-usage/working-with-items">Working With Items</a></li>
            <li><a href="/basic-usage/adding-sub-menus">Adding Sub Menus</a></li>
        </ul>
    </li>
</ul>
```

If you're using a callable, the new instance will be a blueprint—an empty copy—of the current menu. This means that filters applied to your main menu will also be applied to your submenu. This is useful for cascading `prefixLinks`.

```php
Menu::new()
    ->prefixLinks('/foo')
    ->submenu(function (Menu $menu) {
        $menu
            ->prefixLinks('/bar')
            ->add('/baz', 'Baz');
    });
```

```html
<ul>
    <li>
        <ul>
            <li><a href="/foo/bar/baz">Baz</a></li>
        </ul>
    </li>
</ul>
```
