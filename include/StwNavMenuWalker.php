<?php
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