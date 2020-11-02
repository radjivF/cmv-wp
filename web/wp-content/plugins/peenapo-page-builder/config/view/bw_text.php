<?php

$a = shortcode_atts(array(
    'class'         => ''
), $atts );

$output  = "<div class='bwpb-text {$a['class']}'>";
$output .= do_shortcode( Bwpb::autop( $content ) );
$output .= "</div>";

return $output;