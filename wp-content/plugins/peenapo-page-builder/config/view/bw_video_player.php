<?php

$a = shortcode_atts(array(
    'class'         => ''
), $atts );

$output  = "<div class='bwpb-video-player {$a['class']}'>";
$output .= ! empty( $content ) ? apply_filters('the_content', "[embed]" . $content . "[/embed]") : '';
$output .= "</div>";

return $output;