---
title: Html
weight: 3
---

## `Spatie\Menu\Html`

- Implements `Spatie\Menu\Activatable`, `Spatie\Menu\HasParentAttributes`, `Spatie\Menu\Item`

### `raw`

```php
/**
 * Create an item containing a chunk of raw html.
 *
 * @param string $html
 *
 * @return static
 */
public static function raw(string $html)
```

### `getHtml`

```php
/**
 * @return string
 */
public function getHtml() : string
```

### `render`

```php
/**
 * @return string
 */
public function render() : string
```

### `isActive`

```php
/**
 * @return bool
 */
public function isActive() : bool
```

### `setActive`

```php
/**
 * @return $this
 */
public function setActive()
```

### `setInactive`

```php
/**
 * @return $this
 */
public function setInactive()
```

### `getParentAttributes`

```php
/**
 * Return an array of attributes to apply on the parent. This generally means
 * the attributes that should be applied on the <li> tag.
 *
 * @return array
 */
public function getParentAttributes() : array
```

### `setParentAttribute`

```php
/**
 * @param string $attribute
 * @param string $value
 *
 * @return $this
 */
public function setParentAttribute(string $attribute, string $value = '')
```

### `addParentClass`

```php
/**
 * @param string $class
 *
 * @return $this
 */
public function addParentClass(string $class)
```

## `Spatie\Menu\Laravel\Html`

- Extends `Spatie\Menu\Html`
- Uses `Illuminate\Support\Traits\Macroable`
