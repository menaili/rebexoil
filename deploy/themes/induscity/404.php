<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Induscity
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( '404', 'induscity' ); ?></h1>
					<p class="line-1"><?php esc_html_e( 'OOPPS! THE PAGE YOU WERE LOOKING FOR, COULDN\'T BE FOUND.', 'induscity' ); ?></p>
					<p class="line-2"><?php esc_html_e( 'Try the search below to find matching pages:', 'induscity' ); ?></p>
				</header><!-- .page-header -->

				<div class="page-content">
					<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<label>
							<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'induscity' ) ?></span>
							<input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search...', 'induscity' ) ?>" value="" name="s">
						</label>
						<input type="submit" class="search-submit" value="<?php esc_attr_e( 'Search', 'induscity' ) ?>">
					</form>

					<div class="back-home">
						<a href="<?php echo esc_url( home_url( '/' ) ) ?>"><?php esc_html_e( 'Back to Home Page', 'induscity' ) ?></a>
					</div>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
