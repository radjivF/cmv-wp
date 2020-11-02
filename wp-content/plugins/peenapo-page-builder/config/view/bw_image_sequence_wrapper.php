<?php

extract(shortcode_atts(array(
    'mobile_image'  => '',
    'class'         => '',
), $atts));

$mobile = $mobile_image ? "<img src='{$mobile_image}' alt=''>" : '';

return "<div class='bwpb-image-sequence {$class}'>" . ( ! wp_is_mobile() ? do_shortcode( $content ) : $mobile ) . "</div>";