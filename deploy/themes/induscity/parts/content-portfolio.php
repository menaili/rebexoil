<?php
/**
 * @package Induscity
 */

global $mf_loop_portfolio;

$size = 'induscity-portfolio-thumbnail';

$columns = induscity_get_option( 'portfolio_columns' );

$col = 12 / intval($columns);

$class = 'project-wrapper col-sm-6 col-xs-12 col-md-' . $col . ' col-' . intval($columns);

$cats = get_the_terms( get_the_ID(), 'portfolio_category' );

$title_length = intval( induscity_get_option( 'portfolio_title_length' ) );

if ( isset( $mf_loop_portfolio['size'] ) ) {
	$size = $mf_loop_portfolio['size'];
}

if ( isset( $mf_loop_portfolio['css'] ) ) {
	$class = $mf_loop_portfolio['css'];
}

if ( ! is_wp_error( $cats ) &&  $cats ) {
	foreach ( $cats as $cat ) {
		$class .= ' portfolio_id-' . $cat->term_id;
	}
}

?>
<div id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
	<div class="project-inner">
		<div class="project-thumbnail">
			<?php the_post_thumbnail( $size ) ?>
			<a href="<?php the_permalink() ?>" class="pro-link"><span class="mf-portfolio-icon"><i class="flaticon-multimedia"></i></span></a>
		</div>
		<div class="project-summary">
			<?php if ( induscity_get_option( 'portfolio_style' ) == 'modern' ) : ?>
				<h2 class="project-title"><a href="<?php the_permalink() ?>"><?php echo wp_trim_words( get_the_title(), $title_length ); ?></a></h2>
			<?php else : ?>
				<h2 class="project-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
			<?php endif; ?>

			<?php
			if ( ! is_wp_error( $cats ) && $cats ) {
				$cat_name = $cats[0]->name;
				$cat_url = get_term_link($cats[0]->term_id, 'portfolio_category');
				echo '<a class="cat-portfolio" href="' . esc_url($cat_url) . '">' . esc_html( $cat_name ) . '</a>';
			}
			?>
		</div>
	</div>
</div><!-- #project-## -->
