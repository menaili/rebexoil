<?php
/**
 * Induscity theme customizer
 *
 * @package Induscity
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Induscity_Customize {
	/**
	 * Customize settings
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * The class constructor
	 *
	 * @param array $config
	 */
	public function __construct( $config ) {
		$this->config = $config;

		if ( ! class_exists( 'Kirki' ) ) {
			return;
		}

		$this->register();
	}

	/**
	 * Register settings
	 */
	public function register() {
		/**
		 * Add the theme configuration
		 */
		if ( ! empty( $this->config['theme'] ) ) {
			Kirki::add_config(
				$this->config['theme'], array(
					'capability'  => 'edit_theme_options',
					'option_type' => 'theme_mod',
				)
			);
		}

		/**
		 * Add panels
		 */
		if ( ! empty( $this->config['panels'] ) ) {
			foreach ( $this->config['panels'] as $panel => $settings ) {
				Kirki::add_panel( $panel, $settings );
			}
		}

		/**
		 * Add sections
		 */
		if ( ! empty( $this->config['sections'] ) ) {
			foreach ( $this->config['sections'] as $section => $settings ) {
				Kirki::add_section( $section, $settings );
			}
		}

		/**
		 * Add fields
		 */
		if ( ! empty( $this->config['theme'] ) && ! empty( $this->config['fields'] ) ) {
			foreach ( $this->config['fields'] as $name => $settings ) {
				if ( ! isset( $settings['settings'] ) ) {
					$settings['settings'] = $name;
				}

				Kirki::add_field( $this->config['theme'], $settings );
			}
		}
	}

	/**
	 * Get config ID
	 *
	 * @return string
	 */
	public function get_theme() {
		return $this->config['theme'];
	}

	/**
	 * Get customize setting value
	 *
	 * @param string $name
	 *
	 * @return bool|string
	 */
	public function get_option( $name ) {

		$default = $this->get_option_default( $name );

		return get_theme_mod( $name, $default );
	}

	/**
	 * Get default option values
	 *
	 * @param $name
	 *
	 * @return mixed
	 */
	public function get_option_default( $name ) {
		if ( ! isset( $this->config['fields'][$name] ) ) {
			return false;
		}

		return isset( $this->config['fields'][$name]['default'] ) ? $this->config['fields'][$name]['default'] : false;
	}
}

/**
 * This is a short hand function for getting setting value from customizer
 *
 * @param string $name
 *
 * @return bool|string
 */
function induscity_get_option( $name ) {
	global $induscity_customize;

	if ( empty( $induscity_customize ) ) {
		return false;
	}

	if ( class_exists( 'Kirki' ) ) {
		$value = Kirki::get_option( $induscity_customize->get_theme(), $name );
	} else {
		$value = $induscity_customize->get_option( $name );
	}

	return apply_filters( 'induscity_get_option', $value, $name );
}

/**
 * Get default option values
 *
 * @param $name
 *
 * @return mixed
 */
function induscity_get_option_default( $name ) {
	global $induscity_customize;

	if ( empty( $induscity_customize ) ) {
		return false;
	}

	return $induscity_customize->get_option_default( $name );
}

/**
 * Move some default sections to `general` panel that registered by theme
 *
 * @param object $wp_customize
 */
function induscity_customize_modify( $wp_customize ) {
	$wp_customize->get_section( 'title_tagline' )->panel     = 'general';
	$wp_customize->get_section( 'static_front_page' )->panel = 'general';
}

add_action( 'customize_register', 'induscity_customize_modify' );

/**
 * Customizer register
 */
$induscity_customize = new Induscity_Customize(
	array(
		'theme'    => 'induscity',
		'panels'   => array(
			'general'     => array(
				'priority' => 10,
				'title'    => esc_html__( 'General', 'induscity' ),
			),
			'typography'  => array(
				'priority' => 10,
				'title'    => esc_html__( 'Typography', 'induscity' ),
			),
			'styling'     => array(
				'priority' => 10,
				'title'    => esc_html__( 'Styling', 'induscity' ),
			),
			'header'      => array(
				'priority' => 10,
				'title'    => esc_html__( 'Header', 'induscity' ),
			),
			'blog'        => array(
				'title'      => esc_html__( 'Blog', 'induscity' ),
				'priority'   => 10,
				'capability' => 'edit_theme_options',
			),
			'woocommerce' => array(
				'priority' => 10,
				'title'    => esc_html__( 'Woocommerce', 'induscity' ),
			),
			'page'        => array(
				'priority' => 10,
				'title'    => esc_html__( 'Page', 'induscity' ),
			),
			'portfolio'   => array(
				'title'      => esc_html__( 'Portfolio', 'induscity' ),
				'priority'   => 10,
				'capability' => 'edit_theme_options',
			),
			'services'    => array(
				'title'      => esc_html__( 'Services', 'induscity' ),
				'priority'   => 10,
				'capability' => 'edit_theme_options',
			),
		),
		'sections' => array(
			'topbar'                       => array(
				'title'       => esc_html__( 'Topbar', 'induscity' ),
				'description' => '',
				'priority'    => 5,
				'capability'  => 'edit_theme_options',
				'panel'       => 'header',
			),
			'body_typo'                    => array(
				'title'       => esc_html__( 'Body', 'induscity' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'typography',
			),
			'heading_typo'                 => array(
				'title'       => esc_html__( 'Heading', 'induscity' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'typography',
			),
			'header_typo'                  => array(
				'title'       => esc_html__( 'Header', 'induscity' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'typography',
			),
			'footer_typo'                  => array(
				'title'       => esc_html__( 'Footer', 'induscity' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'typography',
			),
			'header'                       => array(
				'title'       => esc_html__( 'Header', 'induscity' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'header',
			),
			'logo'                         => array(
				'title'       => esc_html__( 'Logo', 'induscity' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'header',
			),
			'color_scheme'                 => array(
				'title'       => esc_html__( 'Color Scheme', 'induscity' ),
				'description' => '',
				'priority'    => 210,
				'capability'  => 'edit_theme_options',
				'panel'       => 'styling',
			),
			'page_layout'                  => array(
				'title'      => esc_html__( 'Page Layout', 'induscity' ),
				'priority'   => 10,
				'capability' => 'edit_theme_options',
				'panel'      => 'page',
			),
			'page_header'                  => array(
				'title'       => esc_html__( 'Page Header', 'induscity' ),
				'description' => esc_html__( 'Work on page default.', 'induscity' ),
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'page',
			),
			'not_found'                    => array(
				'title'      => esc_html__( '404 Page', 'induscity' ),
				'priority'   => 10,
				'capability' => 'edit_theme_options',
				'panel'      => 'page',
			),
			'blog_page_header'             => array(
				'title'       => esc_html__( 'Page Header on Blog Page', 'induscity' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'blog',
			),
			'blog_page'                    => array(
				'title'       => esc_html__( 'Blog Page', 'induscity' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'blog',
			),
			'single_page_header'           => array(
				'title'       => esc_html__( 'Page Header on Single Blog', 'induscity' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'blog',
			),
			'single_post'                  => array(
				'title'       => esc_html__( 'Single Post', 'induscity' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'blog',
			),
			'shop_page_header'             => array(
				'title'       => esc_html__( 'Page Header on Shop Page', 'induscity' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'woocommerce',
			),
			'woocommerce_product_catalog'  => array(
				'title'       => esc_html__( 'Product Catalog', 'induscity' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'woocommerce',
			),
			'single_product_page_header'   => array(
				'title'       => esc_html__( 'Page Header on Single Product', 'induscity' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'woocommerce',
			),
			'single_product'               => array(
				'title'       => esc_html__( 'Single Product', 'induscity' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'woocommerce',
			),
			'portfolio_page_header'        => array(
				'title'       => esc_html__( 'Page Header on Portfolio Page', 'induscity' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'portfolio',
			),
			'portfolio_page'               => array(
				'title'       => esc_html__( 'Portfolio Page', 'induscity' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'portfolio',
			),
			'single_portfolio_page_header' => array(
				'title'       => esc_html__( 'Page Header on Single Portfolio', 'induscity' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'portfolio',
			),
			'single_portfolio'             => array(
				'title'       => esc_html__( 'Single Portfolio', 'induscity' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'portfolio',
			),
			'service_page_header'          => array(
				'title'       => esc_html__( 'Page Header on Service Page', 'induscity' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'services',
			),
			'service_page'                 => array(
				'title'       => esc_html__( 'Service Page', 'induscity' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'services',
			),
			'single_service_page_header'   => array(
				'title'       => esc_html__( 'Page Header on Single Service', 'induscity' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'services',
			),
			'single_service'               => array(
				'title'       => esc_html__( 'Single Service', 'induscity' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'services',
			),
			'footer'                       => array(
				'title'       => esc_html__( 'Footer', 'induscity' ),
				'description' => '',
				'priority'    => 350,
				'capability'  => 'edit_theme_options',
			),
		),
		'fields'   => array(
			// Typography
			'body_typo'                             => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Body', 'induscity' ),
				'section'  => 'body_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Hind',
					'variant'        => '300',
					'font-size'      => '16px',
					'line-height'    => '1.6',
					'letter-spacing' => '0',
					'subsets'        => array( 'latin-ext' ),
					'color'          => '#848484',
					'text-transform' => 'none',
				),
			),
			'heading1_typo'                         => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Heading 1', 'induscity' ),
				'section'  => 'heading_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Hind',
					'variant'        => '600',
					'font-size'      => '36px',
					'line-height'    => '1.2',
					'letter-spacing' => '0',
					'subsets'        => array( 'latin-ext' ),
					'color'          => '#393939',
					'text-transform' => 'none',
				),
			),
			'heading2_typo'                         => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Heading 2', 'induscity' ),
				'section'  => 'heading_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Hind',
					'variant'        => '600',
					'font-size'      => '30px',
					'line-height'    => '1.2',
					'letter-spacing' => '0',
					'subsets'        => array( 'latin-ext' ),
					'color'          => '#393939',
					'text-transform' => 'none',
				),
			),
			'heading3_typo'                         => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Heading 3', 'induscity' ),
				'section'  => 'heading_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Hind',
					'variant'        => '600',
					'font-size'      => '24px',
					'line-height'    => '1.2',
					'letter-spacing' => '0',
					'subsets'        => array( 'latin-ext' ),
					'color'          => '#393939',
					'text-transform' => 'none',
				),
			),
			'heading4_typo'                         => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Heading 4', 'induscity' ),
				'section'  => 'heading_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Hind',
					'variant'        => '600',
					'font-size'      => '18px',
					'line-height'    => '1.2',
					'letter-spacing' => '0',
					'subsets'        => array( 'latin-ext' ),
					'color'          => '#393939',
					'text-transform' => 'none',
				),
			),
			'heading5_typo'                         => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Heading 5', 'induscity' ),
				'section'  => 'heading_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Hind',
					'variant'        => '600',
					'font-size'      => '16px',
					'line-height'    => '1.2',
					'letter-spacing' => '0',
					'subsets'        => array( 'latin-ext' ),
					'color'          => '#393939',
					'text-transform' => 'none',
				),
			),
			'heading6_typo'                         => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Heading 6', 'induscity' ),
				'section'  => 'heading_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Hind',
					'variant'        => '600',
					'font-size'      => '12px',
					'line-height'    => '1.2',
					'letter-spacing' => '0',
					'subsets'        => array( 'latin-ext' ),
					'color'          => '#393939',
					'text-transform' => 'none',
				),
			),
			'menu_typo'                             => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Menu', 'induscity' ),
				'section'  => 'header_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Hind',
					'variant'        => '600',
					'subsets'        => array( 'latin-ext' ),
					'font-size'      => '16px',
					'color'          => '#fff',
					'text-transform' => 'none',
				),
			),
			'sub_menu_typo'                         => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Sub Menu', 'induscity' ),
				'section'  => 'header_typo',
				'priority' => 10,
				'default'  => array(
					'font-family'    => 'Hind',
					'variant'        => '300',
					'subsets'        => array( 'latin-ext' ),
					'font-size'      => '16px',
					'color'          => '#909090',
					'text-transform' => 'none',
				),
			),
			'footer_text_typo'                      => array(
				'type'     => 'typography',
				'label'    => esc_html__( 'Footer Text', 'induscity' ),
				'section'  => 'footer_typo',
				'priority' => 10,
				'default'  => array(
					'font-family' => 'Hind',
					'variant'     => '300',
					'subsets'     => array( 'latin-ext' ),
					'font-size'   => '16px',
				),
			),

			// Topbar
			'topbar_enable'                         => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Show topbar', 'induscity' ),
				'section'  => 'topbar',
				'default'  => 1,
				'priority' => 10,
			),
			'topbar_mobile'                         => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Hide topbar on mobile', 'induscity' ),
				'section'  => 'topbar',
				'default'  => 1,
				'priority' => 15,
			),
			'topbar_background'                     => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Topbar Background Color', 'induscity' ),
				'default'  => '',
				'section'  => 'topbar',
				'priority' => 15,
			),

			// Header layout
			'header_layout'                         => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Header Layout', 'induscity' ),
				'section'  => 'header',
				'default'  => 'v1',
				'priority' => 10,
				'choices'  => array(
					'v1' => esc_html__( 'Header v1', 'induscity' ),
					'v2' => esc_html__( 'Header v2', 'induscity' ),
					'v3' => esc_html__( 'Header v3', 'induscity' ),
					'v4' => esc_html__( 'Header v4', 'induscity' ),
					'v5' => esc_html__( 'Header v5', 'induscity' ),
				),
			),

			'header_sticky'                         => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Header Sticky', 'induscity' ),
				'default'  => 0,
				'section'  => 'header',
				'priority' => 40,
			),

			'header_transparent'                    => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Header Transparent', 'induscity' ),
				'default'         => 1,
				'section'         => 'header',
				'priority'        => 40,
				'description'     => esc_html__( 'Check this to enable header transparent in homepage only for Header Layout 2,3.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => 'in',
						'value'    => array( 'v2', 'v3' ),
					),
				),
			),

			'header_item_search'                    => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Search Item', 'induscity' ),
				'section'  => 'header',
				'default'  => 1,
				'priority' => 45,
			),

			'header_item_button'                    => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Button Item', 'induscity' ),
				'section'  => 'header',
				'default'  => 0,
				'priority' => 45,
			),

			'header_button_link'                    => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Button Link', 'induscity' ),
				'section'         => 'header',
				'default'         => '',
				'priority'        => 55,
				'active_callback' => array(
					array(
						'setting'  => 'header_item_button',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'header_button_text'                    => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Button Text', 'induscity' ),
				'section'         => 'header',
				'default'         => esc_html__( 'Get a Quote', 'induscity' ),
				'priority'        => 55,
				'active_callback' => array(
					array(
						'setting'  => 'header_item_button',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'menu_extra_block'                      => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Menu Extra Block', 'induscity' ),
				'section'         => 'header',
				'default'         => array( 'right' ),
				'priority'        => 55,
				'choices'         => array(
					'right' => esc_html__( 'Block on the right of Menu', 'induscity' ),
					'left'  => esc_html__( 'Block on the left of Menu', 'induscity' ),
				),
				'description'     => esc_html__( 'Select Menu Extra Block you want to show.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => 'in',
						'value'    => array( 'v1', 'v5' ),
					),
				),
			),

			// Logo
			'logo_dark'                             => array(
				'type'     => 'image',
				'label'    => esc_html__( 'Logo', 'induscity' ),
				'section'  => 'logo',
				'default'  => '',
				'priority' => 10,
			),
			'logo_light'                            => array(
				'type'     => 'image',
				'label'    => esc_html__( 'Logo Light', 'induscity' ),
				'section'  => 'logo',
				'default'  => '',
				'priority' => 10,
			),
			'logo_width'                            => array(
				'type'     => 'number',
				'label'    => esc_html__( 'Logo Width', 'induscity' ),
				'section'  => 'logo',
				'default'  => '',
				'priority' => 10,
			),
			'logo_height'                           => array(
				'type'     => 'number',
				'label'    => esc_html__( 'Logo Height', 'induscity' ),
				'section'  => 'logo',
				'default'  => '',
				'priority' => 10,
			),
			'logo_position'                         => array(
				'type'     => 'spacing',
				'label'    => esc_html__( 'Logo Margin', 'induscity' ),
				'section'  => 'logo',
				'priority' => 10,
				'default'  => array(
					'top'    => '0',
					'bottom' => '0',
					'left'   => '0',
					'right'  => '0',
				),
			),

			// Color Scheme
			'color_scheme'                          => array(
				'type'     => 'palette',
				'label'    => esc_html__( 'Base Color Scheme', 'induscity' ),
				'default'  => '#f7c02d',
				'section'  => 'color_scheme',
				'priority' => 10,
				'choices'  => array(
					'#f7c02d' => array( '#f7c02d' ),
					'#00baff' => array( '#00baff' ),
					'#ee6012' => array( '#ee6012' ),
					'#00cc00' => array( '#00cc00' ),
					'#e83f39' => array( '#e83f39' ),
				),
			),
			'custom_color_scheme'                   => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Custom Color Scheme', 'induscity' ),
				'default'  => 0,
				'section'  => 'color_scheme',
				'priority' => 10,
			),
			'custom_color'                          => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Color', 'induscity' ),
				'default'         => '',
				'section'         => 'color_scheme',
				'priority'        => 10,
				'active_callback' => array(
					array(
						'setting'  => 'custom_color_scheme',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			// Page
			'page_layout'                           => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Page Layout', 'induscity' ),
				'section'     => 'page_layout',
				'default'     => 'full-content',
				'priority'    => 10,
				'description' => esc_html__( 'Select default sidebar for page default.', 'induscity' ),
				'choices'     => array(
					'full-content'    => esc_html__( 'Full Content', 'induscity' ),
					'sidebar-content' => esc_html__( 'Left Sidebar', 'induscity' ),
					'content-sidebar' => esc_html__( 'Right Sidebar', 'induscity' ),
				),
			),
			'page_page_header'                      => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Page Header', 'induscity' ),
				'default'     => 1,
				'section'     => 'page_header',
				'priority'    => 10,
				'description' => esc_html__( 'Check this option to show the page header below the header.', 'induscity' ),
			),
			'page_page_header_els'                  => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Page Header Elements', 'induscity' ),
				'section'         => 'page_header',
				'default'         => array( 'breadcrumb', 'title' ),
				'priority'        => 20,
				'choices'         => array(
					'breadcrumb' => esc_html__( 'BreadCrumb', 'induscity' ),
					'title'      => esc_html__( 'Title', 'induscity' ),
				),
				'description'     => esc_html__( 'Select which elements you want to show.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'page_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'page_page_header_bg'                   => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Background Image', 'induscity' ),
				'section'         => 'page_header',
				'default'         => '',
				'priority'        => 30,
				'active_callback' => array(
					array(
						'setting'  => 'page_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'page_page_header_parallax'             => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Parallax', 'induscity' ),
				'default'         => 1,
				'section'         => 'page_header',
				'priority'        => 30,
				'description'     => esc_html__( 'Check this option to enable parallax for the page header.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'page_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			// 404
			'not_found_bg'                          => array(
				'type'     => 'image',
				'label'    => esc_html__( 'Background Image', 'induscity' ),
				'section'  => 'not_found',
				'default'  => '',
				'priority' => 10,
			),

			// Blog Page Header
			'blog_page_header'                      => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Page Header', 'induscity' ),
				'default'     => 1,
				'section'     => 'blog_page_header',
				'priority'    => 10,
				'description' => esc_html__( 'Check this option to show the page header below the header.', 'induscity' ),
			),
			'blog_page_header_els'                  => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Page Header Elements', 'induscity' ),
				'section'         => 'blog_page_header',
				'default'         => array( 'breadcrumb', 'title' ),
				'priority'        => 20,
				'choices'         => array(
					'breadcrumb' => esc_html__( 'BreadCrumb', 'induscity' ),
					'title'      => esc_html__( 'Title', 'induscity' ),
				),
				'description'     => esc_html__( 'Select which elements you want to show.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'blog_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'blog_page_header_bg'                   => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Bacground Image', 'induscity' ),
				'section'         => 'blog_page_header',
				'default'         => '',
				'priority'        => 30,
				'active_callback' => array(
					array(
						'setting'  => 'blog_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'blog_page_header_parallax'             => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Parallax', 'induscity' ),
				'default'         => 1,
				'section'         => 'blog_page_header',
				'priority'        => 30,
				'description'     => esc_html__( 'Check this option to enable parallax for the page header.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'blog_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			// Blog
			'blog_layout'                           => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Blog Layout', 'induscity' ),
				'section'     => 'blog_page',
				'default'     => 'full-content',
				'priority'    => 10,
				'description' => esc_html__( 'Select default sidebar for blog page.', 'induscity' ),
				'choices'     => array(
					'content-sidebar' => esc_html__( 'Right Sidebar', 'induscity' ),
					'sidebar-content' => esc_html__( 'Left Sidebar', 'induscity' ),
					'full-content'    => esc_html__( 'Full Content', 'induscity' ),
				),
			),
			'blog_view'                             => array(
				'type'     => 'radio',
				'label'    => esc_html__( 'Blog Layout', 'induscity' ),
				'section'  => 'blog_page',
				'default'  => 'classic',
				'priority' => 10,
				'choices'  => array(
					'classic' => esc_html__( 'Classic', 'induscity' ),
					'grid'    => esc_html__( 'Grid', 'induscity' ),
				),
			),
			'blog_grid_columns'                     => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Blog Grid Columns', 'induscity' ),
				'section'         => 'blog_page',
				'default'         => '3',
				'priority'        => 10,
				'choices'         => array(
					'3' => esc_html__( '3 Columns', 'induscity' ),
					'2' => esc_html__( '2 Columns', 'induscity' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'blog_view',
						'operator' => '==',
						'value'    => 'grid',
					),
				),
			),
			'blog_grid_excerpt_length'              => array(
				'type'     => 'number',
				'label'    => esc_html__( 'Blog Grid Excerpt Length', 'induscity' ),
				'section'  => 'blog_page',
				'default'  => 20,
				'priority' => 10,
			),

			'blog_classic_excerpt_length'           => array(
				'type'     => 'number',
				'label'    => esc_html__( 'Blog List Excerpt Length', 'induscity' ),
				'section'  => 'blog_page',
				'default'  => 30,
				'priority' => 10,
			),
			'blog_entry_meta'                       => array(
				'type'     => 'multicheck',
				'label'    => esc_html__( 'Entry Meta', 'induscity' ),
				'section'  => 'blog_page',
				'default'  => array( 'author', 'date' ),
				'choices'  => array(
					'author' => esc_html__( 'Author', 'induscity' ),
					'date'   => esc_html__( 'Date', 'induscity' ),
					'cat'    => esc_html__( 'Categories', 'induscity' ),
				),
				'priority' => 10,
			),

			// Post Page Header
			'single_page_header'                    => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Page Header', 'induscity' ),
				'default'     => 1,
				'section'     => 'single_page_header',
				'priority'    => 10,
				'description' => esc_html__( 'Check this option to show the page header below the header.', 'induscity' ),
			),
			'single_page_header_els'                => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Page Header Elements', 'induscity' ),
				'section'         => 'single_page_header',
				'default'         => array( 'breadcrumb', 'title' ),
				'priority'        => 20,
				'choices'         => array(
					'breadcrumb' => esc_html__( 'BreadCrumb', 'induscity' ),
					'title'      => esc_html__( 'Title', 'induscity' ),
				),
				'description'     => esc_html__( 'Select which elements you want to show.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'single_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'single_page_header_bg'                 => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Bacground Image', 'induscity' ),
				'section'         => 'single_page_header',
				'default'         => '',
				'priority'        => 30,
				'active_callback' => array(
					array(
						'setting'  => 'single_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'single_page_header_parallax'           => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Parallax', 'induscity' ),
				'default'         => 1,
				'section'         => 'single_page_header',
				'priority'        => 30,
				'description'     => esc_html__( 'Check this option to enable parallax for the page header.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'single_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			// Single Posts
			'single_post_layout'                    => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Single Post Layout', 'induscity' ),
				'section'     => 'single_post',
				'default'     => 'full-content',
				'priority'    => 5,
				'description' => esc_html__( 'Select default sidebar for the single post page.', 'induscity' ),
				'choices'     => array(
					'content-sidebar' => esc_html__( 'Right Sidebar', 'induscity' ),
					'sidebar-content' => esc_html__( 'Left Sidebar', 'induscity' ),
					'full-content'    => esc_html__( 'Full Content', 'induscity' ),
				),
			),
			'post_entry_meta'                       => array(
				'type'     => 'multicheck',
				'label'    => esc_html__( 'Entry Meta', 'induscity' ),
				'section'  => 'single_post',
				'default'  => array( 'author', 'date', 'cat' ),
				'choices'  => array(
					'author' => esc_html__( 'Author', 'induscity' ),
					'date'   => esc_html__( 'Date', 'induscity' ),
					'cat'    => esc_html__( 'Categories', 'induscity' ),
				),
				'priority' => 10,
			),
			'post_custom_field_2'                   => array(
				'type'    => 'custom',
				'section' => 'single_post',
				'default' => '<hr/>',
			),

			'show_post_social_share'                => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Show Socials Share', 'induscity' ),
				'description' => esc_html__( 'Check this option to show socials share in the single post page.', 'induscity' ),
				'section'     => 'single_post',
				'default'     => 0,
				'priority'    => 10,
			),

			'post_socials_share'                    => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Socials Share', 'induscity' ),
				'section'         => 'single_post',
				'default'         => array( 'facebook', 'twitter', 'google', 'linkedin' ),
				'choices'         => array(
					'twitter'   => esc_html__( 'Twitter', 'induscity' ),
					'facebook'  => esc_html__( 'Facebook', 'induscity' ),
					'google'    => esc_html__( 'Google Plus', 'induscity' ),
					'pinterest' => esc_html__( 'Pinterest', 'induscity' ),
					'linkedin'  => esc_html__( 'Linkedin', 'induscity' ),
					'vkontakte' => esc_html__( 'Vkontakte', 'induscity' ),
				),
				'priority'        => 10,
				'active_callback' => array(
					array(
						'setting'  => 'show_post_social_share',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'show_author_box'                       => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Show Author Box', 'induscity' ),
				'section'  => 'single_post',
				'default'  => 1,
				'priority' => 30,
			),

			// Page Header for Shop
			'page_header_shop'                      => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Page Header', 'induscity' ),
				'default'     => 1,
				'section'     => 'shop_page_header',
				'priority'    => 10,
				'description' => esc_html__( 'Check this option to show the page header below the header.', 'induscity' ),
			),
			'page_header_shop_els'                  => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Page Header Elements', 'induscity' ),
				'section'         => 'shop_page_header',
				'default'         => array( 'breadcrumb', 'title' ),
				'priority'        => 20,
				'choices'         => array(
					'breadcrumb' => esc_html__( 'BreadCrumb', 'induscity' ),
					'title'      => esc_html__( 'Title', 'induscity' ),
				),
				'description'     => esc_html__( 'Select which elements you want to show.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_shop',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'page_header_shop_bg'                   => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Bacground Image', 'induscity' ),
				'section'         => 'shop_page_header',
				'default'         => '',
				'priority'        => 30,
				'active_callback' => array(
					array(
						'setting'  => 'page_header_shop',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'page_header_shop_parallax'             => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Parallax', 'induscity' ),
				'default'         => 1,
				'section'         => 'shop_page_header',
				'priority'        => 30,
				'description'     => esc_html__( 'Check this option to enable parallax for the page header.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_shop',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			// Shop Page
			'shop_layout'                           => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Shop Layout', 'induscity' ),
				'default'     => 'sidebar-content',
				'section'     => 'woocommerce_product_catalog',
				'priority'    => 20,
				'description' => esc_html__( 'Select default sidebar for shop page.', 'induscity' ),
				'choices'     => array(
					'sidebar-content' => esc_html__( 'Left Sidebar', 'induscity' ),
					'content-sidebar' => esc_html__( 'Right Sidebar', 'induscity' ),
					'full-content'    => esc_html__( 'Full Content', 'induscity' ),
				),
			),
			'shop_ribbons'                          => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Show Ribbons', 'induscity' ),
				'default'     => 0,
				'section'     => 'woocommerce_product_catalog',
				'priority'    => 20,
				'description' => esc_html__( 'Check this option to show ribbons on product', 'induscity' ),
			),
			'product_newness'                       => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Product Newness', 'induscity' ),
				'section'     => 'woocommerce_product_catalog',
				'default'     => 3,
				'priority'    => 20,
				'description' => esc_html__( 'Display the "New" badge for how many days?', 'induscity' ),
			),

			// Single Product Page Header
			'single_product_page_header'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Page Header', 'induscity' ),
				'default'     => 1,
				'section'     => 'single_product_page_header',
				'priority'    => 10,
				'description' => esc_html__( 'Check this option to show the page header below the header.', 'induscity' ),
			),
			'single_product_page_header_els'        => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Page Header Elements', 'induscity' ),
				'section'         => 'single_product_page_header',
				'default'         => array( 'breadcrumb', 'title' ),
				'priority'        => 20,
				'choices'         => array(
					'breadcrumb' => esc_html__( 'BreadCrumb', 'induscity' ),
					'title'      => esc_html__( 'Title', 'induscity' ),
				),
				'description'     => esc_html__( 'Select which elements you want to show.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'single_product_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'single_product_page_header_bg'         => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Bacground Image', 'induscity' ),
				'section'         => 'single_product_page_header',
				'default'         => '',
				'priority'        => 30,
				'active_callback' => array(
					array(
						'setting'  => 'single_product_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'single_product_page_header_parallax'   => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Parallax', 'induscity' ),
				'default'         => 1,
				'section'         => 'single_product_page_header',
				'priority'        => 30,
				'description'     => esc_html__( 'Check this option to enable parallax for the page header.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'single_product_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			// Single Product
			'single_product_layout'                 => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Single Product Layout', 'induscity' ),
				'default'     => 'sidebar-content',
				'section'     => 'single_product',
				'priority'    => 10,
				'description' => esc_html__( 'Select default sidebar for the single post page.', 'induscity' ),
				'choices'     => array(
					'sidebar-content' => esc_html__( 'Left Sidebar', 'induscity' ),
					'content-sidebar' => esc_html__( 'Right Sidebar', 'induscity' ),
					'full-content'    => esc_html__( 'Full Content', 'induscity' ),
				),
			),
			'single_product_custom_field_1'         => array(
				'type'    => 'custom',
				'section' => 'single_product',
				'default' => '<hr/>',
			),
			'related_product'                       => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Related Products', 'induscity' ),
				'section'     => 'single_product',
				'description' => esc_html__( 'Check this option to show related posts in the single post page.', 'induscity' ),
				'default'     => 1,
				'priority'    => 20,
			),
			'related_product_title'                 => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Related Products Title', 'induscity' ),
				'section'         => 'single_product',
				'default'         => esc_html__( 'Related Products', 'induscity' ),
				'priority'        => 20,

				'active_callback' => array(
					array(
						'setting'  => 'related_product',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'related_product_numbers'               => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Related Products Numbers', 'induscity' ),
				'section'         => 'single_product',
				'default'         => '3',
				'priority'        => 20,
				'active_callback' => array(
					array(
						'setting'  => 'related_product',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'related_product_columns'               => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Related Products Columns', 'induscity' ),
				'default'     => '4',
				'section'     => 'single_product',
				'priority'    => 20,
				'description' => esc_html__( 'Select product columns for related product.', 'induscity' ),
				'choices'     => array(
					'4' => esc_html__( '4 Columns', 'induscity' ),
					'3' => esc_html__( '3 Columns', 'induscity' ),
				),
			),

			// Portfolio Page Header
			'portfolio_page_header'                 => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Page Header', 'induscity' ),
				'default'     => 1,
				'section'     => 'portfolio_page_header',
				'priority'    => 10,
				'description' => esc_html__( 'Check this option to show the page header below the header.', 'induscity' ),
			),
			'portfolio_page_header_els'             => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Page Header Elements', 'induscity' ),
				'section'         => 'portfolio_page_header',
				'default'         => array( 'breadcrumb', 'title' ),
				'priority'        => 20,
				'choices'         => array(
					'breadcrumb' => esc_html__( 'BreadCrumb', 'induscity' ),
					'title'      => esc_html__( 'Title', 'induscity' ),
				),
				'description'     => esc_html__( 'Select which elements you want to show.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'portfolio_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'portfolio_page_header_bg'              => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Bacground Image', 'induscity' ),
				'section'         => 'portfolio_page_header',
				'default'         => '',
				'priority'        => 30,
				'active_callback' => array(
					array(
						'setting'  => 'portfolio_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'portfolio_page_header_parallax'        => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Parallax', 'induscity' ),
				'default'         => 1,
				'section'         => 'portfolio_page_header',
				'priority'        => 30,
				'description'     => esc_html__( 'Check this option to enable parallax for the page header.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'portfolio_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			// Portfolio
			'portfolio_style'                       => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Portfolio Style', 'induscity' ),
				'section'     => 'portfolio_page',
				'default'     => 'modern',
				'priority'    => 10,
				'description' => esc_html__( 'Select style for portfolio page.', 'induscity' ),
				'choices'     => array(
					'modern'        => esc_html__( 'Modern', 'induscity' ),
					'with-space'    => esc_html__( 'With Space', 'induscity' ),
					'without-space' => esc_html__( 'Without Space', 'induscity' ),
				),
			),
			'portfolio_columns'                     => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Portfolio Columns', 'induscity' ),
				'section'  => 'portfolio_page',
				'default'  => '2',
				'priority' => 10,
				'choices'  => array(
					'2' => esc_html__( '2 Columns', 'induscity' ),
					'3' => esc_html__( '3 Columns', 'induscity' ),
					'4' => esc_html__( '4 Columns', 'induscity' ),
				),
			),
			'portfolio_nav_filter'                  => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Portfolio Nav Filter', 'induscity' ),
				'default'     => 1,
				'section'     => 'portfolio_page',
				'priority'    => 10,
				'description' => esc_html__( 'Check this option to show the nav filter.', 'induscity' ),
			),
			'portfolio_filter'                      => array(
				'type'     => 'radio',
				'label'    => esc_html__( 'Filter', 'induscity' ),
				'section'  => 'portfolio_page',
				'default'  => 'slug',
				'priority' => 10,
				'choices'  => array(
					'slug' => esc_html__( 'By Category Slug', 'induscity' ),
					'id'   => esc_html__( 'By Category ID', 'induscity' ),
				),
			),
			'portfolio_title_length'                => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Portfolio Title Length', 'induscity' ),
				'section'         => 'portfolio_page',
				'default'         => 10,
				'priority'        => 10,
				'description'     => esc_html__( 'How many words you want to show on title', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'portfolio_style',
						'operator' => '==',
						'value'    => 'modern',
					),
				),
			),

			// Single Portfolio Page Header
			'single_portfolio_page_header'          => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Page Header', 'induscity' ),
				'default'     => 1,
				'section'     => 'single_portfolio_page_header',
				'priority'    => 10,
				'description' => esc_html__( 'Check this option to show the page header below the header.', 'induscity' ),
			),
			'single_portfolio_page_header_els'      => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Page Header Elements', 'induscity' ),
				'section'         => 'single_portfolio_page_header',
				'default'         => array( 'breadcrumb', 'title' ),
				'priority'        => 20,
				'choices'         => array(
					'breadcrumb' => esc_html__( 'BreadCrumb', 'induscity' ),
					'title'      => esc_html__( 'Title', 'induscity' ),
				),
				'description'     => esc_html__( 'Select which elements you want to show.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'single_portfolio_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'single_portfolio_page_header_bg'       => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Bacground Image', 'induscity' ),
				'section'         => 'single_portfolio_page_header',
				'default'         => '',
				'priority'        => 30,
				'active_callback' => array(
					array(
						'setting'  => 'single_portfolio_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'single_portfolio_page_header_parallax' => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Parallax', 'induscity' ),
				'default'         => 1,
				'section'         => 'single_portfolio_page_header',
				'priority'        => 30,
				'description'     => esc_html__( 'Check this option to enable parallax for the page header.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'single_portfolio_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			// Single Portfolio
			'single_portfolio_social'               => array(
				'type'     => 'repeater',
				'label'    => esc_html__( 'Socials', 'induscity' ),
				'section'  => 'single_portfolio',
				'priority' => 60,
				'default'  => array(
					array(
						'link_url' => 'https://facebook.com/',
					),
					array(
						'link_url' => 'https://twitter.com/',
					),
					array(
						'link_url' => 'https://dribbble.com/',
					),
					array(
						'link_url' => 'https://www.skype.com/en/',
					),
					array(
						'link_url' => 'https://plus.google.com/',
					),
				),
				'fields'   => array(
					'link_url' => array(
						'type'        => 'text',
						'label'       => esc_html__( 'Social URL', 'induscity' ),
						'description' => esc_html__( 'Enter the URL for this social', 'induscity' ),
						'default'     => '',
					),
				),
			),

			// Service Page Header
			'service_page_header'                   => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Page Header', 'induscity' ),
				'default'     => 1,
				'section'     => 'service_page_header',
				'priority'    => 10,
				'description' => esc_html__( 'Check this option to show the page header below the header.', 'induscity' ),
			),
			'service_page_header_els'               => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Page Header Elements', 'induscity' ),
				'section'         => 'service_page_header',
				'default'         => array( 'breadcrumb', 'title' ),
				'priority'        => 20,
				'choices'         => array(
					'breadcrumb' => esc_html__( 'BreadCrumb', 'induscity' ),
					'title'      => esc_html__( 'Title', 'induscity' ),
				),
				'description'     => esc_html__( 'Select which elements you want to show.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'service_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'service_page_header_bg'                => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Bacground Image', 'induscity' ),
				'section'         => 'service_page_header',
				'default'         => '',
				'priority'        => 30,
				'active_callback' => array(
					array(
						'setting'  => 'service_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'service_page_header_parallax'          => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Parallax', 'induscity' ),
				'default'         => 1,
				'section'         => 'service_page_header',
				'priority'        => 30,
				'description'     => esc_html__( 'Check this option to enable parallax for the page header.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'service_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			// Service
			'service_layout'                        => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Service Layout', 'induscity' ),
				'section'     => 'service_page',
				'default'     => 'full-content',
				'priority'    => 5,
				'description' => esc_html__( 'Select default sidebar for the single post page.', 'induscity' ),
				'choices'     => array(
					'full-content'    => esc_html__( 'Full Content', 'induscity' ),
					'sidebar-content' => esc_html__( 'Left Sidebar', 'induscity' ),
					'content-sidebar' => esc_html__( 'Right Sidebar', 'induscity' ),
				),
			),
			'service_columns'                       => array(
				'type'     => 'radio',
				'label'    => esc_html__( 'Columns', 'induscity' ),
				'section'  => 'service_page',
				'default'  => '3',
				'priority' => 10,
				'choices'  => array(
					'2' => esc_html__( '2 Columns', 'induscity' ),
					'3' => esc_html__( '3 Columns', 'induscity' ),
				),
			),
			'service_custom_field_1'                => array(
				'type'    => 'custom',
				'section' => 'service_page',
				'default' => '<hr/>',
			),
			'service_banner'                        => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Service Banner', 'induscity' ),
				'default'     => 1,
				'section'     => 'service_page',
				'priority'    => 10,
				'description' => esc_html__( 'Check this option to show the service banner at bottom of service page.', 'induscity' ),
			),
			'service_banner_image'                  => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Banner Image', 'induscity' ),
				'section'         => 'service_page',
				'default'         => '',
				'priority'        => 10,
				'active_callback' => array(
					array(
						'setting'  => 'service_banner',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'service_banner_content'                => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Banner Content', 'induscity' ),
				'section'         => 'service_page',
				'default'         => esc_html__( 'Innovative Products and Service for Construction Projects and Automative Service.', 'induscity' ),
				'priority'        => 10,
				'active_callback' => array(
					array(
						'setting'  => 'service_banner',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'service_banner_btn_url'                => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Banner Button Link', 'induscity' ),
				'section'         => 'service_page',
				'description'     => esc_html__( 'Enter button link', 'induscity' ),
				'priority'        => 10,
				'active_callback' => array(
					array(
						'setting'  => 'service_banner',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'service_banner_btn'                    => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Banner Button Text', 'induscity' ),
				'section'         => 'service_page',
				'default'         => esc_html__( 'Get a Quote', 'induscity' ),
				'priority'        => 10,
				'description'     => esc_html__( 'Enter button text', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'service_banner',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			// Single Service Page Header
			'single_service_page_header'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Page Header', 'induscity' ),
				'default'     => 1,
				'section'     => 'single_service_page_header',
				'priority'    => 10,
				'description' => esc_html__( 'Check this option to show the page header below the header.', 'induscity' ),
			),
			'single_service_page_header_els'        => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Page Header Elements', 'induscity' ),
				'section'         => 'single_service_page_header',
				'default'         => array( 'breadcrumb', 'title' ),
				'priority'        => 20,
				'choices'         => array(
					'breadcrumb' => esc_html__( 'BreadCrumb', 'induscity' ),
					'title'      => esc_html__( 'Title', 'induscity' ),
				),
				'description'     => esc_html__( 'Select which elements you want to show.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'single_service_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'single_service_page_header_bg'         => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Bacground Image', 'induscity' ),
				'section'         => 'single_service_page_header',
				'default'         => '',
				'priority'        => 30,
				'active_callback' => array(
					array(
						'setting'  => 'single_service_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'single_service_page_header_parallax'   => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Parallax', 'induscity' ),
				'default'         => 1,
				'section'         => 'single_service_page_header',
				'priority'        => 30,
				'description'     => esc_html__( 'Check this option to enable parallax for the page header.', 'induscity' ),
				'active_callback' => array(
					array(
						'setting'  => 'single_service_page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			// Single Service
			'single_service_layout'                 => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Single Service Layout', 'induscity' ),
				'section'     => 'single_service',
				'default'     => 'content-sidebar',
				'priority'    => 5,
				'description' => esc_html__( 'Select default sidebar for the single service page.', 'induscity' ),
				'choices'     => array(
					'content-sidebar' => esc_html__( 'Right Sidebar', 'induscity' ),
					'sidebar-content' => esc_html__( 'Left Sidebar', 'induscity' ),
					'full-content'    => esc_html__( 'Full Content', 'induscity' ),
				),
			),

			// Footer
			'back_to_top'                           => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Back to Top', 'induscity' ),
				'section'  => 'footer',
				'default'  => 1,
				'priority' => 10,
			),
			'footer_widget'                         => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Foot Widgets', 'induscity' ),
				'sections' => 'footer',
				'default'  => 1,
				'priority' => 10,
			),
			'footer_custom_2'                       => array(
				'type'     => 'custom',
				'section'  => 'footer',
				'default'  => '<hr/>',
				'priority' => 20,
			),
			'footer_widget_columns'                 => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Footer Columns', 'induscity' ),
				'section'     => 'footer',
				'default'     => '3',
				'priority'    => 20,
				'choices'     => array(
					'3' => esc_html__( '3 Columns', 'induscity' ),
					'4' => esc_html__( '4 Columns', 'induscity' ),
					'5' => esc_html__( '2 Columns', 'induscity' ),
				),
				'description' => esc_html__( 'Go to Appearance > Widgets > Footer 1, 2, 3, 4 to add widgets content.', 'induscity' ),
			),
			'footer_custom_3'                       => array(
				'type'     => 'custom',
				'section'  => 'footer',
				'default'  => '<hr/>',
				'priority' => 20,
			),
			'footer_show_socials'                   => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Show Socials on Footer', 'induscity' ),
				'section'  => 'footer',
				'default'  => 1,
				'priority' => 20,
			),
			'footer_socials'                        => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Socials', 'induscity' ),
				'section'         => 'footer',
				'priority'        => 20,
				'default'         => array(
					array(
						'link_url' => '',
					),
					array(
						'link_url' => '',
					),
					array(
						'link_url' => '',
					),
					array(
						'link_url' => '',
					),
				),
				'fields'          => array(
					'link_url' => array(
						'type'        => 'text',
						'label'       => esc_html__( 'Social URL', 'induscity' ),
						'description' => esc_html__( 'Enter the URL for this social', 'induscity' ),
						'default'     => '',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'footer_show_socials',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'footer_custom_1'                       => array(
				'type'     => 'custom',
				'section'  => 'footer',
				'default'  => '<hr/>',
				'priority' => 20,
			),
			'footer_copyright'                      => array(
				'type'        => 'textarea',
				'label'       => esc_html__( 'Footer Copyright', 'induscity' ),
				'description' => esc_html__( 'Shortcodes are allowed', 'induscity' ),
				'section'     => 'footer',
				'default'     => esc_html__( 'Copyright &copy; 2018', 'induscity' ),
				'priority'    => 20,
			),
		),
	)
);
