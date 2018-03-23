<?php
/**
 * Card grid module class
 *
 * @package Hogan
 */

declare( strict_types = 1 );
namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\\Dekode\\Hogan\\Grid' ) && class_exists( '\\Dekode\\Hogan\\Module' ) ) {

	/**
	 * Grid module class.
	 *
	 * @extends Modules base class.
	 */
	class Grid extends Module {

		/**
		 * Card collection
		 *
		 * @var array $collection
		 */
		public $collection;

		/**
		 * Text align
		 *
		 * @var string
		 */
		public $text_align;

		/**
		 * Theme
		 *
		 * @var string
		 */
		public $theme;

		/**
		 * Fetched posts on page
		 *
		 * @var array
		 */
		public $fetched_posts = [];

		/**
		 * Module constructor.
		 */
		public function __construct() {

			$this->label    = __( 'Card grid', 'hogan-grid' );
			$this->template = __DIR__ . '/assets/template.php';

			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );

			add_filter( 'acf/fields/relationship/query/name=posts_list', [ $this, 'relationship_options_filter' ], 10, 2 );
			add_filter( 'hogan/module/outer_wrapper_classes', [ $this, 'add_wrapper_classname' ], 10, 2 );

			parent::__construct();
		}

		/**
		 * Enqueue module admin assets
		 */
		public function enqueue_admin_assets() {
			$_version = defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ? time() : HOGAN_GRID_VERSION;
			wp_enqueue_style( 'hogan-grid-admin', plugins_url( '/assets/hogan-grid-admin.css', __FILE__ ), [], $_version );
		}

		/**
		 * Enqueue module assets
		 */
		public function enqueue_assets() {
			$_version = defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ? time() : HOGAN_GRID_VERSION;
			wp_enqueue_style( 'hogan-grid', plugins_url( '/assets/hogan-grid.css', __FILE__ ), [], $_version );
		}

		/**
		 * Field definitions for module.
		 *
		 * @return array $fields Fields for this module
		 */
		public function get_fields() : array {

			$fields = [];

			/**
			 * Filters the choices for themes in the Grid module
			 *
			 * The selected choice key will be used to add the classname
			 * .hogan-grid-theme-{$key} on the module wrapper.
			 *
			 * @param array $choices Theme choices.
			 */
			$theme_choices = apply_filters( 'hogan/module/grid/themes', [] );

			if ( ! empty( $theme_choices ) ) {
				$fields[] = [
					'key'               => $this->field_key . '_theme',
					'label'             => esc_html__( 'Theme', 'hogan-grid' ),
					'name'              => 'theme',
					'type'              => 'select',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => [
						'width' => '',
						'class' => '',
						'id'    => '',
					],
					'choices'           => $theme_choices,
					'default_value'     => '',
					'allow_null'        => 1,
					'multiple'          => 0,
					'ui'                => 0,
					'ajax'              => 0,
					'return_format'     => 'value',
					'placeholder'       => '',
				];
			}

			$fields[] = [
				'key'          => $this->field_key . '_flex',
				'label'        => '',
				'name'         => 'flex_grid',
				'type'         => 'flexible_content',
				'button_label' => esc_html__( 'Add cards', 'hogan-grid' ),
				'wrapper'      => [
					'class' => 'grid-layouts',
				],
				'layouts'      => [
					[
						'key'        => $this->field_key . '_flex_static_content',
						'name'       => 'static_content',
						'label'      => esc_html__( 'Static content', 'hogan-grid' ),
						'display'    => 'block',
						'sub_fields' => [
							[
								'type'          => 'button_group',
								'key'           => $this->field_key . '_card_style',
								'label'         => __( 'Card Style', 'hogan-grid' ),
								'name'          => 'card_style',
								'instructions'  => __( 'Choose card type for this group', 'hogan-grid' ),
								'choices'       => apply_filters( 'hogan/module/grid/card_sizes', [
									'small'  => __( 'Single', 'hogan-grid' ),
									'medium' => __( 'Double', 'hogan-grid' ),
									'large'  => __( 'Full', 'hogan-grid' ),
								], $this ),
								'allow_null'    => 0,
								'default_value' => 'automatic',
								'layout'        => 'horizontal',
								'return_format' => 'value',
							],
							[
								'type'          => 'relationship',
								'key'           => $this->field_key . '_posts_list',
								'label'         => __( 'Pick items from list', 'hogan-grid' ),
								'name'          => 'posts_list',
								'value'         => null,
								'instructions'  => __( 'Select items to by clicking the items on the left side', 'hogan-grid' ),
								'required'      => 1,
								'post_type'     => apply_filters( 'hogan/module/grid/static_content_post_types', [
									0 => 'post',
									1 => 'page',
								], $this ),
								'taxonomy'      => apply_filters( 'hogan/module/grid/static_content_taxonomy', [], $this ),
								'filters'       => apply_filters( 'hogan/module/grid/static_content_relation_filters', [
									0 => 'search',
									1 => 'post_type',
									2 => 'taxonomy',
								], $this ),
								'elements'      => [
									0 => 'featured_image',
								],
								'min'           => 1,
								'max'           => apply_filters( 'hogan/module/grid/static_content_limit', '' ),
								'return_format' => 'id',
							],
						],
					],
					[
						'key'        => $this->field_key . '_flex_dynamic_content',
						'name'       => 'dynamic_content',
						'label'      => esc_html__( 'Dynamic content', 'hogan-grid' ),
						'display'    => 'block',
						'sub_fields' => [
							[
								'type'          => 'button_group',
								'key'           => $this->field_key . '_dynamic_card_style',
								'label'         => __( 'Card Style', 'hogan-grid' ),
								'name'          => 'card_style',
								'instructions'  => __( 'Choose card type for this group', 'hogan-grid' ),
								'choices'       => apply_filters( 'hogan/module/grid/card_sizes', [
									'small'  => __( 'Single', 'hogan-grid' ),
									'medium' => __( 'Double', 'hogan-grid' ),
									'large'  => __( 'Full', 'hogan-grid' ),
								], $this ),
								'allow_null'    => 0,
								'default_value' => 'automatic',
								'layout'        => 'horizontal',
								'return_format' => 'value',
							],
							[
								'type'          => 'select',
								'key'           => $this->field_key . '_dynamic_card_content_type',
								'label'         => __( 'Content Type', 'hogan-grid' ),
								'name'          => 'card_content_type',
								'instructions'  => __( 'Select the content type to build cards from', 'hogan-grid' ),
								'required'      => 1,
								'wrapper'       => [
									'width' => '50',
								],
								'choices'       => apply_filters( 'hogan/module/grid/dynamic_content_post_types', [
									'post' => __( 'Posts', 'hogan-grid' ),
									'page' => __( 'Pages', 'hogan-grid' ),
								], $this ),
								'allow_null'    => 0,
								'multiple'      => 0,
								'ui'            => 0,
								'ajax'          => 0,
								'return_format' => 'value',
							],
							[
								'type'          => 'number',
								'key'           => $this->field_key . '_number_of_items',
								'label'         => __( 'Number of items', 'hogan-grid' ),
								'name'          => 'number_of_items',
								'instructions'  => __( 'Set the number of items to display', 'hogan-grid' ),
								'required'      => 1,
								'default_value' => 3,
								'min'           => 1,
								'max'           => 10,
								'step'          => 1,
								'wrapper'       => [
									'width' => '50',
								],
							],
						],
					],
				],
			];

			return $fields;
		}

		/**
		 * Filter relationship field to only show published posts.
		 *
		 * @param array $options WP_Query options.
		 * @param array $field ACF field options.
		 * @return array
		 */
		public function relationship_options_filter( array $options, array $field ) : array {
			if ( $field['key'] === $this->field_key . '_posts_list' ) {
				$options['post_status'] = [ 'publish' ];
			}

			return $options;
		}

		/**
		 * Module wrapper classname.
		 *
		 * @param array  $classnames Wrapper classnames.
		 * @param Module $module Module.
		 * @return array Wrapper classnames.
		 */
		public function add_wrapper_classname( array $classnames, Module $module ) : array {
			if ( $module->name !== $this->name ) {
				return $classnames;
			}

			if ( ! empty( $module->theme ) ) {
				$classnames[] = 'hogan-grid-has-theme';
				$classnames[] = 'hogan-grid-theme-' . $module->theme;
			}

			return $classnames;
		}

		/**
		 * Map raw fields from acf to object variable.
		 *
		 * @param array $raw_content Content values.
		 * @param int   $counter Module location in page layout.
		 * @return void
		 */
		public function load_args_from_layout_content( array $raw_content, int $counter = 0 ) {

			$this->collection = [];

			if ( is_array( $raw_content['flex_grid'] ) ) {
				$this->collection = $this->structure_card_data( $raw_content['flex_grid'] );
			}

			$this->text_align = (string) apply_filters( 'hogan/module/grid/template/text-align', 'center' );
			$this->theme      = $raw_content['theme'] ?? '';
			parent::load_args_from_layout_content( $raw_content, $counter );

		}

		/**
		 * Get card layouts
		 *
		 * @param array $data ACF layouts.
		 * @return array Cards collection
		 */
		public function structure_card_data( array $data ) : array {

			$cards = [];

			foreach ( $data as $group ) {

				if ( ! isset( $group['acf_fc_layout'] ) ) {
					continue;
				}

				switch ( $group['acf_fc_layout'] ) {

					case 'static_content':
						foreach ( $group['posts_list'] as $post_id ) {
							if ( 'publish' !== get_post_status( $post_id ) ) {
								continue;
							}

							$this->fetched_posts[] = $post_id;

							$cards[] = [
								'id'   => $post_id,
								'type' => get_post_type( $post_id ),
								'size' => $group['card_style'],
							];
						}
						break;

					case 'dynamic_content':
						$cards_query = new \WP_Query( apply_filters( 'hogan/module/grid/dynamic_content_query', [
							'fields'         => 'ids',
							'post_type'      => $group['card_content_type'],
							'post_status'    => 'publish',
							'posts_per_page' => $group['number_of_items'],
							'post__not_in'   => wp_parse_id_list( $this->fetched_posts ),
						] ) );

						if ( $cards_query->have_posts() ) {
							foreach ( $cards_query->posts as $post_id ) {
								$this->fetched_posts[] = $post_id;

								$cards[] = [
									'id'   => $post_id,
									'type' => $group['card_content_type'],
									'size' => $group['card_style'],
								];
							}
						}
						break;

					default:
						break;
				}
			}
			return $cards;
		}

		/**
		 * Validate module content before template is loaded.
		 */
		public function validate_args() : bool {
			return ( ! empty( $this->collection ) );
		}
	}
}
