<?php
/**
 * @package Induscity
 */

$columns = induscity_get_option( 'service_columns' );
if ( '3' == $columns ) {
	$css_class = 'col-3 col-xs-12 col-md-4 col-sm-6';
} else {
	$css_class = 'col-2 col-xs-12 col-md-6 col-sm-6';
}

if ( ! has_post_thumbnail() ) {
	$css_class .= ' no-thumb';
}

$icon = get_post_meta( get_the_ID(), 'service_icon', true );

if ( ! $icon ) {
	$css_class .= ' no-icon';
}

?>
<div id="post-<?php the_ID(); ?>" <?php post_class( $css_class ); ?>>
	<div class="service-inner">
		<?php if ( has_post_thumbnail() ) : ?>
		<div class="service-thumbnail">
			<a href="<?php the_permalink() ?>" class="pro-link"><i class="fa fa-link"></i></a>
			<?php the_post_thumbnail( 'induscity-service-thumbnail' ) ?>
		</div>
		<?php endif; ?>
		<div class="service-summary">
			<?php if ( $icon ) : ?>
				<span class="service-icon service-icon-1"><?php echo wp_kses( $icon, wp_kses_allowed_html( 'post' ) ); ?></span>
				<span class="service-icon service-icon-2"><?php echo wp_kses( $icon, wp_kses_allowed_html( 'post' ) ); ?></span>
			<?php endif; ?>
			<div class="service-content">
				<h2 class="service-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
				<div class="service-excerpt"><?php the_excerpt(); ?></div>
			</div>
		</div>
	</div>
</div>
