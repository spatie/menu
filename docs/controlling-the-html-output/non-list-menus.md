---
title: Non-list Menus
weight: 4
---

You can render menus without `ul` and `li` tags. This can be achieved with the `setWrapperTag`, `withoutWrapperTag`, `setParentTag` and `withoutParentTag` methods.

Without wrapper tag & without parent tag:

```php
Menu::new()
    ->withoutWrapperTag()
    ->withoutParentTag()
    ->link('/', 'Home')
    ->link('/about', 'About');
```

```html
<a href="/">Home</a>
<a href="/about">About</a>
```

Without wrapper tag & with custom parent tag:

```php
Menu::new()
    ->withoutWrapperTag()
    ->setParentTag('span')
    ->link('/', 'Home')
    ->link('/about', 'About');
```

```html
<span><a href="/">Home</a></span>
<span><a href="/about">About</a></span>
```

With custom wrapper tag & without parent tags:

```php
Menu::new()
    ->setWrapperTag('nav')
    ->withoutParentTag()
    ->link('/', 'Home')
    ->link('/about', 'About');
```

```html
<nav>
    <a href="/">Home</a>
    <a href="/about">About</a>
</nav>
```

With custom wrapper tag & custom parent tags:

```php
Menu::new()
    ->setWrapperTag('nav')
    ->setParentTag('span')
    ->link('/', 'Home')
    ->link('/about', 'About');
```

```html
<nav>
    <span><a href="/">Home</a></span>
    <span><a href="/about">About</a></span>
</nav>
```
