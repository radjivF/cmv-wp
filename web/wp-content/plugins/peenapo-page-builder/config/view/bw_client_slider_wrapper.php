<?php

extract(shortcode_atts(array(
    'slides'        => 6,
    'dots'          => false,
    'autoheight'    => false,
    'autoplay'      => false,
    'autoplay_timeout' => 5000,
    'class'         => '',
), $atts));

$options  = '';

$options .= $dots ? ' data-pagination' : '';
$options .= $autoplay ? ' data-autoplay' : '';
$options .= $autoplay_timeout ? " data-autoplay-timeout={$autoplay_timeout}" : '';
$options .= $autoheight ? ' data-autoheight' : '';

return "<div class='bwpb-wrapper bwpb-client-slider bwpb-slider {$class}' data-slides='{$slides}'{$options}>
    " . do_shortcode( $content ) . "
</div>";