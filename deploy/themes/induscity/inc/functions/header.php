<?php
/**
 * Custom functions for header.
 *
 * @package Induscity
 */

/**
 * Header Button
 */
function manyfactory_header_item_button() {
	if ( ! intval( induscity_get_option( 'header_item_button' ) ) ) {
		return;
	}

	$url = induscity_get_option( 'header_button_link' );
	$btn = induscity_get_option( 'header_button_text' );

	printf('<div class="mf-header-item-button"><a href="%s" class="mf-btn">%s</a></div>', esc_url( $url ), wp_kses( $btn, wp_kses_allowed_html( 'post' ) ) );
}