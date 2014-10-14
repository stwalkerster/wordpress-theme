<?php

// add_theme_supports( 'post_formats', array() );

// add_theme_support( 'post-thumbnails' ); 

function stw_register_menus() {
  register_nav_menus(
    array(
         'header-menu' => __( 'Header Menu' ),
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


//////////////////////////////

class StwNavMenuWalker extends Walker_Nav_Menu {
  
    function start_lvl(&$output, $depth = 0, $args = array())
    {
        // depth dependent classes
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
      
        // build html
        $output .= "\n" . $indent . '<ul class="dropdown-menu" role="menu">' . "\n";
    }
    
    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $output.= "</ul>";
    }
    
    function end_el(&$output, $item, $depth = 0, $args = array())
    {
        $output .= "</li>";
    }
  
    // add main/sub classes to li's and links
    function start_el(  &$output, $item, $depth = 0, $args = array(), $id = 0 ) 
    {
        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
      
        if($item->classes == '')
        {
            $item->classes = array();
        }
      
        $isDropdownRoot = in_array("menu-item-has-children", $item->classes);
      
        // passed classes
        $classes = array();
        $classes[] = in_array("current_page_item", $item->classes) ? 'active' : '';
        $classes[] = $isDropdownRoot ? 'dropdown' : '';
        $classes[] = $isDropdownRoot && $depth > 0 ? 'dropdown-submenu' : '';

        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
      
        // build html
        $output .= $indent . '<li class="' . $class_names . '">';
      
        // link attributes
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
      
        $caret = '';
        if($isDropdownRoot)
        {
            $attributes .= ' class="dropdown-toggle" data-toggle="dropdown"';
            
            if($depth == 0)
            {
                $caret = ' <span class="caret"></span>';
            }
        }
        
        $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters( 'the_title', $item->title, $item->ID ),
            $args->link_after . $caret,
            $args->after
        );
      
        // build html
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

//////////////

function stw_posted_on() {
	printf( __( '<a href="%1$s" title="%2$s" rel="bookmark"><time datetime="%3$s">%4$s</time></a> by <a href="%5$s" title="%6$s" rel="author">%7$s</a>', 'stwbootstrap' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'stwbootstrap' ), get_the_author() ) ),
		get_the_author()
	);
}

function stw_has_more_posts() {
  global $wp_query;
  return $wp_query->current_post + 1 < $wp_query->post_count;
}