<?php

extract(shortcode_atts(array(
    'class'         => ''
), $atts ));

$output  = "<div class='bwpb-faq-wrapper {$class}'>";
$output .= do_shortcode( $content );
$output .= "</div>";

return $output;