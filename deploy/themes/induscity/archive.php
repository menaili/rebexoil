<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Induscity
 */

get_header();

$blog_view = induscity_get_option( 'blog_view' );
?>

	<div id="primary" class="content-area <?php induscity_content_columns(); ?>">
		<main id="main" class="site-main">

		<?php if ( $blog_view == 'grid' ) : ?>
			<div class="row">
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'parts/content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php induscity_numeric_pagination(); ?>

		<?php else : ?>

			<?php get_template_part( 'parts/content', 'none' ); ?>

		<?php endif; ?>

		<?php if ( $blog_view == 'grid' ) : ?>
			</div>
		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
