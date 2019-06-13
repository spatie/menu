---
title: Using Macros
weight: 4
---

All classes in the laravel-menu package use the `Macroable` trait for quick & easy extensions.

## Example: Convenience Methods for Links

`Spatie\Menu\Laravel\Link`

```php
Link::macro('product', function (Product $product) {
    return Link::action('ProductController@show', $product->name, [$product->id]);
});

echo Link::product(Product::findOrFail(1));
```

```html
<a href="https://example.com/products/1">Product #1</a>
```

## Example: Html Macros

`Spatie\Menu\Laravel\Html`

```php
Html::macro('avatar', function (User $user) {
    return Html::raw(sprintf(
        '<img src="%s" alt="%s" class="avatar">',
        $user->gravatar_link,
        $user->name
    ));
});

echo Html::avatar(User::findOrFail(1));
```

```html
<img 
    src="https://www.gravatar.com/avatar/27e1bbf570a99f9a73dd0f34af844db1?d=mm&s=256"
    alt="Sebastian De Deyne"
    class="avatar"
>
```

## Example: Registering Menu's for Quick Access

`Spatie\Menu\Laravel\Menu`

```php
Menu::macro('main', function() {
    return Menu::new()
        ->route('home', 'Home')
        ->route('about', 'Home')
        ->route('contact', 'Home');
});
```

If you've registered the facade, You can call the macro without namespace imports in your blade view:

```html
<header>
    {!! Menu::main() !!}
</header>
```
