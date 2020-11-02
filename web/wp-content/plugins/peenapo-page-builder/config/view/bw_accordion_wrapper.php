<?php

extract(shortcode_atts(array(
    'class'         => '',
), $atts));

return "<div class='bwpb-accordion {$class}'>" . do_shortcode( $content ) . "</div>";