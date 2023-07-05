<?php
/**
 * Hooks for template archive
 *
 * @package Induscity
 */


/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @since 1.0
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function induscity_setup_author()
{
    global $wp_query;

    if ($wp_query->is_author() && isset($wp_query->post)) {
        $GLOBALS['authordata'] = get_userdata($wp_query->post->post_author);
    }
}

add_action('wp', 'induscity_setup_author');

/**
 * Add CSS classes to posts
 *
 * @param array $classes
 *
 * @return array
 */
function induscity_post_class($classes)
{

    $classes[] = has_post_thumbnail() ? '' : 'no-thumb';

    return $classes;
}

add_filter('post_class', 'induscity_post_class');


/*
 * Project categories filter
 */
function induscity_portfolio_categories_filter()
{
    if (!intval(induscity_get_option('portfolio_nav_filter'))) {
        return;
    }

    if (!induscity_is_portfolio()) {
        return;
    }

    $filterBy = induscity_get_option( 'portfolio_filter' );

    $cats = array();
    $ids = array();
    global $wp_query;

    while ($wp_query->have_posts()) {
        $wp_query->the_post();
        $post_categories = wp_get_post_terms(get_the_ID(), 'portfolio_category');

        foreach ($post_categories as $cat) {
            if (empty($cats[$cat->term_id])) {
                $cats[$cat->term_id] = array('name' => $cat->name, 'slug' => $cat->slug,);
                $ids[] = array( 'id' => $cat->term_id, 'name' => $cat->name );
            }
        }
    }

    $filter = array(
        '<li><a href="#" class="active" data-filter="*">' . esc_html__('View All', 'induscity') . '</a></li>'
    );

    if ( $filterBy == 'slug' ) {
        foreach ($cats as $category) {
            $filter[] = sprintf('<li><a href="#" class="" data-filter=".portfolio_category-%s">%s</a></li>', esc_attr($category['slug']), esc_html($category['name']));
        }
    } else {
        foreach ($ids as $id) {
            $filter[] = sprintf('<li><a href="#" class="" data-filter=".portfolio_id-%s">%s</a></li>', esc_attr($id['id']), esc_html($id['name']) );
        }
    }

    $output = '<div class="nav-section"><ul class="nav-filter">' . implode("\n", $filter) . '</ul></div>';

	echo wp_kses_post($output);
}

add_action('induscity_before_portfolio_content', 'induscity_portfolio_categories_filter');

function induscity_service_banner()
{
    if (!intval(induscity_get_option('service_banner'))) {
        return;
    }

    if (!(induscity_is_service() || is_singular('service'))) {
        return;
    }

    $banner = induscity_get_option('service_banner_image');
    $style = '';
    if ($banner) {
        $style = sprintf('style="background-image:url(%s)', esc_url($banner));
    }
    $banner_content = induscity_get_option('service_banner_content');
    $btn = induscity_get_option('service_banner_btn');
    $url = induscity_get_option('service_banner_btn_url');

    printf(
        '<div class="mf-service-banner" %s">
			<div class="container">
				<div class="mf-service-banner-content">
					<div class="mf-service-banner-content-el">%s</div>
					<a href="%s" class="mf-btn banner-btn">%s</a>
				</div>
			</div>
		</div>',
       $style,
        wp_kses($banner_content, wp_kses_allowed_html('post')),
        esc_url($url),
        wp_kses($btn, wp_kses_allowed_html('post'))
    );
}

add_action('induscity_before_footer', 'induscity_service_banner', 10, 1);