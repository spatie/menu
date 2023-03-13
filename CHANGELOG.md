# Changelog

All notable changes to `menu` will be documented in this file.

## 3.1.1 - 2023-03-13

- fix active classes

### What's Changed

- Add `id` to docs by @milwad-dev in https://github.com/spatie/menu/pull/144

**Full Changelog**: https://github.com/spatie/menu/compare/3.1.0...3.1.1

## 3.1.0 - 2023-03-10

### What's Changed

- typofix in item-attributes.md by @davidjr82 in https://github.com/spatie/menu/pull/138
- Add PHP 8.2 Support by @patinthehat in https://github.com/spatie/menu/pull/141
- Refactor tests to pest by @AyoobMH in https://github.com/spatie/menu/pull/142
- Add `id` attribute for menu by @milwad-dev in https://github.com/spatie/menu/pull/143

### New Contributors

- @davidjr82 made their first contribution in https://github.com/spatie/menu/pull/138
- @AyoobMH made their first contribution in https://github.com/spatie/menu/pull/142
- @milwad-dev made their first contribution in https://github.com/spatie/menu/pull/143

**Full Changelog**: https://github.com/spatie/menu/compare/3.0.1...3.1.0

## 3.0.0 - 2021-03-24

- Support PHP 8+
- Drop support for PHP 7.x
- Use PHP 8 syntax where possible

## 2.10.3 - 2021-03-16

- Ensure `Items` are transformed to string before prepending or appending

## 2.10.2 - 2020-12-02

- Fix `methods_exists` check in PHP8

## 2.10.1 - 2020-12-02

- Ensure the necessary methods exist to check if a menu is active

## 2.10.0 - 2020-12-02

- Support `Item` instances in `Menu::prepend` so headers can be set active

## 2.9.0 - 2020-11-06

- Drop support for versions older than PHP 7.1

## 2.8.0 - 2018-11-05

- Add `exact-active` class to links that exactly match the current URL. This is accompanied by a `setExactActiveClass(string $class)` method to set the class name

## 2.7.0 - 2018-10-23

- Add `IteratorAggregate` interface to `Menu` class

## 2.6.0 - 2018-09-10

- Add `beforeRender` and `willRender` hooks that are called when an item is rendered

## 2.5.0 - 2018-03-02

- This release adds a few methods to create non-`ul` menus, which allows for Bootstrap 4 compatibility
- Added `Menu::setWrapperTag` and `Menu::withoutWrapperTag` to set a custom wrapper tag name for the menu list. Default: `ul`
- Added `Menu::setParentTag` & `Menu::withoutParentTag` to determine which tag should be used for the item's parent element. Default: `li`
- Added `Menu::setActiveClassOnLink` and `Menu::setActiveClassOnParent` to determine where the active class should be applied

## 2.4.1 - 2017-11-13

- Allow invokable classes as callbacks

## 2.4.0 - 2017-10-17

- Added `Menu::empty` and `Html::empty` method for adding empty list items

## 2.3.1 - 2017-08-29

- Extracted a `ActiveUrlChecker` class for public use

## 2.3.0 - 2017-08-28

- Added `append` and `prepend` methods to `Link`

## 2.2.2 - 2017-07-11

- Fixed returning a menu instance is now optional with `fill` and `build`

## 2.2.1 - 2017-03-07

- Fixed setting items active with urls that start with the same string

## 2.2.0 - 2017-02-09

- Added `if` function

## 2.1.3

- Fixed setting an active url when the url is exactly the same

## 2.1.1

- Added the request root path when setting the active path

## 2.1.0

- Added optional third `$initial` parameter in `Menu::build`

## 2.0.1

- Fixed require `^1.0.0` of spatie/url

## 2.0.0

- Added added the static `Menu::build` and non-static `Menu::fill` methods to create menu's from arrays.
- Added the `setActive` method on `Activatable` now also accepts a non-strict boolean or callable parameter to set `$active` to true or false.
- Added `Menu::html` and `Menu::htmlIf` now accept a `$parentAttributes` array as their second arguments.
- Changed the `HtmlAttributes` and `ParentAttributes` traits have been renamed to `HasHtmlAttributes` and `HasParentAttributes`.
- Changed the `HasUrl` interface and trait has been removed. Url-related methods now also are part of the `Activatable` interface and trait.
- Removed the `void` and `voidIf` have been removed. These can be replaced by `html` and `htmlIf`, with empty strings as their first arguments
- Removed the `prefixLinks` and `prefixUrls` methods have been removed because they were too unpredictable in some case. There currently isn't an alternative for these, besides writing your own logic and applying it with `applyToAll`.

## 1.4.0

- Added a `HasUrl` trait
- Deprecated `prefixLinks` in favor of `prefixUrls`

## 1.3.0

- Added `submenuIf`

## 1.2.1

- Internal refactors

## 1.2.0

- New methods on `Menu`:
- - `submenu` for submenus with optional headers
- 
- - `void` and `voidIf` for empty list items
- 
- - `wrap` to wrap the menu in an html tag with optional attributes
- 
- - A `blueprint` method to copy the menu without it's contents
- 
- - Html item convenience methods: `addItemClass`, `setItemAttribute`
- 
- - Html parent convenience methods: `addItemParentClass`, `setItemParentAttribute`
- 
- 
- Added `HasHtmlAttributes` and `HasParentAttributes` interfaces
- `HtmlAttributes` and `ParentAttributes` now also have a `setAttributes` method

## 1.1.1

- Fixed `setActive` when setting active from a URL

## 1.1.0

- Added conditional `add` functions, `addIf`, `linkIf` and `htmlIf`

## 1.0.0

- First release
