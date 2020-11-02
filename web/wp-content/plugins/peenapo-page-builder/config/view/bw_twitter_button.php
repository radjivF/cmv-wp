<?php

extract(shortcode_atts(array(
    'type' => 'horizontal' //horizontal, vertical, none
), $atts ));

return "<div class='bwpb-twitter-button'>
    <a href='//twitter.com/share' class='twitter-share-button' data-count='{$type}'>" . __( 'Tweet', PBTD ) . "</a>
    <script type='text/javascript' src='//platform.twitter.com/widgets.js'></script>
</div>";