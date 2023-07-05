<?php
/**
 * Hooks for frontend display
 *
 * @package Induscity
 */


/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function induscity_body_classes( $classes ) {
	$header_layout = induscity_get_option( 'header_layout' );

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( is_singular( 'post' ) ) {
		$classes[] = induscity_get_option( 'single_post_layout' );
	} elseif ( induscity_is_blog() ) {
		$classes[] = 'blog-' . induscity_get_option( 'blog_view' );
		$classes[] = induscity_get_option( 'blog_layout' );
	} elseif ( induscity_is_portfolio() ) {
		$classes[] = 'portfolio-' . induscity_get_option( 'portfolio_style' );
	} else {
		$classes[] = induscity_get_layout();
	}

	if ( is_search() ) {
		$classes[] = 'blog-classic';
	}

	if ( intval( induscity_get_option( 'header_sticky' ) ) ) {
		$classes[] = 'header-sticky';
	}

	if ( induscity_get_option( 'topbar_mobile' ) ) {
		$classes[] = 'hide-topbar-mobile';
	}

	if (
		is_page_template( 'template-homepage.php' )
		&& induscity_get_option( 'header_transparent' )
		&& ( $header_layout == 'v2' || $header_layout == 'v3' )
	) {
		$classes[] = 'header-transparent';
	}

	$classes[] = 'header-' . $header_layout;

	return $classes;
}

add_filter( 'body_class', 'induscity_body_classes' );


if ( ! function_exists( 'induscity_get_layout' ) ) :
	/**
	 * Get layout base on current page
	 *
	 * @return string
	 */
	function induscity_get_layout() {
		$layout = induscity_get_option( 'blog_layout' );

		if ( is_404() ) {
			$layout = 'full-content';
		} elseif ( is_singular( 'post' ) ) {
			if ( get_post_meta( get_the_ID(), 'custom_page_layout', true ) ) {
				$layout = get_post_meta( get_the_ID(), 'layout', true );
			} else {
				$layout = induscity_get_option( 'single_post_layout' );
			}
		} elseif ( is_page_template( array( 'template-fullwidth.php', 'template-homepage.php' ) ) ) {
			$layout = 'full-content';
		} elseif ( is_page() ) {
			if ( get_post_meta( get_the_ID(), 'custom_page_layout', true ) ) {
				$layout = get_post_meta( get_the_ID(), 'layout', true );
			} else {
				$layout = induscity_get_option( 'page_layout' );
			}
		} elseif ( is_singular( 'portfolio' ) || induscity_is_portfolio() ) {
			$layout = 'full-content';
		} elseif ( induscity_is_service() ) {
			$layout = induscity_get_option( 'service_layout' );
		} elseif ( is_singular( 'service' ) ) {
			$layout = induscity_get_option( 'single_service_layout' );
		} elseif ( induscity_is_catalog() ) {
			$layout = induscity_get_option( 'shop_layout' );
		} elseif ( function_exists( 'is_product' ) && is_product() ) {
			$layout = induscity_get_option( 'single_product_layout' );
		}


		return apply_filters( 'induscity_site_layout', $layout );
	}

endif;

if ( ! function_exists( 'induscity_get_content_columns' ) ) :
	/**
	 * Get CSS classes for content columns
	 *
	 * @param string $layout
	 *
	 * @return array
	 */
	function induscity_get_content_columns( $layout = null ) {
		$layout = $layout ? $layout : induscity_get_layout();

		if ( 'full-content' == $layout ) {
			return array( 'col-md-12', 'col-sm-12', 'col-xs-12' );
		}

		if ( induscity_is_catalog() || ( function_exists( 'is_product' ) && is_product() ) ) {
			return array( 'col-md-9', 'col-sm-12', 'col-xs-12' );
		} else {
			return array( 'col-md-8', 'col-sm-12', 'col-xs-12' );
		}
	}

endif;


if ( ! function_exists( 'induscity_content_columns' ) ) :

	/**
	 * Display CSS classes for content columns
	 *
	 * @param string $layout
	 */
	function induscity_content_columns( $layout = null ) {
		echo implode( ' ', induscity_get_content_columns( $layout ) );
	}

endif;
