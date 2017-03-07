# Changelog

All notable changes to `menu` will be documented in this file.

## 2.2.1 - 2017-03-07
- Fixed: Setting items active with urls that start with the same string

## 2.2.0 - 2017-02-09
- Added: `if` function

## 2.1.3
- Fixed: setting an active url when the url is exactly the same

## 2.1.1
- Added: The request root path when setting the active path
 
## 2.1.0
- Added: Optional third `$initial` parameter in `Menu::build`

## 2.0.1
- Fixed: Require `^1.0.0` of spatie/url

## 2.0.0
- Added: Added the static `Menu::build` and non-static `Menu::fill` methods to create menu's from arrays.
- Added: The `setActive` method on `Activatable` now also accepts a non-strict boolean or callable parameter to set `$active` to true or false.
- Added: `Menu::html` and `Menu::htmlIf` now accept a `$parentAttributes` array as their second arguments.
- Changed: The `HtmlAttributes` and `ParentAttributes` traits have been renamed to `HasHtmlAttributes` and `HasParentAttributes`.
- Changed: The `HasUrl` interface and trait has been removed. Url-related methods now also are part of the `Activatable` interface and trait.
- Removed: The `void` and `voidIf` have been removed. These can be replaced by `html` and `htmlIf`, with empty strings as their first arguments
- Removed: The `prefixLinks` and `prefixUrls` methods have been removed because they were too unpredictable in some case. There currently isn't an alternative for these, besides writing your own logic and applying it with `applyToAll`.

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
