<?php
/**
 * @package Induscity
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-wrapper' ); ?>>
	<header class="entry-header">
		<div class="entry-thumbnail"><?php induscity_entry_thumbnail( 'full' ) ?></div>

		<div class="entry-meta">
			<?php induscity_entry_meta( true ) ?>
		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

	<div class="entry-content clearfix">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'induscity' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php induscity_entry_footer(); ?>
</article><!-- #post-## -->
