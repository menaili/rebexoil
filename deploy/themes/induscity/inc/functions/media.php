<?php
/**
 * Custom functions for images, audio, videos.
 *
 * @package Induscity
 */


/**
 * Register fonts
 *
 * @since  1.0.0
 *
 * @return string
 */
function induscity_fonts_url() {
    $fonts_url = '';

	/* Translators: If there are characters in your language that are not
	* supported by Montserrat, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$hind = _x( 'on', 'Hind font: on or off', 'induscity' );

	/* Translators: If there are characters in your language that are not
	* supported by Raleway, translate this to 'off'. Do not translate
	* into your own language.
	*/


	if ( 'off' !== $hind ) {
		$font_families = array();

		if ( 'off' !== $hind ) {
			$font_families[] = 'Hind:400,500,600,700';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}