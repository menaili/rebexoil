<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Induscity
 */

get_header();

$css = 'list-portfolio';

if ( induscity_get_option( 'portfolio_style' ) != 'without-space' ) {
	$css .= ' row';
}

?>

<div id="primary" class="content-area all-project <?php induscity_content_columns(); ?>">
	<main id="main" class="site-main">
		<div class="<?php echo esc_attr( $css ) ?>">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				/* Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'parts/content', 'portfolio' );
				?>

			<?php endwhile; ?>

			<?php induscity_numeric_pagination(); ?>

		<?php else : ?>

			<?php get_template_part( 'parts/content', 'none' ); ?>

		<?php endif; ?>

		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
