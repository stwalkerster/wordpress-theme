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
