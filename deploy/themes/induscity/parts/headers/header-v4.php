<?php
/**
 * Template part for displaying header v4
 *
 * @package Induscity
 */
?>

<div class="header-main">
	<div class="container">
		<div class="row menu-row">
			<div class="site-logo col-md-9 col-sm-9 col-xs-9">
				<?php get_template_part( 'parts/logo' ); ?>
			</div>
			<div class="site-menu hidden-md hidden-sm hidden-xs">
				<nav id="site-navigation" class="main-nav primary-nav nav">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'container'      => false,
						'walker'         => new Induscity_Mega_Menu_Walker()
					) );
					?>
				</nav>
				<?php manyfactory_header_item_button(); ?>
			</div>
			<div class="navbar-toggle col-md-3 col-sm-3 col-xs-3"><?php induscity_menu_icon(); ?></div>
		</div>
	</div>
</div>

