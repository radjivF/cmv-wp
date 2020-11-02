<?php

extract(shortcode_atts(array(
    'type' => 'standard', //standard, button_count, box_count
), $atts ));

$url = get_permalink();

return "<div class='bwpb-facebook-like'>
    <iframe src='http://www.facebook.com/plugins/like.php?href={$url}&amp;layout={$type}&amp;show_faces=false&amp;action=like&amp;colorscheme=light' scrolling='no' frameborder='0' allowTransparency='true'></iframe>
</div>";