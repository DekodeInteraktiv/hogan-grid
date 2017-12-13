# Card Grid Module for [Hogan](https://github.com/dekodeinteraktiv/hogan-core)

## Installation
Install the module using Composer `composer require dekodeinteraktiv/hogan-grid` or simply by downloading this repository and placing it in `wp-content/plugins`

## Usage
Module for displaying post types as cards in a grid.
Two types content inclusion: static content and dynamic content.

Static content is setting a specific post as a card in the module. Ex. picking a specific article, page or post from a custom post type.

Dynamic content show card with content that is dynamically queried. Ex. showing the 3 newest posts from a selected post type and/or taxonomy.

## Available filters
- `hogan/module/grid/heading/enabled (true/false).` for disabling module header
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

- `hogan/module/grid/dynamic_content_post_types` - array with post types to allow in dynamic selection
```
//default values
[
	'post' => __( 'Posts', 'hogan-grid' ),
	'page' => __( 'Pages', 'hogan-grid' )
]
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

## TODO
- set background color or image for module
- template output
- dynamic selection with logic
