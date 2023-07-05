<?php

/**
 * Class for all WooCommerce template modification
 *
 * @version 1.0
 */
class Induscity_WooCommerce {
	/**
	 * @var string Layout of current page
	 */
	public $layout;

	public $new_duration;

	/**
	 * Construction function
	 *
	 * @since  1.0
	 * @return Induscity_WooCommerce
	 */
	function __construct() {
		// Check if Woocomerce plugin is actived
		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			return false;
		}

		// Define all hook
		add_action( 'template_redirect', array( $this, 'hooks' ) );

		//Need an early hook to ajaxify update mini shop cart
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'add_to_cart_fragments' ) );
	}

	/**
	 * Hooks to WooCommerce actions, filters
	 *
	 * @since  1.0
	 * @return void
	 */
	function hooks() {
		$this->layout       = induscity_get_layout();

		$this->new_duration = induscity_get_option( 'product_newness' );

		// WooCommerce Styles
		add_filter( 'woocommerce_enqueue_styles', array( $this, 'wc_styles' ) );

		// Add Bootstrap classes
		add_filter( 'post_class', array( $this, 'product_class' ), 30, 3 );
		add_filter( 'product_cat_class', array( $this, 'cat_class' ), 30, 3 );

		// Change shop columns


		// Related cross-sell and upsells columns
		add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products' ) );
		add_filter( 'woocommerce_upsell_display_args', array( $this, 'related_products' ) );
		add_filter( 'woocommerce_cross_sells_columns', array( $this, 'cross_sell_columns' ) );


		// Remove breadcrumb, use theme's instead
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

		// Add badges
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash' );

		// Add/Remove single prosuct
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

		// Add toolbars for shop page
		add_filter( 'woocommerce_show_page_title', '__return_false' );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
		add_action( 'woocommerce_before_shop_loop', array( $this, 'shop_toolbar' ) );

		// Add badges
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash' );
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'product_ribbons' ) );
		add_action( 'woocommerce_before_single_product_summary', array( $this, 'product_ribbons' ), 7 );

		// Change product link position
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 20 );

		// Add product icon
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'show_product_loop_icon' ), 15 );

		// Add link to product title in shop loop
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );
		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'show_product_loop_title' ) );

		// Change next and prev text
		add_filter( 'woocommerce_pagination_args', array( $this, 'pagination_args' ) );

		// Change placeholder woocommerce form
		add_filter( 'woocommerce_form_field_args', array( $this, 'woo_form_args' ) );

		// Rating Product
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 15 );

		// Wrap product
		add_action( 'woocommerce_before_shop_loop_item', array( $this, 'open_loop_product_wrapper' ), 5 );
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'close_loop_product_wrapper' ), 30 );

		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'open_loop_product_info' ), 20 );
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'close_loop_product_info' ), 25 );

		add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'open_loop_product_footer' ), 20 );
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'close_loop_product_footer' ), 20 );
	}


	/**
	 * Ajaxify update cart viewer
	 *
	 * @since 1.0
	 *
	 * @param array $fragments
	 *
	 * @return array
	 */
	function add_to_cart_fragments( $fragments ) {
		global $woocommerce;

		if ( empty( $woocommerce ) ) {
			return $fragments;
		}

		ob_start();
		?>

		<a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ) ?>" class="cart-contents" id="icon-cart-contents">
			<i class="t-icon fa fa-shopping-cart"></i>
			<span class="mini-cart-counter"><?php echo intval( $woocommerce->cart->cart_contents_count ) ?></span>
		</a>

		<?php
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}


	/**
	 * Remove default woocommerce styles
	 *
	 * @since  1.0
	 *
	 * @param  array $styles
	 *
	 * @return array
	 */
	function wc_styles( $styles ) {
		unset( $styles['woocommerce-layout'] );
		unset( $styles['woocommerce-smallscreen'] );

		return $styles;
	}



	/**
	 * Change related products args to display in correct grid
	 *
	 * @param  array $args
	 *
	 * @return array
	 */
	function related_products( $args ) {
		$columns = intval( induscity_get_option( 'related_product_columns' ) );

		if ( $this->layout != 'full-content' ) {
			$columns = 3;
		}

		$args['posts_per_page'] = intval( induscity_get_option( 'related_product_numbers' ) );;
		$args['columns'] = $columns;

		return $args;
	}

	/**
	 * Change cross sell product columns
	 *
	 * @return int
	 */
	public function cross_sell_columns() {
		$columns = intval( induscity_get_option( 'shop_columns' ) );

		if ( $this->layout != 'full-content' ) {
			$columns = 3;
		}

		return $columns;
	}

	/**
	 * Add Bootstrap's column classes for product
	 *
	 * @since 1.0
	 *
	 * @param array  $classes
	 * @param string $class
	 * @param string $post_id
	 *
	 * @return array
	 */
	function product_class( $classes, $class = '', $post_id = '' ) {
		if ( ! $post_id || get_post_type( $post_id ) !== 'product' || is_single( $post_id ) ) {
			return $classes;
		}
		global $woocommerce_loop;

		$classes[] = 'col-sm-6 col-xs-12';
		$classes[] = 'col-md-' . ( 12 / $woocommerce_loop['columns'] );
		$classes[] = 'col-' . $woocommerce_loop['columns'];

		return $classes;
	}

	function cat_class( $classes ) {
		global $woocommerce_loop;

		if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
			$classes[] = 'col-sm-6 col-xs-6';
			$classes[] = 'col-md-' . (12 / $woocommerce_loop['columns']);
		}

		return $classes;
	}

	/**
	 * Change next and previous icon of pagination nav
	 *
	 * @since  1.0
	 */
	function pagination_args( $args ) {
		$args['prev_text'] = '<i class="fa fa-caret-left"></i>';
		$args['next_text'] = '<i class="fa fa-caret-right"></i>';

		return $args;
	}

	/**
	 * Open product wrapper
	 */
	public function open_loop_product_wrapper() {
		?><div class="product-inner"><?php
	}

	/**
	 * Close product wrapper
	 */
	public function close_loop_product_wrapper() {
		?></div><?php
	}

	/**
	 * Open product info
	 */
	public function open_loop_product_info() {
		?><div class="product-info"><?php
	}

	/**
	 * Close product info
	 */
	public function close_loop_product_info() {
		?></div><?php
	}

	/**
	 * Open Group title and rating
	 */
	public function open_loop_product_footer() {
		?><div class="product-footer"><?php
	}

	/**
	 * Close Group title and rating
	 */
	public function close_loop_product_footer() {
		?></div><?php
	}

	/**
	 * Print new product title shop page with link inside
	 */
	function show_product_loop_title() {
		?><h4><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4><?php
	}

	/**
	 * Print new product title shop page with link inside
	 */
	function show_product_loop_icon() {
		?><span class="product-icon"><i class="fa fa-link"></i></span><?php
	}

	/**
	 * Display badge for new product or featured product
	 *
	 * @since 1.0
	 */
	public function product_ribbons() {
		if ( !intval( induscity_get_option( 'shop_ribbons' ) ) ) {
			return;
		}

		global $product;

		$output = array();

		$stock_status = '';

		if ( method_exists( $product, 'get_stock_status' ) ) {
			$stock_status = $product->get_stock_status();
		} else {
			$stock_status = $product->stock_status;
		}

		if ( $stock_status == 'outofstock' ) {
			$output[] = '<span class="out-of-stock ribbon">' . esc_html__( 'Out Of Stock', 'induscity' ) . '</span>';
		}

		if ( $product->is_on_sale() ) {
			$output[] = '<span class="onsale ribbon">' . esc_html__( 'Sale', 'induscity' ) . '</span>';
		}

		if ( $product->is_featured() ) {
			$output[] = '<span class="featured ribbon">' . esc_html__( 'Hot', 'induscity' ) . '</span>';
		}

		if ( ( time() - ( 60 * 60 * 24 * $this->new_duration ) ) < strtotime( get_the_time( 'Y-m-d' ) ) ) {
			$output[] = '<span class="newness ribbon">' . esc_html__( 'New', 'induscity' ) . '</span>';
		}

		if ( $output ) {
			printf( '<span class="ribbons">%s</span>', implode( '', $output ) );
		}
	}

	/**
	 * Display a tool bar on top of product archive
	 *
	 * @since 1.0
	 */
	function shop_toolbar() {
		?>

		<div class="shop-toolbar">
			<div class="row">
				<div class="toolbar-col-left col-xs-12 col-sm-6">
					<?php if ( $relsult_count = woocommerce_result_count() ) : ?>
						<span class="woo-character">(</span><?php $relsult_count ?><span class="woo-character">)</span>
					<?php endif; ?>
				</div>

				<div class="toolbar-col-right col-xs-12 col-sm-6 text-right">
					<?php woocommerce_catalog_ordering() ?>
				</div>
			</div>
		</div>

		<?php
	}

	function woo_form_args( $args ) {
		$args['placeholder'] = $args['label'];

		return $args;
	}
}

