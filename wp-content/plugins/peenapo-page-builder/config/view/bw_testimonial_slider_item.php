<?php

extract(shortcode_atts(array(
    'name'          => '',
    'position'      => '',
    'image'         => '',
    'class'         => '',
), $atts));

$img = ! empty( $image ) ? "<div class='bwpb-testimonial-thumb'><img src='" . esc_attr( $image ) . "' alt='" . esc_attr( $name ) . "'></div>" : '';

return "<div class='bwpb-testimonial-slider-item bwpb-slider-item {$class}'>
    {$img}
    <div class='bwpb-testimonial-content'>
        <h4>{$name}</h4><span>{$position}</span>
        <div>" . do_shortcode( Bwpb::autop( $content ) ) . "</div>
    </div>
</div>";