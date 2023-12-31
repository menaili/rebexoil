<?php
/**
 * Custom functions for nav menu
 *
 * @package Induscity
 */


/**
 * Display numeric pagination
 *
 * @since 1.0
 * @return void
 */
function induscity_numeric_pagination() {
	global $wp_query;

	if( $wp_query->max_num_pages < 2 ) {
        return;
	}

	?>
	<nav class="navigation paging-navigation numeric-navigation">
		<?php
		$big = 999999999;
		$args = array(
			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'total'     => $wp_query->max_num_pages,
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'prev_text' => '<i class="fa fa-caret-left" aria-hidden="true"></i>',
			'next_text' => '<i class="fa fa-caret-right" aria-hidden="true"></i>',
			'type'      => 'plain',
		);

		if ( is_post_type_archive( 'project' ) && 'ajax' == induscity_get_option( 'project_nav_type' ) ) :
			$args['prev_text'] = '';
			$args['next_text'] = sprintf( '<span class="load-more">%s</span><span class="induscity-loading">%s</span>', esc_html__( 'Load More', 'induscity' ),esc_html__( 'Loading', 'induscity' ) );
		endif;

		echo paginate_links( $args );
		?>
	</nav>
<?php
}

/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since 1.0
 * @return void
 */
function induscity_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation">
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
				<div class="nav-previous"><?php next_posts_link( wp_kses_post( esc_html__( '<span class="meta-nav">&larr;</span> Older posts', 'induscity' ) ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
				<div class="nav-next"><?php previous_posts_link( wp_kses_post( esc_html__( 'Newer posts <span class="meta-nav">&rarr;</span>', 'induscity' ) ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
<?php
}


/**
 * Display navigation to next/previous post when applicable.
 *
 * @since 1.0
 * @return void
 */
function induscity_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation">
		<div class="nav-links">
			<?php
			previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav"><i class="fa fa-chevron-left" aria-hidden="true"></i></span>' . esc_html__( 'Prev', 'induscity' ), 'Previous post link', 'induscity' ) );
			next_post_link(     '<div class="nav-next">%link</div>',     _x( esc_html__( 'Next', 'induscity' ) . '<span class="meta-nav"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>', 'Next post link', 'induscity' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
<?php
}

function induscity_portfolio_nav( $post_tyle ) {
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation portfolio-navigation" >
		<div class="container">
			<div class="nav-links clearfix">
				<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav left"><i class="fa fa-chevron-left" aria-hidden="true"></i></span>' . esc_html__( 'Prev', 'induscity' ), 'Previous post link', 'induscity' ) );
				?>
				<a class="portfolio-link" href="<?php echo esc_url( get_post_type_archive_link( $post_tyle ) ) ?>"><i class="fa fa-th" aria-hidden="true"></i></a>
				<?php
				next_post_link(     '<div class="nav-next">%link</div>',     _x( esc_html__( 'Next', 'induscity' ) . '<span class="meta-nav right"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>', 'Next post link', 'induscity' ) );
				?>
			</div><!-- .nav-links -->
		</div>
	</nav><!-- .navigation -->
	<?php
}
