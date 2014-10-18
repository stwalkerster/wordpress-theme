<?php

class StwFooterMenuWalker extends Walker_Nav_Menu {
  
    function start_lvl(&$output, $depth = 0, $args = array())
    {
    }
    
    function end_lvl(&$output, $depth = 0, $args = array())
    {
    }
    
    function end_el(&$output, $item, $depth = 0, $args = array())
    {
    }
  
    // add main/sub classes to li's and links
    function start_el(  &$output, $item, $depth = 0, $args = array(), $id = 0 ) 
    {
        // link attributes
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        
        $item_output = sprintf( ' &middot; %1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters( 'the_title', $item->title, $item->ID ),
            $args->link_after,
            $args->after
        );
      
        // build html
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}
