<?php

extract(shortcode_atts(array(
    'name'          => '',
    'image'         => 'http://placehold.it/600x320',
    'class'         => '',
), $atts));

$img = ! empty( $image ) ? "<div class='bwpb-image-slider-img'><img src='" . esc_attr( $image ) . "' alt='" . esc_attr( $name ) . "'></div>" : '';

return "<div class='bwpb-image-slider-item bwpb-slider-item {$class}'>{$img}</div>";