<?php
/**
 * Custom functions that act in the footer.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Induscity
 */

/**
 *  Display site footer
 */
function induscity_footer()
{
    ?>
    <div class="container footer-info">
        <div class="footer-copyright">
            <?php echo do_shortcode(wp_kses(induscity_get_option('footer_copyright'), wp_kses_allowed_html('post'))); ?>
        </div>
        <div class="text-right">
            <?php induscity_footer_social() ?>
        </div>
    </div>
    <?php
}

add_action('induscity_footer', 'induscity_footer');

/**
 *  Display footer widget
 */
function induscity_footer_widgets()
{


    if (induscity_get_option('footer_widget') == 0) {
        return '';
    }

    if (is_active_sidebar('footer-sidebar-1') == false &&
        is_active_sidebar('footer-sidebar-2') == false &&
        is_active_sidebar('footer-sidebar-3') == false &&
        is_active_sidebar('footer-sidebar-4') == false) {
        return '';
    }
    ?>

    <div id="footer-widgets" class="footer-widgets widgets-area">
        <div class="container">
            <div class="row">

                <?php
                $columns = max(1, absint(induscity_get_option('footer_widget_columns')));

                $col_class = 'col-xs-12 col-sm-6 col-md-' . floor(12 / $columns);
                for ($i = 1; $i <= $columns; $i++) :
                    ?>
                    <div class="footer-sidebar footer-<?php echo esc_attr($i) ?> <?php echo esc_attr($col_class) ?>">
                        <?php dynamic_sidebar("footer-sidebar-$i"); ?>
                    </div>
                <?php endfor; ?>

            </div>
        </div>
    </div>
    <?php
}

add_action('induscity_before_footer', 'induscity_footer_widgets', 20, 1);

function induscity_footer_social()
{

    if (!intval(induscity_get_option('footer_show_socials'))) {
        return;
    }

    $footer_socials = (array)induscity_get_option('footer_socials');

    if (empty($footer_socials)) {
        return;
    }

    ?>
    <div class="socials footer-social">
        <?php

        if ($footer_socials) {

            $socials = (array)induscity_get_socials();

            foreach ($footer_socials as $social) {
                foreach ($socials as $name => $label) {
                    $link_url = $social['link_url'];

                    if (preg_match('/' . $name . '/', $link_url)) {

                        if ($name == 'google') {
                            $name = 'google-plus';
                        }

                        printf('<a href="%s" target="_blank"><i class="fa fa-%s"></i></a>', esc_url($link_url), esc_attr($name));
                        break;
                    }
                }
            }
        }
        ?>
    </div>
    <?php
}

/**
 * Add a modal on the footer, for displaying footer modal
 *
 * @since 1.0.0
 */
function induscity_footer_modal()
{
    ?>
    <div id="modal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="item-detail">
            <div class="modal-dialog woocommerce">
                <div class="modal-content product">
                    <div class="modal-header">
                        <button type="button" class="close fh-close-modal" data-dismiss="modal">&#215;<span
                                    class="sr-only"></span></button>
                    </div>
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

add_action('wp_footer', 'induscity_footer_modal');

/**
 * Add off mobile menu to footer
 *
 * @since 1.0.0
 */
function induscity_off_canvas_mobile_menu()
{
    ?>
    <div class="primary-mobile-nav" id="primary-mobile-nav" role="navigation">
        <div class="mobile-nav-content">
            <a href="#" class="close-canvas-mobile-panel"></a>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
            ));
            ?>
            <?php manyfactory_header_item_button(); ?>
        </div>
    </div>
    <?php
}

add_action('wp_footer', 'induscity_off_canvas_mobile_menu');

/**
 * Display a layer to close canvas panel everywhere inside page
 *
 * @since 1.0.0
 */
function induscity_site_canvas_layer()
{
    ?>
    <div id="off-canvas-layer" class="off-canvas-layer"></div>
    <?php
}

add_action('wp_footer', 'induscity_site_canvas_layer');

/**
 * Display back to top
 *
 * @since 1.0.0
 */
function induscity_back_to_top()
{
    if (!intval(induscity_get_option('back_to_top'))) {
        return;
    }
    ?>
    <a id="scroll-top" class="backtotop" href="#page-top">
        <i class="fa fa-chevron-up"></i>
    </a>
    <?php
}

add_action('wp_footer', 'induscity_back_to_top');

/**
 * Adds photoSwipe dialog element
 */
function induscity_gallery_images_lightbox()
{

    if (!is_singular()) {
        return;
    }

    ?>
    <div id="pswp" class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="pswp__bg"></div>

        <div class="pswp__scroll-wrap">

            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>

            <div class="pswp__ui pswp__ui--hidden">

                <div class="pswp__top-bar">


                    <div class="pswp__counter"></div>

                    <button class="pswp__button pswp__button--close"
                            title="<?php esc_attr_e('Close (Esc)', 'induscity') ?>"></button>

                    <button class="pswp__button pswp__button--share"
                            title="<?php esc_attr_e('Share', 'induscity') ?>"></button>

                    <button class="pswp__button pswp__button--fs"
                            title="<?php esc_attr_e('Toggle fullscreen', 'induscity') ?>"></button>

                    <button class="pswp__button pswp__button--zoom"
                            title="<?php esc_attr_e('Zoom in/out', 'induscity') ?>"></button>

                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                            <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div>

                <button class="pswp__button pswp__button--arrow--left"
                        title="<?php esc_attr_e('Previous (arrow left)', 'induscity') ?>">
                </button>

                <button class="pswp__button pswp__button--arrow--right"
                        title="<?php esc_attr_e('Next (arrow right)', 'induscity') ?>">
                </button>

                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>

            </div>

        </div>

    </div>
    <?php
}

add_action('wp_footer', 'induscity_gallery_images_lightbox');
