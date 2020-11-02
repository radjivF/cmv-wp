<?php

extract(shortcode_atts(array(
    'name'          => '',
    'image'         => 'http://placehold.it/600x400',
    'delay'         => 300,
    'animation_type'=> 'fadeIn',
    'position'      => 'fadeIn',
    'class'         => '',
), $atts));

return ! empty( $image ) ? "<img class='bwpb-image-sequence-layer bwpb-waypoint {$class}' style='{$position}' data-animation='{$animation_type}' data-animation-delay='{$delay}' src='" . esc_attr( $image ) . "' alt='" . esc_attr( $name ) . "'>" : '';