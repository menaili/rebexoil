<?php
/**
 * Plugin Name: Induscity Visual Composer Addons
 * Plugin URI: http://demo2.steelthemes.com/plugins/induscity-vc-addons.zip
 * Description: Extra elements for Visual Composer. It was built for induscity theme.
 * Version: 1.1.1
 * Author: Steelthemes
 * Author URI: http://steelthemes.com
 * License: GPL2+
 * Text Domain: induscity
 * Domain Path: /lang/
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! defined( 'INDUSCITY_ADDONS_DIR' ) ) {
	define( 'INDUSCITY_ADDONS_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'INDUSCITY_ADDONS_URL' ) ) {
	define( 'INDUSCITY_ADDONS_URL', plugin_dir_url( __FILE__ ) );
}

require_once INDUSCITY_ADDONS_DIR . '/inc/visual-composer.php';
require_once INDUSCITY_ADDONS_DIR . '/inc/shortcodes.php';
require_once INDUSCITY_ADDONS_DIR . '/inc/portfolio.php';
require_once INDUSCITY_ADDONS_DIR . '/inc/services.php';
require_once INDUSCITY_ADDONS_DIR . '/inc/socials.php';
require_once INDUSCITY_ADDONS_DIR . '/inc/widgets/widgets.php';

if( is_admin()) {
	require_once INDUSCITY_ADDONS_DIR . '/inc/importer.php';
}

/**
 * Init
 */
function induscity_vc_addons_init() {
	load_plugin_textdomain( 'induscity', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );

	// Add image size
	add_image_size( 'induscity-service-thumbnail', 555, 300, true );
	add_image_size( 'induscity-portfolio-thumbnail', 585, 415, true );
	add_image_size( 'induscity-portfolio-single', 1170, 500, true );
	add_image_size( 'induscity-portfolio-vc-thumbnail', 350, 420, true );

	new Induscity_VC;
	new Induscity_Shortcodes;
	new Induscity_Portfolio;
	new Induscity_Services;
}

add_action( 'after_setup_theme', 'induscity_vc_addons_init', 20 );
