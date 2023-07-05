<?php
/**
 * Template for displaying single projects
 *
 * @package TA Project
 */

$size = 'induscity-portfolio-single';
$owl_css = '';
$client = get_post_meta( get_the_ID(), 'client', true );
$date = get_post_meta( get_the_ID(), 'date', true );
$rating = get_post_meta( get_the_ID(), 'rating', true );
$website = get_post_meta( get_the_ID(), 'website', true );
$gallery = get_post_meta( get_the_ID(), 'images', false );

if ( $gallery ) {
	$owl_css = 'portfolio-gallery owl-carousel';
}

get_header(); ?>

	<div id="primary" class="content-area <?php induscity_content_columns(); ?>">
		<div class="site-main">


			<?php while ( have_posts() ) : the_post(); ?>

				<?php do_action( 'mf_portfolio_single_before' ) ?>

				<div <?php post_class( 'single-project-wrapper' ) ?>>
					<div class="row">
						<div class="entry-thumbnail mf-gallery-popup <?php echo esc_attr( $owl_css ) ?> col-md-12 col-sm-12 col-xs-12">
							<?php
							if ( $gallery ) {
								foreach ( $gallery as $image ) {
									$img_name  = basename( get_attached_file( $image ) );
									$thumb = wp_get_attachment_image_src( $image, $size );
									if ( $thumb ) {
										printf(
											'<div class="item-gallery">
													<a href="%s" class="photoswipe" data-large_image_width="%s" data-large_image_height="%s"><img src="%s" alt="%s"/></a>
												</div>',
											$thumb[0],
											$thumb[1],
											$thumb[2],
											$thumb[0],
											$img_name
										);
									}
								}
							} else {
								$gallery = get_post_thumbnail_id( get_the_ID() );
								$img_name  = basename( get_attached_file( $gallery ) );
								$image   = wp_get_attachment_image_src( $gallery, $size );
								if ( $image ) {
									printf(
										'<div class="item"><a href="%s" class="photoswipe"><img src="%s" alt="%s"/></a></div>',
										esc_url( $image[0] ),
										esc_url( $image[0] ),
										esc_attr( $img_name )
									);
								}
							}
							?>

						</div>

						<div class="col-md-12 col-sm-12 col-xs-12">
							<?php the_title( '<h2 class="single-project-title">', '</h2>' ); ?>
						</div>

						<div class="entry-content col-md-9 col-sm-12 col-xs-12">
							<?php the_content(); ?>

							<div class="project-socials">
								<?php
								$project_social = (array) induscity_get_option( 'single_portfolio_social' );

								if ( $project_social ) {

									$socials = (array) induscity_get_socials();

									printf( '<ul class="socials-inline">' );
									foreach( $project_social as $social ) {
										foreach( $socials as $name =>$label ) {
											$link_url = $social['link_url'];

											if( preg_match('/' . $name . '/',$link_url) ) {

												if( $name == 'google' ) {
													$name = 'google-plus';
												}

												printf( '<li><a href="%s" target="_blank"><i class="fa fa-%s"></i></a></li>', esc_url( $link_url ), esc_attr( $name ) );
												break;
											}
										}
									}
									printf( '</ul>' );
								}
								?>
							</div>
						</div>

						<div class="portfolio-metas col-md-3 col-sm-12 col-xs-12">
							<?php
							$category = get_the_terms( get_the_ID(), 'portfolio_category' );

							if ( $category ) {
								?>
								<div class="meta cat">
									<h4><?php esc_html_e( 'Category :', 'induscity' ) ?></h4>
									<a href="<?php echo esc_url( get_term_link( $category[0], 'portfolio_category' ) ) ?>" class="cat-project"><?php echo esc_html($category[0]->name) ?></a>
								</div>
								<?php
							}
							?>

							<?php if ( $client ) : ?>
								<div class="meta client">
									<h4><?php esc_html_e( 'Client :', 'induscity' ) ?></h4>
									<?php echo wp_kses( $client, wp_kses_allowed_html( 'post' ) ) ?>
								</div>
							<?php endif; ?>

							<div class="meta date">
								<h4><?php esc_html_e( 'Date :', 'induscity' ) ?></h4>
								<?php echo get_the_date() ?>
							</div>

							<?php if ( $website ) : ?>
								<div class="meta link">
									<h4><?php esc_html_e( 'Link :', 'induscity' ) ?></h4>
									<?php echo wp_kses( $website, wp_kses_allowed_html( 'post' ) ) ?>
								</div>
							<?php endif; ?>

							<?php if ( $rating ) : ?>
								<div class="meta rating">
									<h4><?php esc_html_e( 'Rating :', 'induscity' ) ?></h4>
									<?php induscity_rating_stars( $rating ) ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<?php do_action( 'mf_portfolio_single_after' ) ?>

				<?php
				// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; ?>

			<?php induscity_portfolio_nav( 'portfolio' ) ?>

		</div>
		<!-- #content -->
	</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
