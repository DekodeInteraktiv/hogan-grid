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
		 * Module constructor.
		 */
		public function __construct() {

			$this->label    = __( 'Card grid', 'hogan-grid' );
			$this->template = __DIR__ . '/assets/template.php';

			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );

			parent::__construct();
		}

		/**
		 * Enqueue module admin assets
		 */
		public function enqueue_admin_assets() {
			$_version = defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ? time() : false;
			wp_enqueue_style( 'grid-admin-style', plugins_url( '/assets/admin-style.css', __FILE__ ), [], $_version );
		}

		/**
		 * Field definitions for module.
		 *
		 * @return array $fields Fields for this module
		 */
		public function get_fields() : array {

			$fields = [];

			// Heading field can be disabled using filter hogan/module/grid/heading/enabled (true/false).
			hogan_append_heading_field( $fields, $this );

			array_push( $fields,
			[
				'key' => $this->field_key . '_flex',
				'label' => '',
				'name' => 'flex_grid',
				'type' => 'flexible_content',
				'button_label' => esc_html__( 'Add cards', 'hogan-grid' ),
				'wrapper' => [
					'class' => 'grid-layouts',
				],
				'layouts' => [
					[
						'key' => $this->field_key . '_flex_static_content',
						'name' => 'static_content',
						'label' => esc_html__( 'Static content', 'hogan-grid' ),
						'display' => 'block',
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
								'type'              => 'relationship',
								'key'               => $this->field_key . '_posts_list',
								'label'             => __( 'Pick items from list', 'hogan-grid' ),
								'name'              => 'posts_list',
								'value'             => null,
								'instructions'      => __( 'Select items to by clicking the items on the left side', 'hogan-grid' ),
								'required'          => 1,
								'post_type'         => apply_filters( 'hogan/module/grid/static_content_post_types', [ 0 => 'post', 1 => 'page' ], $this ),
								'taxonomy'          => apply_filters( 'hogan/module/grid/static_content_taxonomy', [], $this ),
								'filters'           => apply_filters( 'hogan/module/grid/static_content_relation_filters', [ 0 => 'search',	1 => 'post_type', 2 => 'taxonomy',], $this ),
								'elements'          => [
									0 => 'featured_image',
								],
								'min'               => 1,
								'max'               => 10,
								'return_format'     => 'id',
							],
						],
					],
					[
						'key' => $this->field_key . '_flex_dynamic_content',
						'name' => 'dynamic_content',
						'label' => esc_html__( 'Dynamic content', 'hogan-grid' ),
						'display' => 'block',
						'sub_fields' => [
							[
								'type'          => 'button_group',
								'key'           => $this->field_key . 'dynamic_card_style',
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
								'type' => 'select',
								'key' => $this->field_key . 'dynamic_card_content_type',
								'label' => __( 'Content Type', 'hogan-grid' ),
								'name' => 'card_content_type',
								'instructions' => __( 'Select the content type to build cards from', 'hogan-grid' ),
								'required' => 1,
								'wrapper' => array(
									'width' => '50',
								),
								'choices' => apply_filters( 'hogan/module/grid/dynamic_content_post_types', [ 'post' => __( 'Posts', 'hogan-grid' ), 'page' => __( 'Pages', 'hogan-grid' ) ], $this ),
								'allow_null' => 0,
								'multiple' => 0,
								'ui' => 0,
								'ajax' => 0,
								'return_format' => 'value',
							],
							[
								'type'              => 'number',
								'key'               => $this->field_key . '_number_of_items',
								'label'             => __( 'Number of items', 'hogan-grid' ),
								'name'              => 'number_of_items',
								'instructions'      => __( 'Set the number of items to display', 'hogan-grid' ),
								'required'          => 1,
								'default_value'     => 3,
								'min'               => 1,
								'max'               => 10,
								'step'              => 1,
								'wrapper'           => [
									'width' => '50',
								],
							],
						],
					],
				],
			]
			);

			return $fields;
		}

		/**
		 * Map fields to object variable.
		 *
		 * @param array $content The content value.
		 *
		 * @return bool Whether validation of the module is successful / filled with content.
		 */
		public function load_args_from_layout_content( array $raw_content, int $counter = 0 ) {

			$this->collection = $this->structure_card_data( $raw_content['flex_grid'] );
			parent::load_args_from_layout_content( $raw_content, $counter );

		}

		public function structure_card_data( $data ) {

			if ( empty( $data ) ){
				return '';
			}
			$cards = [];
			foreach ( $data as $group ) {

				switch ( $group['acf_fc_layout'] ) {

					case 'static_content':
						foreach ( $group['posts_list'] as $card ) {

							$cards[] = [
								'id' => $card,
								'content_type' => get_post_type( $card ),
								'style' => $group['card_style'],
							];
						}
						break;

					case 'dynamic_content':
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
