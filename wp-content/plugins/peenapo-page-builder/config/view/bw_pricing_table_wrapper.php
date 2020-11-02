<?php

$a = shortcode_atts(array(
    'content'       => '',
    'class'         => ''
), $atts );

$class = $a['class'];

$parse = array();
$parse = Bwpb_shortcode_parser::ps_the_shortcodes( $parse, $content );

if( ! is_array( $parse ) or count( $parse ) <= 0 ) { return; } 

$output  = "<div class='bwpb-pt-wrapper bwpb-pt-cols-" . count( $parse ) . " {$class}'>";
$output .= do_shortcode( $content );
$output .= "</div>";

return $output;