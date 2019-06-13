---
title: Link
weight: 2
---

## `Spatie\Menu\Link`

- Implements `Spatie\Menu\Activatable`, `Spatie\Menu\HasUrl`, `Spatie\Menu\HasHtmlAttributes`, `Spatie\Menu\HasParentAttributes`, `Spatie\Menu\Item`


### `to`

```php
/**
 * @param string $url
 * @param string $text
 *
 * @return static
 */
public static function to(string $url, string $text)
```

### `getText`

```php
/**
 * @return string
 */
public function getText() : string
```

### `getUrl`

```php
/**
 * @return string
 */
public function getUrl() : string
```

### `segment`

```php
/**
 * Return a segment of the link's URL. This function works for both absolute
 * and relative URL's. The index is a 1-index based number. Trailing and
 * double slashes are ignored.
 *
 * Example: (new Link('Open Source', 'https://spatie.be/opensource'))->segment(1)
 *      => 'opensource'
 *
 * @param int $index
 *
 * @return string|null
 */
public function segment(int $index)
```

### `prefix`

```php
/**
 * @param string $prefix
 *
 * @return $this
 */
public function prefix(string $prefix)
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

### `setAttribute`

```php
/**
 * @param string $attribute
 * @param string $value
 *
 * @return $this
 */
public function setAttribute(string $attribute, string $value = '')
```

### `addClass`

```php
/**
 * @param string $class
 *
 * @return $this
 */
public function addClass(string $class)
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

## `Spatie\Menu\Laravel\Link`

- Extends `Spatie\Menu\Link`
- Uses `Illuminate\Support\Traits\Macroable`

```php
/**
 * @param string $path
 * @param string $text
 * @param array $parameters
 * @param bool|null $secure
 *
 * @return $this
 */
public static function url(string $path, string $text, array $parameters = [], $secure = null)
```

```php
/**
 * @param string $action
 * @param string $text
 * @param array $parameters
 * @param bool $absolute
 *
 * @return $this
 */
public static function action(string $action, string $text, array $parameters = [], bool $absolute = true)
```

```php
/**
 * @param string $name
 * @param string $text
 * @param array $parameters
 * @param bool $absolute
 * @param \Illuminate\Routing\Route|null $route
 *
 * @return $this
 */
public static function route(string $name, string $text, array $parameters = [], $absolute = true, $route = null)
```
