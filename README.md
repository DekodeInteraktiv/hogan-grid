# Card Grid Module for [Hogan](https://github.com/dekodeinteraktiv/hogan-core) [![Build Status](https://travis-ci.org/DekodeInteraktiv/hogan-grid.svg?branch=master)](https://travis-ci.org/DekodeInteraktiv/hogan-grid)

## Installation
Install the module using Composer `composer require dekodeinteraktiv/hogan-grid` or simply by downloading this repository and placing it in `wp-content/plugins`

## Usage
Module for displaying post types as cards in a grid.
Two types content inclusion: static content and dynamic content.

Static content is setting a specific post as a card in the module. Ex. picking a specific article, page or post from a custom post type.

Dynamic content show card with content that is dynamically queried. Ex. showing the 3 newest posts from a selected post type and/or taxonomy.

## Available filters
- `hogan/module/grid/heading/enabled (true/false).` for disabling module header
- `hogan/module/grid/template/text-align` - text align classname. Default `center`.
- `hogan/module/grid/static_content_post_types` for including custom post types in the ACF relationship field for static content.
```
//default values
[
	'0' => 'post',
	'1' => 'page',
];

```
- `hogan/module/grid/static_content_relation_filters` - which filters to use for the relationship field.
```
//default values
[
	'0' => 'search',
	'1' => 'post_type',
	'2' => 'taxonomy',
];
```

- `hogan/module/grid/static_content_taxonomy`  - which taxonomies to allow content for in the relationship field (default empty array).
- `hogan/module/grid/static_content_limit` - max number static posts allowed in module. Default no limit.

- `hogan/module/grid/dynamic_content_query` - args to send to wp_query when fetching the posts.
- `hogan/module/grid/dynamic_content_post_types` - array with post types to allow in dynamic selection.
- `hogan/module/grid/dynamic_content_limit` - max number dynamic posts allowed in module. Default 10.
```
//default values
[
	'post' => __( 'Posts', 'hogan-grid' ),
	'page' => __( 'Pages', 'hogan-grid' )
]
```
- `hogan/module/grid/dynamic_content_taxonomies` - add taxonomies to use in dynamic selection. Ex. use:
```
function enable_dynamic_taxonomies() : array {
	return [ 'category', 'my_custom_taxonomy' ];
}
add_filter( 'hogan/module/grid/dynamic_content_taxonomies', __NAMESPACE__ . '\\enable_dynamic_taxonomies' );
```

- `hogan/module/grid/card_sizes` - card sizes to use in module
```
//default values
[
	'small'  => __( 'Single', 'hogan-grid' ),
	'medium' => __( 'Double', 'hogan-grid' ),
	'large'  => __( 'Full', 'hogan-grid' ),
]
```
