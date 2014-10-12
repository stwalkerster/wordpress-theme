<?php

// add_theme_supports( 'post_formats', array() );

// add_theme_support( 'post-thumbnails' ); 

function stw_register_menus() {
  register_nav_menus(
    array(
         'header-menu' => __( 'Header Menu' ),
        'footer-links' => __( 'Footer Links' ),
        )
    );
}
add_action( 'init', 'stw_register_menus' );