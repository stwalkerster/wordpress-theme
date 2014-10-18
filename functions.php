<?php

function stw_init_hook() {
  register_nav_menus(
    array(
         'header-menu' => __( 'Header Menu' ),
         'cover-menu' => __( 'Cover Page Menu' ),
         'footer-links' => __( 'Footer Links' ),
        )
    );
}

function stw_after_setup_theme_hook()
{
    add_theme_support( 'post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat') );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'infinite-scroll', array(
        'container' => 'content',
) );
}

add_action( 'init', 'stw_init_hook' );
add_action( 'init', 'stw_after_setup_theme_hook' );

function stw_pride()
{
    if(get_theme_mod('pride'))
    {
    ?>
         <style type="text/css">
            .item-content p::selection:nth-child(6n+1) {background:rgba(255, 0, 0, 0.25);}
            .item-content p::selection:nth-child(6n+2) {background:rgba(255, 127, 0, 0.25);}
            .item-content p::selection:nth-child(6n+3) {background:rgba(255, 255, 0, 0.25);}
            .item-content p::selection:nth-child(6n+4) {background:rgba(0, 255, 0, 0.25);}
            .item-content p::selection:nth-child(6n+5) {background:rgba(0, 255, 255, 0.25);}
            .item-content p::selection:nth-child(6n+6) {background:rgba(127, 0, 255, 0.25);}
         </style>
    <?php
    }
}
add_action( 'wp_head', 'stw_pride');

function stw_customize_register( $wp_customize ) {
   //All our sections, settings, and controls will be added here
   $wp_customize->add_setting( 'copyright-name' , array(
        'default'     => 'Simon Walker',
        'transport'   => 'refresh',
    ) );       
    
    $wp_customize->add_setting( 'pride' , array(
        'default'     => false,
        'transport'   => 'refresh',
    ) );
    
    $wp_customize->add_setting( 'no-pin-sticky' , array(
        'default'     => false,
        'transport'   => 'refresh',
    ) );    
    
    $wp_customize->add_section( 'stw_footer_customisation' , array(
        'title'      => 'Footer customisation',
        'priority'   => 30,
    ) );
    
    $wp_customize->add_section( 'stw_reading' , array(
        'title'      => 'Reading',
        'priority'   => 1000,
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'copyright-name', array(
        'label'        => 'Copyright Name',
        'section'    => 'stw_footer_customisation',
        'settings'   => 'copyright-name',
        'type' => 'text'
    ) ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'pride', array(
        'label'        => 'Fill with Pride',
        'section'    => 'colors',
        'settings'   => 'pride',
        'type' => 'checkbox'
    ) ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'no-pin-sticky', array(
        'label'        => 'Don\'t pin sticky posts to the top',
        'section'    => 'stw_reading',
        'settings'   => 'no-pin-sticky',
        'type' => 'checkbox'
    ) ) );
}
add_action( 'customize_register', 'stw_customize_register' );


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
#        'edicastle' => array(
#            'url' => get_stylesheet_directory_uri() . '/images/header/christmas/edicastle.JPG',
#            'thumbnail_url' => get_stylesheet_directory_uri() . '/images/header/christmas/thumbs/edicastle.JPG',
#            'description' => 'Edinburgh Castle from Calton Hill'
#        ),
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
#        'edimound' => array(
#            'url' => get_stylesheet_directory_uri() . '/images/header/christmas/edimound.jpg',
#            'thumbnail_url' => get_stylesheet_directory_uri() . '/images/header/christmas/thumbs/edimound.jpg',
#            'description' => 'Edinburgh\'s Christmas from The Mound'
#        ),
        'sunset' => array(
            'url' => get_stylesheet_directory_uri() . '/images/header/sunset.jpg',
            'thumbnail_url' => get_stylesheet_directory_uri() . '/images/header/thumbs/sunset.jpg',
            'description' => 'Sunset over Edinburgh'
        ),
    ) );
}

add_action( 'after_setup_theme', 'custom_theme_features' );


//////////////////////////////
require_once('include/StwNavMenuWalker.php');
require_once('include/StwFooterMenuWalker.php');
//////////////

function stw_posted_on() 
{
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

function stw_has_more_posts() 
{
  global $wp_query;
  return $wp_query->current_post + 1 < $wp_query->post_count;
}

function stw_footer_nav_fallback()
{
    ?> &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a><?php
}

function stw_nav_fallback()
{
    ?>
    <div class="navbar-collapse collapse">
        <ul id="menu-testing-menu" class="nav navbar-nav">
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </div>
    <?php
}

function stw_pager() 
{
    global $wp_query;
    $total = $wp_query->max_num_pages;
    $big = 999999999; // need an unlikely integer
    if( $total > 1 )
    {
        if( !$current_page = get_query_var('paged') )
        {
            $current_page = 1;
        }
        
        if( get_option('permalink_structure') ) 
        {
            $format = 'page/%#%/';
        } 
        else 
        {
            $format = '&paged=%#%';
        }
        
        $links = paginate_links(
            array(
                'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format'    => $format,
                'current'   => max( 1, get_query_var('paged') ),
                'total'     => $total,
                'mid_size'  => 3,
                'type'      => 'array',
                'prev_text' => '&larr;',
                'next_text' => '&rarr;',
            )
        );
        echo '<div class="text-center"><ul class="pagination">';
        
        foreach($links as $l)
        {            
            echo '<li' 
                . (strpos($l, "current") !== false ? ' class="active"' : '')
                . '>' 
                .  $l 
                . '</li>';
        }
        echo '</ul></div>';
    }
}

function stw_breadcrumb() {
    global $post;
    echo '<ol class="breadcrumb">';
    if (!is_home()) {
        echo '<li><a href="';
        echo home_url();
        echo '">';
        echo 'Home';
        echo '</a></li>';
        if (is_category() || is_single()) {
            echo '<li>';
            the_category(' </li><li> ');
            if (is_single()) {
                echo '</li><li>';
                the_title();
                echo '</li>';
            }
        } elseif (is_page()) {
            if($post->post_parent){
                $anc = get_post_ancestors( $post->ID );
                $title = get_the_title();
                foreach ( $anc as $ancestor ) {
                    $output = '<li><a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a></li>';
                }
                echo $output;
                echo '<li><strong title="'.$title.'">'.$title.'</strong></li>';
            } else {
                echo '<li><strong> '.get_the_title().'</strong></li>';
            }
        }
    }
    elseif (is_tag()) {single_tag_title();}
    elseif (is_day()) {echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>';}
    elseif (is_month()) {echo"<li>Archive for "; the_time('F, Y'); echo'</li>';}
    elseif (is_year()) {echo"<li>Archive for "; the_time('Y'); echo'</li>';}
    elseif (is_author()) {echo"<li>Author Archive"; echo'</li>';}
    elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo'</li>';}
    elseif (is_search()) {echo"<li>Search Results"; echo'</li>';}
    echo '</ul>';
}

add_filter( 'img_caption_shortcode', 'stw_img_caption_shortcode', 10, 3 );

function stw_img_caption_shortcode( $empty, $attr, $content ){
	$attr = shortcode_atts( array(
		'id'      => '',
		'align'   => 'alignnone',
		'width'   => '',
		'caption' => ''
	), $attr );

	if ( 1 > (int) $attr['width'] || empty( $attr['caption'] ) ) {
		return '';
	}

	if ( $attr['id'] ) {
		$attr['id'] = 'id="' . esc_attr( $attr['id'] ) . '" ';
	}

	return '<div class="clearfix"></div><div ' . $attr['id']
	. 'class="thumbnail ' . esc_attr( $attr['align'] ) . '" '
	. 'style="max-width: ' . ( 10 + (int) $attr['width'] ) . 'px;">'
	. do_shortcode( $content )
	. '<div class="caption">' . $attr['caption'] . '</div>'
	. '</div>';

}


