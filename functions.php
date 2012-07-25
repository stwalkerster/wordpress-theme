<?php

register_sidebar( array(
		'name' => 'Alternate Page Sidebar',
		'id' => 'sidebar-pagealternate',
		'description' => 'The sidebar for the alternate page template',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

register_default_headers( array(
	'disk' => array(
		'url' => '%s/images/header/Disque_dur_0007.jpg',
		'thumbnail_url' => '%s/images/header/thumbs/Disque_dur_0007.jpg',
		'description' => 'Disk head'
	),
	'plasma' => array(
		'url' => '%s/images/header/Plasma-lamp.jpg',
		'thumbnail_url' => '%s/images/header/thumbs/Plasma-lamp.jpg',
		'description' => 'Plasma lamp'
	),
	'lights' => array(
		'url' => '%s/images/header/Light_painting_gnangarra-1.jpg',
		'thumbnail_url' => '%s/images/header/thumbs/Light_painting_gnangarra-1.jpg',
		'description' => 'Light painting'
	),
	'pencils' => array(
		'url' => '%s/images/header/Colouring_pencils.jpg',
		'thumbnail_url' => '%s/images/header/thumbs/Colouring_pencils.jpg',
		'description' => 'Colouring pencils'
	),
	'sparkler' => array(
		'url' => '%s/images/header/Sparkler.jpg',
		'thumbnail_url' => '%s/images/header/thumbs/Sparkler.jpg',
		'description' => 'Sparkler'
	),
	'balloon' => array(
		'url' => '%s/images/header/Cappadocia_Balloon_Inflating_Wikimedia_Commons.jpg',
		'thumbnail_url' => '%s/images/header/thumbs/Cappadocia_Balloon_Inflating_Wikimedia_Commons.jpg',
		'description' => 'Hot air balloon'
	),
	'beach' => array(
		'url' => '%s/images/header/Lanzarote_3_Luc_Viatour.jpg',
		'thumbnail_url' => '%s/images/header/thumbs/Lanzarote_3_Luc_Viatour.jpg',
		'description' => 'Lanzarote beach'
	),
	'lightning' => array(
		'url' => '%s/images/header/Blitze_IMGP6376_wp.jpg',
		'thumbnail_url' => '%s/images/header/thumbs/Blitze_IMGP6376_wp.jpg',
		'description' => 'Lightning'
	),
) );
	
	
add_filter('body_class', 'adjust_body_class', 20, 2);

function adjust_body_class($wp_classes, $extra_classes) {
	if( is_page_template('page-alt.php') ) {
		// Filter the body classes
		foreach($wp_classes as $key => $value) {
			if ($value == 'singular') {
				unset($wp_classes[$key]);
			}
		}
	}

	// Add the extra classes back untouched
	return array_merge($wp_classes, (array) $extra_classes );
}
