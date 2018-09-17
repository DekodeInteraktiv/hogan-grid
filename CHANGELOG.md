# Changelog

## 1.3.1
- Add filters for grid and item class names. [#61](https://github.com/DekodeInteraktiv/hogan-grid/pull/61)

## 1.3
- Add hook for including taxonomies in dynamic card selection.
[#56](https://github.com/DekodeInteraktiv/hogan-grid/pull/56)

## 1.2.1
- Move relative css rule position on the body-inner to label wrapper. Fixes a meta card info position that broke in 1.2.0. [#55](https://github.com/DekodeInteraktiv/hogan-grid/pull/55)

## 1.2.0
- Added a default CSS style [#51](https://github.com/DekodeInteraktiv/hogan-grid/pull/51)
- Added a filter to set default theme [#54](https://github.com/DekodeInteraktiv/hogan-grid/pull/54)

## 1.1.11
- Update `hogan-scripts` - Fixes the grid on IOS8. [#52](https://github.com/DekodeInteraktiv/hogan-grid/pull/52)
- Optimize xsmall grid padding [#50](https://github.com/DekodeInteraktiv/hogan-grid/pull/50)
- Add grid size option [#46](https://github.com/DekodeInteraktiv/hogan-grid/pull/46)

## 1.1.10
- Exclude current post from `dynamic_content` [#39](https://github.com/DekodeInteraktiv/hogan-grid/pull/39)
- Added option to select multiple post types in dynamic content. [#41](https://github.com/DekodeInteraktiv/hogan-grid/issues/41)

## 1.1.9
- Module name translation fix.

## 1.1.8
- Update module to new registration method introduced in [Hogan Core 1.1.7](https://github.com/DekodeInteraktiv/hogan-core/releases/tag/1.1.7)
- Set hogan-core dependency `"dekodeinteraktiv/hogan-core": ">=1.1.7"`
- Add Dekode Coding Standards

## 1.1.7
- Fixed a fatal type error bug when no cards is selected backend. [#36](https://github.com/DekodeInteraktiv/hogan-grid/issues/36)
- Added classname `.hogan-grid-has-theme` to all sections that have a theme. [#34](https://github.com/DekodeInteraktiv/hogan-grid/issues/34)

## 1.1.6
- Added `hogan/module/grid/theme` filter. With this you can now add section theme classname.

## 1.1.5
- Fixed a bug on large cards when text align is center. Meta/icon was left align. They are now center aligned. [#32](https://github.com/DekodeInteraktiv/hogan-grid/issues/32)

## 1.1.4
- Only include posts with post status `publish`.
- Meta now follows the position of the `hogan/module/grid/template/text-align` filter.
- Added `hogan/module/grid/dynamic_content_query` filter.

## 1.1.3
- Added filter `hogan/module/grid/template/text-align` to change text align classname.
- Make sure dynamic posts doesn't show same card multiple times.

## 1.1.2
- Styled meta info added in [DekodeInteraktiv/savage-cards#31](https://github.com/DekodeInteraktiv/savage-cards/pull/31)

## 1.1.1
- Fix a Firefox position bug on savage avatar/icon component. [#18](https://github.com/DekodeInteraktiv/hogan-grid/issues/18)

## 1.1.0
- remove heading field, provided from Core in [#53](https://github.com/DekodeInteraktiv/hogan-core/pull/53)
- Breaking change: heading field has to be added using filter (was default on before).

## 1.0.3
- Added post type classname.
- Added style for Savage Icons and Avatars.
- Added support for loading dynamic cards.
- Fixed a css bug on iOS.
