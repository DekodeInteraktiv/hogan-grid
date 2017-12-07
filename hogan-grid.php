<?php
/**
 * Plugin Name: Hogan Module: Grid
 * Plugin URI: https://github.com/dekodeinteraktiv/hogan-grid
 * GitHub Plugin URI: https://github.com/dekodeinteraktiv/hogan-grid
 * Description: Card Grid Module for Hogan
 * Version: 0.1
 * Author: Dekode
 * Author URI: https://dekode.no
 * License: GPL-3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * Text Domain: hogan-grid
 * Domain Path: /languages/
 *
 * @package Hogan
 * @author Dekode
 */

declare( strict_types = 1 );
namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\\hogan_grid_load_textdomain' );
add_action( 'hogan/include_modules', __NAMESPACE__ . '\\hogan_grid_register_module' );

/**
 * Register module text domain
 */
function hogan_grid_load_textdomain() {
	load_plugin_textdomain( 'hogan-grid', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/**
 * Register module in Hogan
 */
function hogan_grid_register_module() {
	require_once 'class-grid.php';
	require_once 'includes/template-tags.php';
	\hogan_register_module( new \Dekode\Hogan\Grid() );
}
