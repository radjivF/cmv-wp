<?php

$a = shortcode_atts(array(
    'title'         => '',
    'content'       => '',
    'class'         => ''
), $atts );

$output  = "<div class='bwpb-tab-item {$a['class']}'>";
$output .= do_shortcode( $content );
$output .= "</div>";

return $output;