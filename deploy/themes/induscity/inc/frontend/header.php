<?php
/**
 * Hooks for template header
 *
 * @package Induscity
 */

/**
 * Enqueue scripts and styles.
 *
 * @since 1.0
 */
function induscity_enqueue_scripts() {
	/**
	 * Register and enqueue styles
	 */
	wp_register_style( 'induscity-fonts', induscity_fonts_url(), array(), '20161025' );
	wp_register_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7' );
	wp_register_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.6.3' );
	wp_register_style( 'fontawesome-5', get_template_directory_uri() . '/css/font-awesome-5.min.css', array(), '5.15.3' );
	wp_register_style( 'flaticon', get_template_directory_uri() . '/css/flaticon.css', array(), '20171020' );
	wp_register_style( 'photoswipe', get_template_directory_uri() . '/css/photoswipe.css', array(), '4.1.1' );
	wp_register_style( 'slick', get_template_directory_uri() . '/css/slick.css', array(), '1.8.1' );

	wp_enqueue_style(
		'induscity', get_template_directory_uri() . '/style.css', array(
		'induscity-fonts',
		'bootstrap',
		'fontawesome',
		'fontawesome-5',
		'flaticon',
		'photoswipe',
		'slick',
	), '20161025'
	);

	wp_add_inline_style( 'induscity', induscity_customize_css() );

	/**
	 * Register and enqueue scripts
	 */
	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/html5shiv.min.js', array(), '3.7.2' );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'respond', get_template_directory_uri() . '/js/respond.min.js', array(), '1.4.2' );
	wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );

	wp_register_script( 'photoswipe', get_template_directory_uri() . '/js/photoswipe.min.js', array(), '4.1.1', true );
	wp_register_script( 'photoswipe-ui', get_template_directory_uri() . '/js/photoswipe-ui.min.js', array( 'photoswipe' ), '4.1.1', true );

	wp_register_script( 'isotope', get_template_directory_uri() . '/js/plugins/isotope.pkgd.min.js', array( 'imagesloaded' ) , '2.2.2', true );
	wp_register_script( 'counterup', get_template_directory_uri() . '/js/plugins/jquery.counterup.min.js', array(), '1.0', true );
	wp_register_script( 'parallax', get_template_directory_uri() . '/js/plugins/jquery.parallax.min.js', array(), '1.0', true );
	wp_register_script( 'tabs', get_template_directory_uri() . '/js/plugins/jquery.tabs.js', array(), '1.0', true );
	wp_register_script( 'carousel', get_template_directory_uri() . '/js/plugins/owl.carousel.js', array(), '2.2.0', true );
	wp_register_script( 'slick', get_template_directory_uri() . '/js/plugins/slick.min.js', array(), '1.0', true );

	if ( is_singular() ) {

		wp_enqueue_style( 'photoswipe' );
		wp_enqueue_script( 'photoswipe-ui' );

		$photoswipe_skin = 'photoswipe-default-skin';
		if ( wp_style_is( $photoswipe_skin, 'registered' ) && ! wp_style_is( $photoswipe_skin, 'enqueued' ) ) {
			wp_enqueue_style( $photoswipe_skin );
		}
	}

	wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array( 'jquery' ), '2.0.2' );

	wp_enqueue_script( 'induscity', get_template_directory_uri() . "/js/scripts$min.js", array(
		'jquery',
		'isotope',
		'imagesloaded',
		'counterup',
		'parallax',
		'tabs',
		'carousel',
		'slick',
	), '20171013', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'induscity_enqueue_scripts', 50 );

/**
 * Enqueues front-end CSS for theme customization
 */
function induscity_customize_css() {
	$css = '';

	// Logo
	$logo_size_width = intval( induscity_get_option( 'logo_width' ) );
	$logo_css        = $logo_size_width ? 'width:' . $logo_size_width . 'px; ' : '';

	$logo_size_height = intval( induscity_get_option( 'logo_height' ) );
	$logo_css .= $logo_size_height ? 'height:' . $logo_size_height . 'px; ' : '';

	$logo_margin = induscity_get_option( 'logo_position' );
	$logo_css .= $logo_margin['top'] ? 'margin-top:' . $logo_margin['top'] . '; ' : '';
	$logo_css .= $logo_margin['right'] ? 'margin-right:' . $logo_margin['right'] . '; ' : '';
	$logo_css .= $logo_margin['bottom'] ? 'margin-bottom:' . $logo_margin['bottom'] . '; ' : '';
	$logo_css .= $logo_margin['left'] ? 'margin-left:' . $logo_margin['left'] . '; ' : '';

	if ( ! empty( $logo_css ) ) {
		$css .= '.site-header .logo img ' . ' {' . $logo_css . '}';
	}

	/* 404 background */

	if ( is_404() ) {
		$banner = induscity_get_option( 'not_found_bg' );

		if ( $banner ) {
			$css .= '.error404 .site-content { background-image: url( ' . esc_url( $banner ) . '); }';
		}
	}

	/* Color Scheme */
	$color_scheme_option = induscity_get_option( 'color_scheme' );

	if ( intval( induscity_get_option( 'custom_color_scheme' ) ) ) {
		$color_scheme_option = induscity_get_option( 'custom_color' );
	}

	// Don't do anything if the default color scheme is selected.
	if ( $color_scheme_option ) {
		$css .= induscity_get_color_scheme_css( $color_scheme_option );
	}

	$cursor = get_template_directory_uri() . '/img/cursor.png';

	$css .= induscity_cursor_css( $cursor );

	$seperate = get_template_directory_uri() . '/img/menu-seperate.png';

	$css .= '.header-v1 .main-nav ul.menu > li:not(.mf-active-menu), .header-v2 .main-nav ul.menu > li:not(.mf-active-menu), .header-v5 .main-nav ul.menu > li:not(.mf-active-menu) { background-image: url( ' . esc_url( $seperate ) . '); }';

	$css .= induscity_typography_css();

	$css .= induscity_get_heading_typography_css();

	return $css;

}

/**
 * Display header
 */
function induscity_show_header() {
	get_template_part( 'parts/headers/header', induscity_get_option( 'header_layout' ) );
}

add_action( 'induscity_header', 'induscity_show_header' );

/**
 * Display topbar on top of site
 *
 * @since 1.0.0
 */
function induscity_show_topbar() {
	if ( ! intval( induscity_get_option( 'topbar_enable' ) ) ) {
		return;
	}

	if (is_active_sidebar( 'topbar-left' ) == false &&
		is_active_sidebar( 'topbar-right' ) == false ) {
		return '';
	}

	$style = $class = '';

	$topbar_bg = induscity_get_option( 'topbar_background' );

	if ( $topbar_bg ) {
		$style = 'style="background-color:' . esc_attr( $topbar_bg ) . '"';
	}

	if ( induscity_get_option( 'topbar_mobile' ) ) {
		$class = 'hidden-md hidden-sm hidden-xs';
	}

	?>
	<div id="topbar" class="topbar <?php echo esc_attr( $class ) ?>" <?php echo esc_attr($style); ?>>
		<div class="container">
			<?php if ( is_active_sidebar( 'topbar-left' ) ) : ?>

				<div class="topbar-left topbar-widgets text-left clearfix">
					<?php
					ob_start();
					dynamic_sidebar( 'topbar-left' );
					$output = ob_get_clean();

					echo apply_filters( 'mf_topbar_left', $output );
					?>
				</div>

			<?php endif; ?>

			<?php if ( is_active_sidebar( 'topbar-right' ) ) : ?>

				<div class="topbar-right topbar-widgets text-right clearfix">
					<?php
					ob_start();
					dynamic_sidebar( 'topbar-right' );
					$output = ob_get_clean();

					echo apply_filters( 'mf_topbar_right', $output );
					?>
				</div>

			<?php endif; ?>
		</div>
	</div>
	<?php
}

add_action( 'induscity_before_header', 'induscity_show_topbar' );

/**
 * Display the header minimized
 *
 * @since 1.0.0
 */
function induscity_header_minimized() {

	if ( induscity_get_option( 'header_sticky' ) == false ) {
		return;
	}

	$css_class = 'mf-header-' . induscity_get_option( 'header_layout' );

	printf( '<div id="mf-header-minimized" class="mf-header-minimized %s"></div>', esc_attr( $css_class ) );

}

add_action( 'induscity_before_header', 'induscity_header_minimized' );


/**
 * Display page header
 */
function induscity_page_header() {
	get_template_part( 'parts/page-headers/page-header' );
}

add_action( 'induscity_after_header', 'induscity_page_header' );

/**
 * Get breadcrumbs
 *
 * @since  1.0.0
 *
 * @return string
 */

if ( ! function_exists( 'induscity_get_breadcrumbs' ) ) :
	function induscity_get_breadcrumbs() {

		ob_start();
		?>
		<nav class="breadcrumbs">
			<?php
			induscity_breadcrumbs(
				array(
					'before'   => '',
					'taxonomy' => function_exists( 'is_woocommerce' ) && is_woocommerce() ? 'product_cat' : 'category',
				)
			);
			?>
		</nav>
		<?php
		echo ob_get_clean();
	}

endif;

/**
 * Filter to archive title and add page title for singular pages
 *
 * @param string $title
 *
 * @return string
 */
function induscity_the_archive_title( $title ) {
	if ( is_search() ) {
		$title = sprintf( esc_html__( 'Search Results', 'induscity' ) );
	} elseif ( is_404() ) {
		$title = sprintf( esc_html__( 'Page Not Found', 'induscity' ) );
	} elseif ( is_page() ) {
		$title = get_the_title();
	} elseif ( is_home() && is_front_page() ) {
		$title = esc_html__( 'The Latest Posts', 'induscity' );
	} elseif ( is_home() && ! is_front_page() ) {
		$title = get_the_title( get_option( 'page_for_posts' ) );
	} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
		$title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
	} elseif ( function_exists( 'is_product' ) && is_product() ) {
		$cats = get_the_terms( get_the_ID(), 'product_cat' );
		if (  ! is_wp_error( $cats ) && $cats ) {
			$title = $cats[0]->name;
		} else {
			$title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
		}
	} elseif ( is_post_type_archive( 'portfolio' ) ) {

		if ( get_option( 'induscity_portfolio_page_id' ) ) {
			$title = get_the_title( get_option( 'induscity_portfolio_page_id' ) );
		} else {
			$title = esc_html__( 'Portfolio', 'induscity' );
		}

	} elseif ( is_post_type_archive( 'service' ) ) {

		if ( get_option( 'induscity_service_page_id' ) ) {
			$title = get_the_title( get_option( 'induscity_service_page_id' ) );
		} else {
			$title = esc_html__( 'Services', 'induscity' );
		}

	} elseif ( is_singular( 'portfolio' ) ) {
		$cats = get_the_terms( get_the_ID(), 'portfolio_category' );
		if ( $cats ) {
			$title = $cats[0]->name;
		} elseif ( get_option( 'induscity_portfolio_page_id' ) ) {
			$title = get_the_title( get_option( 'induscity_portfolio_page_id' ) );
		} else {
			$title = esc_html__( 'Portfolio', 'induscity' );
		}
	} elseif ( is_singular( 'service' ) ) {
		$cats = get_the_terms( get_the_ID(), 'service_category' );
		if ( $cats ) {
			$title = $cats[0]->name;
		} elseif ( get_option( 'induscity_service_page_id' ) ) {
			$title = get_the_title( get_option( 'induscity_service_page_id' ) );
		} else {
			$title = esc_html__( 'Service', 'induscity' );
		}
	} elseif ( is_tax() || is_category() ) {
		$title = single_term_title( '', false );
	} elseif ( is_singular( 'post' ) ) {
		$title = get_the_title( get_the_ID() );
	}

	return $title;
}

add_filter( 'get_the_archive_title', 'induscity_the_archive_title' );

/**
 * Returns CSS for the cursor.
 *
 * @return string cursor CSS.
 */
function induscity_cursor_css( $cursor ) {
	return <<<CSS
	.popular-posts-widget .widget-thumb
	{ cursor: url( $cursor ), auto; }
CSS;
}


/**
 * Returns CSS for the color schemes.
 *
 *
 * @param array $colors Color scheme colors.
 *
 * @return string Color scheme CSS.
 */
function induscity_get_color_scheme_css( $colors ) {
	return <<<CSS
	/* Color Scheme */
	/* Background Color */
	.main-background-color,
	ul.nav-filter li a.active, ul.nav-filter li a:hover,
	.primary-nav > ul.menu > li.mf-active-menu,
	.numeric-navigation .page-numbers:hover,.numeric-navigation .page-numbers.current,
	.project-nav-ajax .numeric-navigation .page-numbers.next:hover,.project-nav-ajax .numeric-navigation .page-numbers.next:focus,
	.primary-mobile-nav .menu-item-button-link a,
	.mf-btn,
	.mf-btn:hover,.mf-btn:focus,.mf-btn:active,
	.mf-heading-primary:after,
	.mf-heading-primary:after,
	.post-author .box-title:after,
	.post-author .box-title:after,
	.single-post .social-share li a:hover,
	.mf-service-banner:before,
	.single-portfolio .single-project-title:after,
	.single-portfolio .single-project-title:after,
	.error404 .site-content:before,
	.comments-title:after,.comment-reply-title:after,
	.comments-title:after,.comment-reply-title:after,
	.comment-respond .form-submit .submit,
	.comment-respond .form-submit .submit:hover,.comment-respond .form-submit .submit:focus,.comment-respond .form-submit .submit:active,
	.widget_tag_cloud a:hover,
	.service-sidebar .download .item-download:hover,
	.woocommerce a.button,.woocommerce button.button,.woocommerce input.button,.woocommerce a.button.alt,.woocommerce button.button.alt,.woocommerce input.button.alt,
	.woocommerce a.button.disabled,.woocommerce button.button.disabled,
	.woocommerce input.button.disabled,.woocommerce a.button.alt.disabled,.woocommerce button.button.alt.disabled,.woocommerce input.button.alt.disabled,
	.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce a.button.alt:hover,.woocommerce button.button.alt:hover,
	.woocommerce input.button.alt:hover,.woocommerce a.button.disabled:hover,
	.woocommerce button.button.disabled:hover,.woocommerce input.button.disabled:hover,.woocommerce a.button.alt.disabled:hover,
	.woocommerce button.button.alt.disabled:hover,.woocommerce input.button.alt.disabled:hover,.woocommerce a.button:focus,.woocommerce button.button:focus,
	.woocommerce input.button:focus,.woocommerce a.button.alt:focus,.woocommerce button.button.alt:focus,
	.woocommerce input.button.alt:focus,.woocommerce a.button.disabled:focus,.woocommerce button.button.disabled:focus,
	.woocommerce input.button.disabled:focus,.woocommerce a.button.alt.disabled:focus,.woocommerce button.button.alt.disabled:focus,.woocommerce input.button.alt.disabled:focus,
	.woocommerce a.button:active,.woocommerce button.button:active,.woocommerce input.button:active,.woocommerce a.button.alt:active,.woocommerce button.button.alt:active,
	.woocommerce input.button.alt:active,.woocommerce a.button.disabled:active,.woocommerce button.button.disabled:active,
	.woocommerce input.button.disabled:active,.woocommerce a.button.alt.disabled:active,
	.woocommerce button.button.alt.disabled:active,.woocommerce input.button.alt.disabled:active,
	.woocommerce .cross-sells h2:after,.woocommerce .up-sells h2:after,.woocommerce .cart_totals h2:after,.woocommerce .woocommerce-billing-fields h3:after,
	.woocommerce #order_review_heading:after,.woocommerce #ship-to-different-address:after,
	.woocommerce .cross-sells h2:after,.woocommerce .up-sells h2:after,.woocommerce .cart_totals h2:after,.woocommerce .woocommerce-billing-fields h3:after,
	.woocommerce #order_review_heading:after,.woocommerce #ship-to-different-address:after,
	.woocommerce div.product #reviews #review_form .comment-form .form-submit input.submit,
	.woocommerce div.product #reviews #review_form .comment-form .form-submit input.submit:hover,
	.woocommerce div.product #reviews #review_form .comment-form .form-submit input.submit:focus,
	.woocommerce div.product #reviews #review_form .comment-form .form-submit input.submit:active,
	.woocommerce ul.products li.product .woocommerce-loop-product__link .product-icon,
	.woocommerce ul.products li.product .button:hover:after,
	.woocommerce .widget_product_tag_cloud a:hover,
	.woocommerce .widget_price_filter .ui-slider .ui-slider-handle:before,
	.woocommerce nav.woocommerce-pagination ul .page-numbers:hover,.woocommerce nav.woocommerce-pagination ul .page-numbers.current,
	.footer-widgets .widget-title:after,
	.footer-widgets .widget-title:after,
	.footer-widgets ul li:hover:before,
	.footer-social a:hover,
	.owl-nav div:hover,
	.owl-dots .owl-dot.active span,.owl-dots .owl-dot:hover span,
	.induscity-office-location-widget .office-switcher,
	.induscity-office-location-widget .office-switcher ul,
	.mf-section-title h2:after,
	.mf-icon-box.icon_style-has-background-color:hover .mf-icon,
	.mf-services-2 .mf-icon,
	.mf-services-2.style-2 .service-title:before,
	.mf-portfolio ul.nav-filter.dark li a.active, .mf-portfolio ul.nav-filter.dark li a:hover,
	.mf-portfolio.style-2 .owl-nav div:hover,
	.mf-portfolio .owl-nav div:hover,
	.mf-testimonial.style-1 .desc,
	.mf-testimonial.style-2 .testimonial-info:hover .desc,
	.mf-pricing .pricing-content a:hover,
	.mf-history .date:before,
	.mf-contact-box .contact-social li:hover a,
	.wpcf7-form input[type="submit"],
	.wpcf7-form input[type="submit"]:hover,.wpcf7-form input[type="submit"]:focus,.wpcf7-form input[type="submit"]:active,
	.mf-list li:before,
	.vc_progress_bar.vc_progress-bar-color-custom .vc_single_bar .vc_bar,
	.induscity-arrow:hover,
	.slick-prev:hover, .slick-prev:focus,
	.slick-next:hover, .slick-next:focus,
	.mf-team .team-member ul li,
	.slick-dots li.slick-active button:before,
	.slick-dots li button:hover:before,
	.mf-icon-box.icon_position-top-left.style-2 .box-wrapper:hover .box-title a:after,
	.mf-icon-box.icon_position-top-left.style-2 .box-wrapper:hover .box-title span:after
	{background-color: $colors}

	/* Color */
	blockquote cite,
	blockquote cite span,
	.main-color,
	.header-transparent.header-v2 .site-extra-text .induscity-social-links-widget a:hover,
	.site-extra-text .header-contact i,
	.site-extra-text .induscity-social-links-widget a:hover,
	.main-nav ul.menu > li.current-menu-item > a,.main-nav ul.menu > li.current-menu-parent > a,.main-nav ul.menu > li.current-menu-ancestor > a,.main-nav ul.menu > li:hover > a,
	.main-nav div.menu > ul > li.current_page_item > a,.main-nav div.menu > ul > li:hover > a,
	.header-v3 .main-nav ul.menu > li.current-menu-item > a,.header-v3 .main-nav ul.menu > li.current-menu-parent > a,.header-v3 .main-nav ul.menu > li.current-menu-ancestor > a,.header-v3 .main-nav ul.menu > li:hover > a,
	.header-v4 .main-nav ul.menu > li.current-menu-item > a,.header-v4 .main-nav ul.menu > li.current-menu-parent > a,.header-v4 .main-nav ul.menu > li.current-menu-ancestor > a,.header-v4 .main-nav ul.menu > li:hover > a,
	.post-navigation a:hover,
	.portfolio-navigation .nav-previous a:hover,.portfolio-navigation .nav-next a:hover,
	.project-nav-ajax .numeric-navigation .page-numbers.next,
	.project-nav-ajax .numeric-navigation .page-numbers.next span,
	.primary-mobile-nav ul.menu li.current-menu-item > a,
	.entry-meta a:hover,
	.entry-title:hover a,
	.entry-footer .read-more:hover,
	.entry-footer .read-more:hover i,
	.blog-wrapper.sticky .entry-title:before,
	.service-inner:hover .service-title a,
	.single-portfolio .project-socials a:hover,
	.portfolio-metas i,
	.comment .comment-reply-link:hover,
	.widget_categories a:hover, .widget_recent_comments a:hover, .widget_rss a:hover, .widget_pages a:hover, .widget_archive a:hover, .widget_nav_menu a:hover, .widget_recent_entries a:hover, .widget_meta a:hover, .widget-recent-comments a:hover, .courses-categories-widget a:hover,
	.popular-posts-widget .mini-widget-title h4:hover a,
	.widget-about a:hover,
	.service-sidebar .services-menu-widget li:hover a,.service-sidebar .services-menu-widget li.current-menu-item a,
	.service-sidebar .mf-team-contact i,
	.woocommerce .quantity .increase:hover,.woocommerce .quantity .decrease:hover,
	.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
	.woocommerce ul.products li.product .button:hover,
	.woocommerce ul.products li.product .added_to_cart:hover,
	.woocommerce table.shop_table td.product-subtotal,
	.woocommerce .widget_product_categories li:hover,
	.woocommerce .widget_product_categories li:hover > a,
	.woocommerce .widget_top_rated_products ul.product_list_widget li a:hover,
	.woocommerce .widget_recent_reviews ul.product_list_widget li a:hover,
	.woocommerce .widget_products ul.product_list_widget li a:hover,
	.woocommerce .widget_recently_viewed_products ul.product_list_widget li a:hover,
	.woocommerce-checkout #payment .payment_method_paypal .about_paypal,
	.woocommerce-checkout .woocommerce-info a,
	.woocommerce-account .woocommerce-MyAccount-navigation ul li:hover a,.woocommerce-account .woocommerce-MyAccount-navigation ul li.is-active a,
	.site-footer .footer-copyright a,
	.footer-widgets ul li:hover > a,
	.footer-widgets .footer-widget-contact .detail i,
	.page-header.has-image h1,
	.page-header.has-image .breadcrumbs,
	.topbar .induscity-social-links-widget a:hover,
	.induscity-office-location-widget .topbar-office li i,
	.mf-services-2 .service-summary > a:hover,
	.mf-services-2 h4:hover a,
	.mf-services-2.style-1 .btn-service-2:hover i,
	.mf-services-2.style-3 .btn-service-2:hover i,
	.mf-services-3.style-1 .vc_service-wrapper:hover i,
	.mf-services-3.style-1 .vc_service-wrapper.featured-box i,
	.mf-services-3.style-1 .on-hover .vc_service-wrapper.featured-box.active i,
	.mf-portfolio.light-version .project-inner:hover .cat-portfolio,
	.mf-portfolio.style-3 .project-title a:hover,
	.mf-testimonial.style-3 .testimonial-avatar .testi-icon,
	.mf-testimonial.style-3 .address,
	.mf-testimonial.style-3 .owl-nav div:hover,
	.mf-testimonial.style-4 .address,
	.mf-counter .mf-icon,
	.mf-counter .counter-content .counter,
	.mf-contact-box .contact-info i,
	.mf-department .department-info i,
	.wpb-js-composer div .vc_tta.vc_tta-accordion .vc_tta-panel.vc_active .vc_tta-panel-title > a,
	.wpb-js-composer div .vc_tta.vc_tta-accordion .vc_tta-panel:hover .vc_tta-panel-title > a,
	.wpb-js-composer div .vc_tta.vc_tta-accordion .vc_tta-panel.vc_active .vc_tta-controls-icon.vc_tta-controls-icon-chevron:after,
	.wpb-js-composer div .vc_tta.vc_tta-accordion .vc_tta-panel:hover .vc_tta-controls-icon.vc_tta-controls-icon-chevron:after,
	.wpb-js-composer div .vc_tta-tabs-position-top.vc_tta-color-white.vc_tta-style-classic .vc_tta-tab.vc_active > a,
	.wpb-js-composer div .vc_tta-tabs-position-top.vc_tta-color-white.vc_tta-style-classic .vc_tta-tab:hover > a,
	.induscity-arrow-2:hover .fa,
	.primary-mobile-nav ul.menu li.current_page_parent > a,
	.primary-mobile-nav ul.menu li.current-menu-item > a,
	.primary-mobile-nav ul.menu li.current-menu-ancestor > a,
	.primary-mobile-nav ul.menu li.current-menu-parent > a,
	.primary-mobile-nav ul.menu li > a:hover,
	.mf-services.color_scheme-light .service-inner .service-summary .service-icon-1,
	.mf-services.color_scheme-light .service-inner:hover .service-summary h2 a,
	.mf-services.color_scheme-light .service-inner:hover .service-summary h2 span,
	.sticky .blog-wrapper .entry-title:before
	{color: $colors}

	.woocommerce table.shop_table a.remove:hover
	{color: $colors !important;}

	/* Border */
	ul.nav-filter li a.active, ul.nav-filter li a:hover,
	.numeric-navigation .page-numbers:hover,.numeric-navigation .page-numbers.current,
	.project-nav-ajax .numeric-navigation .page-numbers.next:hover,.project-nav-ajax .numeric-navigation .page-numbers.next:focus,
	.single-post .social-share li a:hover,
	.widget_tag_cloud a:hover,
	.woocommerce .widget_product_tag_cloud a:hover,
	.woocommerce nav.woocommerce-pagination ul .page-numbers:hover,.woocommerce nav.woocommerce-pagination ul .page-numbers.current,
	.footer-social a:hover,
	.owl-nav div:hover,
	.mf-portfolio ul.nav-filter.dark li a.active, .mf-portfolio ul.nav-filter.dark li a:hover,
	.mf-testimonial.style-3 .owl-nav div:hover,
	.mf-contact-box .contact-social li:hover a,
	.owl-dots .owl-dot span,
	.service-inner:before,
	.project-inner:before,
	.mf-testimonial.style-3 .testimonial-avatar .testi-icon,
	.slick-prev:hover, .slick-prev:focus,
	.slick-next:hover, .slick-next:focus,
	.slick-dots li button:before
	{border-color: $colors}

	/* Border Bottom */
	.mf-testimonial.style-1 .desc:before,
	.mf-testimonial.style-2 .testimonial-info:hover .desc:before
	{border-bottom-color: $colors}

	/* Border Left */
	.woocommerce-checkout .woocommerce-info,
	.woocommerce .widget_product_categories ul,
	.widget_categories ul, .widget_recent_comments ul,
	.widget_rss ul,
	.widget_pages ul,
	.widget_archive ul,
	.widget_nav_menu ul,
	.widget_recent_entries ul,
	.widget_meta ul,
	.widget-recent-comments ul,
	.courses-categories-widget ul
	{border-left-color: $colors}

CSS;
}

if ( ! function_exists( 'induscity_typography_css' ) ) :
	/**
	 * Get typography CSS base on settings
	 *
	 * @since 1.1.6
	 */
	function induscity_typography_css() {
		$css        = '';
		$properties = array(
			'font-family'    => 'font-family',
			'font-size'      => 'font-size',
			'variant'        => 'font-weight',
			'line-height'    => 'line-height',
			'letter-spacing' => 'letter-spacing',
			'color'          => 'color',
			'text-transform' => 'text-transform',
			'text-align'     => 'text-align',
		);

		$settings = array(
			'body_typo'              => 'body',
			'heading1_typo'          => 'h1',
			'heading2_typo'          => 'h2',
			'heading3_typo'          => 'h3',
			'heading4_typo'          => 'h4',
			'heading5_typo'          => 'h5',
			'heading6_typo'          => 'h6',
			'menu_typo'              => '.main-nav a, .mf-header-item-button a, .primary-mobile-nav ul.menu > li > a',
			'sub_menu_typo'          => '.main-nav li li a, .primary-mobile-nav ul.menu ul li a',
			'footer_text_typo'       => '.site-footer',
		);

		foreach ( $settings as $setting => $selector ) {
			$typography = induscity_get_option( $setting );
			$default    = (array) induscity_get_option_default( $setting );
			$style      = '';

			foreach ( $properties as $key => $property ) {
				if ( isset( $typography[$key] ) && ! empty( $typography[$key] ) ) {
					if ( isset( $default[$key] ) && strtoupper( $default[$key] ) == strtoupper( $typography[$key] ) ) {
						continue;
					}

					$value = 'font-family' == $key ? '"' . rtrim( trim( $typography[ $key ] ), ',' ) . '"' : $typography[$key];
					$value = 'variant' == $key ? str_replace( 'regular', '400', $value ) : $value;

					if ( $value ) {
						$style .= $property . ': ' . $value . ';';
					}
				}
			}

			if ( ! empty( $style ) ) {
				$css .= $selector . '{' . $style . '}';
			}
		}

		return $css;
	}
endif;

/**
 * Returns CSS for the typography.
 *
 * @return string typography CSS.
 */
function induscity_get_heading_typography_css() {

	$headings   = array(
		'h1' => 'heading1_typo',
		'h2' => 'heading2_typo',
		'h3' => 'heading3_typo',
		'h4' => 'heading4_typo',
		'h5' => 'heading5_typo',
		'h6' => 'heading6_typo'
	);
	$inline_css = '';
	foreach ( $headings as $heading ) {
		$keys = array_keys( $headings, $heading );
		if ( $keys ) {
			$inline_css .= induscity_get_heading_font( $keys[0], $heading );
		}
	}

	return $inline_css;

}

/**
 * Returns CSS for the typography.
 *
 *
 * @param array $body_typo Color scheme body typography.
 *
 * @return string typography CSS.
 */
function induscity_get_heading_font( $key, $heading ) {

	$inline_css   = '';
	$heading_typo = induscity_get_option( $heading );

	if ( $heading_typo ) {
		if ( isset( $heading_typo['font-family'] ) && strtolower( $heading_typo['font-family'] ) !== 'hind' ) {
			$inline_css .= $key . '{font-family:' . rtrim( trim( $heading_typo['font-family'] ), ',' ) . ', Arial, sans-serif}';
		}
	}

	if ( empty( $inline_css ) ) {
		return;
	}

	return <<<CSS
	{$inline_css}
CSS;
}