<?php
/**
 * Register required, recommended plugins for theme
 *
 * @package Induscity
 */

/**
 * Register required plugins
 *
 * @since  1.0
 */
function induscity_register_required_plugins() {
	$plugins = array(
		array(
			'name'               => esc_html__( 'WooCommerce', 'induscity' ),
			'slug'               => 'woocommerce',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'Meta Box', 'induscity' ),
			'slug'               => 'meta-box',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'Kirki', 'induscity' ),
			'slug'               => 'kirki',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'WPBakery Page Builder', 'induscity' ),
			'slug'               => 'js_composer',
			'source'             => esc_url( 'https://github.com/drfuri/plugins/raw/main/js_composer.zip' ),
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'Induscity Visual Composer Addons', 'induscity' ),
			'slug'               => 'induscity-vc-addons',
			'source'             => get_template_directory() . '/plugins/induscity-vc-addons.zip',
			'required'           => true,
			'force_activation'   => false,
			'force_deactivation' => false,
			'version'            => '1.1.1',
		),
		array(
			'name'               => esc_html__( 'Revolution Slider', 'induscity' ),
			'slug'               => 'revslider',
			'source'             => esc_url( 'https://github.com/drfuri/plugins/raw/main/revslider.zip' ),
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'Contact Form 7', 'induscity' ),
			'slug'               => 'contact-form-7',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		array(
			'name'               => esc_html__( 'MailChimp for WordPress', 'induscity' ),
			'slug'               => 'mailchimp-for-wp',
			'required'           => false,
			'force_activation'   => false,
			'force_deactivation' => false,
		),
	);
	$config  = array(
		'domain'       => 'induscity',
		'default_path' => '',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'is_automatic' => false,
		'message'      => '',
		'strings'      => array(
			'page_title'                      => esc_html__( 'Install Required Plugins', 'induscity' ),
			'menu_title'                      => esc_html__( 'Install Plugins', 'induscity' ),
			'installing'                      => esc_html__( 'Installing Plugin: %s', 'induscity' ),
			'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'induscity' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'induscity' ),
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'induscity' ),
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'induscity' ),
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'induscity' ),
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'induscity' ),
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'induscity' ),
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'induscity' ),
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'induscity' ),
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'induscity' ),
			'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'induscity' ),
			'return'                          => esc_html__( 'Return to Required Plugins Installer', 'induscity' ),
			'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'induscity' ),
			'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'induscity' ),
			'nag_type'                        => 'updated'
		)
	);

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'induscity_register_required_plugins' );
