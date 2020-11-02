<?php

$a = shortcode_atts(array(
    'title'         => 'Progress bar',
    'percentage'    => 50,
    'custom_color'  => '#dedede',
    'enable_counter'=> false,
    'more'          => '',
    'class'         => ''
), $atts );

$percentage = (int)$a['percentage'];
$bar_state = ! wp_is_mobile() ? '0' : $a['percentage'];
$more = ! empty( $a['more'] ) ? ' ' . $a['more'] : '';
$counter = $a['enable_counter'] ? "<span class='bwpb-pb-counter'><strong>{$percentage}</strong>{$more}</span>" : '';

$output  = "<div class='bwpb-pb {$a['class']}' data-percentage='{$percentage}'>";
$output .= "<div class='bwpb-pb-title'>{$a['title']}</div>";
$output .= "<div class='bwpb-pb-holder'>";
$output .= "<div class='bwpb-pb-bar' style='width:{$bar_state}%;background-color:{$a['custom_color']}'>{$counter}</div>";
$output .= "</div></div>";

return $output;