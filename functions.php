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