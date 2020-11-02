<?php

$a = shortcode_atts(array(
    'class'         => ''
), $atts );

$output  = "<div class='bwpb-pb-wrapper {$a['class']}'>";
$output .= do_shortcode( $content );
$output .= "</div>";

return $output;