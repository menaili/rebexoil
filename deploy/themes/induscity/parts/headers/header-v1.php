<?php
/**
 * Template part for displaying header v1.
 *
 * @package Induscity
 */

?>

<div class="header-main clearfix">
	<div class="site-contact">
		<div class="container">
			<div class="row menu-row">
				<div class="site-logo col-md-9 col-sm-9 col-xs-9">
					<?php get_template_part( 'parts/logo' ); ?>
				</div>
				<div class="site-extra-text hidden-md hidden-sm hidden-xs">
					<?php
					if ( is_active_sidebar( 'header-contact' ) ) {
						ob_start();
						dynamic_sidebar( 'header-contact' );
						$output = ob_get_clean();

						echo apply_filters( 'mf_header_contact', $output );
					}
					?>
				</div>
				<div class="navbar-toggle col-md-3 col-sm-3 col-xs-3"><?php induscity_menu_icon(); ?></div>
			</div>
		</div>
	</div>
	<div class="site-menu container">
		<nav id="site-navigation" class="main-nav primary-nav nav">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'walker'         => new Induscity_Mega_Menu_Walker()
				)
			);
			?>
		</nav>
		<?php manyfactory_header_item_button(); ?>
		<?php
		$block = induscity_get_option( 'menu_extra_block' );
		if ( in_array( 'left', $block ) ) {
			echo '<div class="menu-block-left"></div>';
		}

		if ( in_array( 'right', $block ) ) {
			echo '<div class="menu-block-right"></div>';
		}
		?>
	</div>
</div>