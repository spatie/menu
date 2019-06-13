---
title: Installation and Setup
weight: 4
---

## Basic installation

You can install the `menu` package via composer:

```bash
composer require spatie/menu
```

### Laravel

If you're in a Laravel environment, you'll want to require `laravel-menu` instead:

```bash
composer require spatie/laravel-menu
```

If you want to use a facade, you'll need to register the service provider and facade class names (these are both optional):

```php
// config/app.php

'providers' => [
    // ...
    Spatie\Menu\Laravel\MenuServiceProvider::class,
],

'aliases' => [
    // ...
    'Menu' => Spatie\Menu\Laravel\MenuFacade::class,
],
```
