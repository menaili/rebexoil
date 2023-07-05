<?php
/**
 * @package Induscity
 */
$page_header = induscity_get_page_header_image();

if ( ! $page_header ) {
	return;
}

$css_item    = 'hide-title';
$breadcrumbs = false;
if ( isset( $page_header['elements'] ) && $page_header['elements'] ) {
	$els = $page_header['elements'];

	if ( in_array( 'title', $els ) ) {
		$css_item = '';
	}

	if ( in_array( 'breadcrumb', $els ) ) {
		$breadcrumbs = true;
	}
}

if ( isset( $page_header['parallax'] ) && $page_header['parallax'] ) {
	$css_item .= ' parallax';
}


if ( isset( $page_header['bg_image'] ) && $page_header['bg_image'] ) {
	$css_item .= ' has-image';
}

?>
<div class="page-header <?php echo esc_attr( $css_item ); ?>">
	<div class="page-header-content">
		<?php if ( isset( $page_header['bg_image'] ) && $page_header['bg_image'] ) {
            echo sprintf( '<div class="featured-image" style="background-image: url(%s)"></div>', esc_url( $page_header['bg_image'] ) );
        } ?>
		<div class="container">
			<?php
			the_archive_title( '<h1>', '</h1>' );

			if ( $breadcrumbs ) {
				induscity_get_breadcrumbs();
			}
			?>

		</div>
	</div>
</div>