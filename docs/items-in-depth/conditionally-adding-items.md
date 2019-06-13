---
title: Conditionally Adding Items
weight: 3
---

<span class="badge">v1.1+</span>

The `add` method has an equivalent method with an `if` suffix, which takes a condition as it's first argument. The items will only be added to the menu if the condition resolves to true (non-strict).

```php
Menu::new()
    ->add(Link::to('/', 'Home'))
    ->addIf(!$loggedIn, Link::to('/login', 'Login'))
    ->addIf(!$loggedIn, Link::to('/register', 'Register'))
    ->addIf($loggedIn, Link::to('/logout', 'Logout'))
```

```html
<!-- $loggedIn = false -->
<ul>
    <li><a href="/">Home</a></li>
    <li><a href="/login">Login</a></li>
    <li><a href="/register">Register</a></li>
</ul>
```

```html
<!-- $loggedIn = true -->
<ul>
    <li><a href="/">Home</a></li>
    <li><a href="/logout">Logout</a></li>
</ul>
```

This also applies to the convenience methods:

```php
Menu::new()
    ->link('/', 'Home')
    ->htmlIf(count($notifications), '<i data-notifications data-icon="bell"></i>');
```

```html
<!-- $notifications = [] -->
<ul>
    <li><a href="/">Home</a></li>
</ul>
```

```html
<!-- $notifications = ['new-message'] -->
<ul>
    <li><a href="/">Home</a></li>
    <li><i data-notifications data-icon="bell"></i></li>
</ul>
```
