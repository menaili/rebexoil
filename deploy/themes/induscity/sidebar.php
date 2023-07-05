<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Induscity
 */
if ( 'full-content' == induscity_get_layout() ) {
	return;
}

$col = 'col-md-4 mf-widget-col-4';

if ( induscity_is_catalog() || (function_exists('is_product') && is_product()) ) {
	$col = 'col-md-3';
}

$sidebar = 'blog-sidebar';

if( is_page() ) {
	$sidebar = 'page-sidebar';
} elseif ( induscity_is_catalog() || (function_exists('is_product') && is_product()) ) {
	$sidebar = 'shop-sidebar';
} elseif ( induscity_is_service() || is_singular( 'service' ) ) {
	$sidebar = 'service-sidebar';
}

?>
<aside id="primary-sidebar" class="widgets-area primary-sidebar <?php echo esc_attr( $sidebar ) ?> col-xs-12 col-sm-12 <?php echo esc_attr( $col ) ?>">
	<div class="induscity-widget">
		<?php
		if (is_active_sidebar($sidebar)) {
			dynamic_sidebar($sidebar);
		}
		?>
	</div>
</aside><!-- #secondary -->
