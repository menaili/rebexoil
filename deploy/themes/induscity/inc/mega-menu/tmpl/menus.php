<% if ( depth == 0 ) { %>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Mega Menu Content', 'induscity' ) ?>" data-panel="mega"><?php esc_html_e( 'Mega Menu', 'induscity' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Mega Menu Background', 'induscity' ) ?>" data-panel="background"><?php esc_html_e( 'Background', 'induscity' ) ?></a>
<div class="separator"></div>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'induscity' ) ?>" data-panel="icon"><?php esc_html_e( 'Icon', 'induscity' ) ?></a>
<% } else if ( depth == 1 ) { %>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Content', 'induscity' ) ?>" data-panel="content"><?php esc_html_e( 'Menu Content', 'induscity' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu General', 'induscity' ) ?>" data-panel="general"><?php esc_html_e( 'General', 'induscity' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'induscity' ) ?>" data-panel="icon"><?php esc_html_e( 'Icon', 'induscity' ) ?></a>
<% } else { %>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Icon', 'induscity' ) ?>" data-panel="icon"><?php esc_html_e( 'Icon', 'induscity' ) ?></a>
<% } %>
