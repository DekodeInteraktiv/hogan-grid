# Changelog

# Unreleased
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
