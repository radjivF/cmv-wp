<?php

extract(shortcode_atts(array(
    'title'         => '',
    'percent'       => 50,
    'line_width'    => 20,
    'size'          => 150,
    'track_color'   => '#f1f1f1',
    'bar_color'     => '#666',
    'line_cap'      => 'butt',
    'enable_animation' => false,
    'animation_speed' => 500,
    'animation_delay' => 0,
    'class'         => '',
), $atts));

if( wp_is_mobile() ) { $enable_animation = false; }

$animation = $enable_animation ? "data-speed='{$animation_speed}' data-delay='{$animation_delay}'" : '';
$pie_visible = $enable_animation ? '' : 'bwpb-pie-visible';
$pie_title = $enable_animation ? 'opacity:0;' : '';

$output = $style = '';

$style .= "height:{$size}px;";

$output = "<div class='bwpb-pie-holder {$class}'>
    <div style='{$style}' class='bwpb-pie {$pie_visible}' data-percent='{$percent}' data-trackcolor='{$track_color}' data-barcolor='{$bar_color}' data-linewidth='{$line_width}' data-size='{$size}' data-linecap='{$line_cap}' {$animation}'>
        <div class='bwpb-pie-inner'>
            <div class='bwpb-table'>
                <div class='bwpb-table-cell'>
                    <div class='bwpb-pie-percent' style='color:{$bar_color}'><i>{$percent}</i>%</div>
                </div>
            </div>
        </div>
    </div>
    <h4 class='bwpb-pie-title' style='color:{$bar_color};{$pie_title}'>{$title}</h4>
</div>";

return $output;