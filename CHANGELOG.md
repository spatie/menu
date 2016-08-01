# Changelog

All Notable changes to `menu` will be documented in this file.

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
