<?php

extract(shortcode_atts(array(
    'title'         => '',
    'number'        => 50,
    'text_alignment'=> 'left',
    'color'         => '#666',
    'enable_icon'   => false,
    'icon'          => false,
    'enable_animation' => false,
    'animation_speed' => 2000,
    'animation_delay' => 0,
    'class'         => '',
), $atts));

if( wp_is_mobile() ) { $enable_animation = false; }

$icon_output = $enable_icon ? "<i class='" . Bwpb::get_icon( $icon ) . "'></i>" : '';
$title_output = ! empty( $title ) ? "<h4>{$title}</h4>" : '';
$animation = $enable_animation ? "data-speed='{$animation_speed}' data-delay='{$animation_delay}'" : '';
$class .= $enable_animation ? '' : ' bwpb-number-counter-visible';

$output = "<div class='bwpb-number-counter-holder {$class}' style='text-align:{$text_alignment};color:{$color}'>
    {$icon_output}<div class='bwpb-number-counter {$class}' {$animation}>{$number}</div>{$title_output}
</div>";

return $output;