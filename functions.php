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


function custom_theme_features()  {
    $header_args = array(
            'default-image'          => '',
            'flex-width'             => true,
            'flex-height'            => true,
            'random-default'         => true,
            'header-text'            => true,
            'default-text-color'     => 'white',
            'uploads'                => false,
            'wp-head-callback'       => '',
            'admin-head-callback'    => '',
            'admin-preview-callback' => '',
        );
        
    add_theme_support('custom-header', $header_args );
    
    	register_default_headers( array(
		'leapfrogscreen' => array(
			'url' => get_stylesheet_directory_uri() . '/images/header/leapfrogscreen.jpg',
			'thumbnail_url' => get_stylesheet_directory_uri() . '/images/header/thumbs/leapfrogscreen.jpg',
			'description' => 'zero88 Leap Frog (screen)'
		),
#		'edicastle' => array(
#			'url' => get_stylesheet_directory_uri() . '/images/header/christmas/edicastle.JPG',
#			'thumbnail_url' => get_stylesheet_directory_uri() . '/images/header/christmas/thumbs/edicastle.JPG',
#			'description' => 'Edinburgh Castle from Calton Hill'
#		),
		'leapfrog' => array(
			'url' => get_stylesheet_directory_uri() . '/images/header/leapfrog.JPG',
			'thumbnail_url' => get_stylesheet_directory_uri() . '/images/header/thumbs/leapfrog.JPG',
			'description' => 'zero88 Leap Frog'
		),		
		'openmic' => array(
			'url' => get_stylesheet_directory_uri() . '/images/header/openmic.jpg',
			'thumbnail_url' => get_stylesheet_directory_uri() . '/images/header/thumbs/openmic.jpg',
			'description' => 'Open Mic'
		),
		'gb4' => array(
			'url' => get_stylesheet_directory_uri() . '/images/header/gb4.jpg',
			'thumbnail_url' => get_stylesheet_directory_uri() . '/images/header/thumbs/gb4.jpg',
			'description' => 'GB4'
		),
		'ingress' => array(
			'url' => get_stylesheet_directory_uri() . '/images/header/ingress.jpg',
			'thumbnail_url' => get_stylesheet_directory_uri() . '/images/header/thumbs/ingress.jpg',
			'description' => 'Ingress Scanner'
		),
#		'edimound' => array(
#			'url' => get_stylesheet_directory_uri() . '/images/header/christmas/edimound.jpg',
#			'thumbnail_url' => get_stylesheet_directory_uri() . '/images/header/christmas/thumbs/edimound.jpg',
#			'description' => 'Edinburgh\'s Christmas from The Mound'
#		),
		'sunset' => array(
			'url' => get_stylesheet_directory_uri() . '/images/header/sunset.jpg',
			'thumbnail_url' => get_stylesheet_directory_uri() . '/images/header/thumbs/sunset.jpg',
			'description' => 'Sunset over Edinburgh'
		),
	) );
}

add_action( 'after_setup_theme', 'custom_theme_features' );