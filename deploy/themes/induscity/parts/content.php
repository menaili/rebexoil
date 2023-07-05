<?php
/**
 * @package Induscity
 */
global $mf_post;

$size = 'induscity-blog-thumb';

$css_class = '';

$excerpt_length = intval( induscity_get_option( 'blog_classic_excerpt_length' ) );

if ( 'grid' == induscity_get_option( 'blog_view' ) ) {
	$size = 'induscity-blog-grid-thumb';
	$css_class = 'col-xs-12 col-sm-12';

	if ( induscity_get_option( 'blog_grid_columns' ) == '2' ) {
		$css_class .= ' blog-wrapper-col-2 col-md-6';
	} else {
		if ( 'full-content' == induscity_get_layout() ) {
			$css_class .= ' blog-wrapper-col-3 col-md-4';
		} else {
			$css_class .= ' blog-wrapper-col-2 col-md-6';
		}
	}

	$excerpt_length = intval( induscity_get_option( 'blog_grid_excerpt_length' ) );
}

if ( isset($mf_post['css']) ) {
	$css_class .= $mf_post['css'];
}

if ( isset($mf_post['excerpt_length']) ) {
	$excerpt_length = $mf_post['excerpt_length'];
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $css_class ); ?>>
	<div class="blog-wrapper">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="entry-thumbnail">
				<a href="<?php the_permalink() ?>"><span class="mf-icon"><i class="fa fa-link"></i></span><?php the_post_thumbnail( $size ) ?></a>
			</div>
		<?php endif; ?>
		<header class="entry-header">
			<div class="entry-meta">
				<?php induscity_entry_meta() ?>
			</div><!-- .entry-meta -->
			<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
		</header><!-- .entry-header -->

		<div class="entry-content clearfix">
			<?php induscity_content_limit( $excerpt_length, '', true ); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer clearfix">
			<a href="<?php the_permalink() ?>" class="read-more"><?php echo apply_filters( 'induscity_blog_read_more_text', esc_html__( 'Read More', 'induscity' ) ); ?><i class="fa fa-chevron-right"></i></a>
			<?php
			if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
				echo '<span class="comments-link"><i class="flaticon-interface"></i>';
				comments_number( esc_html__( 'Comment: 0', 'induscity' ), esc_html__( ' Comment: 1', 'induscity' ), esc_html__( ' Comments: %', 'induscity' ) );
				echo '</span>';
			}
			?>
		</footer>
	</div>
</article><!-- #post-## -->
