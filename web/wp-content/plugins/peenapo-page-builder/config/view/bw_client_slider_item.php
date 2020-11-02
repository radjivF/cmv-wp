<?php

extract(shortcode_atts(array(
    'name'          => '',
    'image'         => 'http://placehold.it/300x200',
    'class'         => '',
), $atts));

return "<div class='bwpb-client-slider-item bwpb-slider-item {$class}' title='{$name}'>
    <img src='" . esc_attr( $image ) . "' alt='" . esc_attr( $name ) . "'>
</div>";