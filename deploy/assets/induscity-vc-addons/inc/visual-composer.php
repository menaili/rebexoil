<?php
/**
 * Custom functions for Visual Composer
 *
 * @package    Induscity
 * @subpackage Visual Composer
 */

if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

/**
 * Class Induscity
 *
 * @since 1.0.0
 */
class Induscity_VC {

	/**
	 * Construction
	 */
	function __construct() {
		// Stop if VC is not installed
		if ( ! is_plugin_active( 'js_composer/js_composer.php' ) ) {
			return false;
		}

		add_filter( 'vc_iconpicker-type-flaticon', array( $this, 'vc_iconpicker_type_flaticon' ) );

		add_action( 'vc_base_register_front_css', array( $this, 'vc_iconpicker_base_register_css' ) );
		add_action( 'vc_base_register_admin_css', array( $this, 'vc_iconpicker_base_register_css' ) );

		add_action( 'vc_enqueue_font_icon_element', array( $this, 'vc_icon_element_fonts_enqueue' ) );

		add_action( 'init', array( $this, 'map_shortcodes' ), 20 );
	}


	/**
	 * Add new params or add new shortcode to VC
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	function map_shortcodes() {

		vc_remove_param( 'vc_row', 'parallax_image' );
		vc_remove_param( 'vc_row', 'parallax' );
		vc_remove_param( 'vc_row', 'parallax_speed_bg' );

		$attributes = array(
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Enable Parallax effect', 'induscity' ),
				'param_name'  => 'enable_parallax',
				'group'       => esc_html__( 'Design Options', 'induscity' ),
				'value'       => array( esc_html__( 'Enable', 'induscity' ) => 'yes' ),
				'description' => esc_html__( 'Enable this option if you want to have parallax effect on this row. When you enable this option, please set background repeat option as "Theme defaults" to make it works.', 'induscity' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Overlay', 'induscity' ),
				'param_name'  => 'overlay',
				'group'       => esc_html__( 'Design Options', 'induscity' ),
				'value'       => '',
				'description' => esc_html__( 'Select an overlay color for this row', 'induscity' ),
			),
		);

		vc_add_params( 'vc_row', $attributes );

		// Induscity Section Title
		vc_map(
			array(
				'name'     => esc_html__( 'Section Title', 'induscity' ),
				'base'     => 'manufactory_section_title',
				'class'    => '',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'induscity' ),
						'param_name' => 'title',
						'value'      => esc_html__( 'Enter Title in there', 'induscity' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Sub Title', 'induscity' ),
						'param_name'  => 'sub_title',
						'value'       => '',
						'description' => esc_html__( 'Enter Sub Title', 'induscity' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Position', 'induscity' ),
						'param_name' => 'position',
						'value'      => array(
							esc_html__( 'Left', 'induscity' )   => 'left',
							esc_html__( 'Center', 'induscity' ) => 'center',
						),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Font Size', 'induscity' ),
						'param_name' => 'font_size',
						'value'      => array(
							esc_html__( 'Large (36px)', 'induscity' )  => 'large',
							esc_html__( 'Medium (26px)', 'induscity' ) => 'medium',
						),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Font Weight', 'induscity' ),
						'param_name' => 'font_weight',
						'value'      => '',
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Title Color', 'induscity' ),
						'param_name' => 'color',
						'value'      => array(
							esc_html__( 'Dark', 'induscity' )  => 'dark',
							esc_html__( 'Light', 'induscity' ) => 'light',
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'induscity' ),
					),
				),
			)
		);

		// Button
		vc_map(
			array(
				'name'     => esc_html__( 'Induscity Buttons', 'induscity' ),
				'base'     => 'manufactory_button',
				'class'    => '',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'heading'     => esc_html__( 'Alignment', 'induscity' ),
						'description' => esc_html__( 'Select button alignment', 'induscity' ),
						'param_name'  => 'align',
						'type'        => 'dropdown',
						'value'       => array(
							esc_html__( 'Left', 'induscity' )   => 'left',
							esc_html__( 'Center', 'induscity' ) => 'center',
							esc_html__( 'Right', 'induscity' )  => 'right',
						),
					),
					array(
						'heading'     => esc_html__( 'Style', 'induscity' ),
						'description' => esc_html__( 'Select button style', 'induscity' ),
						'param_name'  => 'style',
						'type'        => 'dropdown',
						'value'       => array(
							esc_html__( 'Style 1', 'induscity' ) => '1',
							esc_html__( 'Style 2', 'induscity' ) => '2',
						),
					),
					array(
						'heading'    => esc_html__( 'URL (Link)', 'induscity' ),
						'type'       => 'vc_link',
						'param_name' => 'link',
					),
					array(
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'induscity' ),
						'param_name'  => 'el_class',
						'type'        => 'textfield',
						'value'       => '',
					),
				),
			)
		);

		// Empty Space
		vc_map(
			array(
				'name'     => esc_html__( 'Induscity Empty Space', 'induscity' ),
				'base'     => 'manufactory_empty_space',
				'class'    => '',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Height(px)', 'induscity' ),
						'param_name'  => 'height',
						'admin_label' => true,
						'description' => esc_html__( 'Enter empty space height on Desktop.', 'induscity' )
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Height on Tablet(px)', 'induscity' ),
						'param_name'  => 'height_tablet',
						'admin_label' => true,
						'description' => esc_html__( 'Enter empty space height on Mobile. Leave empty to use the height of the desktop', 'induscity' )
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Height on Mobile(px)', 'induscity' ),
						'param_name'  => 'height_mobile',
						'admin_label' => true,
						'description' => esc_html__( 'Enter empty space height on Mobile. Leave empty to use the height of the tablet', 'induscity' )
					),
					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__( 'Background Color', 'induscity' ),
						'param_name' => 'bg_color',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'induscity' ),
					),
				),
			)
		);

		// Icon Box
		vc_map(
			array(
				'name'     => esc_html__( 'Icon Box', 'induscity' ),
				'base'     => 'manufactory_icon_box',
				'class'    => '',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'heading'     => esc_html__( 'Icon library', 'induscity' ),
						'description' => esc_html__( 'Select icon library.', 'induscity' ),
						'param_name'  => 'icon_type',
						'type'        => 'dropdown',
						'value'       => array(
							esc_html__( 'Font Awesome', 'induscity' ) => 'fontawesome',
							esc_html__( 'Flaticon', 'induscity' )     => 'flaticon',
							esc_html__( 'Custom Image', 'induscity' ) => 'image',
							esc_html__( 'Number', 'induscity' )       => 'number',
						),
						'group'       => esc_html__( 'Icons', 'induscity' ),
					),
					array(
						'heading'     => esc_html__( 'Icon', 'induscity' ),
						'description' => esc_html__( 'Pick an icon from library.', 'induscity' ),
						'type'        => 'iconpicker',
						'param_name'  => 'icon_fontawesome',
						'value'       => 'fa fa-adjust',
						'settings'    => array(
							'emptyIcon'    => false,
							'iconsPerPage' => 4000,
						),
						'dependency'  => array(
							'element' => 'icon_type',
							'value'   => 'fontawesome',
						),
						'group'       => esc_html__( 'Icons', 'induscity' ),
					),
					array(
						'heading'    => esc_html__( 'Icon', 'induscity' ),
						'type'       => 'iconpicker',
						'param_name' => 'icon_flaticon',
						'settings'   => array(
							'emptyIcon'    => true,
							'type'         => 'flaticon',
							'iconsPerPage' => 4000,
						),
						'dependency' => array(
							'element' => 'icon_type',
							'value'   => 'flaticon',
						),
						'group'      => esc_html__( 'Icons', 'induscity' ),
					),
					array(
						'heading'     => esc_html__( 'Icon Image', 'induscity' ),
						'description' => esc_html__( 'Upload icon image', 'induscity' ),
						'type'        => 'attach_image',
						'param_name'  => 'image',
						'value'       => '',
						'dependency'  => array(
							'element' => 'icon_type',
							'value'   => 'image',
						),
						'group'       => esc_html__( 'Icons', 'induscity' ),
					),
					array(
						'heading'     => esc_html__( 'Number', 'induscity' ),
						'description' => esc_html__( 'Process number', 'induscity' ),
						'type'        => 'textfield',
						'param_name'  => 'number',
						'value'       => '',
						'dependency'  => array(
							'element' => 'icon_type',
							'value'   => 'number',
						),
						'group'       => esc_html__( 'Icons', 'induscity' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Icon Style', 'induscity' ),
						'param_name' => 'icon_style',
						'value'      => array(
							esc_html__( 'Normal', 'induscity' )               => 'normal',
							esc_html__( 'Has Background Color', 'induscity' ) => 'has-background-color',
						),
						'dependency' => array(
							'element' => 'icon_type',
							'value'   => array( 'fontawesome', 'flaticon', 'number' ),
						),
						'group'      => esc_html__( 'Icons', 'induscity' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Icon Position', 'induscity' ),
						'param_name' => 'position',
						'value'      => array(
							esc_html__( 'Left', 'induscity' )       => 'left',
							esc_html__( 'Top Left', 'induscity' )   => 'top-left',
							esc_html__( 'Top Center', 'induscity' ) => 'top-center',
						),
						'group'      => esc_html__( 'Icons', 'induscity' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Icon size', 'induscity' ),
						'param_name' => 'icon_size',
						'value'      => array(
							esc_html__( 'Large', 'induscity' ) => 'large',
							esc_html__( 'Small', 'induscity' ) => 'small',
						),
						'dependency' => array(
							'element' => 'icon_style',
							'value'   => 'normal',
						),
						'group'      => esc_html__( 'Icons', 'induscity' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Box Color', 'induscity' ),
						'param_name' => 'box_color',
						'value'      => array(
							esc_html__( 'Dark', 'induscity' )  => 'dark',
							esc_html__( 'Light', 'induscity' ) => 'light',
						),
						'group'      => esc_html__( 'Box', 'induscity' ),
					),
					array(
						'heading'    => esc_html__( 'Link', 'induscity' ),
						'param_name' => 'link',
						'type'       => 'vc_link',
						'value'      => '',
						'group'      => esc_html__( 'Box', 'induscity' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'induscity' ),
						'param_name' => 'title',
						'value'      => esc_html__( 'I am Icon Box', 'induscity' ),
						'group'      => esc_html__( 'Box', 'induscity' ),
					),
					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Content', 'induscity' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter the content of this box', 'induscity' ),
						'group'       => esc_html__( 'Box', 'induscity' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'induscity' ),
						'group'       => esc_html__( 'Box', 'induscity' ),
					),
				),
			)
		);

		// Latest Post
		vc_map(
			array(
				'name'     => esc_html__( 'Latest Post', 'induscity' ),
				'base'     => 'manufactory_latest_post',
				'class'    => '',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Section title', 'induscity' ),
						'param_name'  => 'section_title',
						'value'       => esc_html__( 'Latest From Blog', 'induscity' ),
						'description' => esc_html__( 'Enter title for this section', 'induscity' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Number of Posts', 'induscity' ),
						'param_name'  => 'number',
						'value'       => 'All',
						'description' => esc_html__( 'Set numbers of Posts you want to display. Set -1 to display all posts', 'induscity' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Thumbnail', 'induscity' ),
						'param_name'  => 'thumbnail',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Enable Show Thumbnail', 'induscity' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Excerpt Length', 'induscity' ),
						'param_name' => 'excerpt_length',
						'value'      => '20',
						'dependency' => array(
							'element' => 'excerpt',
							'value'   => array( 'yes' ),
						),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Type', 'induscity' ),
						'param_name' => 'type',
						'value'      => array(
							esc_html__( 'Grid', 'induscity' )     => 'grid',
							esc_html__( 'Carousel', 'induscity' ) => 'carousel',
						),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Button Text', 'induscity' ),
						'param_name' => 'btn_text',
						'value'      => esc_html__( 'View More', 'induscity' ),
						'dependency' => array(
							'element' => 'type',
							'value'   => array( 'grid' ),
						),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Autoplay', 'induscity' ),
						'param_name'  => 'autoplay',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Enable autoplay', 'induscity' ),
						'dependency'  => array(
							'element' => 'type',
							'value'   => array( 'carousel' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Autoplay timeout', 'induscity' ),
						'param_name'  => 'autoplay_timeout',
						'value'       => '2000',
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'induscity' ),
						'dependency'  => array(
							'element' => 'autoplay',
							'value'   => array( 'yes' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Autoplay speed', 'induscity' ),
						'param_name'  => 'autoplay_speed',
						'value'       => '800',
						'description' => esc_html__( 'Set auto play speed (in ms).', 'induscity' ),
						'dependency'  => array(
							'element' => 'autoplay',
							'value'   => array( 'yes' ),
						),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Navigation', 'induscity' ),
						'param_name'  => 'nav',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Enable navigation', 'induscity' ),
						'dependency'  => array(
							'element' => 'type',
							'value'   => array( 'carousel' ),
						),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Dots', 'induscity' ),
						'param_name'  => 'dot',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Enable dots', 'induscity' ),
						'dependency'  => array(
							'element' => 'type',
							'value'   => array( 'carousel' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'induscity' ),
					),
				),
			)
		);

		// Services
		vc_map(
			array(
				'name'     => esc_html__( 'Services', 'induscity' ),
				'base'     => 'manufactory_services',
				'class'    => '',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Number of Services', 'induscity' ),
						'param_name'  => 'number',
						'value'       => 'All',
						'description' => esc_html__( 'Set numbers of Services you want to display. Set -1 to display all services', 'induscity' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Order By', 'induscity' ),
						'param_name'  => 'orderby',
						'value'       => array(
							''                                   => '',
							esc_html__( 'Date', 'induscity' )       => 'date',
							esc_html__( 'Title', 'induscity' )      => 'title',
							esc_html__( 'Random', 'induscity' )     => 'rand',
						),
						'description' => esc_html__( 'Select to order Services. Leave empty to use the default order by of theme.', 'induscity' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Order', 'induscity' ),
						'param_name'  => 'order',
						'value'       => array(
							''                                    => '',
							esc_html__( 'Ascending ', 'induscity' )  => 'asc',
							esc_html__( 'Descending ', 'induscity' ) => 'desc',
						),
						'description' => esc_html__( 'Select to sort Services. Leave empty to use the default sort of theme', 'induscity' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Services Description', 'induscity' ),
						'param_name'  => 'desc',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" show Description. Edit Description in Description Tab', 'induscity' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'induscity' ),
						'param_name' => 'title',
						'value'      => '',
						'group'      => esc_html__( 'Description', 'induscity' ),
					),
					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Content', 'induscity' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter the content of this box', 'induscity' ),
						'group'       => esc_html__( 'Description', 'induscity' ),
					),
					array(
						'heading'    => esc_html__( 'Button', 'induscity' ),
						'type'       => 'vc_link',
						'param_name' => 'link',
						'group'      => esc_html__( 'Description', 'induscity' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'induscity' ),
					),
				),
			)
		);

		// Services 2
		vc_map(
			array(
				'name'     => esc_html__( 'Services 2', 'induscity' ),
				'base'     => 'manufactory_services_2',
				'class'    => '',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'induscity' ),
						'param_name' => 'title',
						'value'      => '',
						'group'      => esc_html__( 'Service', 'induscity' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Sub Title', 'induscity' ),
						'param_name' => 'sub_title',
						'value'      => '',
						'dependency' => array(
							'element' => 'style',
							'value'   => array( '2' ),
						),
						'group'      => esc_html__( 'Service', 'induscity' ),
					),
					array(
						'heading'     => esc_html__( 'Icon library', 'induscity' ),
						'description' => esc_html__( 'Select icon library.', 'induscity' ),
						'param_name'  => 'icon_type',
						'type'        => 'dropdown',
						'value'       => array(
							esc_html__( 'Font Awesome', 'induscity' ) => 'fontawesome',
							esc_html__( 'Flaticon', 'induscity' )     => 'flaticon',
							esc_html__( 'Custom Image', 'induscity' ) => 'image',
						),
						'group'       => esc_html__( 'Service Icons', 'induscity' ),
					),
					array(
						'heading'     => esc_html__( 'Icon', 'induscity' ),
						'description' => esc_html__( 'Pick an icon from library.', 'induscity' ),
						'type'        => 'iconpicker',
						'param_name'  => 'icon_fontawesome',
						'value'       => 'fa fa-adjust',
						'settings'    => array(
							'emptyIcon'    => false,
							'iconsPerPage' => 4000,
						),
						'dependency'  => array(
							'element' => 'icon_type',
							'value'   => 'fontawesome',
						),
						'group'       => esc_html__( 'Service Icons', 'induscity' ),
					),
					array(
						'heading'    => esc_html__( 'Icon', 'induscity' ),
						'type'       => 'iconpicker',
						'param_name' => 'icon_flaticon',
						'settings'   => array(
							'emptyIcon'    => true,
							'type'         => 'flaticon',
							'iconsPerPage' => 4000,
						),
						'dependency' => array(
							'element' => 'icon_type',
							'value'   => 'flaticon',
						),
						'group'      => esc_html__( 'Service Icons', 'induscity' ),
					),
					array(
						'heading'     => esc_html__( 'Icon Image', 'induscity' ),
						'description' => esc_html__( 'Upload icon image', 'induscity' ),
						'type'        => 'attach_image',
						'param_name'  => 'image',
						'value'       => '',
						'dependency'  => array(
							'element' => 'icon_type',
							'value'   => 'image',
						),
						'group'       => esc_html__( 'Service Icons', 'induscity' ),
					),
					array(
						'heading'    => esc_html__( 'Style', 'induscity' ),
						'param_name' => 'style',
						'type'       => 'dropdown',
						'value'      => array(
							esc_html__( 'Style 1', 'induscity' ) => '1',
							esc_html__( 'Style 2', 'induscity' ) => '2',
							esc_html__( 'Style 3', 'induscity' ) => '3',
							esc_html__( 'Style 4', 'induscity' ) => '4',
						),
						'group'      => esc_html__( 'Service', 'induscity' ),
					),
					array(
						'heading'     => esc_html__( 'Image', 'induscity' ),
						'description' => esc_html__( 'Upload service image', 'induscity' ),
						'type'        => 'attach_image',
						'param_name'  => 'service_image',
						'value'       => '',
						'group'       => esc_html__( 'Service', 'induscity' ),
					),
					array(
						'heading'     => esc_html__( 'Image size', 'induscity' ),
						'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'induscity' ),
						'type'        => 'textfield',
						'param_name'  => 'image_size',
						'value'       => '',
						'group'       => esc_html__( 'Service', 'induscity' ),
					),
					array(
						'heading'    => esc_html__( 'Link', 'induscity' ),
						'param_name' => 'link',
						'type'       => 'vc_link',
						'value'      => '',
						'group'      => esc_html__( 'Service', 'induscity' ),
					),
					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Content', 'induscity' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter the content of this box', 'induscity' ),
						'group'       => esc_html__( 'Service', 'induscity' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'induscity' ),
						'group'       => esc_html__( 'Service', 'induscity' ),
					),
				),
			)
		);

		// Services 3
		vc_map(
			array(
				'name'     => esc_html__( 'Services 3', 'induscity' ),
				'base'     => 'manufactory_services_3',
				'class'    => '',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'induscity' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'induscity' ) => '1',
							esc_html__( 'Style 2', 'induscity' ) => '2',
						),
					),
					array(
						'type'       => 'param_group',
						'heading'    => esc_html__( 'Services Setting', 'induscity' ),
						'value'      => '',
						'param_name' => 'setting',
						'params'     => array(
							array(
								'type'        => 'checkbox',
								'heading'     => esc_html__( 'Featured Box', 'induscity' ),
								'param_name'  => 'featured_box',
								'value'       => array( esc_html__( 'Yes', 'induscity' ) => '1' ),
								'description' => esc_html__( 'Work on Style 1', 'induscity' ),
							),
							array(
								'heading'     => esc_html__( 'Icon library', 'induscity' ),
								'description' => esc_html__( 'Select icon library.', 'induscity' ),
								'param_name'  => 'icon_type',
								'type'        => 'dropdown',
								'value'       => array(
									esc_html__( 'Font Awesome', 'induscity' ) => 'fontawesome',
									esc_html__( 'Flaticon', 'induscity' )     => 'flaticon',
									esc_html__( 'Custom Image', 'induscity' ) => 'image',
								),
							),
							array(
								'heading'     => esc_html__( 'Icon', 'induscity' ),
								'description' => esc_html__( 'Pick an icon from library.', 'induscity' ),
								'type'        => 'iconpicker',
								'param_name'  => 'icon_fontawesome',
								'value'       => 'fa fa-adjust',
								'settings'    => array(
									'emptyIcon'    => false,
									'iconsPerPage' => 4000,
								),
								'dependency'  => array(
									'element' => 'icon_type',
									'value'   => 'fontawesome',
								),
							),
							array(
								'heading'    => esc_html__( 'Icon', 'induscity' ),
								'type'       => 'iconpicker',
								'param_name' => 'icon_flaticon',
								'settings'   => array(
									'emptyIcon'    => true,
									'type'         => 'flaticon',
									'iconsPerPage' => 4000,
								),
								'dependency' => array(
									'element' => 'icon_type',
									'value'   => 'flaticon',
								),
							),
							array(
								'heading'     => esc_html__( 'Icon Image', 'induscity' ),
								'description' => esc_html__( 'Upload icon image', 'induscity' ),
								'type'        => 'attach_image',
								'param_name'  => 'image',
								'value'       => '',
								'dependency'  => array(
									'element' => 'icon_type',
									'value'   => 'image',
								),
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Title', 'induscity' ),
								'param_name' => 'title',
								'value'      => '',
								'admin_label' => true,
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Sub Title', 'induscity' ),
								'param_name' => 'sub_title',
								'value'      => '',
							),
							array(
								'heading'    => esc_html__( 'Link', 'induscity' ),
								'param_name' => 'link',
								'type'       => 'vc_link',
								'value'      => '',
							),
							array(
								'type'        => 'textarea',
								'heading'     => esc_html__( 'Content', 'induscity' ),
								'param_name'  => 'desc',
								'value'       => '',
								'description' => esc_html__( 'Enter the content of this box', 'induscity' ),
							),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'induscity' ),
					),
				),
			)
		);

		// Portfolio Carousel
		vc_map(
			array(
				'name'     => esc_html__( 'Portfolio', 'induscity' ),
				'base'     => 'manufactory_portfolio',
				'class'    => '',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Type', 'induscity' ),
						'param_name' => 'type',
						'value'      => array(
							esc_html__( 'Carousel', 'induscity' ) => 'carousel',
							esc_html__( 'Isotope', 'induscity' )  => 'isotope',
						),
						'group' => esc_html__( 'Portfolio', 'induscity' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'induscity' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'induscity' ) => '1',
							esc_html__( 'Style 2', 'induscity' ) => '2',
							esc_html__( 'Style 3', 'induscity' ) => '3',
						),
						'dependency' => array(
							'element' => 'type',
							'value'   => 'carousel',
						),
						'group' => esc_html__( 'Portfolio', 'induscity' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Nav Filter', 'induscity' ),
						'param_name'  => 'filter',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => '1' ),
						'description' => esc_html__( 'If "YES" Enable Nav Filter', 'induscity' ),
						'group' => esc_html__( 'Portfolio', 'induscity' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Nav Filter Color', 'induscity' ),
						'param_name'  => 'nav_color',
						'value'       => array(
							esc_html__( 'Light', 'induscity' ) => 'light',
							esc_html__( 'Dark', 'induscity' )  => 'dark',
						),
						'dependency'  => array(
							'element' => 'filter',
							'value'   => '1',
						),
						'group' => esc_html__( 'Portfolio', 'induscity' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Version', 'induscity' ),
						'param_name'  => 'version',
						'value'       => array(
							esc_html__( 'Dark', 'induscity' )  => 'dark',
							esc_html__( 'Light', 'induscity' ) => 'light',
						),
						'description' => esc_html__( 'Work on Style 1 and 2', 'induscity' ),
						'dependency'  => array(
							'element' => 'type',
							'value'   => 'carousel',
						),
						'group' => esc_html__( 'Portfolio', 'induscity' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Number of Portfolio', 'induscity' ),
						'param_name'  => 'number',
						'value'       => 'All',
						'description' => esc_html__( 'Set numbers of Portfolio you want to display. Set -1 to display all portfolio', 'induscity' ),
						'group' => esc_html__( 'Portfolio', 'induscity' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Autoplay', 'induscity' ),
						'param_name'  => 'autoplay',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Enable autoplay', 'induscity' ),
						'dependency'  => array(
							'element' => 'type',
							'value'   => 'carousel',
						),
						'group' => esc_html__( 'Portfolio', 'induscity' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Autoplay speed', 'induscity' ),
						'param_name'  => 'autoplay_speed',
						'value'       => '800',
						'description' => esc_html__( 'Set auto play speed (in ms).', 'induscity' ),
						'dependency'  => array(
							'element' => 'autoplay',
							'value'   => array( 'yes' ),
						),
						'group' => esc_html__( 'Portfolio', 'induscity' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Navigation', 'induscity' ),
						'param_name'  => 'nav',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Enable navigation', 'induscity' ),
						'dependency'  => array(
							'element' => 'type',
							'value'   => 'carousel',
						),
						'group' => esc_html__( 'Portfolio', 'induscity' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Dots', 'induscity' ),
						'param_name'  => 'dot',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Enable dots', 'induscity' ),
						'dependency'  => array(
							'element' => 'type',
							'value'   => 'carousel',
						),
						'group' => esc_html__( 'Portfolio', 'induscity' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'induscity' ),
						'group' => esc_html__( 'Portfolio', 'induscity' ),
					),

					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Portfolio Title', 'induscity' ),
						'param_name' => 'section_title',
						'group' => esc_html__( 'Section Title', 'induscity' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Position', 'induscity' ),
						'param_name' => 'position',
						'value'      => array(
							esc_html__( 'Left', 'induscity' )   => 'left',
							esc_html__( 'Center', 'induscity' ) => 'center',
						),
						'group' => esc_html__( 'Section Title', 'induscity' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Title Color', 'induscity' ),
						'param_name' => 'color',
						'value'      => array(
							esc_html__( 'Dark', 'induscity' )  => 'dark',
							esc_html__( 'Light', 'induscity' ) => 'light',
						),
						'group' => esc_html__( 'Section Title', 'induscity' ),
					),
				),
			)
		);

		// Testimonial
		vc_map(
			array(
				'name'     => esc_html__( 'Testimonials', 'induscity' ),
				'base'     => 'manufactory_testimonial',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'induscity' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'induscity' ) => '1',
							esc_html__( 'Style 2', 'induscity' ) => '2',
							esc_html__( 'Style 3', 'induscity' ) => '3',
							esc_html__( 'Style 4', 'induscity' ) => '4',
							esc_html__( 'Style 5', 'induscity' ) => '5',
						),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Version', 'induscity' ),
						'param_name' => 'version',
						'value'      => array(
							esc_html__( 'Dark', 'induscity' )  => 'dark',
							esc_html__( 'Light', 'induscity' ) => 'light',
						),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Type', 'induscity' ),
						'param_name' => 'type',
						'value'      => array(
							esc_html__( 'Carousel', 'induscity' ) => 'carousel',
							esc_html__( 'Grid', 'induscity' )     => 'grid',
						),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Columns', 'induscity' ),
						'param_name' => 'columns',
						'value'      => array(
							esc_html__( '1 Columns', 'induscity' ) => '1',
							esc_html__( '2 Columns', 'induscity' ) => '2',
							esc_html__( '3 Columns', 'induscity' ) => '3',
						),
						'dependency' => array(
							'element' => 'type',
							'value'   => 'carousel',
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Image size', 'induscity' ),
						'param_name'  => 'image_size',
						'description' => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'induscity' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Autoplay', 'induscity' ),
						'param_name'  => 'autoplay',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Enable autoplay', 'induscity' ),
						'dependency'  => array(
							'element' => 'type',
							'value'   => 'carousel',
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Autoplay timeout', 'induscity' ),
						'param_name'  => 'autoplay_timeout',
						'value'       => '2000',
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'induscity' ),
						'dependency'  => array(
							'element' => 'autoplay',
							'value'   => array( 'yes' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Autoplay speed', 'induscity' ),
						'param_name'  => 'autoplay_speed',
						'value'       => '800',
						'description' => esc_html__( 'Set auto play speed (in ms).', 'induscity' ),
						'dependency'  => array(
							'element' => 'autoplay',
							'value'   => array( 'yes' ),
						),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Navigation', 'induscity' ),
						'param_name'  => 'nav',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Enable navigation', 'induscity' ),
						'dependency'  => array(
							'element' => 'type',
							'value'   => 'carousel',
						),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Dots', 'induscity' ),
						'param_name'  => 'dot',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Enable dots', 'induscity' ),
						'dependency'  => array(
							'element' => 'type',
							'value'   => 'carousel',
						),
					),
					array(
						'type'       => 'param_group',
						'heading'    => esc_html__( 'Testimonial Setting', 'induscity' ),
						'value'      => '',
						'param_name' => 'setting',
						'params'     => array(
							array(
								'heading'    => esc_html__( 'Image', 'induscity' ),
								'param_name' => 'image',
								'type'       => 'attach_image',
								'value'      => '',
							),
							array(
								'heading'     => esc_html__( 'Rating Point', 'induscity' ),
								'param_name'  => 'point',
								'type'        => 'textfield',
								'value'       => '',
								'description' => esc_html__( 'Range 0 to 5', 'induscity' ),
							),
							array(
								'heading'     => esc_html__( 'Name', 'induscity' ),
								'param_name'  => 'name',
								'type'        => 'textfield',
								'value'       => '',
								'admin_label' => true,
							),
							array(
								'heading'    => esc_html__( 'Address', 'induscity' ),
								'param_name' => 'address',
								'type'       => 'textfield',
								'value'      => '',
							),
							array(
								'type'       => 'textarea',
								'heading'    => esc_html__( 'Description', 'induscity' ),
								'param_name' => 'desc',
								'value'      => '',
							),
						),
					),
					array(
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'type'        => 'textfield',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'induscity' ),
					),
				),
			)
		);

		// Pricing Table shortcode
		vc_map(
			array(
				'name'     => __( 'Pricing Table', 'induscity' ),
				'base'     => 'manufactory_pricing',
				'class'    => '',
				'category' => __( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'induscity' ),
						'param_name' => 'title',
						'value'      => '',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Price', 'induscity' ),
						'param_name' => 'price',
						'value'      => '',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Unit', 'induscity' ),
						'param_name' => 'unit',
						'value'      => '',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Time Duration', 'induscity' ),
						'param_name' => 'time_duration',
						'value'      => '',
					),
					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Content', 'induscity' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter the content of this table', 'induscity' ),
					),
					array(
						'heading'     => esc_html__( 'Features', 'induscity' ),
						'description' => esc_html__( 'Feature list of this plan. Click to arrow button to edit.', 'induscity' ),
						'param_name'  => 'features',
						'type'        => 'param_group',
						'params'      => array(
							array(
								'heading'     => esc_html__( 'Feature name', 'induscity' ),
								'param_name'  => 'name',
								'type'        => 'textfield',
								'admin_label' => true,
							),
						),
					),
					array(
						'heading'    => esc_html__( 'Button Text', 'induscity' ),
						'param_name' => 'button_text',
						'type'       => 'textfield',
						'value'      => esc_html__( 'Join Now', 'induscity' ),
					),
					array(
						'heading'    => esc_html__( 'Button Link', 'induscity' ),
						'param_name' => 'button_link',
						'type'       => 'vc_link',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'induscity' ),
					),
				),
			)
		);

		// Counter
		vc_map(
			array(
				'name'     => esc_html__( 'Counter', 'induscity' ),
				'base'     => 'manufactory_counter',
				'class'    => '',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'heading'     => esc_html__( 'Style', 'induscity' ),
						'description' => esc_html__( 'Select counter style', 'induscity' ),
						'param_name'  => 'style',
						'type'        => 'dropdown',
						'value'       => array(
							esc_html__( 'Style 1', 'induscity' ) => '1',
							esc_html__( 'Style 2', 'induscity' ) => '2',
						),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Columns', 'induscity' ),
						'param_name' => 'columns',
						'value'      => array(
							esc_html__( '1 Columns', 'induscity' ) => '1',
							esc_html__( '2 Columns', 'induscity' ) => '2',
							esc_html__( '3 Columns', 'induscity' ) => '3',
							esc_html__( '4 Columns', 'induscity' ) => '4',
						),
					),
					array(
						'type'              => 'param_group',
						'heading'           => esc_html__( 'Counter Option', 'induscity' ),
						'value'             => '',
						'param_name'        => 'counter_option',
						'admin_enqueue_css' => get_template_directory_uri() . '/css/vc/icon-field.css',
						'params'            => array(
							array(
								'heading'     => esc_html__( 'Icon library', 'induscity' ),
								'description' => esc_html__( 'Select icon library.', 'induscity' ),
								'param_name'  => 'icon_type',
								'type'        => 'dropdown',
								'value'       => array(
									esc_html__( 'Font Awesome', 'induscity' ) => 'fontawesome',
									esc_html__( 'Flaticon', 'induscity' )     => 'flaticon',
									esc_html__( 'Custom Image', 'induscity' ) => 'image',
								),
							),
							array(
								'heading'     => esc_html__( 'Icon', 'induscity' ),
								'description' => esc_html__( 'Pick an icon from library.', 'induscity' ),
								'type'        => 'iconpicker',
								'param_name'  => 'icon_fontawesome',
								'value'       => 'fa fa-adjust',
								'settings'    => array(
									'emptyIcon'    => false,
									'iconsPerPage' => 4000,
								),
								'dependency'  => array(
									'element' => 'icon_type',
									'value'   => 'fontawesome',
								),
							),
							array(
								'heading'    => esc_html__( 'Icon', 'induscity' ),
								'type'       => 'iconpicker',
								'param_name' => 'icon_flaticon',
								'settings'   => array(
									'emptyIcon'    => true,
									'type'         => 'flaticon',
									'iconsPerPage' => 4000,
								),
								'dependency' => array(
									'element' => 'icon_type',
									'value'   => 'flaticon',
								),
							),
							array(
								'heading'     => esc_html__( 'Icon Image', 'induscity' ),
								'description' => esc_html__( 'Upload icon image', 'induscity' ),
								'type'        => 'attach_image',
								'param_name'  => 'image',
								'value'       => '',
								'dependency'  => array(
									'element' => 'icon_type',
									'value'   => 'image',
								),
							),
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Counter Value', 'induscity' ),
								'param_name'  => 'value',
								'value'       => '',
								'description' => esc_html__( 'Input integer value for counting', 'induscity' ),
							),
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Unit', 'induscity' ),
								'param_name'  => 'unit',
								'value'       => '',
								'description' => esc_html__( 'Enter the Unit. Example: +, % .etc', 'induscity' ),
							),
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Title', 'induscity' ),
								'param_name'  => 'title',
								'value'       => '',
								'description' => esc_html__( 'Enter the title of this box', 'induscity' ),
								'admin_label' => true,
							),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'induscity' ),
					),
				),
			)
		);

		// Video Banner
		vc_map(
			array(
				'name'     => esc_html__( 'Video Banner', 'induscity' ),
				'base'     => 'manufactory_video',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Video file URL', 'induscity' ),
						'description' => esc_html__( 'Only support YouTube and Vimeo', 'induscity' ),
						'param_name'  => 'video',
						'value'       => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Min Height(px)', 'induscity' ),
						'param_name'  => 'min_height',
						'value'       => '500',
					),
					array(
						'type'       => 'attach_image',
						'heading'    => esc_html__( 'Video Background Image', 'induscity' ),
						'param_name' => 'image',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Image size', 'induscity' ),
						'param_name'  => 'image_size',
						'description' => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'induscity' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Button', 'induscity' ),
						'param_name'  => 'show_btn',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Show Button', 'induscity' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Button Text', 'induscity' ),
						'param_name' => 'btn_text',
						'value'      => esc_html__( 'Watch Project Video', 'induscity' ),
						'dependency' => array(
							'element' => 'show_btn',
							'value'   => array( 'yes' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'induscity' ),
					),
				),
			)
		);

		// Partner
		vc_map(
			array(
				'name'     => esc_html__( 'Partners', 'induscity' ),
				'base'     => 'manufactory_partner',
				'class'    => '',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Columns', 'induscity' ),
						'param_name'  => 'columns',
						'value'       => array(
							esc_html__( '5 Columns', 'induscity' ) => '5',
							esc_html__( '4 Columns', 'induscity' ) => '4',
							esc_html__( '6 Columns', 'induscity' ) => '6',
						),
						'description' => esc_html__( 'How many partner\'s columns want to display', 'induscity' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Type', 'induscity' ),
						'param_name' => 'type',
						'value'      => array(
							esc_html__( 'Normal', 'induscity' )   => 'normal',
							esc_html__( 'Carousel', 'induscity' ) => 'carousel',
						),
					),
					array(
						'type'        => 'attach_images',
						'heading'     => esc_html__( 'Images', 'induscity' ),
						'param_name'  => 'images',
						'value'       => '',
						'description' => esc_html__( 'Choose images from media library', 'induscity' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Image size', 'induscity' ),
						'param_name'  => 'image_size',
						'description' => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'induscity' ),
					),
					array(
						'type'        => 'exploded_textarea_safe',
						'heading'     => esc_html__( 'Custom links', 'induscity' ),
						'param_name'  => 'custom_links',
						'description' => esc_html__( 'Enter links for each slide here. Divide links with linebreaks (Enter).', 'induscity' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Custom link target', 'induscity' ),
						'param_name'  => 'custom_links_target',
						'value'       => array(
							esc_html__( 'Same window', 'induscity' ) => '_self',
							esc_html__( 'New window', 'induscity' )  => '_blank',
						),
						'description' => esc_html__( 'Select where to open custom links.', 'induscity' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'induscity' ),
					),
				),
			)
		);

		// Team
		vc_map(
			array(
				'name'     => esc_html__( 'Team', 'induscity' ),
				'base'     => 'manufactory_team',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Type', 'induscity' ),
						'param_name' => 'type',
						'value'      => array(
							esc_html__( 'Carousel', 'induscity' ) => 'carousel',
							esc_html__( 'Grid', 'induscity' )     => 'grid',
						),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Columns', 'induscity' ),
						'param_name' => 'columns',
						'value'      => array(
							esc_html__( '4 columns', 'induscity' ) => '4',
							esc_html__( '3 columns', 'induscity' ) => '3',
							esc_html__( '2 columns', 'induscity' ) => '2',
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Image size', 'induscity' ),
						'param_name'  => 'image_size',
						'description' => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'induscity' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Autoplay', 'induscity' ),
						'param_name'  => 'autoplay',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Enable autoplay', 'induscity' ),
						'dependency'  => array(
							'element' => 'type',
							'value'   => 'carousel',
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Autoplay timeout', 'induscity' ),
						'param_name'  => 'autoplay_timeout',
						'value'       => '2000',
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'induscity' ),
						'dependency'  => array(
							'element' => 'autoplay',
							'value'   => array( 'yes' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Autoplay speed', 'induscity' ),
						'param_name'  => 'autoplay_speed',
						'value'       => '800',
						'description' => esc_html__( 'Set auto play speed (in ms).', 'induscity' ),
						'dependency'  => array(
							'element' => 'autoplay',
							'value'   => array( 'yes' ),
						),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Navigation', 'induscity' ),
						'param_name'  => 'nav',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Enable navigation', 'induscity' ),
						'dependency'  => array(
							'element' => 'type',
							'value'   => 'carousel',
						),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Dots', 'induscity' ),
						'param_name'  => 'dot',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Enable dots', 'induscity' ),
						'dependency'  => array(
							'element' => 'type',
							'value'   => 'carousel',
						),
					),
					array(
						'type'       => 'param_group',
						'heading'    => esc_html__( 'Member Setting', 'induscity' ),
						'value'      => '',
						'param_name' => 'member_info',
						'params'     => array(
							array(
								'heading'    => esc_html__( 'Image', 'induscity' ),
								'param_name' => 'image',
								'type'       => 'attach_image',
								'value'      => '',
							),
							array(
								'heading'     => esc_html__( 'Name', 'induscity' ),
								'param_name'  => 'name',
								'type'        => 'textfield',
								'value'       => '',
								'admin_label' => true,
							),
							array(
								'heading'    => esc_html__( 'Job', 'induscity' ),
								'param_name' => 'job',
								'type'       => 'textfield',
								'value'      => '',
							),
							array(
								'heading'    => esc_html__( 'Social 1', 'induscity' ),
								'param_name' => 'social_1',
								'type'       => 'textfield',
								'value'      => 'https://facebook.com/',
							),
							array(
								'heading'    => esc_html__( 'Social 2', 'induscity' ),
								'param_name' => 'social_2',
								'type'       => 'textfield',
								'value'      => 'https://twitter.com/',
							),
							array(
								'heading'    => esc_html__( 'Social 3', 'induscity' ),
								'param_name' => 'social_3',
								'type'       => 'textfield',
								'value'      => 'https://www.skype.com/',
							),
							array(
								'heading'    => esc_html__( 'Social 4', 'induscity' ),
								'param_name' => 'social_4',
								'type'       => 'textfield',
								'value'      => '',
							),
							array(
								'heading'    => esc_html__( 'Social 5', 'induscity' ),
								'param_name' => 'social_5',
								'type'       => 'textfield',
								'value'      => '',
							),
						),
					),
					array(
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'type'        => 'textfield',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'induscity' ),
					),
				),
			)
		);

		// History
		vc_map(
			array(
				'name'     => esc_html__( 'History', 'induscity' ),
				'base'     => 'manufactory_history',
				'class'    => '',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Number of History Events', 'induscity' ),
						'param_name'  => 'number',
						'value'       => '4',
						'description' => esc_html__( 'Set numbers of History Event you want to display', 'induscity' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Autoplay', 'induscity' ),
						'param_name'  => 'autoplay',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Enable autoplay', 'induscity' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Autoplay timeout', 'induscity' ),
						'param_name'  => 'autoplay_timeout',
						'value'       => '2000',
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'induscity' ),
						'dependency'  => array(
							'element' => 'autoplay',
							'value'   => array( 'yes' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Autoplay speed', 'induscity' ),
						'param_name'  => 'autoplay_speed',
						'value'       => '800',
						'description' => esc_html__( 'Set auto play speed (in ms).', 'induscity' ),
						'dependency'  => array(
							'element' => 'autoplay',
							'value'   => array( 'yes' ),
						),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Navigation', 'induscity' ),
						'param_name'  => 'nav',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Enable navigation', 'induscity' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Dots', 'induscity' ),
						'param_name'  => 'dot',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Enable dots', 'induscity' ),
					),
					array(
						'type'       => 'param_group',
						'heading'    => esc_html__( 'History', 'induscity' ),
						'value'      => '',
						'param_name' => 'history',
						'params'     => array(
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Date', 'induscity' ),
								'param_name' => 'date',
								'admin_label' => true,
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Title', 'induscity' ),
								'param_name' => 'title',
								'admin_label' => true,
							),
							array(
								'type'       => 'textarea',
								'heading'    => esc_html__( 'Description', 'induscity' ),
								'param_name' => 'desc',
							),
						)
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'induscity' ),
					),
				),
			)
		);

		// Contact Box
		vc_map(
			array(
				'name'     => esc_html__( 'Contact Box', 'induscity' ),
				'base'     => 'manufactory_contact_box',
				'class'    => '',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Section title', 'induscity' ),
						'param_name'  => 'section_title',
						'value'       => '',
						'description' => esc_html__( 'Enter title for this section', 'induscity' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Address', 'induscity' ),
						'param_name'  => 'show_address',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Show Address', 'induscity' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Phone Number', 'induscity' ),
						'param_name'  => 'show_phone',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Show Phone Number', 'induscity' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Email', 'induscity' ),
						'param_name'  => 'show_email',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Show Email', 'induscity' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Social', 'induscity' ),
						'param_name'  => 'show_social',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Show Social. Enter Social in Social Tab', 'induscity' ),
					),
					array(
						'type'        => 'textarea',
						'heading'     => esc_html__( 'Address', 'induscity' ),
						'param_name'  => 'address',
						'value'       => '',
						'description' => esc_html__( 'Enter address', 'induscity' ),
						'dependency'  => array(
							'element' => 'show_address',
							'value'   => array( 'yes' ),
						),
					),
					array(
						'type'        => 'textarea',
						'heading'     => esc_html__( 'Phone', 'induscity' ),
						'param_name'  => 'phone',
						'value'       => '',
						'description' => esc_html__( 'Enter phone number', 'induscity' ),
						'dependency'  => array(
							'element' => 'show_phone',
							'value'   => array( 'yes' ),
						),
					),
					array(
						'type'        => 'textarea',
						'heading'     => esc_html__( 'Email', 'induscity' ),
						'param_name'  => 'email',
						'value'       => '',
						'description' => esc_html__( 'Enter email', 'induscity' ),
						'dependency'  => array(
							'element' => 'show_email',
							'value'   => array( 'yes' ),
						),
					),

					// Social Group
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Facebook', 'induscity' ),
						'param_name' => 'facebook',
						'value'      => '',
						'group'      => esc_html__( 'Socials', 'induscity' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Twitter', 'induscity' ),
						'param_name' => 'twitter',
						'value'      => '',
						'group'      => esc_html__( 'Socials', 'induscity' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Skype', 'induscity' ),
						'param_name' => 'skype',
						'value'      => '',
						'group'      => esc_html__( 'Socials', 'induscity' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Google Plus', 'induscity' ),
						'param_name' => 'google',
						'value'      => '',
						'group'      => esc_html__( 'Socials', 'induscity' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'RSS', 'induscity' ),
						'param_name' => 'rss',
						'value'      => '',
						'group'      => esc_html__( 'Socials', 'induscity' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Pinterest', 'induscity' ),
						'param_name' => 'pinterest',
						'value'      => '',
						'group'      => esc_html__( 'Socials', 'induscity' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Linkedin', 'induscity' ),
						'param_name' => 'linkedin',
						'value'      => '',
						'group'      => esc_html__( 'Socials', 'induscity' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Youtube', 'induscity' ),
						'param_name' => 'youtube',
						'value'      => '',
						'group'      => esc_html__( 'Socials', 'induscity' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Instagram', 'induscity' ),
						'param_name' => 'instagram',
						'value'      => '',
						'group'      => esc_html__( 'Socials', 'induscity' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'induscity' ),
					),
				),
			)
		);

		// Working Hour
		vc_map(
			array(
				'name'     => __( 'Working Hour', 'induscity' ),
				'base'     => 'manufactory_working_hour',
				'class'    => '',
				'category' => __( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Section title', 'induscity' ),
						'param_name'  => 'section_title',
						'value'       => '',
						'description' => esc_html__( 'Enter title for this section', 'induscity' ),
					),
					array(
						'heading'     => esc_html__( 'Hour', 'induscity' ),
						'description' => esc_html__( 'Working Hour. Click to arrow button to edit.', 'induscity' ),
						'param_name'  => 'hours',
						'type'        => 'param_group',
						'params'      => array(
							array(
								'heading'     => esc_html__( 'Day', 'induscity' ),
								'param_name'  => 'day',
								'type'        => 'textfield',
								'admin_label' => true,
							),
							array(
								'heading'     => esc_html__( 'Hour', 'induscity' ),
								'param_name'  => 'hour',
								'type'        => 'textfield',
								'admin_label' => true,
							),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'induscity' ),
					),
				),
			)
		);

		// Department Carousel
		vc_map(
			array(
				'name'     => esc_html__( 'Department Carousel', 'induscity' ),
				'base'     => 'manufactory_department_carousel',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Section title', 'induscity' ),
						'param_name'  => 'section_title',
						'value'       => '',
						'description' => esc_html__( 'Enter title for this section', 'induscity' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Image size', 'induscity' ),
						'param_name'  => 'image_size',
						'description' => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'induscity' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Autoplay', 'induscity' ),
						'param_name'  => 'autoplay',
						'value'       => array( esc_html__( 'Yes', 'induscity' ) => 'yes' ),
						'description' => esc_html__( 'If "YES" Enable autoplay', 'induscity' ),
						'dependency'  => array(
							'element' => 'type',
							'value'   => 'carousel',
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Autoplay timeout', 'induscity' ),
						'param_name'  => 'autoplay_timeout',
						'value'       => '2000',
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'induscity' ),
						'dependency'  => array(
							'element' => 'autoplay',
							'value'   => array( 'yes' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Autoplay speed', 'induscity' ),
						'param_name'  => 'autoplay_speed',
						'value'       => '800',
						'description' => esc_html__( 'Set auto play speed (in ms).', 'induscity' ),
						'dependency'  => array(
							'element' => 'autoplay',
							'value'   => array( 'yes' ),
						),
					),
					array(
						'type'       => 'param_group',
						'heading'    => esc_html__( 'Department Setting', 'induscity' ),
						'value'      => '',
						'param_name' => 'setting',
						'params'     => array(
							array(
								'heading'    => esc_html__( 'Image', 'induscity' ),
								'param_name' => 'image',
								'type'       => 'attach_image',
								'value'      => '',
							),
							array(
								'heading'     => esc_html__( 'Name', 'induscity' ),
								'param_name'  => 'name',
								'type'        => 'textfield',
								'value'       => '',
								'admin_label' => true,
							),
							array(
								'heading'    => esc_html__( 'Phone Number', 'induscity' ),
								'param_name' => 'phone',
								'type'       => 'textfield',
								'value'      => '',
							),
							array(
								'type'       => 'textarea',
								'heading'    => esc_html__( 'Mail', 'induscity' ),
								'param_name' => 'mail',
								'value'      => '',
							),
						),
					),
					array(
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'type'        => 'textfield',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'induscity' ),
					),
				),
			)
		);

		// Add newsletter shortcode
		// get form id of mailchimp
		$mail_forms    = get_posts( 'post_type=mc4wp-form&posts_per_page=-1' );
		$mail_form_ids = array(
			esc_html__( 'Select Form', 'induscity' ) => '',
		);
		foreach ( $mail_forms as $form ) {
			$mail_form_ids[$form->post_title] = $form->ID;
		}
		vc_map(
			array(
				'name'     => esc_html__( 'Newsletter', 'induscity' ),
				'base'     => 'manufactory_newsletter',
				'class'    => '',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Mailchimp Form', 'induscity' ),
						'param_name' => 'form',
						'value'      => $mail_form_ids,
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'induscity' ),
					),
				),
			)
		);

		// Add contact form 7 shortcode
		$mail_forms    = get_posts( 'post_type=wpcf7_contact_form&posts_per_page=-1' );
		$mail_form_ids = array(
			esc_html__( 'Select Form', 'induscity' ) => '',
		);
		foreach ( $mail_forms as $form ) {
			$mail_form_ids[$form->post_title] = $form->ID;
		}
		vc_map(
			array(
				'name'     => esc_html__( 'Induscity Contact Form 7', 'induscity' ),
				'base'     => 'manufactory_contact_form_7',
				'class'    => '',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Section title', 'induscity' ),
						'param_name'  => 'section_title',
						'value'       => '',
						'description' => esc_html__( 'Enter title for this section', 'induscity' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Form Version', 'induscity' ),
						'param_name' => 'color',
						'value'      => array(
							esc_html__( 'Light', 'induscity' ) => 'light',
							esc_html__( 'Dark', 'induscity' )  => 'dark',
						),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Contact Form 7', 'induscity' ),
						'param_name' => 'form',
						'value'      => $mail_form_ids,
					),
					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__( 'Form Background Color', 'induscity' ),
						'param_name' => 'form_bg',
						'value'      => '',
						'group'      => esc_html__( 'CSS', 'induscity' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Padding Top (px)', 'induscity' ),
						'param_name' => 'padding_top',
						'value'      => '',
						'group'      => esc_html__( 'CSS', 'induscity' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Padding Right (px)', 'induscity' ),
						'param_name' => 'padding_right',
						'value'      => '',
						'group'      => esc_html__( 'CSS', 'induscity' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Padding Bottom (px)', 'induscity' ),
						'param_name' => 'padding_bottom',
						'value'      => '',
						'group'      => esc_html__( 'CSS', 'induscity' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Padding Left (px)', 'induscity' ),
						'param_name' => 'padding_left',
						'value'      => '',
						'group'      => esc_html__( 'CSS', 'induscity' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'induscity' ),
					),
				),
			)
		);

		// GG maps

		vc_map(
			array(
				'name'     => esc_html__( 'Google Maps', 'induscity' ),
				'base'     => 'manufactory_gmap',
				'category' => esc_html__( 'Induscity', 'induscity' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Api Key', 'induscity' ),
						'param_name'  => 'api_key',
						'value'       => '',
						'description' => sprintf( __( 'Please go to <a href="%s">Google Maps APIs</a> to get a key', 'induscity' ), esc_url( 'https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key' ) ),
					),
					array(
						'type'        => 'attach_image',
						'heading'     => esc_html__( 'Marker', 'induscity' ),
						'param_name'  => 'marker',
						'value'       => '',
						'description' => esc_html__( 'Choose an image from media library', 'induscity' ),
					),
					array(
						'type'       => 'param_group',
						'heading'    => esc_html__( 'Address Infomation', 'induscity' ),
						'value'      => '',
						'param_name' => 'info',
						'params'     => array(
							array(
								'type'        => 'attach_image',
								'heading'     => esc_html__( 'Location Image', 'induscity' ),
								'param_name'  => 'image',
								'value'       => '',
								'description' => esc_html__( 'Choose an image from media library', 'induscity' ),
							),
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Address', 'induscity' ),
								'param_name'  => 'address',
								'admin_label' => true,
							),
							array(
								'type'       => 'textarea',
								'heading'    => esc_html__( 'Details', 'induscity' ),
								'param_name' => 'details',
							),
						),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Width(px)', 'induscity' ),
						'param_name' => 'width',
						'value'      => '',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Height(px)', 'induscity' ),
						'param_name' => 'height',
						'value'      => '500',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Zoom', 'induscity' ),
						'param_name' => 'zoom',
						'value'      => '13',
					),
					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__( 'Map Colors', 'induscity' ),
						'param_name' => 'map_color',
						'value'      => '#efba2c',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'induscity' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'induscity' ),
					),
				),
			)
		);
	}

	/**
	 * Get icon
	 *
	 * @return array|string
	 */
	function vc_iconpicker_type_flaticon( $icons ) {
		$flaticon = array(
			array( 'flaticon-tool' => 'flaticon tool' ),
			array( 'flaticon-sign' => 'flaticon sign' ),
			array( 'flaticon-arrow' => 'flaticon arrow' ),
			array( 'flaticon-home' => 'flaticon home' ),
			array( 'flaticon-engineer' => 'flaticon engineer' ),
			array( 'flaticon-letter' => 'flaticon letter' ),
			array( 'flaticon-arrows-1' => 'flaticon arrows 1' ),
			array( 'flaticon-plus-zoom-or-search-symbol-of-interface' => 'flaticon plus zoom or search symbol of interface' ),
			array( 'flaticon-hyperlink' => 'flaticon hyperlink' ),
			array( 'flaticon-telephone' => 'flaticon telephone' ),
			array( 'flaticon-call-answer' => 'flaticon call answer' ),
			array( 'flaticon-check' => 'flaticon check' ),
			array( 'flaticon-up-arrow' => 'flaticon up arrow' ),
			array( 'flaticon-two-quotes' => 'flaticon two quotes' ),
			array( 'flaticon-interface' => 'flaticon interface' ),
			array( 'flaticon-transport-1' => 'flaticon transport 1' ),
			array( 'flaticon-road' => 'flaticon road' ),
			array( 'flaticon-wall-clock' => 'flaticon wall clock' ),
			array( 'flaticon-down-arrow' => 'flaticon down arrow' ),
			array( 'flaticon-multimedia' => 'flaticon multimedia' ),
			array( 'flaticon-wrong-sign' => 'flaticon wrong sign' ),
			array( 'flaticon-pinwheel' => 'flaticon pinwheel' ),
			array( 'flaticon-sprout' => 'flaticon sprout' ),
			array( 'flaticon-music' => 'flaticon music' ),
			array( 'flaticon-signs' => 'flaticon signs' ),
			array( 'flaticon-time' => 'flaticon time' ),
			array( 'flaticon-null' => 'flaticon null' ),
			array( 'flaticon-arrows' => 'flaticon arrows' ),
			array( 'flaticon-cruise' => 'flaticon cruise' ),
			array( 'flaticon-transport' => 'flaticon transport' ),
			array( 'flaticon-technology-1' => 'flaticon technology 1' ),
			array( 'flaticon-construction' => 'flaticon construction' ),
			array( 'flaticon-buildings' => 'flaticon buildings' ),
			array( 'flaticon-technology' => 'flaticon technology' ),
			array( 'flaticon-landscape' => 'flaticon landscape' ),
			array( 'flaticon-note' => 'flaticon note' ),
			array( 'flaticon-motor' => 'flaticon motor' ),
		);

		return array_merge( $icons, $flaticon );
	}

	/**
	 * Enqueue icon element font
	 *
	 * @param $font
	 */
	function vc_icon_element_fonts_enqueue( $font ) {
		switch ( $font ) {
			case 'flaticon':
				wp_enqueue_style( 'flaticon' );
		}
	}

	function vc_iconpicker_base_register_css() {
		wp_enqueue_style( 'flaticon', INDUSCITY_ADDONS_URL . '/assets/css/flaticon.min.css', array(), '1.0.0' );
	}
}