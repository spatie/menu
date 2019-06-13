---
title: Views as Menu Items
weight: 2
---

`laravel-menu` ships with a `View` item type, which you can use to render views as menu items. Views are created by specifying the view's name, and optionally passing data.

```php
Menu::new()
    ->add(View::create('greeting', ['name' => 'Sebastian']));
```

```html
<!-- resources/views/greeting.blade.php -->
Hello, {{ $name }}!
```

```html
<ul>
    <li>
        Hello, Sebastian!
    </li>
</ul>
```

If `url` is set in the data argument, it will be used to determine the active state of the view with `setActiveFromUrl` or `setActiveFromRequest`.

```php
Menu::new()
    ->add(View::create('greeting', ['name' => 'Sebastian', 'url' => '/profile']))
    ->setActiveFromUrl('/profile');
```

```html
<ul>
    <li class="active">
        Hello, Sebastian!
    </li>
</ul>
```

Additionally, an `$active` boolean will always be passed to the view.

```html
<!-- resources/views/amIActive.blade.php -->
I'm {{ $active ? 'active' : 'inactive' }}!
```
