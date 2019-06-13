---
title: Appending and Prepending Html
weight: 3
---

You can append and prepend html outside of the `ul` tag with similarly named functions. This is useful for submenu titles or separators.

```php
Menu::new()
    ->prepend('<h2>Title</h2>')
    ->add(Link::to('/title/subpage', 'Subpage'))
    ->append('<hr>');
```

```html
<h2>Title</h2>
<ul>
    <li>
        <a href="/title/subpage">Subpage</a>
    </li>
</ul>
<hr>
```

If you only want to add html in certain conditions, you can use `appendIf` and `prependIf`.

```php
$displayTitles = false;
$displayRulers = true;

Menu::new()
    ->prependIf($displayTitles, '<h2>Title</h2>')
    ->add(Link::to('/title/subpage', 'Subpage'))
    ->appendIf($displayRulers, '<hr>');
```

You can also wrap the menu in an element.

```php
Menu::new()->wrap('div', ['class' => 'nav']);
```

```html
<div class="nav">
  <ul></ul>
</div>
```
