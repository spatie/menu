---
title: Parent Attributes
weight: 2
---

The `Menu` and `Link`, and `Html` classes also use the `ParentAttributes` trait, which allows you to add attributes to their parent elements (which are generally a `ul` or `li` tags) via `setParentAttribute` and `addParentClass`.

```php
Menu::new()
    ->add(Html::raw('<img src="/my-avatar">')
        ->setParentAttribute('id', 'user-123')
        ->addParentClass('-has-avatar')
    );
```

```html
<ul>
    <li id="user-123" class="-has-avatar">
        <img src="/my-avatar">
    </li>
</ul>
```

These attributes will only be rendered if the elements are rendered inside of a parent (e.g. a link or a sub menu).

If you want to add classes or set attributes to all items' parents in a menu, the `Menu` class provides some convenience methods: `addItemParentClass`, `setItemParentAttribute`.
