<?php

$a = shortcode_atts(array(
    'media_source'  => 'youtube',
    'enable_cover'  => false,
    'cover_img'     => '',
    'cover_text'    => '',
    'cover_text_color' => '#fff',
    'video_title' => '',
    'video_sub_title' => '',
    'class'         => ''
), $atts );

if( $a['media_source'] == 'youtube' ) {
    parse_str( parse_url( $content, PHP_URL_QUERY ), $parsed_embed );
    $video_id = $parsed_embed['v'];
    $iframe_src = "http://www.youtube.com/embed/{$video_id}";
}elseif( $a['media_source'] == 'vimeo' ) {
    $video_id = substr( parse_url( $content, PHP_URL_PATH ), 1 );
    $iframe_src = "http://player.vimeo.com/video/{$video_id}";
}

$output  = "<div class='bwpb-video-player {$a['class']}'>";
$output .= "<iframe src='{$iframe_src}' frameborder='0' allowfullscreen></iframe>";
$output .= ! empty( $a['enable_cover'] ) ? "<a href='{$content}?autoplay=1' data-title='{$a['video_title']}' data-alt='{$a['video_sub_title']}' class='bwpb-mp-item mfp-iframe bwpb-video-player-cover bwpb-noselect' style='color:{$a['cover_text_color']};background-image:url({$a['cover_img']})'>
    <div class='bwpb-table'><div class='bwpb-table-cell'>
        <span class='fa fa-play' style='border:6px solid {$a['cover_text_color']}'></span><i>{$a['cover_text']}</i>
    </div></div>
</a>" : '';
$output .= "</div>";

return $output;