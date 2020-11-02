<?php

extract(shortcode_atts(array(
    'slides'        => 6,
    'dots'          => false,
    'autoheight'    => false,
    'autoplay'      => false,
    'autoplay_timeout' => 5000,
    'color'         => '',
    'class'         => '',
), $atts));

$options = $style = '';

$options .= $dots ? ' data-pagination' : '';
$options .= $autoplay ? ' data-autoplay' : '';
$options .= $autoplay_timeout ? " data-autoplay-timeout={$autoplay_timeout}" : '';
$options .= $autoheight ? ' data-autoheight' : '';

$style .= $color ? "style='color:{$color}'" : '';

return "<div class='bwpb-wrapper bwpb-testimonial-slider bwpb-slider {$class}' data-slides='1' {$options} {$style}>
    " . do_shortcode( $content ) . "
</div>";