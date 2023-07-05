<?php

/**
 * Define theme shortcodes
 *
 * @package Induscity
 */
class Induscity_Shortcodes
{

    /**
     * Store variables for js
     *
     * @var array
     */
    public $l10n = array();

    public $api_key = '';

    /**
     * Store variables for maps
     *
     * @var array
     */
    public $maps = array();

    /**
     * Check if WooCommerce plugin is actived or not
     *
     * @var bool
     */
    private $wc_actived = false;

    /**
     * Construction
     *
     * @return Induscity_Shortcodes
     */
    function __construct()
    {
        $this->wc_actived = function_exists('is_woocommerce');

        $shortcodes = array(
            'manufactory_section_title',
            'manufactory_empty_space',
            'manufactory_button',
            'manufactory_icon_box',
            'manufactory_latest_post',
            'manufactory_services',
            'manufactory_services_2',
            'manufactory_services_3',
            'manufactory_portfolio',
            'manufactory_testimonial',
            'manufactory_pricing',
            'manufactory_counter',
            'manufactory_video',
            'manufactory_partner',
            'manufactory_team',
            'manufactory_history',
            'manufactory_contact_box',
            'manufactory_working_hour',
            'manufactory_department_carousel',
            'manufactory_newsletter',
            'manufactory_contact_form_7',
            'manufactory_gmap',
        );

        foreach ($shortcodes as $shortcode) {
            add_shortcode($shortcode, array($this, $shortcode));
        }

        add_action('wp_footer', array($this, 'footer'));
    }

    public function footer()
    {
        // Load Google maps only when needed
        if (isset($this->l10n['map'])) {
            echo '<script>if ( typeof google !== "object" || typeof google.maps !== "object" )
				document.write(\'<script src="//maps.google.com/maps/api/js?sensor=false&key=' . $this->api_key . '"><\/script>\')</script>';
        }

        wp_enqueue_script(
            'shortcodes', INDUSCITY_ADDONS_URL . '/assets/js/frontend.js', array(
            'jquery',
        ), '20171018', true
        );

        wp_localize_script('shortcodes', 'induscityShortCode', $this->l10n);
    }

    /**
     * Get empty space
     *
     * @since  1.0
     *
     * @return string
     */
    function manufactory_empty_space($atts, $content)
    {
        $atts = shortcode_atts(
            array(
                'height' => '',
                'height_mobile' => '',
                'height_tablet' => '',
                'bg_color' => '',
                'el_class' => '',
            ), $atts
        );

        $css_class = array(
            'mf-empty-space',
            $atts['el_class'],
        );

        $style = '';

        if ($atts['bg_color']) {
            $style = 'background-color:' . $atts['bg_color'] . ';';
        }

        $height = $atts['height'] ? (float)$atts['height'] : '';
        $height_tablet = $atts['height_tablet'] ? (float)$atts['height_tablet'] : $height;
        $height_mobile = $atts['height_mobile'] ? (float)$atts['height_mobile'] : $height_tablet;

        $inline_css = $height ? ' style="height: ' . esc_attr($height) . 'px"' : '';
        $inline_css_mobile = $height_mobile ? ' style="height: ' . esc_attr($height_mobile) . 'px"' : '';
        $inline_css_tablet = $height_tablet ? ' style="height: ' . esc_attr($height_tablet) . 'px"' : '';


        return sprintf(
            '<div class="%s" style="%s">' .
            '<div class="mf_empty_space_lg" %s></div>' .
            '<div class="mf_empty_space_md" %s></div>' .
            '<div class="mf_empty_space_xs" %s></div>' .
            '</div>',
            esc_attr(implode(' ', $css_class)),
            $style,
            $inline_css,
            $inline_css_tablet,
            $inline_css_mobile
        );
    }

    /**
     * Shortcode to display section title
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    function manufactory_section_title($atts, $content)
    {
        $atts = shortcode_atts(
            array(
                'title' => '',
                'sub_title' => '',
                'position' => 'left',
                'color' => 'dark',
                'font_size' => 'large',
                'font_weight' => '',
                'el_class' => '',
            ), $atts
        );

        return $this->induscity_addons_title($atts);
    }

    /**
     * Button
     *
     * @param array $atts
     *
     * @return string
     */
    function manufactory_button($atts, $content)
    {
        $atts = shortcode_atts(
            array(
                'align' => 'left',
                'style' => '1',
                'link' => '',
                'el_class' => '',
            ), $atts
        );

        return $this->induscity_addons_btn($atts);
    }

    /**
     * Icon Box
     *
     * @param array $atts
     *
     * @return string
     */
    function manufactory_icon_box($atts, $content)
    {
        $atts = shortcode_atts(
            array(
                'icon_type' => 'fontawesome',
                'icon_fontawesome' => 'fa fa-adjust',
                'icon_flaticon' => '',
                'image' => '',
                'number' => '',
                'icon_style' => 'normal',
                'position' => 'left',
                'icon_size' => 'large',
                'box_color' => 'dark',
                'link' => '',
                'title' => esc_html__('I am Icon Box', 'induscity'),
                'el_class' => '',
            ), $atts
        );

        $css_class = array(
            'mf-icon-box',
            'icon_type-' . $atts['icon_type'],
            'icon_style-' . $atts['icon_style'],
            'icon_position-' . $atts['position'],
            'icon_size-' . $atts['icon_size'],
            'box-' . $atts['box_color'],
            $atts['el_class'],
        );

        $attributes = array();

        $title = $icon = $link = $button = '';

        $link = vc_build_link($atts['link']);

        if (!empty($link['url'])) {
            $attributes['href'] = $link['url'];
        }

        if (!empty($link['title'])) {
            $attributes['title'] = $link['title'];
        }

        if (!empty($link['target'])) {
            $attributes['target'] = $link['target'];
        }

        if (!empty($link['rel'])) {
            $attributes['rel'] = $link['rel'];
        }

        $attr = array();

        foreach ($attributes as $name => $value) {
            $attr[] = $name . '="' . esc_attr($value) . '"';
        }

        if ($atts['title']) {

            $title = sprintf(
                '<%1$s class="box-title"><%2$s %3$s>%4$s</%2$s></%1$s>',
                'h2',
                empty($attributes['href']) ? 'span' : 'a',
                implode(' ', $attr),
                $atts['title']
            );
        }

        if ('image' == $atts['icon_type']) {
            $image = wp_get_attachment_image($atts['image'], 'full', '', array('class' => 'img-icon'));
            $icon = $image ? sprintf('%s', $image) : '';
        } elseif ('number' == $atts['icon_type']) {
            if ($atts['number']) {
                $icon = sprintf('<span class="mf-icon">%s</span>', intval($atts['number']));
            }
        } else {
            vc_icon_element_fonts_enqueue($atts['icon_type']);
            $icon = '<span class="mf-icon"><i class="' . esc_attr($atts['icon_' . $atts['icon_type']]) . '"></i></span>';
        }


        return sprintf(
            '<div class="%s">%s<div class="box-wrapper">%s<div class="desc">%s</div></div></div>',
            esc_attr(implode(' ', $css_class)),
            $icon,
            $title,
            $content
        );
    }

    /**
     * Shortcode to display latest post
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    function manufactory_latest_post($atts, $content)
    {
        $atts = shortcode_atts(
            array(
                'section_title' => esc_html__('Latest From Blog', 'induscity'),
                'number' => '-1',
                'thumbnail' => false,
                'excerpt_length' => '20',
                'type' => 'grid',
                'btn_text' => esc_html__('View More', 'induscity'),
                'nav' => false,
                'dot' => false,
                'autoplay' => false,
                'autoplay_timeout' => '2000',
                'autoplay_speed' => '800',
                'el_class' => '',
            ), $atts
        );

        $css_class = array(
            'mf-latest-post blog-grid',
            $atts['type'],
            $atts['el_class'],
        );

        if ($atts['thumbnail']) {
            $css_class[] = 'has-thumbnail';
        } else {
            $css_class[] = 'no-thumb';
        }

        $section_title = $btn = '';

        if ($atts['section_title']) {
            $atts['title'] = $atts['section_title'];
            $atts['position'] = 'left';
            $atts['color'] = 'dark';
            $atts['font_size'] = 'large';
            $section_title = $this->induscity_addons_title($atts);
        }

        if ($atts['type'] == 'grid' && $atts['btn_text']) {
            $btn = sprintf('<a href="%s" class="mf-btn-2 view-more">%s</a>', esc_url(get_permalink(get_option('page_for_posts'))), $atts['btn_text']);
        }

        $excerpt_length = intval($atts['excerpt_length']);
        $autoplay_speed = intval($atts['autoplay_speed']);
        $autoplay_timeout = intval($atts['autoplay_timeout']);

        if ($atts['autoplay']) {
            $autoplay = true;
        } else {
            $autoplay = false;
        }

        if ($atts['nav']) {
            $nav = true;
        } else {
            $nav = false;
        }

        if ($atts['dot']) {
            $dot = true;
        } else {
            $dot = false;
        }

        $is_carousel = 1;
        if ($atts['type'] == 'grid') {
            $is_carousel = 0;
        }

        $id = uniqid('post-slider-');
        $this->l10n['post'][$id] = array(
            'nav' => $nav,
            'dot' => $dot,
            'autoplay' => $autoplay,
            'autoplay_speed' => $autoplay_speed,
            'autoplay_timeout' => $autoplay_timeout,
            'is_carousel' => $is_carousel,
        );

        $output = array();

        $query_args = array(
            'posts_per_page' => $atts['number'],
            'post_type' => 'post',
            'ignore_sticky_posts' => true,
        );

        $query = new WP_Query($query_args);

        while ($query->have_posts()) : $query->the_post();
            global $mf_post;
            $mf_post['excerpt_length'] = $excerpt_length;
            $mf_post['css'] = ' blog-wrapper-col-3 col-md-4';

            ob_start();
            get_template_part('parts/content', get_post_format());
            $output[] = ob_get_clean();

        endwhile;
        wp_reset_postdata();

        return sprintf(
            '<div class="%s">
				<div class="mf-latest-post-header">%s%s</div>
                <div class="post-list %s" id="%s">%s</div>
            </div>',
            esc_attr(implode(' ', $css_class)),
            $section_title,
            $btn,
            $atts['type'] == 'grid' ? 'row' : 'owl-carousel',
            esc_attr($id),
            implode('', $output)
        );
    }

    /**
     * Shortcode to display services
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    function manufactory_services($atts, $content)
    {
        $atts = shortcode_atts(
            array(
                'number' => '-1',
                'orderby' => 'date',
                'order' => 'desc',
                'desc' => false,
                'title' => '',
                'link' => '',
                'el_class' => '',
            ), $atts
        );

        $css_class = array(
            'mf-services',
            $atts['el_class'],
        );

        $output = array();
        $title = $btn = '';

        if ($atts['desc']) {
            if ($atts['title']) {
                $atts['position'] = 'left';
                $atts['color'] = 'dark';
                $atts['font_size'] = 'large';
                $title = $this->induscity_addons_title($atts);
            }

            if ($atts['link']) {
                $atts['align'] = 'left';
                $atts['style'] = '1';
                $btn = $this->induscity_addons_btn($atts);
            }

            $output[] = sprintf(
                '<div class="service-desc col-md-4 col-sm-6 col-xs-12">%s%s%s</div>',
                $title,
                $content,
                $btn
            );
        }

        $query_args = array(
            'posts_per_page' => $atts['number'],
            'post_type' => 'service',
            'orderby' => $atts['orderby'],
            'order' => $atts['order'],
            'ignore_sticky_posts' => true,
        );

        $query = new WP_Query($query_args);

        while ($query->have_posts()) : $query->the_post();
            ob_start();
            get_template_part('parts/content', 'service');
            $output[] = ob_get_clean();

        endwhile;
        wp_reset_postdata();

        return sprintf(
            '<div class="%s">
                <div class="services-list row">%s</div>
            </div>',
            esc_attr(implode(' ', $css_class)),
            implode('', $output)
        );
    }

    /**
     * Shortcode to display services 2
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    function manufactory_services_2($atts, $content)
    {
        $atts = shortcode_atts(
            array(
                'icon_type' => 'fontawesome',
                'icon_fontawesome' => 'fa fa-adjust',
                'icon_flaticon' => '',
                'image' => '',
                'style' => '1',
                'service_image' => '',
                'image_size' => '',
                'link' => '',
                'sub_title' => '',
                'title' => '',
                'el_class' => '',
            ), $atts
        );

        $css_class = array(
            'mf-services-2',
            'icon_type-' . $atts['icon_type'],
            'style-' . $atts['style'],
            $atts['el_class'],
        );

        $output = array();

        $attributes = array();

        $title = $sub_title = $icon = $link = $item = $btn = $arrow = '';

        if ($atts['style'] == '1') {
            $arrow = '<i class="fa fa-chevron-right"></i>';
        } elseif ($atts['style'] == '3') {
            $arrow = '<i class="fa fa-long-arrow-right"></i>';
        }

        $link = vc_build_link($atts['link']);

        if (!empty($link['url'])) {
            $attributes['href'] = $link['url'];
        }

        if (!empty($link['title'])) {
            $attributes['title'] = $link['title'];
        }

        if (!empty($link['target'])) {
            $attributes['target'] = $link['target'];
        }

        if (!empty($link['rel'])) {
            $attributes['rel'] = $link['rel'];
        }

        $label = $link['title'];

        if (!$label) {
            $attributes['title'] = $label;
        }

        $attr = array();

        foreach ($attributes as $name => $value) {
            $attr[] = $name . '="' . esc_attr($value) . '"';
        }

        if ($atts['title']) {
            $title = sprintf(
                '<%1$s><%2$s %3$s>%4$s</%2$s></%1$s>',
                'h4',
                empty($attributes['href']) ? 'span' : 'a',
                implode(' ', $attr),
                $atts['title']
            );
        }

        if ($atts['sub_title']) {
            $sub_title = sprintf('<span>%s</span>', $atts['sub_title']);
        }

        if ($atts['style'] == '1' || $atts['style'] == '3') {
            $btn = sprintf(
                '<%1$s %2$s class="btn-service-2">%3$s%4$s</%1$s>',
                empty($attributes['href']) ? 'span' : 'a',
                implode(' ', $attr),
                $label,
                $arrow
            );
        }

        if ('image' == $atts['icon_type']) {
            $image = wp_get_attachment_image($atts['image'], 'full', '', array('class' => 'img-icon'));
            $icon = $image ? sprintf('<span class="mf-icon">%s</span>', $image) : '';
        } else {
            vc_icon_element_fonts_enqueue($atts['icon_type']);
            $icon = '<span class="mf-icon"><i class="' . esc_attr($atts['icon_' . $atts['icon_type']]) . '"></i></span>';
        }

        if ($atts['service_image']) {
            if (function_exists('wpb_getImageBySize')) {
                $image = wpb_getImageBySize(
                    array(
                        'attach_id' => $atts['service_image'],
                        'thumb_size' => $atts['image_size'],
                    )
                );

                $item .= $image['thumbnail'];
            } else {
                $image = wp_get_attachment_image_src($atts['service_image'], $atts['image_size']);
                if ($image) {
                    $item .= sprintf(
                        '<img alt="%s" src="%s">',
                        esc_attr($atts['image_size']),
                        esc_url($image[0])
                    );
                }
            }
        } else {
            $css_class[] = 'no-thumb';
        }

        if ($atts['style'] == '2') {
            $output[] = sprintf('<div class="service-title">%s%s</div>', $title, $sub_title);
            $output[] = '<div class="service-summary">';
            $output[] = sprintf(
                '<div class="service-thumbnail"><a href="%s"><span class="service-icon"><i class="fa fa-link"></i></span>%s%s</a></div>',
                esc_url($attributes['href']),
                $item,
                $icon
            );
            $output[] = sprintf('<div class="service-desc">%s</div>', $content);
            $output[] = '</div>';
        } else {
            $output[] = sprintf(
                '<div class="service-thumbnail"><a href="%s"><span class="service-icon"><i class="fa fa-link"></i></span>%s%s</a></div>',
                esc_url($attributes['href']),
                $item,
                $icon
            );
            $output[] = '<div class="service-summary">';
            $output[] = $title;
            $output[] = sprintf('<div class="service-desc">%s</div>', $content);
            $output[] = $btn;
            $output[] = '</div>';
        }

        return sprintf(
            '<div class="%s">%s</div>',
            esc_attr(implode(' ', $css_class)),
            implode('', $output)
        );
    }

    /**
     * Shortcode to display services 3
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    function manufactory_services_3($atts, $content)
    {
        $atts = shortcode_atts(
            array(
                'style' => '1',
                'setting' => '',
                'el_class' => '',
            ), $atts
        );

        $css_class = array(
            'mf-services-3',
            'style-' . $atts['style'],
            $atts['el_class'],
        );

        $output = array();

        $setting = vc_param_group_parse_atts($atts['setting']);

        if ($setting) {
            foreach ($setting as $k => $v) {
                $attributes = array();
                $title = $sub_title = $desc = $css = '';

                if ('image' == $v['icon_type']) {
                    $image = wp_get_attachment_image($v['image'], 'full', '', array('class' => 'img-icon'));
                    $icon = $image ? sprintf('<span class="mf-icon">%s</span>', $image) : '';
                } else {
                    vc_icon_element_fonts_enqueue($v['icon_type']);
                    $icon = '<span class="mf-icon"><i class="' . esc_attr($v['icon_' . $v['icon_type']]) . '"></i></span>';
                }

                if (isset($v['featured_box'])) {
                    if ($atts['style'] == '1' && $v['featured_box'] == '1') {
                        $css = 'featured-box';
                    }
                }

                $link = vc_build_link($v['link']);

                if (!empty($link['url'])) {
                    $attributes['href'] = $link['url'];
                }

                if (!empty($link['title'])) {
                    $attributes['title'] = $link['title'];
                }

                if (!empty($link['target'])) {
                    $attributes['target'] = $link['target'];
                }

                if (!empty($link['rel'])) {
                    $attributes['rel'] = $link['rel'];
                }

                $label = $link['title'];

                if (!$label) {
                    $attributes['title'] = $label;
                }

                $attr = array();

                foreach ($attributes as $name => $value) {
                    $attr[] = $name . '="' . esc_attr($value) . '"';
                }

                if (isset($v['title']) && $v['title']) {
                    $title = sprintf(
                        '<%1$s><%2$s %3$s>%4$s</%2$s></%1$s>',
                        'h3',
                        empty($attributes['href']) ? 'span' : 'a',
                        implode(' ', $attr),
                        $v['title']
                    );
                }

                if (isset($v['sub_title']) && $v['sub_title']) {
                    $sub_title = sprintf('<span>%s</span>', $v['sub_title']);
                }

                if (isset($v['desc']) && $v['desc']) {
                    $desc = sprintf('<div class="desc">%s</div>', $v['desc']);
                }

                $output[] = sprintf(
                    '<div class="vc_service-wrapper %s">%s%s%s%s</div>',
                    esc_attr($css),
                    $icon,
                    $title,
                    $sub_title,
                    $desc
                );
            }
        }

        return sprintf(
            '<div class="%s">
                <div class="services-list clearfix">%s</div>
            </div>',
            esc_attr(implode(' ', $css_class)),
            implode('', $output)
        );
    }

    /**
     * Shortcode to display portfolio
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    function manufactory_portfolio($atts, $content)
    {
        $atts = shortcode_atts(
            array(
                'type' => 'carousel',
                'style' => '1',
                'filter' => false,
                'nav_color' => 'light',
                'version' => 'dark',
                'number' => '-1',
                'nav' => false,
                'dot' => false,
                'autoplay' => false,
                'autoplay_speed' => '800',
                'el_class' => '',
                'section_title' => '',
                'position' => 'left',
                'color' => 'dark',
            ), $atts
        );

        $css_class = array(
            'mf-portfolio',
            'mf-portfolio-' . $atts['type'],
            $atts['type'] == 'carousel' ? 'style-' . $atts['style'] : '',
            $atts['type'] == 'isotope' ? 'portfolio-modern' : '',
            $atts['el_class'],
        );

        $section_title = '';

        if ($atts['section_title']) {
            $atts['title'] = $atts['section_title'];
            $atts['font_size'] = 'large';
            $section_title = $this->induscity_addons_title($atts);
        }

        if ($atts['type'] == 'carousel' && ($atts['style'] == '1' || $atts['style'] == '2')) {
            $css_class[] = $atts['version'] . '-version';
        }

        $autoplay_speed = intval($atts['autoplay_speed']);

        if ($atts['autoplay']) {
            $autoplay = true;
        } else {
            $autoplay = false;
        }

        if ($atts['nav']) {
            $nav = true;
        } else {
            $nav = false;
        }

        if ($atts['dot']) {
            $dot = true;
        } else {
            $dot = false;
        }

        $id = uniqid('portfolio-slider-');

        $this->l10n['portfolio'][$id] = array(
            'nav' => $nav,
            'dot' => $dot,
            'autoplay' => $autoplay,
            'autoplay_speed' => $autoplay_speed,
        );

        $output = array();
        $cats = array();

        $query_args = array(
            'posts_per_page' => $atts['number'],
            'post_type' => 'portfolio',
            'ignore_sticky_posts' => true,
        );

        $query = new WP_Query($query_args);

        while ($query->have_posts()) : $query->the_post();

            global $mf_loop_portfolio;
            $mf_loop_portfolio['css'] = 'project-wrapper col-sm-6 col-xs-12 col-md-3 col-4';

            if ($atts['type'] == 'isotope') {
                $mf_loop_portfolio['size'] = 'induscity-portfolio-thumbnail';
            } else {
                if ($atts['style'] == '2') {
                    $mf_loop_portfolio['size'] = 'induscity-portfolio-thumbnail';
                } else {
                    $mf_loop_portfolio['size'] = 'induscity-portfolio-vc-thumbnail';
                }
            }

            $post_categories = wp_get_post_terms(get_the_ID(), 'portfolio_category');

            if ( ! is_wp_error( $post_categories ) &&  $post_categories ) {
                foreach ($post_categories as $cat) {
                    if (empty($cats[$cat->term_id])) {
                        $cats[$cat->term_id] = array('name' => $cat->name, 'slug' => $cat->slug,);
                    }
                }
            }

            ob_start();
            get_template_part('parts/content', 'portfolio');
            $output[] = ob_get_clean();

        endwhile;
        wp_reset_postdata();

        $filter = array(
            '<li><a href="#" class="active" data-filter="*">' . esc_html__('View All', 'induscity') . '</a></li>'
        );
        foreach ($cats as $category) {
            $filter[] = sprintf('<li><a href="#" class="" data-filter=".portfolio_category-%s">%s</a></li>', esc_attr($category['slug']), esc_html($category['name']));
        }

        $filter_html = '<ul class="nav-filter ' . $atts['nav_color'] . '">' . implode("\n", $filter) . '</ul>';

        return sprintf(
            '<div class="%s">
				<div class="mf-portfolio-header nav-section">%s%s</div>
                <div class="portfolio-list %s" id="%s">%s</div>
            </div>',
            esc_attr(implode(' ', $css_class)),
            $section_title,
            $atts['filter'] == '1' ? $filter_html : '',
            $atts['type'] == 'carousel' ? '' : 'mf-list-portfolio row',
            $atts['type'] == 'carousel' ? esc_attr($id) : 'mf-portfolio-slider',
            implode('', $output)
        );
    }

    /**
     * Shortcode to display testimonials
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    function manufactory_testimonial($atts, $content)
    {

        $atts = shortcode_atts(
            array(
                'style' => '1',
                'version' => 'dark',
                'type' => 'carousel',
                'columns' => '1',
                'nav' => false,
                'dot' => false,
                'autoplay' => false,
                'autoplay_timeout' => '2000',
                'autoplay_speed' => '800',
                'image_size' => '',
                'setting' => '',
                'el_class' => '',
            ), $atts
        );

        $css_class = array(
            'mf-testimonial',
            'style-' . $atts['style'],
            $atts['type'],
            $atts['version'] . '-version',
            $atts['el_class'],
        );

        $columns = intval($atts['columns']);
        $autoplay_speed = intval($atts['autoplay_speed']);
        $autoplay_timeout = intval($atts['autoplay_timeout']);

        if ($atts['autoplay']) {
            $autoplay = true;
        } else {
            $autoplay = false;
        }

        if ($atts['nav']) {
            $nav = true;
        } else {
            $nav = false;
        }

        if ($atts['dot']) {
            $dot = true;
        } else {
            $dot = false;
        }

        $is_carousel = 1;
        if ($atts['type'] == 'grid') {
            $is_carousel = 0;
        }

        $id = uniqid('testimonial-slider-');
        $this->l10n['testimonial'][$id] = array(
            'style' => $atts['style'],
            'nav' => $nav,
            'dot' => $dot,
            'autoplay' => $autoplay,
            'autoplay_speed' => $autoplay_speed,
            'autoplay_timeout' => $autoplay_timeout,
            'is_carousel' => $is_carousel,
            'columns' => $columns,
        );

        $item = '';
        $size = 'full';

        if ($atts['image_size']) {
            $size = $atts['image_size'];
        }

        $info = vc_param_group_parse_atts($atts['setting']);

        $output = array();

        if (!empty($info)) {
            foreach ($info as $key => $value) {
                $els = array();
                $title = $desc = $css = $avatar = $address = $point = $rate = $rate_html = '';

                if ($atts['type'] == 'grid') {
                    $css = 'col-md-4 col-sm-6 col-xs-12';
                }

                if (isset($value['image']) && $value['image']) {
                    if (function_exists('wpb_getImageBySize')) {
                        $image = wpb_getImageBySize(
                            array(
                                'attach_id' => $value['image'],
                                'thumb_size' => $size,
                            )
                        );

                        $item = $image['thumbnail'];
                    } else {
                        $image = wp_get_attachment_image_src($value['image'], $size);

                        if ($image) {
                            $item = sprintf(
                                '<img alt="%s" src="%s">',
                                esc_attr($value['image']),
                                esc_url($image[0])
                            );
                        }
                    }

                    $avatar = sprintf(
                        '<div class="testimonial-avatar">%s%s</div>',
                        $item,
                        $atts['style'] == '3' ? '<div class="testi-icon"><i class="fa fa-quote-left"></i></div>' : ''
                    );

                } else {
                    $css .= ' no-thumbnail';
                }

                if (isset($value['point']) && $value['point']) {
                    $point = floatval($value['point']);

                    if ($point > 5) {
                        $point = 5;
                    }

                    $rate = round($point / 5 * 100) . '%';
                    $rate_html = sprintf(
                        '<div class="testi-rating">
							<div class="rating-content">
								<span style="width: %s"></span>
							</div>
						</div>',
                        esc_attr($rate)
                    );
                }

                if (isset($value['name']) && $value['name']) {
                    $title = sprintf('<h4 class="name"><span>%s</span></h4>', $value['name']);
                }

                if (isset($value['address']) && $value['address']) {
                    $address = sprintf('<span class="address">%s</span>', $value['address']);
                }

                if (isset($value['desc']) && $value['desc']) {
                    $desc = sprintf('<div class="desc">%s</div>', $value['desc']);
                }

                if ($atts['style'] == '3' || $atts['style'] == '5') {
                    $els[] = $desc;
                    $els[] = $avatar;
                    $els[] = $title;
                    $els[] = $address;
                    $els[] = $rate_html;
                } else {
                    $els[] = $avatar;
                    $els[] = $atts['style'] == '4' ? '<div class="testi-group">' : '';
                    $els[] = $title;
                    $els[] = $rate_html;
                    $els[] = $atts['style'] == '4' ? '</div>' : '';
                    $els[] = $address;
                    $els[] = $desc;
                }

                $output[] = sprintf(
                    '<div class="testimonial-info %s"><div class="testi-wrapper">%s</div></div>',
                    esc_attr($css),
                    implode('', $els)
                );
            }
        }

        return sprintf(
            '<div class="%s" id="%s">
				<div class="testimonial-list %s">%s</div>
			</div>',
            esc_attr(implode(' ', $css_class)),
            esc_attr($id),
            $atts['type'] == 'carousel' ? 'owl-carousel' : 'row',
            implode('', $output)
        );
    }

    /**
     * Shortcode to display pricing table
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    function manufactory_pricing($atts, $content)
    {
        $atts = shortcode_atts(
            array(
                'featured' => '',
                'title' => '',
                'unit' => '',
                'price' => '',
                'time_duration' => '',
                'features' => '',
                'button_text' => esc_html__('Join Now', 'induscity'),
                'button_link' => '',
                'el_class' => '',
            ), $atts
        );

        $css_class = array(
            'mf-pricing',
            $atts['el_class'],
        );

        $features = vc_param_group_parse_atts($atts['features']);
        $list = array();
        foreach ($features as $feature) {
            if (isset($feature['name']) && $feature['name']) {
                $list[] = sprintf('<li><span class="feature-name">%s</span></li>', $feature['name']);
            }
        }

        $features = $list ? '<ul class="mf-list">' . implode('', $list) . '</ul>' : '';

        $button = '';
        $link = array_filter(vc_build_link($atts['button_link']));
        if (!empty($link)) {
            $button = sprintf(
                '<a href="%s" class="mf-btn mf-btn-fullwidth" %s%s>%s</a>',
                !empty ($link['url']) ? esc_url($link['url']) : '',
                !empty($link['target']) ? ' target="' . esc_attr($link['target']) . '"' : '',
                !empty($link['rel']) ? ' rel="' . esc_attr($link['rel']) . '"' : '',
                esc_html($atts['button_text'])
            );
        }
        $output = sprintf(
            '<div class="pricing-header">
			   <h3 class="title">%s</h3>
			   <div class="pricing-desc">%s</div>
			</div>
			<div class="pricing-box">
			   <div class="pricing-info">
			      <div class="pricing-inner">
			           <span class="p-money">
			           		<span class="p-unit">%s</span>
			                <span class="p-price">%s</span>
			           </span>
			           <span class="p-duration">/ %s</span>
			       </div>
			   </div>
			   <div class="pricing-content">%s%s</div>
			</div>',
            esc_attr($atts['title']),
            $content,
            esc_attr($atts['unit']),
            esc_attr($atts['price']),
            esc_attr($atts['time_duration']),
            $features,
            $button

        );

        return sprintf(
            '<div class="%s">%s</div>',
            esc_attr(implode(' ', $css_class)),
            $output
        );
    }

    /**
     * Shortcode to display counter
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    function manufactory_counter($atts, $content)
    {
        $atts = shortcode_atts(
            array(
                'style' => '1',
                'columns' => '1',
                'counter_option' => '',
                'el_class' => '',
            ), $atts
        );

        $css_class = array(
            'mf-counter',
            'columns-' . $atts['columns'],
            'style-' . $atts['style'],
            $atts['el_class'],
        );

        $option = vc_param_group_parse_atts($atts['counter_option']);
        $output = array();

        $columns = intval($atts['columns']);
        $col_css = 'col-xs-12 col-sm-6 col-md-' . 12 / $columns;

        foreach ($option as $o) {
            $icon = $content = $unit = '';
            if (isset($o['icon_type'])) {
                if ('image' == $o['icon_type']) {
                    $image = wp_get_attachment_image($o['image'], 'full', '', array('class' => 'img-icon'));
                    $icon = $image ? sprintf('%s', $image) : '';
                } else {
                    vc_icon_element_fonts_enqueue($o['icon_type']);
                    $icon = '<span class="mf-icon"><i class="' . esc_attr($o['icon_' . $o['icon_type']]) . '"></i></span>';
                }
            }

            if (isset($o['unit']) && $o['unit']) {
                $unit = sprintf('<span class="unit">%s</span>', $o['unit']);
            }

            if (isset($o['value']) && $o['value']) {
                $content = sprintf('<div class="counter"> <span class="counter-value">%s</span>%s</div>', $o['value'], $unit);
            }

            if (isset($o['title']) && $o['title']) {
                $content .= sprintf('<h4 class="title">%s</h4>', $o['title']);
            }

            $output[] = sprintf(
                '<div class="%s"><div class="counter-wrapper">%s<div class="counter-content">%s</div></div></div>',
                esc_attr($col_css),
                $icon,
                $content
            );
        }

        return sprintf(
            '<div class="%s"><div class="row list-counter">%s</div></div>',
            esc_attr(implode(' ', $css_class)),
            implode('', $output)
        );
    }

    /**
     * Video banner shortcode
     *
     * @since  1.0
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    function manufactory_video($atts, $content = null)
    {
        $atts = shortcode_atts(
            array(
                'video' => '',
                'min_height' => '500',
                'image' => '',
                'image_size' => '',
                'show_btn' => false,
                'btn_text' => esc_html__('Watch Project Video', 'induscity'),
                'el_class' => '',
            ), $atts
        );

        if (empty($atts['video'])) {
            return '';
        }

        $css_class = array(
            'mf-video-banner',
            $atts['el_class'],
        );

        $icon = INDUSCITY_ADDONS_URL . 'images/play-icon.png';
        $min_height = intval($atts['min_height']);

        $video_html = $src = $btn = '';
        $style = array();
        $video_url = $atts['video'];
        $video_w = '1024';
        $video_h = '768';

        if ($min_height) {
            $style[] = 'min-height:' . $min_height . 'px;';
        }

        if ($atts['image']) {
            $image = wp_get_attachment_image_src($atts['image'], 'full');
            if ($image) {
                $src = $image[0];
            }

            $style[] = 'background-image:url(' . $src . ');';
        }

        if ($atts['show_btn']) {
            $btn = sprintf('<a href="%s" target="_blank" class="video-btn mf-btn">%s</a>', esc_url($video_url), $atts['btn_text']);
        }

        if (filter_var($video_url, FILTER_VALIDATE_URL)) {
            $atts = array(
                'width' => $video_w,
                'height' => $video_h
            );
            if ($oembed = @wp_oembed_get($video_url, $atts)) {
                $video_html = $oembed;
            }

            if ($video_html) {
                $video_html = sprintf('<div class="mf-wrapper"><div class="mf-video-wrapper">%s</div></div>', $video_html);
            }
        }

        return sprintf(
            '<div class="%s" style="%s">
				<div class="mf-video-content">
					<a href="#" data-href="%s" class="photoswipe"><span class="video-play"><img src="%s" alt=""></span></a>
					%s
				</div>
			</div>',
            esc_attr(implode(' ', $css_class)),
            esc_attr(implode(' ', $style)),
            esc_attr($video_html),
            esc_url($icon),
            $btn
        );
    }

    /**
     * Shortcode to display counter
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    function manufactory_partner($atts, $content)
    {
        $atts = shortcode_atts(
            array(
                'columns' => '5',
                'type' => 'normal',
                'images' => '',
                'image_size' => 'thumbnail',
                'custom_links' => '',
                'custom_links_target' => '_self',
                'el_class' => '',
            ), $atts
        );

        $css_class = array(
            'mf-partner clearfix',
            $atts['type'] . '-type',
            $atts['el_class'],
        );

        $columns = intval($atts['columns']);

        $class = $owl_class = '';

        if ($atts['type'] == 'normal') {
            if ($columns == 5) {
                $class = 'col-md-1-5 col-sm-4 col-xs-12';
            } else {
                $class = 'col-sm-4 col-xs-12 col-md-' . intval(12 / $columns);
            }

            $owl_class = 'row';

        } else {
            $owl_class = 'owl-carousel';
        }

        $output = array();
        $custom_links = '';

        if (function_exists('vc_value_from_safe')) {
            $custom_links = vc_value_from_safe($atts['custom_links']);
            $custom_links = explode(',', $custom_links);
        }

        $images = $atts['images'] ? explode(',', $atts['images']) : '';

        if ($images) {
            $i = 0;
            foreach ($images as $attachment_id) {
                $image = wp_get_attachment_image($attachment_id, $atts['image_size']);
                if ($image) {
                    $link = '';
                    if ($custom_links && isset($custom_links[$i])) {
                        $link = preg_replace('/<br \/>/iU', '', $custom_links[$i]);

                        if ($link) {
                            $link = 'href="' . esc_url($link) . '"';
                        }
                    }

                    $output[] = sprintf(
                        '<div class="partner-item %s">
							<a %s target="%s" >%s</a>
						</div>',
                        esc_attr($class),
                        $link,
                        esc_attr($atts['custom_links_target']),
                        $image
                    );
                }
                $i++;
            }
        }

        return sprintf(
            '<div class="%s" data-columns="%s">
				<div class="list-item %s">%s</div>
			</div>',
            esc_attr(implode(' ', $css_class)),
            esc_attr($columns),
            esc_attr($owl_class),
            implode('', $output)
        );
    }

    /**
     * Shortcode to display team
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */

    function manufactory_team($atts, $content)
    {

        $atts = shortcode_atts(
            array(
                'type' => 'carousel',
                'columns' => '4',
                'image_size' => '',
                'nav' => false,
                'dot' => false,
                'autoplay' => false,
                'autoplay_timeout' => '',
                'autoplay_speed' => '',
                'member_info' => '',
                'el_class' => '',
            ), $atts
        );

        $css_class = array(
            'mf-team',
            $atts['type'] == 'carousel' ? 'team-carousel' : 'team-grid',
            $atts['el_class'],
        );

        $autoplay_speed = intval($atts['autoplay_speed']);
        $autoplay_timeout = intval($atts['autoplay_timeout']);

        if ($atts['autoplay']) {
            $autoplay = true;
        } else {
            $autoplay = false;
        }

        if ($atts['nav']) {
            $nav = true;
        } else {
            $nav = false;
        }

        if ($atts['dot']) {
            $dot = true;
        } else {
            $dot = false;
        }

        $is_carousel = 1;
        if ($atts['type'] == 'grid') {
            $is_carousel = 0;
        }

        $id = uniqid('team-slider-');
        $this->l10n['team'][$id] = array(
            'nav' => $nav,
            'dot' => $dot,
            'autoplay' => $autoplay,
            'autoplay_speed' => $autoplay_speed,
            'autoplay_timeout' => $autoplay_timeout,
            'columns' => intval($atts['columns']),
            'is_carousel' => $is_carousel,
        );

        $item = '';
        $size = 'full';

        if ($atts['image_size']) {
            $size = $atts['image_size'];
        }

        $info = vc_param_group_parse_atts($atts['member_info']);

        $output = array();

        if (!empty($info)) {
            foreach ($info as $key => $value) {
                $title = $job = $css = '';

                if ($atts['type'] == 'grid') {
                    $css = 'col-sm-6 col-xs-12 col-md-' . 12 / intval($atts['columns']);
                }

                if (isset($value['image']) && $value['image']) {
                    if (function_exists('wpb_getImageBySize')) {
                        $image = wpb_getImageBySize(
                            array(
                                'attach_id' => $value['image'],
                                'thumb_size' => $size,
                            )
                        );

                        $item = $image['thumbnail'];
                    } else {
                        $image = wp_get_attachment_image_src($value['image'], $size);

                        if ($image) {
                            $item = sprintf(
                                '<img alt="%s" src="%s">',
                                esc_attr($value['image']),
                                esc_url($image[0])
                            );
                        }
                    }
                } else {
                    $css .= ' no-thumbnail';
                }

                if (isset($value['name']) && $value['name']) {
                    $title = sprintf('<h4 class="name">%s</h4>', $value['name']);
                }

                if (isset($value['job']) && $value['job']) {
                    $job = sprintf('<span class="job">%s</span>', $value['job']);
                }

                $social_output = $socials = array();

                for ($i = 1; $i <= 5; $i++) {
                    if (isset($value['social_' . $i]) && $value['social_' . $i]) {
                        $socials[] = $value['social_' . $i];
                    }
                }

                $get_social = $this->induscity_addons_get_socials();

                foreach ($socials as $social) {
                    if (empty($social)) {
                        continue;
                    }

                    foreach ($get_social as $name => $value) {
                        if (preg_match('/' . $name . '/', $social)) {

                            if ($name == 'google') {
                                $name = 'google-plus';
                            }

                            $social_output[] = sprintf('<li><a href="%s" target="_blank"><i class="fa fa-%s"></i></a></li>', esc_url($social), esc_attr($name));
                        }
                    }
                }

                $output[] = sprintf(
                    '<div class="team-member %s">
						<div class="team-header">%s<ul class="team-social">%s</ul></div>
						<div class="team-info">%s%s</div>
					</div>',
                    esc_attr($css),
                    $item,
                    implode('', $social_output),
                    $title,
                    $job
                );
            }
        }

        return sprintf(
            '<div class="%s">
				<div class="team-list %s" id="%s">%s</div>
			</div>',
            esc_attr(implode(' ', $css_class)),
            $atts['type'] == 'carousel' ? 'owl-carousel' : 'row',
            esc_attr($id),
            implode('', $output)
        );
    }

    /**
     * Shortcode to display history
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    function manufactory_history($atts, $content)
    {
        $atts = shortcode_atts(
            array(
                'number' => '4',
                'nav' => false,
                'dot' => false,
                'autoplay' => false,
                'autoplay_timeout' => '',
                'autoplay_speed' => '',
                'history' => '',
                'el_class' => '',
            ), $atts
        );

        $css_class = array(
            'mf-history',
            $atts['el_class'],
        );

        $autoplay_speed = intval($atts['autoplay_speed']);
        $autoplay_timeout = intval($atts['autoplay_timeout']);

        if ($atts['autoplay']) {
            $autoplay = true;
        } else {
            $autoplay = false;
        }

        if ($atts['nav']) {
            $nav = true;
        } else {
            $nav = false;
        }

        if ($atts['dot']) {
            $dot = true;
        } else {
            $dot = false;
        }


        $id = uniqid('history-slider-');
        $this->l10n['history'][$id] = array(
            'nav' => $nav,
            'dot' => $dot,
            'autoplay' => $autoplay,
            'autoplay_speed' => $autoplay_speed,
            'autoplay_timeout' => $autoplay_timeout,
        );

        $output = array();

        $history = vc_param_group_parse_atts($atts['history']);
        $count = count($history);
        $i = 0;

        foreach ($history as $key => $value) {

            $date = '';
            $title = '';
            $desc = '';

            if (isset($value['date']) && $value['date']) {
                $date = sprintf('<div class="date">%s</div>', $value['date']);
            }

            if (isset($value['title']) && $value['title']) {
                $title = sprintf('<h3 class="title">%s</h3>', $value['title']);
            }

            if (isset($value['desc']) && $value['desc']) {
                $desc = sprintf('<div class="history-desc"><p>%s</p></div>', $value['desc']);
            }

            if ($i % 2 == 0) {
                $output[] = '<div class="history-group">';
            }

            $output[] = sprintf(
                '<div class="history">%s<div class="history-content">%s%s</div></div>',
                $date,
                $title,
                $desc
            );

            if ($i % 2 == 1) {
                $output[] = '</div>';
            }

            $i++;
        }

        if ($count % 2 == 1) {
            $output[] = '</div>';
        }

        return sprintf(
            '<div class="%s">
            <div class="history-list owl-carousel" id="%s">%s</div>
        </div>',
            esc_attr(implode(' ', $css_class)),
            esc_attr($id),
            implode('', $output)
        );
    }

    /**
     * Shortcode to display contact box
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    function manufactory_contact_box($atts, $content)
    {
        $socials = array(
            'facebook' => '',
            'twitter' => '',
            'google' => '',
            'rss' => '',
            'skype' => '',
            'pinterest' => '',
            'linkedin' => '',
            'youtube' => '',
            'instagram' => '',
        );

        $atts = shortcode_atts(
            array_merge(
                $socials, array(
                    'section_title' => '',
                    'show_address' => false,
                    'show_phone' => false,
                    'show_email' => false,
                    'show_social' => false,
                    'address' => '',
                    'phone' => '',
                    'email' => '',
                    'el_class' => '',
                )
            ), $atts
        );

        $css_class = array(
            'mf-contact-box clearfix',
            $atts['el_class'],
        );

        $section_title = '';

        if ($atts['section_title']) {
            $atts['title'] = $atts['section_title'];
            $atts['position'] = 'left';
            $atts['color'] = 'dark';
            $atts['font_size'] = 'medium';
            $section_title = $this->induscity_addons_title($atts);
        }

        $output = array();
        $list = array();

        if ($atts['show_address'] && $atts['address']) {
            $output[] = sprintf('<div class="contact-info address"><i class="flaticon-arrow"></i><div><span>%s</span> %s</div></div>', esc_html__('Address:', 'induscity'), $atts['address']);
        }

        if ($atts['show_phone'] && $atts['phone']) {
            $output[] = sprintf('<div class="contact-info phone"><i class="fa fa-phone"></i><div><span>%s</span> %s</div></div>', esc_html__('Call Us:', 'induscity'), $atts['phone']);
        }

        if ($atts['show_email'] && $atts['email']) {
            $output[] = sprintf('<div class="contact-info email"><i class="flaticon-note"></i><div><span>%s</span> %s</div></div>', esc_html__('Mail Us:', 'induscity'), $atts['email']);
        }

        if ($atts['show_social']) {
            foreach ($socials as $social => $url) {
                if (empty($atts[$social])) {
                    continue;
                }

                $list[] = sprintf(
                    '<li class="%s">
						<a href="%s" target="_blank">
							<i class="fa fa-%s"></i>
						</a>
					</li>',
                    'google' == $social ? 'googleplus' : $social,
                    esc_url($atts[$social]),
                    'google' == $social ? 'google-plus' : $social
                );
            }

            $output[] = sprintf('<ul class="contact-social">%s</ul>', implode('', $list));
        }

        return sprintf(
            '<div class="%s">%s%s</div>',
            esc_attr(implode(' ', $css_class)),
            $section_title,
            implode('', $output)
        );
    }

    /**
     * Shortcode to display working hour table
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    function manufactory_working_hour($atts, $content)
    {
        $atts = shortcode_atts(
            array(
                'section_title' => '',
                'hours' => '',
                'el_class' => '',
            ), $atts
        );

        $css_class = array(
            'mf-working-hour',
            $atts['el_class'],
        );

        $section_title = '';

        if ($atts['section_title']) {
            $atts['title'] = $atts['section_title'];
            $atts['position'] = 'left';
            $atts['color'] = 'dark';
            $atts['font_size'] = 'medium';
            $section_title = $this->induscity_addons_title($atts);
        }

        $output = $section_title;

        $features = vc_param_group_parse_atts($atts['hours']);
        $list = array();

        foreach ($features as $feature) {
            $day = $hour = '';
            if (isset($feature['day']) && $feature['day']) {
                $day = sprintf('<span class="day">%s</span>', $feature['day']);
            }

            if (isset($feature['hour']) && $feature['hour']) {
                $hour = sprintf('<span class="hour">%s</span>', $feature['hour']);
            }

            $list[] = sprintf('<li>%s%s</li>', $day, $hour);
        }

        $output .= $list ? '<ul class="mf-list-hour">' . implode('', $list) . '</ul>' : '';

        return sprintf(
            '<div class="%s">%s</div>',
            esc_attr(implode(' ', $css_class)),
            $output
        );
    }

    /**
     * Shortcode to display department
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    function manufactory_department_carousel($atts, $content)
    {

        $atts = shortcode_atts(
            array(
                'section_title' => '',
                'autoplay' => false,
                'autoplay_timeout' => '2000',
                'autoplay_speed' => '800',
                'image_size' => '',
                'setting' => '',
                'el_class' => '',
            ), $atts
        );

        $css_class = array(
            'mf-department',
            $atts['el_class'],
        );

        $section_title = '';

        if ($atts['section_title']) {
            $atts['title'] = $atts['section_title'];
            $atts['position'] = 'left';
            $atts['color'] = 'dark';
            $atts['font_size'] = 'medium';
            $section_title = $this->induscity_addons_title($atts);
        }

        $autoplay_speed = intval($atts['autoplay_speed']);
        $autoplay_timeout = intval($atts['autoplay_timeout']);

        if ($atts['autoplay']) {
            $autoplay = true;
        } else {
            $autoplay = false;
        }

        $id = uniqid('department-slider-');
        $this->l10n['department'][$id] = array(
            'autoplay' => $autoplay,
            'autoplay_speed' => $autoplay_speed,
            'autoplay_timeout' => $autoplay_timeout,
        );

        $item = '';
        $size = 'full';

        if ($atts['image_size']) {
            $size = $atts['image_size'];
        }

        $info = vc_param_group_parse_atts($atts['setting']);
        $count = count($info);
        $output = array();

        $i = 0;

        if (!empty($info)) {
            foreach ($info as $key => $value) {
                $title = $mail = $css = $avatar = $phone = '';

                if (isset($value['image']) && $value['image']) {
                    if (function_exists('wpb_getImageBySize')) {
                        $image = wpb_getImageBySize(
                            array(
                                'attach_id' => $value['image'],
                                'thumb_size' => $size,
                            )
                        );

                        $item = $image['thumbnail'];
                    } else {
                        $image = wp_get_attachment_image_src($value['image'], $size);

                        if ($image) {
                            $item = sprintf(
                                '<img alt="%s" src="%s">',
                                esc_attr($value['image']),
                                esc_url($image[0])
                            );
                        }
                    }

                    $avatar = sprintf('<div class="department-avatar">%s</div>', $item);

                } else {
                    $css .= ' no-thumbnail';
                }

                if (isset($value['name']) && $value['name']) {
                    $title = sprintf('<h5 class="name">%s</h5>', $value['name']);
                }

                if (isset($value['phone']) && $value['phone']) {
                    $phone = sprintf('<span class="phone"><i class="fa fa-phone"></i>%s</span>', $value['phone']);
                }

                if (isset($value['mail']) && $value['mail']) {
                    $mail = sprintf('<div class="mail"><i class="fa fa-envelope"></i>%s</div>', $value['mail']);
                }

                if ($i % 2 == 0) {
                    $output[] = '<div class="department-group">';
                }

                $output[] = sprintf(
                    '<div class="department-info %s">%s<div class="info">%s%s%s</div></div>',
                    esc_attr($css),
                    $avatar,
                    $title,
                    $phone,
                    $mail
                );

                if ($i % 2 == 1) {
                    $output[] = '</div>';
                }

                $i++;
            }
        }

        if ($count % 2 == 1) {
            $output[] = '</div>';
        }

        return sprintf(
            '<div class="%s" id="%s">
				%s
				<div class="department-list owl-carousel">%s</div>
			</div>',
            esc_attr(implode(' ', $css_class)),
            esc_attr($id),
            $section_title,
            implode('', $output)
        );
    }

    /**
     * Shortcode to display newsletter
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    function manufactory_newsletter($atts, $content)
    {
        $atts = shortcode_atts(
            array(
                'form' => '',
                'el_class' => '',
            ), $atts
        );

        $css_class = array(
            'mf-newletter',
            $atts['el_class']
        );

        return sprintf(
            '<div class="%s"><div class="form-area">%s</div></div>',
            esc_attr(implode(' ', $css_class)),
            do_shortcode('[mc4wp_form id="' . esc_attr($atts['form']) . '"]')
        );
    }

    /**
     * Shortcode to display contact form 7
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    function manufactory_contact_form_7($atts, $content)
    {
        $atts = shortcode_atts(
            array(
                'section_title' => '',
                'color' => 'light',
                'form' => '',
                'form_bg' => '',
                'padding_top' => '',
                'padding_right' => '',
                'padding_bottom' => '',
                'padding_left' => '',
                'el_class' => '',
            ), $atts
        );

        $css_class = array(
            'mf-contact-form-7',
            'form-' . $atts['color'],
            $atts['el_class']
        );

        $style = array();

        $section_title = '';
        $p_top = intval($atts['padding_top']);
        $p_right = intval($atts['padding_right']);
        $p_bottom = intval($atts['padding_bottom']);
        $p_left = intval($atts['padding_left']);

        if ($atts['section_title']) {
            $atts['title'] = $atts['section_title'];
            $atts['position'] = 'left';
            $atts['color'] = 'dark';
            $atts['font_size'] = 'medium';
            $section_title = $this->induscity_addons_title($atts);
        }

        if ($atts['form_bg']) {
            $style[] = 'background-color:' . $atts['form_bg'] . ';';
        }

        if ($atts['padding_top']) {
            $style[] = 'padding-top: ' . $p_top . 'px;';
        }

        if ($atts['padding_right']) {
            $style[] = 'padding-right: ' . $p_right . 'px;';
        }

        if ($atts['padding_bottom']) {
            $style[] = 'padding-bottom: ' . $p_bottom . 'px;';
        }

        if ($atts['padding_left']) {
            $style[] = 'padding-left: ' . $p_left . 'px;';
        }

        return sprintf(
            '<div class="%s" style="%s">%s%s</div>',
            esc_attr(implode(' ', $css_class)),
            implode(' ', $style),
            $section_title,
            do_shortcode('[contact-form-7 id="' . esc_attr($atts['form']) . '" title=" ' . get_the_title($atts['form']) . ' "]')
        );
    }

    /*
	 * GG Maps shortcode
	 */
    function manufactory_gmap($atts, $content)
    {
        $atts = shortcode_atts(
            array(
                'api_key' => '',
                'marker' => '',
                'info' => '',
                'width' => '',
                'height' => '500',
                'zoom' => '13',
                'el_class' => '',
                'map_color' => '#efba2c',
            ), $atts
        );

        $class = array(
            'mf-map-shortcode',
            $atts['el_class'],
        );

        $style = '';
        if ($atts['width']) {
            $unit = 'px;';
            if (strpos($atts['width'], '%')) {
                $unit = '%;';
            }

            $atts['width'] = intval($atts['width']);
            $style .= 'width: ' . $atts['width'] . $unit;
        }
        if ($atts['height']) {
            $unit = 'px;';
            if (strpos($atts['height'], '%')) {
                $unit = '%;';
            }

            $atts['height'] = intval($atts['height']);
            $style .= 'height: ' . $atts['height'] . $unit;
        }
        if ($atts['zoom']) {
            $atts['zoom'] = intval($atts['zoom']);
        }

        $id = uniqid('mf_map_');
        $html = sprintf(
            '<div class="%s"><div id="%s" class="mf-map" style="%s"></div></div>',
            implode(' ', $class),
            $id,
            $style
        );

        $lats = array();
        $lng = array();
        $info = array();
        $i = 0;
        $fh_info = vc_param_group_parse_atts($atts['info']);

        foreach ($fh_info as $key => $value) {

	        $map_img = $map_info = $map_html = '';

	        if ( isset( $value['image'] ) && $value['image'] ) {
		        $map_img = wp_get_attachment_image( $value['image'], 'thumbnail' );
	        }

	        if ( isset( $value['details'] ) && $value['details'] ) {
		        $map_info = sprintf( '<div class="mf-map-info">%s</div>', $value['details'] );
	        }

	        $map_html = sprintf(
		        '<div class="box-wrapper" style="width:150px">%s<h4>%s</h4>%s</div>',
		        $map_img,
		        esc_html__( 'Location', 'induscity' ),
		        $map_info
	        );

	        $coordinates = $this->get_coordinates( $value['address'], $atts['api_key'] );
	        $lats[]      = $coordinates['lat'];
	        $lng[]       = $coordinates['lng'];
	        $info[]      = $map_html;

	        if ( isset( $coordinates['error'] ) ) {
		        return $coordinates['error'];
	        }

	        $i ++;
        }

        $marker = '';
        if ($atts['marker']) {

            if (filter_var($atts['marker'], FILTER_VALIDATE_URL)) {
                $marker = $atts['marker'];
            } else {
                $attachment_image = wp_get_attachment_image_src(intval($atts['marker']), 'full');
                $marker = $attachment_image ? $attachment_image[0] : '';
            }
        }

        $this->api_key = $atts['api_key'];

        $this->l10n['map'][$id] = array(
            'type' => 'normal',
            'lat' => $lats,
            'lng' => $lng,
            'zoom' => $atts['zoom'],
            'marker' => $marker,
            'height' => $atts['height'],
            'info' => $info,
            'number' => $i,
            'map_color' => $atts['map_color'],
        );

        return $html;

    }

    /**
     * Helper function to get coordinates for map
     *
     * @since 1.0.0
     *
     * @param string $address
     * @param bool $refresh
     *
     * @return array
     */
    function get_coordinates($address,$api_key, $refresh = false)
    {
        $address_hash = md5($address);
        $coordinates = get_transient($address_hash);
        $results = array('lat' => '', 'lng' => '');

        if ($refresh || $coordinates === false) {
	        $args     = array( 'address' => urlencode( $address ), 'sensor' => 'false', 'key' => $api_key );
	        $url      = add_query_arg( $args, 'https://maps.googleapis.com/maps/api/geocode/json' );
	        $response = wp_remote_get( $url );

            if (is_wp_error($response)) {
                $results['error'] = esc_html__('Can not connect to Google Maps APIs', 'induscity');

                return $results;
            }

            $data = wp_remote_retrieve_body($response);

            if (is_wp_error($data)) {
                $results['error'] = esc_html__('Can not connect to Google Maps APIs', 'induscity');

                return $results;
            }

            if ($response['response']['code'] == 200) {
                $data = json_decode($data);

                if ($data->status === 'OK') {
                    $coordinates = $data->results[0]->geometry->location;

                    $results['lat'] = $coordinates->lat;
                    $results['lng'] = $coordinates->lng;
                    $results['address'] = (string)$data->results[0]->formatted_address;

                    // cache coordinates for 3 months
                    set_transient($address_hash, $results, 3600 * 24 * 30 * 3);
                } elseif ($data->status === 'ZERO_RESULTS') {
                    $results['error'] = esc_html__('No location found for the entered address.', 'induscity');
                } elseif ($data->status === 'INVALID_REQUEST') {
                    $results['error'] = esc_html__('Invalid request. Did you enter an address?', 'induscity');
                } else {
                    $results['error'] = esc_html__('Something went wrong while retrieving your map, please ensure you have entered the short code correctly.', 'induscity');
                }
            } else {
                $results['error'] = esc_html__('Unable to contact Google API service.', 'induscity');
            }
        } else {
            $results = $coordinates; // return cached results
        }

        return $results;
    }

    /**
     * Get images from Instagram profile page
     *
     * @since 2.0
     *
     * @param string $username
     *
     * @return array | WP_Error
     */
    protected function scrape_instagram($username)
    {
        $username = strtolower($username);
        $username = str_replace('@', '', $username);
        $transient_key = 'induscity_instagram-' . sanitize_title_with_dashes($username);

        if (false === ($instagram = get_transient($transient_key))) {
            $remote = wp_remote_get('http://instagram.com/' . trim($username) . '/?__a=1');

            if (is_wp_error($remote)) {
                return new WP_Error('site_down', esc_html__('Unable to communicate with Instagram.', 'induscity'));
            }

            if (200 != wp_remote_retrieve_response_code($remote)) {
                return new WP_Error('invalid_response', esc_html__('Instagram did not return a 200.', 'induscity'));
            }

            $data = json_decode($remote['body'], true);

            if (!$data) {
                return new WP_Error('bad_json', esc_html__('Instagram has returned invalid data.', 'induscity'));
            }

            if (isset($data['user']['media']['nodes'])) {
                $images = $data['user']['media']['nodes'];
            } else {
                return new WP_Error('bad_json_2', esc_html__('Instagram has returned invalid data.', 'induscity'));
            }

            if (!is_array($images)) {
                return new WP_Error('bad_array', esc_html__('Instagram has returned invalid data.', 'induscity'));
            }

            $instagram = array();

            foreach ($images as $image) {

                $image['thumbnail_src'] = preg_replace('/^https?\:/i', '', $image['thumbnail_src']);
                $image['display_src'] = preg_replace('/^https?\:/i', '', $image['display_src']);

                // handle both types of CDN url
                if ((strpos($image['thumbnail_src'], 's640x640') !== false)) {
                    $image['thumbnail'] = str_replace('s640x640', 's160x160', $image['thumbnail_src']);
                    $image['small'] = str_replace('s640x640', 's240x240', $image['thumbnail_src']);
                } else {
                    $urlparts = wp_parse_url($image['thumbnail_src']);
                    $pathparts = explode('/', $urlparts['path']);
                    array_splice($pathparts, 3, 0, array('s160x160'));
                    $image['thumbnail'] = '//' . $urlparts['host'] . implode('/', $pathparts);
                    $pathparts[3] = 's240x240';
                    $image['small'] = '//' . $urlparts['host'] . implode('/', $pathparts);
                }

                $image['large'] = $image['thumbnail_src'];

                if ($image['is_video'] == true) {
                    $type = 'video';
                } else {
                    $type = 'image';
                }

                $instagram[] = array(
                    'description' => $image['caption'],
                    'link' => trailingslashit('//instagram.com/p/' . $image['code']),
                    'time' => $image['date'],
                    'comments' => $image['comments']['count'],
                    'likes' => $image['likes']['count'],
                    'thumbnail' => $image['thumbnail'],
                    'small' => $image['small'],
                    'large' => $image['large'],
                    'original' => $image['display_src'],
                    'type' => $type,
                );
            }

            // do not set an empty transient - should help catch private or empty accounts
            if (!empty($instagram)) {
                $instagram = serialize($instagram);
                set_transient($transient_key, $instagram, 2 * 3600);
            }
        }

        if (!empty($instagram)) {
            return unserialize($instagram);
        } else {
            return new WP_Error('no_images', esc_html__('Instagram did not return any images.', 'induscity'));
        }
    }

    /**
     * Filter images only
     *
     * @param array $item
     *
     * @return bool
     */
    protected function image_only_filter($item)
    {
        return $item['type'] == 'image';
    }

    /**
     * Get limited words from given string.
     * Strips all tags and shortcodes from string.
     *
     * @since 1.0.0
     *
     * @param integer $num_words The maximum number of words
     * @param string $more More link.
     *
     * @return string|void Limited content.
     */
    protected function induscity_addons_content_limit($content, $num_words, $more = "&hellip;")
    {
        // Strip tags and shortcodes so the content truncation count is done correctly
        $content = strip_tags(strip_shortcodes($content), apply_filters('induscity_content_limit_allowed_tags', '<script>,<style>'));

        // Remove inline styles / scripts
        $content = trim(preg_replace('#<(s(cript|tyle)).*?</\1>#si', '', $content));

        // Truncate $content to $max_char
        $content = wp_trim_words($content, $num_words);

        if ($more) {
            $output = sprintf(
                '<p>%s <a href="%s" class="more-link" title="%s">%s</a></p>',
                $content,
                get_permalink(),
                sprintf(esc_html__('Continue reading &quot;%s&quot;', 'induscity'), the_title_attribute('echo=0')),
                esc_html($more)
            );
        } else {
            $output = sprintf('<p>%s</p>', $content);
        }

        return $output;
    }

    protected function induscity_addons_title($atts)
    {
        $atts = shortcode_atts(
            array(
                'title' => esc_html__('Enter Title in there', 'induscity'),
                'sub_title' => '',
                'position' => 'left',
                'color' => 'dark',
                'font_size' => 'large',
                'font_weight' => '',
                'el_class' => '',
            ), $atts
        );

        $css_class = array(
            'mf-section-title',
            'text-' . $atts['position'],
            $atts['color'],
            $atts['font_size'] . '-size',
            $atts['el_class'],
        );

        $title = $sub = $style = '';

        if ($atts['font_weight']) {
            $font_weight = intval($atts['font_weight']);
            $style = 'style= "font-weight:' . $font_weight . ';"';
        }

        if ($atts['title']) {
            $title = sprintf('<h2 %s>%s</h2>', $style, $atts['title']);
        }

        if ($atts['sub_title']) {
            $sub = sprintf('<h3 class="main-color">%s</h3>', $atts['sub_title']);
        }

        return sprintf(
            '<div class="%s">%s%s</div>',
            esc_attr(implode(' ', $css_class)),
            $sub,
            $title
        );
    }

    protected function induscity_addons_btn($atts)
    {
        $css_class = array(
            'mf-button',
            'align-' . $atts['align'],
            'style-' . $atts['style'],
            $atts['el_class'],
        );

        $attributes = array();

        $attributes['class'] = 'button';

        if ($atts['style'] == '1') {
            $attributes['class'] .= ' mf-btn';
        } else {
            $attributes['class'] .= ' mf-btn-2';
        }

        $link = vc_build_link($atts['link']);

        if (!empty($link['url'])) {
            $attributes['href'] = $link['url'];
        }

        $label = $link['title'];

        if (!$label) {
            $attributes['title'] = $label;
        }

        if (!empty($link['target'])) {
            $attributes['target'] = $link['target'];
        }

        if (!empty($link['rel'])) {
            $attributes['rel'] = $link['rel'];
        }

        $attr = array();

        foreach ($attributes as $name => $v) {
            $attr[] = $name . '="' . esc_attr($v) . '"';
        }

        $button = sprintf(
            '<%1$s %2$s>%3$s</%1$s>',
            empty($attributes['href']) ? 'span' : 'a',
            implode(' ', $attr),
            $label
        );

        return sprintf(
            '<div class="%s">%s</div>',
            esc_attr(implode(' ', $css_class)),
            $button
        );
    }

    function induscity_addons_get_socials()
    {
        $socials = array(
            'facebook' => esc_html__('Facebook', 'induscity'),
            'twitter' => esc_html__('Twitter', 'induscity'),
            'google' => esc_html__('Google', 'induscity'),
            'tumblr' => esc_html__('Tumblr', 'induscity'),
            'flickr' => esc_html__('Flickr', 'induscity'),
            'vimeo' => esc_html__('Vimeo', 'induscity'),
            'youtube' => esc_html__('Youtube', 'induscity'),
            'linkedin' => esc_html__('LinkedIn', 'induscity'),
            'pinterest' => esc_html__('Pinterest', 'induscity'),
            'dribbble' => esc_html__('Dribbble', 'induscity'),
            'spotify' => esc_html__('Spotify', 'induscity'),
            'instagram' => esc_html__('Instagram', 'induscity'),
            'tumbleupon' => esc_html__('Tumbleupon', 'induscity'),
            'wordpress' => esc_html__('WordPress', 'induscity'),
            'rss' => esc_html__('Rss', 'induscity'),
            'deviantart' => esc_html__('Deviantart', 'induscity'),
            'share' => esc_html__('Share', 'induscity'),
            'skype' => esc_html__('Skype', 'induscity'),
            'behance' => esc_html__('Behance', 'induscity'),
            'apple' => esc_html__('Apple', 'induscity'),
            'yelp' => esc_html__('Yelp', 'induscity'),
        );

        return apply_filters('induscity_addons_get_socials', $socials);
    }
}
