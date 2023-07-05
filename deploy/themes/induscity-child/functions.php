<?php
add_action( 'wp_enqueue_scripts', 'induscity_child_enqueue_scripts', 60 );

function induscity_child_enqueue_scripts() {
    wp_enqueue_style( 'induscity-child-style', get_stylesheet_uri() );
}
