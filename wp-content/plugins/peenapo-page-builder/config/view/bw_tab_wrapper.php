<?php
$a = shortcode_atts(array(
    'content'       => '',
    'class'         => ''
), $atts );

$class = $a['class'];

$parse = array();
$parse = Bwpb_shortcode_parser::ps_the_shortcodes( $parse, $content );

$output = $tab_list = '';

$tab_list .= '<ul class="bwpb-tab-list">';
if( is_array( $parse ) ) {
    foreach( $parse as $key => $tab ) {
        if( isset( $tab['params'] ) and isset( $tab['params']['title'] ) ) {
            $tab_list .= "<li>{$tab['params']['title']}</li>";
        }
    }
}
$tab_list .= '</ul>';

$output .= "<div class='bwpb-tab-wrapper {$class}'>{$tab_list}";
$output .= "<div class='bwpb-tab-content'>";
$output .= do_shortcode( $content );
$output .= "</div>";
$output .= "</div>";

return $output;