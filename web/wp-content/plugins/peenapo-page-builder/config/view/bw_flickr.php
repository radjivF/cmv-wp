<?php

extract(shortcode_atts(array(
    'flickr_id'     => '',
    'order'         => 'latest',
    'size'          => 's',
), $atts));

return "<div class='bwpb-flickr'>
    <script type='text/javascript' src='http://www.flickr.com/badge_code_v2.gne?count=10&display={$order}&size={$size}&layout=x&source=user&user={$flickr_id}'></script>
    <center><small>Created with <a href='http://www.flickrbadge.com'>flickr badge</a>.</small></center>
    <p class='bwpb-flickr-stream-wrap'>
        <a class='wpb_follow_btn wpb_flickr_stream' href='http://www.flickr.com/photos/'. $flickr_id .''>
            ".__( 'View stream on flickr', PBTD )."
        </a>
    </p>
</div>";