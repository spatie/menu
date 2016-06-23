# Changelog

All Notable changes to `menu` will be documented in this file

## 1.2.0
- Broadened the api of `Menu`:
    - A `submenu` method
    - A `blueprint` method to copy the menu without it's contents
    - More convenience methods: `addLinkClass`, `addLinkParentClass`, `addLinkParentAttribute`, `addItemParentClass`, `setItemParentAttribute`
- Added `HasHtmlAttributes` and `HasParentAttributes` interfaces

## 1.1.1
- Fixed `setActive` when setting active from a URL

## 1.1.0
- Added conditional `add` functions, `addIf`, `linkIf` and `htmlIf`

## 1.0.0
- First release
