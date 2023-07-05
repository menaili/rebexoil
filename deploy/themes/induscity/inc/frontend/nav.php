<?php
/**
 * Hooks for template nav menus
 *
 * @package Induscity
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since 1.0
 * @param array $args Configuration arguments.
 * @return array
 */
function induscity_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'induscity_page_menu_args' );

/**
 * Add extra items to the end of primary menu
 *
 * @since  1.0.0
 *
 * @param  string $items Items list
 * @param  object $args  Menu options
 *
 * @return string
 */
function induscity_nav_menu_extra_items( $items, $args ) {
	if ( 'primary' != $args->theme_location ) {
		return $items;
	}

	if ( ! intval( induscity_get_option( 'header_item_search' ) ) ) {
		return $items;
	}

	$items .= sprintf(
		'<li class="extra-menu-item menu-item-search">
			<a href="#" class="toggle-search"><i class="fa fa-search" aria-hidden="true"></i></a>
			<form method="get" class="search-form" action="%s">
				<input type="search" class="search-field" placeholder="%s..." value="" name="s">
				<input type="submit" class="search-submit" value="Search">
			</form>
		</li>',
		esc_url( home_url( '/' ) ),
		esc_attr__( 'Search', 'induscity' )
	);

	return $items;
}

add_filter( 'wp_nav_menu_items', 'induscity_nav_menu_extra_items', 10, 2 );

