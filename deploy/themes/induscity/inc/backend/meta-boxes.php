<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */


/**
 * Enqueue script for handling actions with meta boxes
 *
 * @since 1.0
 *
 * @param string $hook
 */
function induscity_meta_box_scripts( $hook ) {
	// Detect to load un-minify scripts when WP_DEBUG is enable
	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		wp_enqueue_script( 'induscity-meta-boxes', get_template_directory_uri() . "/js/backend/meta-boxes$min.js", array( 'jquery' ), '20161025', true );
	}
}

add_action( 'admin_enqueue_scripts', 'induscity_meta_box_scripts' );

/**
 * Registering meta boxes
 *
 * Using Meta Box plugin: http://www.deluxeblogtips.com/meta-box/
 *
 * @see http://www.deluxeblogtips.com/meta-box/docs/define-meta-boxes
 *
 * @param array $meta_boxes Default meta boxes. By default, there are no meta boxes.
 *
 * @return array All registered meta boxes
 */
function induscity_register_meta_boxes( $meta_boxes ) {
	// Post format's meta box
	$meta_boxes[] = array(
		'id'       => 'post-format-settings',
		'title'    => esc_html__( 'Format Details', 'induscity' ),
		'pages'    => array( 'post' ),
		'context'  => 'normal',
		'priority' => 'high',
		'autosave' => true,
		'fields'   => array(
			array(
				'name'             => esc_html__( 'Image', 'induscity' ),
				'id'               => 'image',
				'type'             => 'image_advanced',
				'class'            => 'image',
				'max_file_uploads' => 1,
			),
			array(
				'name'  => esc_html__( 'Gallery', 'induscity' ),
				'id'    => 'images',
				'type'  => 'image_advanced',
				'class' => 'gallery',
			),
			array(
				'name'  => esc_html__( 'Audio', 'induscity' ),
				'id'    => 'audio',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 2,
				'class' => 'audio',
			),
			array(
				'name'  => esc_html__( 'Video', 'induscity' ),
				'id'    => 'video',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 2,
				'class' => 'video',
			),
			array(
				'name'  => esc_html__( 'Link', 'induscity' ),
				'id'    => 'url',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'link',
			),
			array(
				'name'  => esc_html__( 'Text', 'induscity' ),
				'id'    => 'url_text',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'link',
			),
			array(
				'name'  => esc_html__( 'Quote', 'induscity' ),
				'id'    => 'quote',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 2,
				'class' => 'quote',
			),
			array(
				'name'  => esc_html__( 'Author', 'induscity' ),
				'id'    => 'quote_author',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'quote',
			),
			array(
				'name'  => esc_html__( 'Author URL', 'induscity' ),
				'id'    => 'author_url',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'quote',
			),
			array(
				'name'  => esc_html__( 'Status', 'induscity' ),
				'id'    => 'status',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'status',
			),
		),
	);

	// Display Settings
	$meta_boxes[] = array(
		'id'       => 'display-settings',
		'title'    => esc_html__( 'Display Settings', 'induscity' ),
		'pages'    => array( 'post', 'page' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name' => esc_html__( 'Layout', 'induscity' ),
				'id'   => 'heading_layout',
				'type' => 'heading',
			),
			array(
				'name' => esc_html__( 'Custom Layout', 'induscity' ),
				'id'   => 'custom_page_layout',
				'type' => 'checkbox',
				'std'  => false,
			),
			array(
				'name'    => esc_html__( 'Layout', 'induscity' ),
				'id'      => 'layout',
				'type'    => 'image_select',
				'class'   => 'custom-page-layout',
				'options' => array(
					'full-content'    => get_template_directory_uri() . '/img/sidebars/empty.png',
					'sidebar-content' => get_template_directory_uri() . '/img/sidebars/single-left.png',
					'content-sidebar' => get_template_directory_uri() . '/img/sidebars/single-right.png',
				),
			),
		),
	);

	//Page Header Settings
	$meta_boxes[] = array(
		'id'       => 'page-header-settings',
		'title'    => esc_html__( 'Page Header Settings', 'induscity' ),
		'pages'    => array( 'post', 'page', 'portfolio', 'service' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name'  => esc_html__( 'Hide Page Header', 'induscity' ),
				'id'    => 'hide_page_header',
				'type'  => 'checkbox',
				'std'   => false,
				'class' => 'hide-homepage',
			),
			array(
				'name' => esc_html__( 'Custom Layout', 'induscity' ),
				'id'   => 'custom_layout',
				'type' => 'checkbox',
				'std'  => false,
			),
			array(
				'name'  => esc_html__( 'Hide Breadcrumb', 'induscity' ),
				'id'    => 'hide_breadcrumb',
				'type'  => 'checkbox',
				'std'   => false,
				'class' => 'hide-homepage',
			),
			array(
				'name'  => esc_html__( 'Hide Title', 'induscity' ),
				'id'    => 'hide_title',
				'type'  => 'checkbox',
				'std'   => false,
				'class' => 'hide-homepage',
			),
			array(
				'name'             => esc_html__( 'Background Image', 'induscity' ),
				'id'               => 'page_bg',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'std'              => false,
			),
		),
	);

	// Portfolio Information
	$meta_boxes[] = array(
		'id'       => 'project-info',
		'title'    => esc_html__( 'Portfolio Info', 'induscity' ),
		'pages'    => array( 'portfolio' ),
		'context'  => 'normal',
		'priority' => 'high',
		'autosave' => true,
		'fields'   => array(
			array(
				'name'  => esc_html__( 'Gallery', 'induscity' ),
				'id'    => 'images',
				'type'  => 'image_advanced',
				'class' => 'gallery',
			),
			array(
				'name'  => esc_html__( 'Client', 'induscity' ),
				'id'    => 'client',
				'type'  => 'text',
				'class' => 'client',
			),
			array(
				'name'  => esc_html__( 'Website', 'induscity' ),
				'id'    => 'website',
				'type'  => 'text',
				'class' => 'website',
			),
			array(
				'name'       => esc_html__( 'Rating', 'induscity' ),
				'id'         => 'rating',
				'type'       => 'slider',
				'js_options' => array(
					'min'  => 0,
					'max'  => 10,
					'step' => 1,
				),
			),
		),
	);

	// Service
	$meta_boxes[] = array(
		'id'       => 'service_general',
		'title'    => esc_html__( 'General', 'induscity' ),
		'pages'    => array( 'service' ),
		'context'  => 'normal',
		'priority' => 'high',
		'autosave' => true,
		'fields'   => array(
			array(
				'name'  => esc_html__( 'Service Icon HTML', 'induscity' ),
				'id'    => 'service_icon',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 1,
				'class' => 'service-icon',
			),
		)
	);

	return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'induscity_register_meta_boxes' );

function induscity_notice__success() {

	if ( ! function_exists('induscity_vc_addons_init') ) {
		return;
	}

	$versions = get_plugin_data( WP_PLUGIN_DIR . '/induscity-vc-addons/induscity-vc-addons.php' );
	if ( version_compare( $versions['Version'], '1.1', '>=' ) ) {
		return;
	}

	?>
	<div class="notice notice-info is-dismissible">
		<p><strong><?php esc_html_e( 'The Induscity Visual Composer Addons plugin needs to be updated to 1.1 to ensure maximum compatibility with this theme. If you do not update it, your widgets will be lost.', 'induscity' ); ?></strong></p>
	</div>
	<?php
}
add_action( 'admin_notices', 'induscity_notice__success' );