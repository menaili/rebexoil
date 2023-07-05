<?php
/**
 * Load and register widgets
 *
 * @package Induscity
 */

require_once INDUSCITY_ADDONS_DIR . '/inc/widgets/popular-posts.php';
require_once INDUSCITY_ADDONS_DIR . '/inc/widgets/service-menu.php';
require_once INDUSCITY_ADDONS_DIR . '/inc/widgets/socials.php';
require_once INDUSCITY_ADDONS_DIR . '/inc/widgets/office-location.php';
require_once INDUSCITY_ADDONS_DIR . '/inc/widgets/button-widget.php';
require_once INDUSCITY_ADDONS_DIR . '/inc/widgets/languages.php';
require_once INDUSCITY_ADDONS_DIR . '/inc/widgets/custom-menu.php';

if ( ! function_exists( 'induscity_register_widgets' ) ) {

	/**
	 * Register widgets
	 *
	 * @since  1.0
	 *
	 * @return void
	 */
	function induscity_register_widgets() {
		register_widget( 'Induscity_PopularPost_Widget' );
		register_widget( 'Induscity_Services_Menu_Widget' );
		register_widget( 'Induscity_Social_Links_Widget' );
		register_widget( 'Induscity_Office_Location_Widget' );
		register_widget( 'Induscity_Button_Widget' );
		register_widget( 'Induscity_Language_Switcher_Widget' );
		register_widget( 'Induscity_Custom_Menu_Widget' );
	}

}

add_action( 'widgets_init', 'induscity_register_widgets' );

if ( ! function_exists( 'induscity_widget_archive_count' ) ) {
	/**
	 * Change markup of archive and category widget to include .count for post count
	 *
	 * @param string $output
	 *
	 * @return string
	 */
	function induscity_widget_archive_count( $output ) {
		$output = preg_replace( '|\((\d+)\)|', '<span class="count">(\\1)</span>', $output );

		return $output;
	}
}

add_filter( 'wp_list_categories', 'induscity_widget_archive_count' );
add_filter( 'get_archives_link', 'induscity_widget_archive_count' );