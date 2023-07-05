<?php
/**
 * @package Induscity
 */
global $mf_post;

$size = 'induscity-blog-thumb';

$excerpt_length = intval( induscity_get_option( 'blog_classic_excerpt_length' ) );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'search-wrapper' ); ?>>
	<div class="blog-wrapper">
		<div class="entry-thumbnail">
			<a href="<?php the_permalink() ?>"><span class="mf-icon"><i class="fa fa-link"></i></span><?php the_post_thumbnail( $size ) ?></a>
		</div>
		<header class="entry-header">
			<div class="entry-meta">
				<?php induscity_entry_meta() ?>
			</div><!-- .entry-meta -->
			<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_excerpt(); ?>
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
