<?php
/**
 * Customize the output of menus for Foundation top bar
 */

class top_bar_walker extends Walker_Nav_Menu {

    private $curItem;


    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        $element->has_children = !empty( $children_elements[$element->ID] );
        $element->classes[] = ( $element->current || $element->current_item_ancestor ) ? 'active' : '';
        $element->classes[] = ( $element->has_children && $max_depth !== 1 ) ? 'has-dropdown' : '';

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

    function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
        $this->curItem = $object;

        $item_html = '';

        parent::start_el( $item_html, $object, $depth, $args );

        $output .= ( $depth == 0 ) ? '<li class="divider"></li>' : '';

        $classes = empty( $object->classes ) ? array() : (array) $object->classes;

        if( in_array('label', $classes) ) {
            $output .= '<li class="divider"></li>';
            $item_html = preg_replace( '/<a[^>]*>(.*)<\/a>/iU', '<label>$1</label>', $item_html );
        }

        if ( in_array('divider', $classes) ) {
            $item_html = preg_replace( '/<a[^>]*>( .* )<\/a>/iU', '', $item_html );
        }

        $output .= $item_html;
    }


        function start_lvl( &$output, $depth = 0, $args = array() ) {
          if ( in_array( 'megamenu', $this->curItem->classes ) ){
            $output .= "\n<div class=\"row tab-flyout\" data-equalizer>\n<ul class=\"sub-menu-mega large-3 columns \" data-equalizer-watch>\n";
          }else{
            $output .= "\n<ul class=\"sub-menu dropdown\">\n";

          }

        }

        function end_lvl(&$output, $depth = 0, $args = array()){
          $indent = str_repeat("\t", $depth);

          if ( in_array( 'megamenutab', $this->curItem->classes ) ){
            $output .= "
                        $indent</ul>
                          <div class='large-9 columns tbacontent' ng-cloak data-equalizer-watch>
                          <span   us-spinner='{radius:5, width:3, length: 5, color: \"#fff\"}' spinner-key='spinmenu' spinner-start-active='true' style=' display: block;top: 50%;left: 50%;right: 50%;'></span>

                            <div ng-bind-html='to_trusted(datahtml)' ng-hide='hidehtml'></div>

                            <h5 ng-bind-html='to_trusted(catloopmegamenu[0].parent_name)' ng-hide='hideloop'></h5>
                              <div class='row'>
                                <div ng-repeat='cat in catloopmegamenu' ng-if='cat.parent_name === \"NULL\"  ' class='large-4 columns' on-finish-render='ngRepeatFinished' ng-hide='hideloop'>
                                  <p><a ng-href='{{cat.cat_link}}' title='{{cat.cat_name}}'> <span ng-bind-html='to_trusted(cat.cat_name)' ></span></a></p>
                                </div>
                              </div>
                              <p class='text-center' ng-hide='hideloop' ><a ng-href='{{catloopmegamenu[0].parent_link}}' > Show all</a></p>
                          </div></div>\n";
          }else{
            $output .= "$indent </ul>\n";

          }

        }


}
?>
