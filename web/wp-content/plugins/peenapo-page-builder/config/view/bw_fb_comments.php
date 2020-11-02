<?php

extract(shortcode_atts(array(
    'comments_shown' => 5,
), $atts ));

$url = get_permalink();
$appid = Bwpb::$global['fb_app_id'];

$output  = "<div id='fb-root'></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = '//connect.facebook.net/en_US/sdk.js#xfbml=1&appId={$appid}&version=v2.0';fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>";
$output .= "<div class='fb-comments' data-href='{$url}' data-width='100%' data-numposts='{$comments_shown}' data-colorscheme='light'></div>";

return $output;