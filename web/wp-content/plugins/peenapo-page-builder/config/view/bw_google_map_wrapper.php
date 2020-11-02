<?php

extract(shortcode_atts(array(
    'title'         => '',
    'add_center'    => false,
    'latitude'      => '',
    'longitude'     => '',
    'zoom'          => '14',
    'fullheight'    => false,
    'pin_anim'      => false,
    'infobox'       => false,
    'first_pin'     => false,
    'ratio'         => '0.4',
    'style'         => '',
    'class'         => '',
), $atts));

$output = '';

$gmap_data  = " data-zoom='{$zoom}'";
$gmap_data .= $fullheight !== '1' ? " data-ratio='{$ratio}'" : '';
$gmap_data .= $pin_anim == '1' ? " data-anim='true'" : '';
$gmap_data .= $infobox == '1' ? " data-infobox='true'" : '';
$gmap_data .= $first_pin == '1' ? " data-first-pin='true'" : '';
$gmap_data .= $add_center == '1' ? " data-new-center='true' data-center-lat='{$latitude}' data-center-lng='{$longitude}'" : '';
$gmap_styles = $style ? "<script>var google_map_styles = '" . str_replace( '_', '=', $style ) . "';</script>" : '';
$class .= $fullheight == '1' ? 'bwpb-gmap-full' : '';

$output .= "<div class='bwpb-gmap {$class}'>
        <div id='" . uniqid() . "' class='bwpb-map-inner'
        {$gmap_data}>
        {$gmap_styles}
    </div>
    <ul class='bwpb-gmap-markers'>" . do_shortcode( $content ) . "</ul>
</div>";

return $output;