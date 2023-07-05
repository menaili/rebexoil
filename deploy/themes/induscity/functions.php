<?php
/**
 * Induscity functions and definitions
 *
 * @package Induscity
 */


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since  1.0
 *
 * @return void
 */
function induscity_setup() {
	// Sets the content width in pixels, based on the theme's design and stylesheet.
	$GLOBALS['content_width'] = apply_filters( 'induscity_content_width', 840 );

	// Make theme available for translation.
	load_theme_textdomain( 'induscity', get_template_directory() . '/lang' );

	// Supports WooCommerce plugin.
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Theme supports
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array( 'gallery', 'video' ) );
	add_theme_support(
		'html5', array(
			'comment-list',
			'search-form',
			'comment-form',
			'gallery',
		)
	);

	add_editor_style( 'css/editor-style.css' );

	// Load regular editor styles into the new block-based editor.
	add_theme_support( 'editor-styles' );

	// Load default block styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	add_theme_support( 'align-wide' );

	add_theme_support( 'align-full' );
	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors.
 	 */
	add_editor_style( array( 'css/editor-style.css' ) );

	add_image_size( 'induscity-blog-thumb', 1170, 638, true );
	add_image_size( 'induscity-blog-grid-thumb', 555, 330, true );
	add_image_size( 'induscity-widget-thumb', 90, 90, true );

	// Register theme nav menu
	register_nav_menus(
		array(
			'primary'   => esc_html__( 'Primary Menu', 'induscity' ),
		)
	);

	new Induscity_WooCommerce;
}

add_action( 'after_setup_theme', 'induscity_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 *
 * @since 1.0
 *
 * @return void
 */
function induscity_register_sidebar() {
	$sidebars = array(
		'blog-sidebar'    => esc_html__( 'Blog Sidebar', 'induscity' ),
		'service-sidebar' => esc_html__( 'Service Sidebar', 'induscity' ),
		'page-sidebar'    => esc_html__( 'Page Sidebar', 'induscity' ),
		'shop-sidebar'    => esc_html__( 'Shop Sidebar', 'induscity' ),
		'topbar-left'     => esc_html__( 'Topbar Left', 'induscity' ),
		'topbar-right'    => esc_html__( 'Topbar Right', 'induscity' ),
		'header-contact'  => esc_html__( 'Header Contact', 'induscity' ),
	);

	// Register sidebars
	foreach ( $sidebars as $id => $name ) {
		register_sidebar(
			array(
				'name'          => $name,
				'id'            => $id,
				'description'   => esc_html__( 'Add widgets here in order to display on pages', 'induscity' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}

	// Register footer sidebars
	for ( $i = 1; $i <= 4; $i ++ ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer', 'induscity' ) . " $i",
				'id'            => "footer-sidebar-$i",
				'description'   => esc_html__( 'Add widgets here in order to display on footer', 'induscity' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}
}

add_action( 'widgets_init', 'induscity_register_sidebar' );

/**
 * Load theme
 */


/**
 * Load WooCommerce compatibility file.
 */
require get_template_directory() . '/inc/frontend/woocommerce.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/backend/customizer.php';

// Frontend functions and shortcodes
require get_template_directory() . '/inc/functions/media.php';
require get_template_directory() . '/inc/functions/nav.php';
require get_template_directory() . '/inc/functions/header.php';
require get_template_directory() . '/inc/functions/comments.php';
require get_template_directory() . '/inc/functions/options.php';
require get_template_directory() . '/inc/functions/breadcrumbs.php';
require get_template_directory() . '/inc/functions/entry.php';

// Frontend hooks
require get_template_directory() . '/inc/frontend/layout.php';
require get_template_directory() . '/inc/frontend/header.php';
require get_template_directory() . '/inc/frontend/footer.php';
require get_template_directory() . '/inc/frontend/nav.php';
require get_template_directory() . '/inc/frontend/entry.php';
require get_template_directory() . '/inc/mega-menu/class-mega-menu-walker.php';

if ( is_admin() ) {
	require get_template_directory() . '/inc/libs/class-tgm-plugin-activation.php';
	require get_template_directory() . '/inc/backend/plugins.php';
	require get_template_directory() . '/inc/backend/meta-boxes.php';
	require get_template_directory() . '/inc/mega-menu/class-mega-menu.php';
	require get_template_directory() . '/inc/backend/editor.php';
}