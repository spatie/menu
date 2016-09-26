# Changelog

All Notable changes to `menu` will be documented in this file.

## 2.0.0
- Item active states for URL's are now determined by a `determineActiveForUrl` on the item itself
- Added static `Menu::build` and non-static `Menu::fill` methods to create menu's from arrays
- `Menu::html` and `Menu::htmlIf` now accept a `$parentAttributes` array as their second arguments  
- Removed `void` and `voidIf` (just use `html` with an empty string instead)
- Removed `prefixLinks` and `prefixUrls` since it's too complex and unpredictable in nested menu's

## 1.4.0
- Added a `HasUrl` trait
- Deprecated `prefixLinks` in favor of `prefixUrls`

## 1.3.0
- Added `submenuIf`

## 1.2.1
- Internal refactors

## 1.2.0
- New methods on `Menu`:
    - `submenu` for submenus with optional headers
    - `void` and `voidIf` for empty list items
    - `wrap` to wrap the menu in an html tag with optional attributes
    - A `blueprint` method to copy the menu without it's contents
    - Html item convenience methods: `addItemClass`, `setItemAttribute`
    - Html parent convenience methods: `addItemParentClass`, `setItemParentAttribute`
- Added `HasHtmlAttributes` and `HasParentAttributes` interfaces
- `HtmlAttributes` and `ParentAttributes` now also have a `setAttributes` method

## 1.1.1
- Fixed `setActive` when setting active from a URL

## 1.1.0
- Added conditional `add` functions, `addIf`, `linkIf` and `htmlIf`

## 1.0.0
- First release
