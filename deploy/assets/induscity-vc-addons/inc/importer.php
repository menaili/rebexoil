<?php
/**
 * Hooks for importer
 *
 * @package Induscity
 */


/**
 * Importer the demo content
 *
 * @since  1.0
 *
 */
function induscity_vc_addons_importer() {
	return array(
		array(
			'name'       => 'Induscity Home 1',
			'preview'    => 'http://steelthemes.com/soo-importer/induscity/preview.jpg',
			'content'    => 'http://steelthemes.com/soo-importer/induscity/demo-content.xml',
			'customizer' => 'http://steelthemes.com/soo-importer/induscity/customizer.dat',
			'widgets'    => 'http://steelthemes.com/soo-importer/induscity/widgets.wie',
			'sliders'    => 'http://steelthemes.com/soo-importer/induscity/sliders.zip',
			'pages'      => array(
				'front_page' => 'Home 1',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 270,
					'height' => 270,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 370,
					'height' => 415,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),

		array(
			'name'       => 'Induscity Home 2',
			'preview'    => 'http://steelthemes.com/soo-importer/induscity/home-2/preview.jpg',
			'content'    => 'http://steelthemes.com/soo-importer/induscity/demo-content.xml',
			'customizer' => 'http://steelthemes.com/soo-importer/induscity/home-2/customizer.dat',
			'widgets'    => 'http://steelthemes.com/soo-importer/induscity/widgets.wie',
			'sliders'    => 'http://steelthemes.com/soo-importer/induscity/sliders.zip',
			'pages'      => array(
				'front_page' => 'Home 2',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 270,
					'height' => 270,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 370,
					'height' => 415,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),

		array(
			'name'       => 'Induscity Home 3',
			'preview'    => 'http://steelthemes.com/soo-importer/induscity/home-3/preview.jpg',
			'content'    => 'http://steelthemes.com/soo-importer/induscity/demo-content.xml',
			'customizer' => 'http://steelthemes.com/soo-importer/induscity/home-3/customizer.dat',
			'widgets'    => 'http://steelthemes.com/soo-importer/induscity/widgets.wie',
			'sliders'    => 'http://steelthemes.com/soo-importer/induscity/sliders.zip',
			'pages'      => array(
				'front_page' => 'Home 3',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 270,
					'height' => 270,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 370,
					'height' => 415,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),

		array(
			'name'       => 'Induscity Homepage 4',
			'preview'    => 'http://steelthemes.com/soo-importer/induscity/home-4/preview.jpg',
			'content'    => 'http://steelthemes.com/soo-importer/induscity/demo-content.xml',
			'customizer' => 'http://steelthemes.com/soo-importer/induscity/home-4/customizer.dat',
			'widgets'    => 'http://steelthemes.com/soo-importer/induscity/widgets.wie',
			'sliders'    => 'http://steelthemes.com/soo-importer/induscity/sliders.zip',
			'pages'      => array(
				'front_page' => 'Home 4',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 270,
					'height' => 270,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 370,
					'height' => 415,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),

		array(
			'name'       => 'Induscity Homepage 5',
			'preview'    => 'http://steelthemes.com/soo-importer/induscity/home-5/preview.jpg',
			'content'    => 'http://steelthemes.com/soo-importer/induscity/demo-content.xml',
			'customizer' => 'http://steelthemes.com/soo-importer/induscity/home-5/customizer.dat',
			'widgets'    => 'http://steelthemes.com/soo-importer/induscity/widgets.wie',
			'sliders'    => 'http://steelthemes.com/soo-importer/induscity/sliders.zip',
			'pages'      => array(
				'front_page' => 'Home 5',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
			),
			'menus'      => array(
				'primary' => 'primary-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 270,
					'height' => 270,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 370,
					'height' => 415,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 70,
					'height' => 70,
					'crop'   => 1,
				),
			),
		),
	);
}

add_filter( 'soo_demo_packages', 'induscity_vc_addons_importer', 20 );
